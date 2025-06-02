<?php

namespace App\Models;

use CodeIgniter\Model;

class PageModel extends Model
{
    protected $table = 'pages';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'title', 'slug', 'content', 'excerpt', 'featured_image', 'template',
        'meta_title', 'meta_description', 'meta_keywords',
        'is_published', 'show_in_menu', 'sort_order'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $beforeInsert = ['generateSlug'];
    protected $beforeUpdate = ['generateSlug'];

    public function getPublishedPages()
    {
        return $this->where('is_published', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }

    public function getMenuPages()
    {
        return $this->where(['is_published' => 1, 'show_in_menu' => 1])
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }

    public function getBySlug($slug)
    {
        return $this->where(['slug' => $slug, 'is_published' => 1])->first();
    }

    protected function generateSlug(array $data)
    {
        if (isset($data['data']['title']) && empty($data['data']['slug'])) {
            $data['data']['slug'] = url_title(strtolower($data['data']['title']), '-', true);
        }
        return $data;
    }
}
