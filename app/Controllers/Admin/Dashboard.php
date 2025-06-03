<?php
// app/Controllers/Admin/Dashboard.php

namespace App\Controllers\Admin;

use App\Models\BlogPostModel;
use App\Models\ContactMessageModel;
use App\Models\TestimonialModel;
use App\Models\ServiceModel;

class Dashboard extends BaseAdminController
{
    public function index(): string
    {
        // Check session timeout
        $this->checkSessionTimeout();

        // Get dashboard statistics
        $blogModel = new BlogPostModel();
        $contactModel = new ContactMessageModel();
        $testimonialModel = new TestimonialModel();
        $serviceModel = new ServiceModel();

        $stats = [
            'total_posts' => $blogModel->where('is_published', 1)->countAllResults(),
            'total_services' => $serviceModel->where('is_active', 1)->countAllResults(),
            'new_messages' => $contactModel->where('status', 'new')->countAllResults(),
            'total_testimonials' => $testimonialModel->where('is_published', 1)->countAllResults(),
        ];

        // Recent activities
        $recentPosts = $blogModel->getPublishedPosts(5);
        $recentMessages = $contactModel->orderBy('created_at', 'DESC')->limit(5)->findAll();
        $recentTestimonials = $testimonialModel->where('is_published', 1)->orderBy('created_at', 'DESC')->limit(5)->findAll();

        $data = $this->setAdminViewData([
            'title' => 'Dashboard Admin',
            'stats' => $stats,
            'recentPosts' => $recentPosts,
            'recentMessages' => $recentMessages,
            'recentTestimonials' => $recentTestimonials,
            'breadcrumbs' => [
                ['name' => 'Dashboard', 'url' => '']
            ]
        ]);

        return view('admin/dashboard/index', $data);
    }

    /**
     * AJAX endpoint untuk refresh stats
     */
    public function refreshStats()
    {
        if (!$this->isAuthenticatedAjax()) {
            return $this->unauthorizedJson();
        }

        $blogModel = new BlogPostModel();
        $contactModel = new ContactMessageModel();
        $testimonialModel = new TestimonialModel();
        $serviceModel = new ServiceModel();

        $stats = [
            'total_posts' => $blogModel->where('is_published', 1)->countAllResults(),
            'total_services' => $serviceModel->where('is_active', 1)->countAllResults(),
            'new_messages' => $contactModel->where('status', 'new')->countAllResults(),
            'total_testimonials' => $testimonialModel->where('is_published', 1)->countAllResults(),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        return $this->successJson($stats, 'Stats updated successfully');
    }
}