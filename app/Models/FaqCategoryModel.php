<?php

namespace App\Models;

use CodeIgniter\Model;

class FaqCategoryModel extends Model
{
    protected $table = 'faq_categories';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'name', 'slug', 'description', 'is_active', 'sort_order'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $beforeInsert = ['generateSlug'];
    protected $beforeUpdate = ['generateSlug'];

    public function getActiveCategories()
    {
        return $this->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }

    public function getCategoriesWithFaqs()
    {
        $categories = $this->getActiveCategories();
        $faqModel = new FaqModel();

        foreach ($categories as &$category) {
            $category['faqs'] = $faqModel->getByCategory($category['id']);
        }

        return $categories;
    }

    protected function generateSlug(array $data)
    {
        if (isset($data['data']['name']) && empty($data['data']['slug'])) {
            $data['data']['slug'] = url_title(strtolower($data['data']['name']), '-', true);
        }
        return $data;
    }
}
