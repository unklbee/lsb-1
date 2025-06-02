<?php
// app/Controllers/Admin/Dashboard.php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BlogPostModel;
use App\Models\ContactMessageModel;
use App\Models\TestimonialModel;
use App\Models\ServiceModel;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $this->checkAuth();

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


        $data = [
            'title' => 'Dashboard Admin',
            'stats' => $stats,
            'recentPosts' => $recentPosts,
            'recentMessages' => $recentMessages,
            'recentTestimonials' => $recentTestimonials,
            'user' => session()->get('admin_user')
        ];

        return view('admin/dashboard/index', $data);
    }

    private function checkAuth()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }
    }
}
