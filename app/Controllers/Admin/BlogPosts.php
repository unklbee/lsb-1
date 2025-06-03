<?php

// app/Controllers/Admin/BlogPosts.php - FIXED VERSION

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BlogPostModel;
use App\Models\BlogCategoryModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Database;

class BlogPosts extends BaseController
{
    protected BlogPostModel $blogPostModel;
    protected BlogCategoryModel $categoryModel;

    public function __construct()
    {
        $this->blogPostModel = new BlogPostModel();
        $this->categoryModel = new BlogCategoryModel();
    }

    public function index(): string
    {
        $this->checkAuth();

        $posts = $this->blogPostModel->select('blog_posts.*, blog_categories.name as category_name')
            ->join('blog_categories', 'blog_categories.id = blog_posts.category_id', 'left')
            ->orderBy('blog_posts.created_at', 'DESC')
            ->findAll();

        $data = [
            'title' => 'Kelola Artikel Blog',
            'posts' => $posts,
            'user' => session()->get('admin_user')
        ];

        return view('admin/blog/posts/index', $data);
    }

    public function create(): string
    {
        $this->checkAuth();

        $categories = $this->categoryModel->getActiveCategories();

        $data = [
            'title' => 'Tulis Artikel Baru',
            'categories' => $categories,
            'user' => session()->get('admin_user')
        ];

        return view('admin/blog/posts/create', $data);
    }

    public function store()
    {
        $this->checkAuth();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'title' => 'required|max_length[255]',
            'category_id' => 'required|integer',
            'excerpt' => 'required',
            'content' => 'required',
            'author' => 'required|max_length[255]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Calculate reading time
        $content = $this->request->getPost('content');
        $wordCount = str_word_count(strip_tags($content));
        $readingTime = ceil($wordCount / 200) . ' menit'; // 200 words per minute

        $data = [
            'category_id' => $this->request->getPost('category_id'),
            'title' => $this->request->getPost('title'),
            'slug' => $this->request->getPost('slug') ?: url_title(strtolower($this->request->getPost('title')), '-', true),
            'excerpt' => $this->request->getPost('excerpt'),
            'content' => $content,
            'featured_image' => $this->request->getPost('featured_image'),
            'author' => $this->request->getPost('author'),
            'reading_time' => $readingTime,
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
            'meta_keywords' => $this->request->getPost('meta_keywords'),
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
            'is_published' => $this->request->getPost('is_published') ? 1 : 0,
        ];

        if ($this->blogPostModel->insert($data)) {
            return redirect()->to('/admin/blog/posts')->with('success', 'Artikel berhasil ditambahkan');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan artikel');
        }
    }

    public function edit($id): string|RedirectResponse
    {
        $this->checkAuth();

        $post = $this->blogPostModel->find($id);
        if (!$post) {
            return redirect()->to('/admin/blog/posts')->with('error', 'Artikel tidak ditemukan');
        }

        $categories = $this->categoryModel->getActiveCategories();

        $data = [
            'title' => 'Edit Artikel',
            'post' => $post,
            'categories' => $categories,
            'user' => session()->get('admin_user')
        ];

        return view('admin/blog/posts/edit', $data);
    }

