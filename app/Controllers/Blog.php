<?php

namespace App\Controllers;

use App\Models\BlogPostModel;
use App\Models\BlogCategoryModel;

class Blog extends BaseController
{
    protected BlogPostModel $blogPostModel;
    protected BlogCategoryModel $blogCategoryModel;

    public function __construct()
    {
//        parent::__construct();
        $this->blogPostModel = new BlogPostModel();
        $this->blogCategoryModel = new BlogCategoryModel();
    }

    public function index(): string
    {
        $seoData = [
            'title' => 'Blog Service Laptop Bandung - Tips & Tutorial Komputer',
            'description' => 'Blog informatif seputar service laptop, tips perawatan komputer, tutorial teknologi, dan panduan troubleshooting dari teknisi berpengalaman di Bandung.',
            'keywords' => 'blog service laptop bandung, tips laptop, tutorial komputer, perawatan laptop, troubleshooting pc',
            'canonical' => base_url('/blog'),
            'og_title' => 'Blog Tips & Tutorial Service Laptop Bandung',
            'og_description' => 'Artikel informatif, tips, dan tutorial seputar service laptop dan komputer dari para ahli teknisi di Bandung.',
            'og_image' => base_url('assets/images/blog-service-laptop-bandung.jpg')
        ];

        // Get blog posts from database with pagination
        $page = (int) ($this->request->getGet('page') ?? 1);
        $perPage = 9;
        $offset = ($page - 1) * $perPage;

        $posts = $this->blogPostModel->getPublishedPosts($perPage, $offset);
        $totalPosts = $this->blogPostModel->where('is_published', 1)->countAllResults();
        $totalPages = ceil($totalPosts / $perPage);

        // Get categories from database
        $categoriesData = $this->blogCategoryModel->getActiveCategories();
        $categories = [];
        foreach ($categoriesData as $category) {
            $categories[$category['slug']] = $category['name'];
        }

        // Pagination data
        $paginationData = [
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalPosts' => $totalPosts,
            'hasNext' => $page < $totalPages,
            'hasPrev' => $page > 1,
            'nextPage' => $page + 1,
            'prevPage' => $page - 1,
        ];

        $data = [
            'seo' => $seoData,
            'posts' => $posts,
            'categories' => $categories,
            'globalSeo' => $this->globalSettings,
            'navigation' => $this->getNavigationData('blog'),
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => base_url()],
                ['name' => 'Blog', 'url' => base_url('/blog')]
            ]
        ];

        // Add pagination data if needed
        if ($totalPages > 1) {
            $data = array_merge($data, $paginationData);
        }

        return view('blog/index', $data);
    }

    public function detail($slug)
    {
        $post = $this->blogPostModel->getBySlug($slug);

        if (!$post) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Artikel tidak ditemukan');
        }

        $seoData = [
            'title' => $post['meta_title'] ?: $post['title'] . ' - Blog Service Laptop Bandung',
            'description' => $post['meta_description'] ?: $post['excerpt'],
            'keywords' => $post['meta_keywords'] ?: '',
            'canonical' => base_url('/blog/' . $slug),
            'og_title' => $post['title'],
            'og_description' => $post['excerpt'],
            'og_image' => $post['featured_image'] ?: base_url('assets/images/blog-default.jpg'),
            'og_type' => 'article'
        ];

        // Get related posts
        $relatedPosts = $this->blogPostModel->getRelatedPosts($post['category_id'], $post['id'], 3);

        $data = [
            'seo' => $seoData,
            'post' => $post,
            'relatedPosts' => $relatedPosts,
            'globalSeo' => $this->globalSettings,
            'navigation' => $this->getNavigationData('blog'),
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => base_url()],
                ['name' => 'Blog', 'url' => base_url('/blog')],
                ['name' => $post['title'], 'url' => base_url('/blog/' . $slug)]
            ]
        ];

        return view('blog/detail', $data);
    }

    public function category($categorySlug)
    {
        // Get category info
        $category = $this->blogCategoryModel->getBySlug($categorySlug);

        if (!$category) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kategori tidak ditemukan');
        }

        // Get posts by category with pagination
        $page = (int) ($this->request->getGet('page') ?? 1);
        $perPage = 9;
        $offset = ($page - 1) * $perPage;

        $posts = $this->blogPostModel->getByCategory($categorySlug, $perPage, $offset);

        // Count total posts in this category
        $totalPosts = $this->blogPostModel->select('blog_posts.*')
            ->join('blog_categories', 'blog_categories.id = blog_posts.category_id', 'left')
            ->where(['blog_posts.is_published' => 1, 'blog_categories.slug' => $categorySlug])
            ->countAllResults();

        $totalPages = ceil($totalPosts / $perPage);

        $seoData = [
            'title' => $category['meta_title'] ?: $category['name'] . ' - Blog Service Laptop Bandung',
            'description' => $category['meta_description'] ?: 'Artikel kategori ' . $category['name'] . ' seputar service laptop dan komputer dari teknisi Bandung berpengalaman.',
            'keywords' => 'blog ' . strtolower($category['name']) . ', service laptop bandung',
            'canonical' => base_url('/blog/category/' . $categorySlug),
            'og_title' => $category['name'] . ' - Blog Service Laptop Bandung',
            'og_description' => $category['description'] ?: $category['name'],
            'og_image' => base_url('assets/images/blog-category-' . $categorySlug . '.jpg')
        ];

        // Get all categories for navigation
        $categoriesData = $this->blogCategoryModel->getActiveCategories();
        $categories = [];
        foreach ($categoriesData as $cat) {
            $categories[$cat['slug']] = $cat['name'];
        }

        $data = [
            'seo' => $seoData,
            'posts' => $posts,
            'category' => $category,
            'categorySlug' => $categorySlug,
            'categories' => $categories,
            'totalPosts' => $totalPosts,
            'globalSeo' => $this->globalSettings,
            'navigation' => $this->getNavigationData('blog'),
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => base_url()],
                ['name' => 'Blog', 'url' => base_url('/blog')],
                ['name' => $category['name'], 'url' => base_url('/blog/category/' . $categorySlug)]
            ]
        ];

        // Add pagination data if needed
        if ($totalPages > 1) {
            $data['currentPage'] = $page;
            $data['totalPages'] = $totalPages;
            $data['hasNext'] = $page < $totalPages;
            $data['hasPrev'] = $page > 1;
            $data['nextPage'] = $page + 1;
            $data['prevPage'] = $page - 1;
        }

        return view('blog/category', $data);
    }

    public function search()
    {
        $query = $this->request->getGet('q');

        if (empty($query)) {
            return redirect()->to('/blog');
        }

        // Search posts
        $page = (int) ($this->request->getGet('page') ?? 1);
        $perPage = 9;
        $offset = ($page - 1) * $perPage;

        $searchResults = $this->blogPostModel->searchPosts($query, $perPage, $offset);

        // Count total search results
        $totalResults = count($this->blogPostModel->searchPosts($query));
        $totalPages = ceil($totalResults / $perPage);

        $seoData = [
            'title' => 'Hasil Pencarian: "' . $query . '" - Blog Service Laptop Bandung',
            'description' => 'Hasil pencarian artikel untuk "' . $query . '" di blog service laptop Bandung.',
            'keywords' => 'search, ' . $query . ', blog service laptop bandung',
            'canonical' => base_url('/blog/search?q=' . urlencode($query)),
            'og_title' => 'Pencarian: ' . $query,
            'og_description' => 'Hasil pencarian untuk "' . $query . '"',
            'og_image' => base_url('assets/images/blog-search.jpg')
        ];

        // Get categories for filter
        $categoriesData = $this->blogCategoryModel->getActiveCategories();
        $categories = [];
        foreach ($categoriesData as $category) {
            $categories[$category['slug']] = $category['name'];
        }

        $data = [
            'seo' => $seoData,
            'posts' => $searchResults,
            'query' => $query,
            'totalResults' => $totalResults,
            'categories' => $categories,
            'globalSeo' => $this->globalSettings,
            'navigation' => $this->getNavigationData('blog'),
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => base_url()],
                ['name' => 'Blog', 'url' => base_url('/blog')],
                ['name' => 'Pencarian: ' . $query, 'url' => '']
            ]
        ];

        // Add pagination data if needed
        if ($totalPages > 1) {
            $data['currentPage'] = $page;
            $data['totalPages'] = $totalPages;
            $data['hasNext'] = $page < $totalPages;
            $data['hasPrev'] = $page > 1;
            $data['nextPage'] = $page + 1;
            $data['prevPage'] = $page - 1;
        }

        return view('blog/search', $data);
    }

    // Method untuk pagination jika diperlukan
    public function page($page = 1)
    {
        // Redirect to main blog index with page parameter
        return redirect()->to('/blog?page=' . $page);
    }

    // Method untuk RSS feed
    public function rss()
    {
        $posts = $this->blogPostModel->getPublishedPosts(20); // Latest 20 posts

        $this->response->setContentType('application/rss+xml');

        $rss = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $rss .= '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">' . "\n";
        $rss .= '<channel>' . "\n";
        $rss .= '<title>Blog Service Laptop Bandung</title>' . "\n";
        $rss .= '<description>Tips dan tutorial service laptop terbaru dari teknisi Bandung</description>' . "\n";
        $rss .= '<link>' . base_url('/blog') . '</link>' . "\n";
        $rss .= '<atom:link href="' . base_url('/blog/rss') . '" rel="self" type="application/rss+xml" />' . "\n";
        $rss .= '<language>id-ID</language>' . "\n";
        $rss .= '<lastBuildDate>' . date('r') . '</lastBuildDate>' . "\n";

        foreach ($posts as $post) {
            $rss .= '<item>' . "\n";
            $rss .= '<title><![CDATA[' . $post['title'] . ']]></title>' . "\n";
            $rss .= '<description><![CDATA[' . $post['excerpt'] . ']]></description>' . "\n";
            $rss .= '<link>' . base_url('/blog/' . $post['slug']) . '</link>' . "\n";
            $rss .= '<guid>' . base_url('/blog/' . $post['slug']) . '</guid>' . "\n";
            $rss .= '<pubDate>' . date('r', strtotime($post['published_at'])) . '</pubDate>' . "\n";
            $rss .= '<author>' . $this->globalSettings['email'] . ' (' . $post['author'] . ')</author>' . "\n";
            $rss .= '<category>' . ($post['category_name'] ?? '') . '</category>' . "\n";
            $rss .= '</item>' . "\n";
        }

        $rss .= '</channel>' . "\n";
        $rss .= '</rss>';

        return $this->response->setBody($rss);
    }

    // Method untuk sitemap khusus blog
    public function sitemap()
    {
        $posts = $this->blogPostModel->getPublishedPosts();

        $this->response->setContentType('application/xml');

        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Blog index
        $sitemap .= '<url>' . "\n";
        $sitemap .= '<loc>' . base_url('/blog') . '</loc>' . "\n";
        $sitemap .= '<lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
        $sitemap .= '<changefreq>daily</changefreq>' . "\n";
        $sitemap .= '<priority>0.8</priority>' . "\n";
        $sitemap .= '</url>' . "\n";

        // Blog categories
        $categories = $this->blogCategoryModel->getActiveCategories();
        foreach ($categories as $category) {
            $sitemap .= '<url>' . "\n";
            $sitemap .= '<loc>' . base_url('/blog/category/' . $category['slug']) . '</loc>' . "\n";
            $sitemap .= '<lastmod>' . $category['updated_at'] . '</lastmod>' . "\n";
            $sitemap .= '<changefreq>weekly</changefreq>' . "\n";
            $sitemap .= '<priority>0.7</priority>' . "\n";
            $sitemap .= '</url>' . "\n";
        }

        // Blog posts
        foreach ($posts as $post) {
            $sitemap .= '<url>' . "\n";
            $sitemap .= '<loc>' . base_url('/blog/' . $post['slug']) . '</loc>' . "\n";
            $sitemap .= '<lastmod>' . $post['updated_at'] . '</lastmod>' . "\n";
            $sitemap .= '<changefreq>monthly</changefreq>' . "\n";
            $sitemap .= '<priority>0.6</priority>' . "\n";
            $sitemap .= '</url>' . "\n";
        }

        $sitemap .= '</urlset>';

        return $this->response->setBody($sitemap);
    }

    /**
     * API endpoint untuk mendapatkan posts
     */
    public function getPostsJson()
    {
        $limit = $this->request->getGet('limit') ?? 10;
        $category = $this->request->getGet('category');
        $featured = $this->request->getGet('featured');

        if ($featured) {
            $posts = $this->blogPostModel->getFeaturedPosts($limit);
        } elseif ($category) {
            $posts = $this->blogPostModel->getByCategory($category, $limit);
        } else {
            $posts = $this->blogPostModel->getPublishedPosts($limit);
        }

        return $this->response->setContentType('application/json')
            ->setBody(json_encode([
                'status' => 'success',
                'data' => $posts
            ]));
    }

    /**
     * API endpoint untuk mendapatkan kategorias
     */
    public function getCategoriesJson()
    {
        $categories = $this->blogCategoryModel->getActiveCategories();

        return $this->response->setContentType('application/json')
            ->setBody(json_encode([
                'status' => 'success',
                'data' => $categories
            ]));
    }

    /**
     * Method untuk increment view count (AJAX)
     */
    public function incrementView($id)
    {
        if ($this->request->isAJAX()) {
            $result = $this->blogPostModel->incrementViewCount($id);

            return $this->response->setContentType('application/json')
                ->setBody(json_encode([
                    'status' => $result ? 'success' : 'error'
                ]));
        }

        return $this->response->setStatusCode(404);
    }
}