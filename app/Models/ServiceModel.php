<?php

namespace App\Models;

use CodeIgniter\Model;

class ServiceModel extends Model
{
    protected $table = 'services';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'name', 'slug', 'short_description', 'description', 'features', 'benefits', 'process',
        'price_start', 'duration', 'warranty', 'icon', 'featured_image',
        'meta_title', 'meta_description', 'meta_keywords',
        'is_popular', 'is_active', 'sort_order'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $beforeInsert = ['generateSlug'];
    protected $beforeUpdate = ['generateSlug'];

    public function getActiveServices()
    {
        return $this->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }

    public function getPopularServices()
    {
        return $this->where(['is_active' => 1, 'is_popular' => 1])
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }

    public function getBySlug($slug)
    {
        $service = $this->where(['slug' => $slug, 'is_active' => 1])->first();

        if ($service) {
            $service['features'] = json_decode($service['features'], true) ?: [];
            $service['benefits'] = json_decode($service['benefits'], true) ?: [];
            $service['process'] = json_decode($service['process'], true) ?: [];
        }

        return $service;
    }

    protected function generateSlug(array $data)
    {
        if (isset($data['data']['name']) && empty($data['data']['slug'])) {
            $data['data']['slug'] = url_title(strtolower($data['data']['name']), '-', true);
        }
        return $data;
    }
}
