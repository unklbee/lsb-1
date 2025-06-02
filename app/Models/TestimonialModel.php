<?php

namespace App\Models;

use CodeIgniter\Model;

class TestimonialModel extends Model
{
    protected $table = 'testimonials';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'name', 'email', 'phone', 'location', 'service_type', 'rating', 'comment',
        'photo', 'is_featured', 'is_published', 'sort_order'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getPublishedTestimonials(): array
    {
        return $this->where('is_published', 1)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    public function getFeaturedTestimonials($limit = 6): array
    {
        return $this->where(['is_published' => 1, 'is_featured' => 1])
            ->orderBy('sort_order', 'ASC')
            ->limit($limit)
            ->findAll();
    }

    public function getAverageRating(): array
    {
        $result = $this->select('AVG(rating) as avg_rating, COUNT(*) as total_reviews')
            ->where('is_published', 1)
            ->first();

        return [
            'avg_rating' => round($result['avg_rating'], 1),
            'total_reviews' => $result['total_reviews']
        ];
    }
}