    public function update($id)
    {
        $this->checkAuth();

        // Debug: Log the incoming request
        log_message('info', 'Blog post update request received for ID: ' . $id);
        log_message('info', 'POST data: ' . json_encode($this->request->getPost()));

        // Check if post exists first
        $post = $this->blogPostModel->find($id);
        if (!$post) {
            log_message('error', 'Blog post not found for ID: ' . $id);
            return redirect()->to('/admin/blog/posts')->with('error', 'Artikel tidak ditemukan');
        }

        // Validation rules
        $validation = \Config\Services::validation();
        $validation->setRules([
            'title' => 'required|max_length[255]',
            'category_id' => 'required|integer',
            'excerpt' => 'required',
            'content' => 'required',
            'author' => 'required|max_length[255]'
        ], [
            'title' => [
                'required' => 'Judul artikel wajib diisi',
                'max_length' => 'Judul maksimal 255 karakter'
            ],
            'category_id' => [
                'required' => 'Kategori wajib dipilih',
                'integer' => 'Kategori tidak valid'
            ],
            'excerpt' => [
                'required' => 'Ringkasan artikel wajib diisi'
            ],
            'content' => [
                'required' => 'Konten artikel wajib diisi'
            ],
            'author' => [
                'required' => 'Nama penulis wajib diisi',
                'max_length' => 'Nama penulis maksimal 255 karakter'
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            log_message('error', 'Blog update validation failed: ' . json_encode($validation->getErrors()));
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        try {
            // Get post data from request
            $title = trim($this->request->getPost('title'));
            $content = trim($this->request->getPost('content'));

            // Calculate reading time
            $wordCount = str_word_count(strip_tags($content));
            $readingTime = ceil($wordCount / 200) . ' menit';

            // Prepare update data
            $updateData = [
                'category_id' => (int) $this->request->getPost('category_id'),
                'title' => $title,
                'excerpt' => trim($this->request->getPost('excerpt')),
                'content' => $content,
                'author' => trim($this->request->getPost('author')),
                'reading_time' => $readingTime,
                'meta_title' => $this->request->getPost('meta_title') ?: null,
                'meta_description' => $this->request->getPost('meta_description') ?: null,
                'meta_keywords' => $this->request->getPost('meta_keywords') ?: null,
                'featured_image' => $this->request->getPost('featured_image') ?: null,
                'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
                'is_published' => $this->request->getPost('is_published') ? 1 : 0,
            ];

            // Handle slug - only update if provided or if title changed
            $providedSlug = trim($this->request->getPost('slug'));
            if ($providedSlug) {
                $updateData['slug'] = $providedSlug;
            } elseif ($post['title'] !== $title) {
                // Generate new slug only if title changed and no custom slug provided
                $newSlug = url_title(strtolower($title), '-', true);
                // Make sure slug is unique
                $slugCount = $this->blogPostModel->where('slug', $newSlug)->where('id !=', $id)->countAllResults();
                if ($slugCount > 0) {
                    $newSlug .= '-' . time();
                }
                $updateData['slug'] = $newSlug;
            }

            // Set published_at if publishing for the first time
            if ($updateData['is_published'] == 1 && !$post['published_at']) {
                $updateData['published_at'] = date('Y-m-d H:i:s');
            }

            // Log the update attempt
            log_message('info', 'Attempting to update blog post ID: ' . $id . ' with data: ' . json_encode($updateData) . ' by user: ' . (session()->get('admin_user')['email'] ?? 'unknown'));

            // Perform the update with explicit transaction
            $db = Database::connect();
            $db->transStart();

            $updateResult = $this->blogPostModel->update($id, $updateData);

            $db->transComplete();

            if ($db->transStatus() === false || !$updateResult) {
                // Transaction failed
                $modelErrors = $this->blogPostModel->errors();
                log_message('error', 'Blog post update failed - Transaction error or model update failed. Model errors: ' . json_encode($modelErrors));

                return redirect()->back()->withInput()->with('error', 'Gagal mengupdate artikel. ' . (is_array($modelErrors) && !empty($modelErrors) ? implode(', ', $modelErrors) : 'Database error.'));
            }

            // Success
            log_message('info', 'Blog post updated successfully: ID ' . $id);

            // Clear any session errors
            session()->remove('errors');

            return redirect()->to('/admin/blog/posts')->with('success', 'Artikel berhasil diupdate');

        } catch (\Exception $e) {
            log_message('error', 'Blog post update exception: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $this->checkAuth();

        $post = $this->blogPostModel->find($id);
        if (!$post) {
            return $this->response->setJSON(['success' => false, 'message' => 'Artikel tidak ditemukan']);
        }

        if ($this->blogPostModel->delete($id)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Artikel berhasil dihapus']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus artikel']);
        }
    }

    /**
     * Handle bulk actions for multiple posts
     */
    public function bulkAction()
    {
        $this->checkAuth();

        if (!$this->request->isAJAX()) {
            return redirect()->to('/admin/blog/posts');
        }

        $json = $this->request->getJSON();
        $action = $json->action ?? '';
        $postIds = $json->post_ids ?? [];

        if (empty($action) || empty($postIds)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Action atau post IDs tidak valid'
            ]);
        }

        try {
            $count = 0;

            foreach ($postIds as $postId) {
                $post = $this->blogPostModel->find($postId);
                if (!$post) continue;

                switch ($action) {
                    case 'publish':
                        $this->blogPostModel->update($postId, [
                            'is_published' => 1,
                            'published_at' => date('Y-m-d H:i:s')
                        ]);
                        $count++;
                        break;

                    case 'unpublish':
                        $this->blogPostModel->update($postId, ['is_published' => 0]);
                        $count++;
                        break;

                    case 'feature':
                        $this->blogPostModel->update($postId, ['is_featured' => 1]);
                        $count++;
                        break;

                    case 'unfeature':
                        $this->blogPostModel->update($postId, ['is_featured' => 0]);
                        $count++;
                        break;

                    case 'delete':
                        $this->blogPostModel->delete($postId);
                        $count++;
                        break;
                }
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => "$count artikel berhasil di-$action"
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Bulk action error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat melakukan bulk action'
            ]);
        }
    }

