<?php

// app/Models/BlogPostModel.php

namespace App\Models;

use CodeIgniter\Model;

class BlogPostModel extends Model
{
    protected $table = 'blog_posts';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'category_id', 'title', 'slug', 'excerpt', 'content', 'featured_image',
        'author', 'reading_time', 'meta_title', 'meta_description', 'meta_keywords',
        'is_featured', 'is_published', 'published_at', 'view_count'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $beforeInsert = ['generateSlug', 'setPublishedAt'];
    protected $beforeUpdate = ['generateSlug', 'setPublishedAt'];

    public function getPublishedPosts($limit = null, $offset = null)
    {
        $query = $this->select('blog_posts.*, blog_categories.name as category_name, blog_categories.slug as category_slug')
            ->join('blog_categories', 'blog_categories.id = blog_posts.category_id', 'left')
            ->where('blog_posts.is_published', 1)
            ->orderBy('blog_posts.published_at', 'DESC');

        if ($limit) {
            $query->limit($limit, $offset);
        }

        return $query->findAll();
    }

    public function getFeaturedPosts($limit = 3)
    {
        return $this->select('blog_posts.*, blog_categories.name as category_name, blog_categories.slug as category_slug')
            ->join('blog_categories', 'blog_categories.id = blog_posts.category_id', 'left')
            ->where(['blog_posts.is_published' => 1, 'blog_posts.is_featured' => 1])
            ->orderBy('blog_posts.published_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    public function getBySlug($slug)
    {
        $post = $this->select('blog_posts.*, blog_categories.name as category_name, blog_categories.slug as category_slug')
            ->join('blog_categories', 'blog_categories.id = blog_posts.category_id', 'left')
            ->where(['blog_posts.slug' => $slug, 'blog_posts.is_published' => 1])
            ->first();

        if ($post) {
            $this->incrementViewCount($post['id']);
        }

        return $post;
    }

    public function getByCategory($categorySlug, $limit = null)
    {
        $query = $this->select('blog_posts.*, blog_categories.name as category_name, blog_categories.slug as category_slug')
            ->join('blog_categories', 'blog_categories.id = blog_posts.category_id', 'left')
            ->where(['blog_posts.is_published' => 1, 'blog_categories.slug' => $categorySlug])
            ->orderBy('blog_posts.published_at', 'DESC');

        if ($limit) {
            $query->limit($limit);
        }

        return $query->findAll();
    }

    public function getRelatedPosts($categoryId, $currentId, $limit = 3)
    {
        return $this->select('blog_posts.*, blog_categories.name as category_name')
            ->join('blog_categories', 'blog_categories.id = blog_posts.category_id', 'left')
            ->where(['blog_posts.category_id' => $categoryId, 'blog_posts.is_published' => 1])
            ->where('blog_posts.id !=', $currentId)
            ->orderBy('blog_posts.published_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    public function searchPosts($query, $limit = null)
    {
        $searchQuery = $this->select('blog_posts.*, blog_categories.name as category_name')
            ->join('blog_categories', 'blog_categories.id = blog_posts.category_id', 'left')
            ->where('blog_posts.is_published', 1)
            ->groupStart()
            ->like('blog_posts.title', $query)
            ->orLike('blog_posts.excerpt', $query)
            ->orLike('blog_posts.content', $query)
            ->orLike('blog_posts.meta_keywords', $query)
            ->groupEnd()
            ->orderBy('blog_posts.published_at', 'DESC');

        if ($limit) {
            $searchQuery->limit($limit);
        }

        return $searchQuery->findAll();
    }

    public function incrementViewCount($id)
    {
        return $this->set('view_count', 'view_count + 1', false)
            ->where('id', $id)
            ->update();
    }

    protected function generateSlug(array $data)
    {
        if (isset($data['data']['title']) && empty($data['data']['slug'])) {
            $data['data']['slug'] = url_title(strtolower($data['data']['title']), '-', true);
        }
        return $data;
    }

    protected function setPublishedAt(array $data)
    {
        if (isset($data['data']['is_published']) && $data['data']['is_published'] == 1 && empty($data['data']['published_at'])) {
            $data['data']['published_at'] = date('Y-m-d H:i:s');
        }
        return $data;
    }
}
