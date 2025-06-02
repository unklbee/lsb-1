<?php

namespace App\Models;

use CodeIgniter\Model;

class FaqModel extends Model
{
    protected $table = 'faqs';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'category_id', 'question', 'answer', 'is_active', 'sort_order', 'view_count'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getActiveFaqs()
    {
        return $this->select('faqs.*, faq_categories.name as category_name, faq_categories.slug as category_slug')
            ->join('faq_categories', 'faq_categories.id = faqs.category_id', 'left')
            ->where('faqs.is_active', 1)
            ->orderBy('faqs.sort_order', 'ASC')
            ->findAll();
    }

    public function getByCategory($categoryId)
    {
        return $this->where(['category_id' => $categoryId, 'is_active' => 1])
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }

    public function getPopularFaqs($limit = 10)
    {
        return $this->select('faqs.*, faq_categories.name as category_name')
            ->join('faq_categories', 'faq_categories.id = faqs.category_id', 'left')
            ->where('faqs.is_active', 1)
            ->orderBy('faqs.view_count', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    public function incrementViewCount($id)
    {
        return $this->set('view_count', 'view_count + 1', false)
            ->where('id', $id)
            ->update();
    }
}