    /**
     * Toggle publish status
     */
    public function togglePublish($id)
    {
        $this->checkAuth();

        if (!$this->request->isAJAX()) {
            return redirect()->to('/admin/blog/posts');
        }

        $post = $this->blogPostModel->find($id);
        if (!$post) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Artikel tidak ditemukan'
            ]);
        }

        $json = $this->request->getJSON();
        $publish = $json->publish ?? false;

        try {
            $data = ['is_published' => $publish ? 1 : 0];

            if ($publish && !$post['published_at']) {
                $data['published_at'] = date('Y-m-d H:i:s');
            }

            $this->blogPostModel->update($id, $data);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Status publikasi berhasil diubah'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Toggle publish error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal mengubah status publikasi'
            ]);
        }
    }

    /**
     * Duplicate post
     */
    public function duplicate($id)
    {
        $this->checkAuth();

        if (!$this->request->isAJAX()) {
            return redirect()->to('/admin/blog/posts');
        }

        $post = $this->blogPostModel->find($id);
        if (!$post) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Artikel tidak ditemukan'
            ]);
        }

        try {
            // Create duplicate data
            $duplicateData = [
                'category_id' => $post['category_id'],
                'title' => $post['title'] . ' (Copy)',
                'slug' => $post['slug'] . '-copy-' . time(),
                'excerpt' => $post['excerpt'],
                'content' => $post['content'],
                'featured_image' => $post['featured_image'],
                'author' => $post['author'],
                'reading_time' => $post['reading_time'],
                'meta_title' => $post['meta_title'],
                'meta_description' => $post['meta_description'],
                'meta_keywords' => $post['meta_keywords'],
                'is_featured' => 0, // Don't copy featured status
                'is_published' => 0, // Always create as draft
                'view_count' => 0 // Reset view count
            ];

            $newPostId = $this->blogPostModel->insert($duplicateData);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Artikel berhasil diduplikasi',
                'new_post_id' => $newPostId
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Duplicate post error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menduplikasi artikel'
            ]);
        }
    }

    /**
     * Auto-save post (for edit mode) - FIXED VERSION
     */
    public function autoSave($id)
    {
        // Check if user is logged in
        if (!session()->get('admin_logged_in')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Not authenticated'
            ])->setStatusCode(403);
        }

        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request'
            ])->setStatusCode(400);
        }

        $post = $this->blogPostModel->find($id);
        if (!$post) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Artikel tidak ditemukan'
            ])->setStatusCode(404);
        }

        try {
            // Only save basic content, don't change publication status
            $data = [];

            if ($this->request->getPost('title')) {
                $data['title'] = $this->request->getPost('title');
            }

            if ($this->request->getPost('excerpt')) {
                $data['excerpt'] = $this->request->getPost('excerpt');
            }

            if ($this->request->getPost('content')) {
                $data['content'] = $this->request->getPost('content');

                // Update reading time if content changed
                $wordCount = str_word_count(strip_tags($data['content']));
                $data['reading_time'] = ceil($wordCount / 200) . ' menit';
            }

            if ($this->request->getPost('meta_title')) {
                $data['meta_title'] = $this->request->getPost('meta_title');
            }

            if ($this->request->getPost('meta_description')) {
                $data['meta_description'] = $this->request->getPost('meta_description');
            }

            if ($this->request->getPost('meta_keywords')) {
                $data['meta_keywords'] = $this->request->getPost('meta_keywords');
            }

            // Only update if there's data to save
            if (!empty($data)) {
                $this->blogPostModel->update($id, $data);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Auto-save berhasil',
                'timestamp' => date('H:i:s')
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Auto-save error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Auto-save gagal: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    /**
     * Get post statistics for dashboard
     */
    public function getStats()
    {
        $this->checkAuth();

        if (!$this->request->isAJAX()) {
            return redirect()->to('/admin/blog/posts');
        }

        try {
            $stats = [
                'total' => $this->blogPostModel->countAll(),
                'published' => $this->blogPostModel->where('is_published', 1)->countAllResults(),
                'draft' => $this->blogPostModel->where('is_published', 0)->countAllResults(),
                'featured' => $this->blogPostModel->where('is_featured', 1)->countAllResults(),
                'today' => $this->blogPostModel->where('DATE(created_at)', date('Y-m-d'))->countAllResults(),
                'this_week' => $this->blogPostModel->where('created_at >=', date('Y-m-d', strtotime('-7 days')))->countAllResults(),
                'this_month' => $this->blogPostModel->where('created_at >=', date('Y-m-01'))->countAllResults()
            ];

            // Get popular posts
            $popularPosts = $this->blogPostModel->select('id, title, view_count')
                ->where('is_published', 1)
                ->orderBy('view_count', 'DESC')
                ->limit(5)
                ->findAll();

            // Get recent posts
            $recentPosts = $this->blogPostModel->select('id, title, created_at, is_published')
                ->orderBy('created_at', 'DESC')
                ->limit(5)
                ->findAll();

            return $this->response->setJSON([
                'success' => true,
                'data' => [
                    'stats' => $stats,
                    'popular_posts' => $popularPosts,
                    'recent_posts' => $recentPosts
                ]
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Get stats error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal mengambil statistik'
            ]);
        }
    }

    /**
     * Search posts (AJAX)
     */
    public function search()
    {
        $this->checkAuth();

        if (!$this->request->isAJAX()) {
            return redirect()->to('/admin/blog/posts');
        }

        $query = $this->request->getGet('q');
        $category = $this->request->getGet('category');
        $status = $this->request->getGet('status');

        try {
            $builder = $this->blogPostModel->select('blog_posts.*, blog_categories.name as category_name')
                ->join('blog_categories', 'blog_categories.id = blog_posts.category_id', 'left');

            if ($query) {
                $builder->groupStart()
                    ->like('blog_posts.title', $query)
                    ->orLike('blog_posts.excerpt', $query)
                    ->orLike('blog_posts.content', $query)
                    ->groupEnd();
            }

            if ($category) {
                $builder->where('blog_posts.category_id', $category);
            }

            if ($status !== null && $status !== '') {
                $builder->where('blog_posts.is_published', $status);
            }

            $posts = $builder->orderBy('blog_posts.created_at', 'DESC')
                ->limit(50)
                ->findAll();

            return $this->response->setJSON([
                'success' => true,
                'data' => $posts,
                'total' => count($posts)
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Search posts error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal mencari artikel'
            ]);
        }
    }

    /**
     * Export posts to CSV
     */
    public function export()
    {
        $this->checkAuth();

        try {
            $posts = $this->blogPostModel->select('blog_posts.*, blog_categories.name as category_name')
                ->join('blog_categories', 'blog_categories.id = blog_posts.category_id', 'left')
                ->orderBy('blog_posts.created_at', 'DESC')
                ->findAll();

            // Set headers for CSV download
            $this->response->setHeader('Content-Type', 'text/csv');
            $this->response->setHeader('Content-Disposition', 'attachment; filename="blog_posts_' . date('Y-m-d') . '.csv"');

            $output = fopen('php://output', 'w');

            // CSV headers
            fputcsv($output, [
                'ID', 'Title', 'Category', 'Author', 'Status', 'Featured',
                'Views', 'Created', 'Updated', 'Published', 'URL'
            ]);

            // CSV data
            foreach ($posts as $post) {
                fputcsv($output, [
                    $post['id'],
                    $post['title'],
                    $post['category_name'] ?? '',
                    $post['author'],
                    $post['is_published'] ? 'Published' : 'Draft',
                    $post['is_featured'] ? 'Yes' : 'No',
                    $post['view_count'] ?? 0,
                    $post['created_at'],
                    $post['updated_at'],
                    $post['published_at'] ?? '',
                    base_url('/blog/' . $post['slug'])
                ]);
            }

            fclose($output);
            return $this->response;

        } catch (\Exception $e) {
            log_message('error', 'Export posts error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengekspor data artikel');
        }
    }

    /**
     * Import posts from CSV
     */
    public function import()
    {
        $this->checkAuth();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'csv_file' => 'uploaded[csv_file]|ext_in[csv_file,csv]|max_size[csv_file,2048]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->with('error', 'File CSV tidak valid');
        }

        try {
            $file = $this->request->getFile('csv_file');

            if ($file->isValid() && !$file->hasMoved()) {
                $csvData = array_map('str_getcsv', file($file->getTempName()));
                $header = array_shift($csvData); // Remove header row

                $imported = 0;
                $errors = [];

                foreach ($csvData as $row) {
                    if (count($row) < 3) continue; // Skip invalid rows

                    $data = [
                        'title' => $row[0] ?? '',
                        'excerpt' => $row[1] ?? '',
                        'content' => $row[2] ?? '',
                        'author' => $row[3] ?? 'Admin',
                        'category_id' => $this->getCategoryIdByName($row[4] ?? ''),
                        'is_published' => 0, // Import as draft
                        'slug' => url_title(strtolower($row[0] ?? ''), '-', true)
                    ];

                    if (empty($data['title']) || empty($data['content'])) {
                        $errors[] = "Row " . ($imported + 1) . ": Title dan content harus diisi";
                        continue;
                    }

                    if ($this->blogPostModel->insert($data)) {
                        $imported++;
                    } else {
                        $errors[] = "Row " . ($imported + 1) . ": Gagal menyimpan artikel";
                    }
                }

                $message = "$imported artikel berhasil diimport";
                if (!empty($errors)) {
                    $message .= ". Errors: " . implode(', ', $errors);
                }

                return redirect()->back()->with('success', $message);
            }

        } catch (\Exception $e) {
            log_message('error', 'Import posts error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengimport data artikel');
        }
    }

    /**
     * Helper method to get category ID by name
     */
    private function getCategoryIdByName($categoryName)
    {
        if (empty($categoryName)) return null;

        $category = $this->categoryModel->where('name', $categoryName)->first();
        return $category ? $category['id'] : null;
    }

    /**
     * Backup posts data
     */
    public function backup()
    {
        $this->checkAuth();

        try {
            $posts = $this->blogPostModel->select('blog_posts.*, blog_categories.name as category_name')
                ->join('blog_categories', 'blog_categories.id = blog_posts.category_id', 'left')
                ->orderBy('blog_posts.created_at', 'DESC')
                ->findAll();

            $backup = [
                'export_date' => date('Y-m-d H:i:s'),
                'total_posts' => count($posts),
                'posts' => $posts
            ];

            $this->response->setHeader('Content-Type', 'application/json');
            $this->response->setHeader('Content-Disposition', 'attachment; filename="blog_backup_' . date('Y-m-d') . '.json"');

            return $this->response->setBody(json_encode($backup, JSON_PRETTY_PRINT));

        } catch (\Exception $e) {
            log_message('error', 'Backup posts error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat backup data artikel');
        }
    }

    /**
     * Restore posts from backup
     */
    public function restore()
    {
        $this->checkAuth();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'backup_file' => 'uploaded[backup_file]|ext_in[backup_file,json]|max_size[backup_file,10240]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->with('error', 'File backup tidak valid');
        }

        try {
            $file = $this->request->getFile('backup_file');

            if ($file->isValid() && !$file->hasMoved()) {
                $backupData = json_decode(file_get_contents($file->getTempName()), true);

                if (!$backupData || !isset($backupData['posts'])) {
                    return redirect()->back()->with('error', 'Format file backup tidak valid');
                }

                $restored = 0;

                foreach ($backupData['posts'] as $postData) {
                    // Remove system fields
                    unset($postData['id'], $postData['created_at'], $postData['updated_at'], $postData['category_name']);

                    // Set as draft
                    $postData['is_published'] = 0;
                    $postData['slug'] = $postData['slug'] . '-restored-' . time();

                    if ($this->blogPostModel->insert($postData)) {
                        $restored++;
                    }
                }

                return redirect()->back()->with('success', "$restored artikel berhasil direstore dari backup");
            }

        } catch (\Exception $e) {
            log_message('error', 'Restore posts error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal merestore data artikel');
        }
    }

    private function checkAuth()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }
    }
}
