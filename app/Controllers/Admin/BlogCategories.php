<?php

// app/Controllers/Admin/BlogCategories.php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BlogCategoryModel;
use App\Models\BlogPostModel;

class BlogCategories extends BaseController
{
    protected $categoryModel;
    protected $blogPostModel;

    public function __construct()
    {
        $this->categoryModel = new BlogCategoryModel();
        $this->blogPostModel = new BlogPostModel();
    }

    public function index()
    {
        $this->checkAuth();

        // Get categories with post count
        $categories = $this->categoryModel->select('blog_categories.*, COUNT(blog_posts.id) as post_count')
            ->join('blog_posts', 'blog_posts.category_id = blog_categories.id', 'left')
            ->groupBy('blog_categories.id')
            ->orderBy('blog_categories.sort_order', 'ASC')
            ->findAll();

        // Get total posts
        $totalPosts = $this->blogPostModel->countAll();

        $data = [
            'title' => 'Kelola Kategori Blog',
            'categories' => $categories,
            'totalPosts' => $totalPosts,
            'user' => session()->get('admin_user'),
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'url' => '/admin/dashboard'],
                ['name' => 'Blog', 'url' => '/admin/blog/posts'],
                ['name' => 'Kategori', 'url' => '']
            ]
        ];

        return view('admin/blog/categories/index', $data);
    }

    public function create()
    {
        $this->checkAuth();

        $data = [
            'title' => 'Tambah Kategori Blog',
            'user' => session()->get('admin_user'),
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'url' => '/admin/dashboard'],
                ['name' => 'Blog', 'url' => '/admin/blog/posts'],
                ['name' => 'Kategori', 'url' => '/admin/blog/categories'],
                ['name' => 'Tambah', 'url' => '']
            ]
        ];

        return view('admin/blog/categories/create', $data);
    }

    public function store()
    {
        $this->checkAuth();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|max_length[255]|is_unique[blog_categories.name]',
            'description' => 'permit_empty|max_length[500]',
            'slug' => 'permit_empty|max_length[255]|is_unique[blog_categories.slug]',
            'meta_title' => 'permit_empty|max_length[255]',
            'meta_description' => 'permit_empty|max_length[500]',
            'sort_order' => 'permit_empty|integer'
        ], [
            'name' => [
                'required' => 'Nama kategori wajib diisi',
                'max_length' => 'Nama kategori maksimal 255 karakter',
                'is_unique' => 'Nama kategori sudah digunakan'
            ],
            'slug' => [
                'is_unique' => 'Slug sudah digunakan'
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'slug' => $this->request->getPost('slug') ?: url_title(strtolower($this->request->getPost('name')), '-', true),
            'description' => $this->request->getPost('description'),
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'sort_order' => $this->request->getPost('sort_order') ?: 0
        ];

        if ($this->categoryModel->insert($data)) {
            return redirect()->to('/admin/blog/categories')->with('success', 'Kategori berhasil ditambahkan');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan kategori');
        }
    }

    public function edit($id)
    {
        $this->checkAuth();

        $category = $this->categoryModel->find($id);
        if (!$category) {
            return redirect()->to('/admin/blog/categories')->with('error', 'Kategori tidak ditemukan');
        }

        // Get post count for this category
        $postCount = $this->blogPostModel->where('category_id', $id)->countAllResults();

        $data = [
            'title' => 'Edit Kategori Blog',
            'category' => $category,
            'postCount' => $postCount,
            'user' => session()->get('admin_user'),
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'url' => '/admin/dashboard'],
                ['name' => 'Blog', 'url' => '/admin/blog/posts'],
                ['name' => 'Kategori', 'url' => '/admin/blog/categories'],
                ['name' => 'Edit', 'url' => '']
            ]
        ];

        return view('admin/blog/categories/edit', $data);
    }

    public function update($id)
    {
        $this->checkAuth();

        $category = $this->categoryModel->find($id);
        if (!$category) {
            return redirect()->to('/admin/blog/categories')->with('error', 'Kategori tidak ditemukan');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => "required|max_length[255]|is_unique[blog_categories.name,id,$id]",
            'description' => 'permit_empty|max_length[500]',
            'slug' => "permit_empty|max_length[255]|is_unique[blog_categories.slug,id,$id]",
            'meta_title' => 'permit_empty|max_length[255]',
            'meta_description' => 'permit_empty|max_length[500]',
            'sort_order' => 'permit_empty|integer'
        ], [
            'name' => [
                'required' => 'Nama kategori wajib diisi',
                'max_length' => 'Nama kategori maksimal 255 karakter',
                'is_unique' => 'Nama kategori sudah digunakan'
            ],
            'slug' => [
                'is_unique' => 'Slug sudah digunakan'
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'slug' => $this->request->getPost('slug') ?: url_title(strtolower($this->request->getPost('name')), '-', true),
            'description' => $this->request->getPost('description'),
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'sort_order' => $this->request->getPost('sort_order') ?: 0
        ];

        if ($this->categoryModel->update($id, $data)) {
            return redirect()->to('/admin/blog/categories')->with('success', 'Kategori berhasil diupdate');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengupdate kategori');
        }
    }

    public function delete($id)
    {
        $this->checkAuth();

        if (!$this->request->isAJAX()) {
            return redirect()->to('/admin/blog/categories');
        }

        $category = $this->categoryModel->find($id);
        if (!$category) {
            return $this->response->setJSON(['success' => false, 'message' => 'Kategori tidak ditemukan']);
        }

        // Check if category has posts
        $postCount = $this->blogPostModel->where('category_id', $id)->countAllResults();

        if ($postCount > 0) {
            // Set posts to have no category (null)
            $this->blogPostModel->where('category_id', $id)->set(['category_id' => null])->update();
        }

        if ($this->categoryModel->delete($id)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => "Kategori berhasil dihapus. $postCount artikel dipindahkan ke tanpa kategori."
            ]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus kategori']);
        }
    }

    /**
     * Handle bulk actions
     */
    public function bulkAction()
    {
        $this->checkAuth();

        if (!$this->request->isAJAX()) {
            return redirect()->to('/admin/blog/categories');
        }

        $json = $this->request->getJSON();
        $action = $json->action ?? '';
        $categoryIds = $json->category_ids ?? [];

        if (empty($action) || empty($categoryIds)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Action atau category IDs tidak valid'
            ]);
        }

        try {
            $count = 0;

            foreach ($categoryIds as $categoryId) {
                $category = $this->categoryModel->find($categoryId);
                if (!$category) continue;

                switch ($action) {
                    case 'activate':
                        $this->categoryModel->update($categoryId, ['is_active' => 1]);
                        $count++;
                        break;

                    case 'deactivate':
                        $this->categoryModel->update($categoryId, ['is_active' => 0]);
                        $count++;
                        break;

                    case 'delete':
                        // Move posts to no category before deleting
                        $this->blogPostModel->where('category_id', $categoryId)->set(['category_id' => null])->update();
                        $this->categoryModel->delete($categoryId);
                        $count++;
                        break;
                }
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => "$count kategori berhasil di-$action"
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
     * Toggle category status
     */
    public function toggleStatus($id)
    {
        $this->checkAuth();

        if (!$this->request->isAJAX()) {
            return redirect()->to('/admin/blog/categories');
        }

        $category = $this->categoryModel->find($id);
        if (!$category) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Kategori tidak ditemukan'
            ]);
        }

        $json = $this->request->getJSON();
        $activate = $json->activate ?? false;

        try {
            $this->categoryModel->update($id, ['is_active' => $activate ? 1 : 0]);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Status kategori berhasil diubah'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Toggle status error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal mengubah status kategori'
            ]);
        }
    }

    /**
     * Update sort order
     */
    public function updateOrder($id)
    {
        $this->checkAuth();

        if (!$this->request->isAJAX()) {
            return redirect()->to('/admin/blog/categories');
        }

        $category = $this->categoryModel->find($id);
        if (!$category) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Kategori tidak ditemukan'
            ]);
        }

        $json = $this->request->getJSON();
        $sortOrder = $json->sort_order ?? 0;

        try {
            $this->categoryModel->update($id, ['sort_order' => $sortOrder]);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Urutan kategori berhasil diubah'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Update order error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal mengubah urutan kategori'
            ]);
        }
    }

    /**
     * Get category statistics
     */
    public function getStats()
    {
        $this->checkAuth();

        if (!$this->request->isAJAX()) {
            return redirect()->to('/admin/blog/categories');
        }

        try {
            $stats = [
                'total' => $this->categoryModel->countAll(),
                'active' => $this->categoryModel->where('is_active', 1)->countAllResults(),
                'inactive' => $this->categoryModel->where('is_active', 0)->countAllResults(),
                'with_posts' => $this->categoryModel->select('blog_categories.id')
                    ->join('blog_posts', 'blog_posts.category_id = blog_categories.id', 'inner')
                    ->groupBy('blog_categories.id')
                    ->countAllResults(),
                'empty' => $this->categoryModel->select('blog_categories.id')
                    ->join('blog_posts', 'blog_posts.category_id = blog_categories.id', 'left')
                    ->where('blog_posts.id IS NULL')
                    ->countAllResults()
            ];

            // Get most used categories
            $mostUsed = $this->categoryModel->select('blog_categories.name, COUNT(blog_posts.id) as post_count')
                ->join('blog_posts', 'blog_posts.category_id = blog_categories.id', 'left')
                ->groupBy('blog_categories.id')
                ->orderBy('post_count', 'DESC')
                ->limit(5)
                ->findAll();

            return $this->response->setJSON([
                'success' => true,
                'data' => [
                    'stats' => $stats,
                    'most_used' => $mostUsed
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
     * Search categories
     */
    public function search()
    {
        $this->checkAuth();

        if (!$this->request->isAJAX()) {
            return redirect()->to('/admin/blog/categories');
        }

        $query = $this->request->getGet('q');
        $status = $this->request->getGet('status');

        try {
            $builder = $this->categoryModel->select('blog_categories.*, COUNT(blog_posts.id) as post_count')
                ->join('blog_posts', 'blog_posts.category_id = blog_categories.id', 'left')
                ->groupBy('blog_categories.id');

            if ($query) {
                $builder->groupStart()
                    ->like('blog_categories.name', $query)
                    ->orLike('blog_categories.description', $query)
                    ->orLike('blog_categories.slug', $query)
                    ->groupEnd();
            }

            if ($status !== null && $status !== '') {
                $builder->where('blog_categories.is_active', $status);
            }

            $categories = $builder->orderBy('blog_categories.sort_order', 'ASC')
                ->limit(50)
                ->findAll();

            return $this->response->setJSON([
                'success' => true,
                'data' => $categories,
                'total' => count($categories)
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Search categories error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal mencari kategori'
            ]);
        }
    }

    /**
     * Export categories to CSV
     */
    public function export()
    {
        $this->checkAuth();

        try {
            $categories = $this->categoryModel->select('blog_categories.*, COUNT(blog_posts.id) as post_count')
                ->join('blog_posts', 'blog_posts.category_id = blog_categories.id', 'left')
                ->groupBy('blog_categories.id')
                ->orderBy('blog_categories.sort_order', 'ASC')
                ->findAll();

            // Set headers for CSV download
            $this->response->setHeader('Content-Type', 'text/csv');
            $this->response->setHeader('Content-Disposition', 'attachment; filename="blog_categories_' . date('Y-m-d') . '.csv"');

            $output = fopen('php://output', 'w');

            // CSV headers
            fputcsv($output, [
                'ID', 'Name', 'Slug', 'Description', 'Status', 'Sort Order',
                'Post Count', 'Created', 'Updated', 'URL'
            ]);

            // CSV data
            foreach ($categories as $category) {
                fputcsv($output, [
                    $category['id'],
                    $category['name'],
                    $category['slug'],
                    $category['description'] ?? '',
                    $category['is_active'] ? 'Active' : 'Inactive',
                    $category['sort_order'],
                    $category['post_count'],
                    $category['created_at'],
                    $category['updated_at'],
                    base_url('/blog/category/' . $category['slug'])
                ]);
            }

            fclose($output);
            return $this->response;

        } catch (\Exception $e) {
            log_message('error', 'Export categories error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengekspor data kategori');
        }
    }

    /**
     * Import categories from CSV
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
                    if (count($row) < 2) continue; // Skip invalid rows

                    $data = [
                        'name' => $row[0] ?? '',
                        'slug' => $row[1] ?? url_title(strtolower($row[0] ?? ''), '-', true),
                        'description' => $row[2] ?? '',
                        'is_active' => isset($row[3]) ? ($row[3] === 'Active' ? 1 : 0) : 1,
                        'sort_order' => isset($row[4]) ? (int)$row[4] : 0
                    ];

                    if (empty($data['name'])) {
                        $errors[] = "Row " . ($imported + 1) . ": Name harus diisi";
                        continue;
                    }

                    // Check for duplicate name or slug
                    $existing = $this->categoryModel->where('name', $data['name'])
                        ->orWhere('slug', $data['slug'])
                        ->first();

                    if ($existing) {
                        $data['name'] .= ' (Import)';
                        $data['slug'] .= '-import-' . time();
                    }

                    if ($this->categoryModel->insert($data)) {
                        $imported++;
                    } else {
                        $errors[] = "Row " . ($imported + 1) . ": Gagal menyimpan kategori";
                    }
                }

                $message = "$imported kategori berhasil diimport";
                if (!empty($errors)) {
                    $message .= ". Errors: " . implode(', ', $errors);
                }

                return redirect()->back()->with('success', $message);
            }

        } catch (\Exception $e) {
            log_message('error', 'Import categories error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengimport data kategori');
        }
    }

    /**
     * Get categories for API/AJAX calls
     */
    public function getCategories()
    {
        $this->checkAuth();

        if (!$this->request->isAJAX()) {
            return redirect()->to('/admin/blog/categories');
        }

        try {
            $categories = $this->categoryModel->select('id, name, slug, is_active')
                ->where('is_active', 1)
                ->orderBy('sort_order', 'ASC')
                ->findAll();

            return $this->response->setJSON([
                'success' => true,
                'data' => $categories
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Get categories error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal mengambil data kategori'
            ]);
        }
    }

    /**
     * Validate slug availability
     */
    public function validateSlug()
    {
        $this->checkAuth();

        if (!$this->request->isAJAX()) {
            return redirect()->to('/admin/blog/categories');
        }

        $slug = $this->request->getPost('slug');
        $excludeId = $this->request->getPost('exclude_id');

        try {
            $builder = $this->categoryModel->where('slug', $slug);

            if ($excludeId) {
                $builder->where('id !=', $excludeId);
            }

            $existing = $builder->first();

            return $this->response->setJSON([
                'available' => !$existing,
                'message' => $existing ? 'Slug sudah digunakan' : 'Slug tersedia'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Validate slug error: ' . $e->getMessage());
            return $this->response->setJSON([
                'available' => false,
                'message' => 'Gagal memvalidasi slug'
            ]);
        }
    }

    /**
     * Generate SEO suggestions for category
     */
    public function generateSeoSuggestions()
    {
        $this->checkAuth();

        if (!$this->request->isAJAX()) {
            return redirect()->to('/admin/blog/categories');
        }

        $name = $this->request->getPost('name');
        $description = $this->request->getPost('description');

        try {
            $suggestions = [
                'meta_title' => $name ? $name . ' - Blog Service Laptop Bandung' : '',
                'meta_description' => $description ?
                    substr($description, 0, 150) . '...' :
                    "Artikel kategori $name seputar service laptop dan komputer di Bandung dari teknisi berpengalaman.",
                'slug' => $name ? url_title(strtolower($name), '-', true) : ''
            ];

            return $this->response->setJSON([
                'success' => true,
                'suggestions' => $suggestions
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Generate SEO suggestions error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal generate SEO suggestions'
            ]);
        }
    }

    private function checkAuth()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }
    }
}