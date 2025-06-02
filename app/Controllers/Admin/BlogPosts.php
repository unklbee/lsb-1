<?php

// app/Controllers/Admin/BlogPosts.php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BlogPostModel;
use App\Models\BlogCategoryModel;

class BlogPosts extends BaseController
{
    protected $blogPostModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->blogPostModel = new BlogPostModel();
        $this->categoryModel = new BlogCategoryModel();
    }

    public function index()
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

    public function create()
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

    public function edit($id)
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

        $post = $this->blogPostModel->find($id);
        if (!$post) {
            return redirect()->to('/admin/blog/posts')->with('error', 'Artikel tidak ditemukan');
        }

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
        $readingTime = ceil($wordCount / 200) . ' menit';

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

        if ($this->blogPostModel->update($id, $data)) {
            return redirect()->to('/admin/blog/posts')->with('success', 'Artikel berhasil diupdate');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengupdate artikel');
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

    private function checkAuth()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }
    }
}
