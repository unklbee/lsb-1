<?php

namespace App\Controllers;

use App\Models\ServiceModel;
use App\Models\TestimonialModel;
use App\Models\FaqModel;
use App\Models\BlogPostModel;
use App\Models\SettingModel;

class Home extends BaseController
{
    protected ServiceModel $serviceModel;
    protected TestimonialModel $testimonialModel;
    protected FaqModel $faqModel;
    protected BlogPostModel $blogPostModel;
    protected $settingModel;

    public function __construct()
    {
        $this->serviceModel = new ServiceModel();
        $this->testimonialModel = new TestimonialModel();
        $this->faqModel = new FaqModel();
        $this->blogPostModel = new BlogPostModel();
        $this->settingModel = new SettingModel();
    }

    public function index(): string
    {
        // Get global settings from database
        $globalSeo = $this->getGlobalSettings();

        // SEO Data - bisa juga disimpan di database settings
        $seoData = [
            'title' => $globalSeo['site_name'] . ' - ' . ($globalSeo['tagline'] ?? 'Service Laptop & Komputer Terpercaya'),
            'description' => $globalSeo['meta_description'] ?? 'Service laptop Bandung terbaik dengan teknisi berpengalaman. Perbaikan laptop, komputer, upgrade hardware dengan garansi resmi.',
            'keywords' => $globalSeo['meta_keywords'] ?? 'service laptop bandung, perbaikan laptop, teknisi laptop bandung',
            'canonical' => base_url(),
            'og_title' => $globalSeo['site_name'] . ' - Perbaikan Profesional',
            'og_description' => $globalSeo['meta_description'] ?? 'Layanan service laptop Bandung terpercaya dengan teknisi berpengalaman.',
            'og_image' => base_url('assets/images/service-laptop-bandung-og.jpg'),
            'schema_type' => 'LocalBusiness'
        ];

        // Get services data from database (popular services for homepage)
        $services = $this->getHomepageServices();

        // Get testimonials from database
        $testimonials = $this->getHomepageTestimonials();

        // Get FAQs from database
        $faqs = $this->getHomepageFaqs();

        // Get stats - bisa dari settings atau hitung dari data aktual
        $stats = $this->getWebsiteStats();

        // Navigation data
        $navigation = $this->getNavigationData('home');

        $data = [
            'seo' => $seoData,
            'services' => $services,
            'testimonials' => $testimonials,
            'faqs' => $faqs,
            'stats' => $stats,
            'globalSeo' => $globalSeo,
            'navigation' => $navigation
        ];

        return view('home/index', $data);
    }

    /**
     * Get global settings from database
     */
    private function getGlobalSettings(): array
    {
        // Get all settings and group them
        $allSettings = $this->settingModel->getAllSettings();

        // Parse social media JSON if exists
        if (isset($allSettings['social_media']) && is_string($allSettings['social_media'])) {
            $allSettings['social_media'] = json_decode($allSettings['social_media'], true) ?: [];
        }

        // Parse business hours JSON if exists
        if (isset($allSettings['business_hours']) && is_string($allSettings['business_hours'])) {
            $allSettings['business_hours'] = json_decode($allSettings['business_hours'], true) ?: [];
        }

        return [
            'site_name' => $allSettings['site_name'] ?? 'LaptopService Bandung',
            'business_name' => $allSettings['business_name'] ?? 'CV. Teknologi Solusi Digital',
            'tagline' => $allSettings['tagline'] ?? 'Service Laptop & Komputer Terpercaya',
            'phone' => $allSettings['phone_primary'] ?? '+62-22-1234-5678',
            'whatsapp' => $allSettings['whatsapp'] ?? 'https://wa.me/6281234567890',
            'email' => $allSettings['email_primary'] ?? 'info@laptopservicebandung.com',
            'address' => $allSettings['address'] ?? 'Jl. Soekarno Hatta No. 123, Bandung',
            'social_media' => $allSettings['social_media'] ?? [
                    'facebook' => 'https://facebook.com/laptopservicebandung',
                    'instagram' => 'https://instagram.com/laptopservice_bdg',
                    'youtube' => 'https://youtube.com/@laptopservicebandung'
                ],
            'business_hours' => $allSettings['business_hours'] ?? [],
            'meta_description' => $allSettings['meta_description'] ?? '',
            'meta_keywords' => $allSettings['meta_keywords'] ?? ''
        ];
    }

    /**
     * Get services for homepage (popular/featured services)
     */
    private function getHomepageServices(): array
    {
        // Get popular services, limit to 4 for homepage
        $services = $this->serviceModel->getPopularServices();

        // If no popular services, get first 4 active services
        if (empty($services)) {
            $services = $this->serviceModel->where('is_active', 1)
                ->orderBy('sort_order', 'ASC')
                ->limit(4)
                ->findAll();
        } else {
            $services = array_slice($services, 0, 4);
        }

        // Format services data for view
        $formattedServices = [];
        foreach ($services as $service) {
            $formattedServices[] = [
                'name' => $service['name'],
                'description' => $service['short_description'],
                'icon' => $service['icon'] ?? 'laptop',
                'price_start' => $service['price_start'],
                'slug' => $service['slug']
            ];
        }

        return $formattedServices;
    }

    /**
     * Get testimonials for homepage
     */
    private function getHomepageTestimonials(): array
    {
        // Get featured testimonials
        $testimonials = $this->testimonialModel->getFeaturedTestimonials(6);

        // If no featured testimonials, get latest published ones
        if (empty($testimonials)) {
            $testimonials = $this->testimonialModel->where('is_published', 1)
                ->orderBy('created_at', 'DESC')
                ->limit(6)
                ->findAll();
        }

        return $testimonials;
    }

    /**
     * Get FAQs for homepage
     */
    private function getHomepageFaqs(): array
    {
        // Get general FAQs or most viewed FAQs for homepage
        $faqs = $this->faqModel->select('faqs.*, faq_categories.name as category_name')
            ->join('faq_categories', 'faq_categories.id = faqs.category_id', 'left')
            ->where('faqs.is_active', 1)
            ->orderBy('faqs.view_count', 'DESC')
            ->limit(6)
            ->findAll();

        // If no FAQs with high view count, get by sort order
        if (empty($faqs)) {
            $faqs = $this->faqModel->select('faqs.*, faq_categories.name as category_name')
                ->join('faq_categories', 'faq_categories.id = faqs.category_id', 'left')
                ->where('faqs.is_active', 1)
                ->orderBy('faqs.sort_order', 'ASC')
                ->limit(6)
                ->findAll();
        }

        return $faqs;
    }

    /**
     * Get website statistics
     */
    private function getWebsiteStats(): array
    {
        // Try to get from settings first (if manually set)
        $statsFromSettings = $this->settingModel->getByKey('stats');

        if ($statsFromSettings && is_array($statsFromSettings)) {
            return $statsFromSettings;
        }

        // Calculate actual stats from database
        $totalCustomers = $this->testimonialModel->where('is_published', 1)->countAllResults();
        $totalServices = $this->serviceModel->where('is_active', 1)->countAllResults();
        $avgRating = $this->testimonialModel->getAverageRating();

        return [
            'experience' => '8+ Tahun',
            'customers' => $totalCustomers > 0 ? $totalCustomers . '+' : '1000+',
            'satisfaction' => isset($avgRating['avg_rating']) ? round($avgRating['avg_rating'] * 20) . '%' : '98%', // Convert 5-star to percentage
            'warranty' => '1 Bulan'
        ];
    }

    /**
     * Get navigation data
     */
    protected function getNavigationData($currentPage = ''): array
    {
        return [
            [
                'title' => 'Beranda',
                'url' => '/',
                'active' => $currentPage === 'home'
            ],
            [
                'title' => 'Layanan',
                'url' => '/layanan',
                'active' => $currentPage === 'services'
            ],
            [
                'title' => 'Blog',
                'url' => '/blog',
                'active' => $currentPage === 'blog'
            ],
            [
                'title' => 'FAQ',
                'url' => '/faq',
                'active' => $currentPage === 'faq'
            ],
            [
                'title' => 'Testimonial',
                'url' => '/testimonial',
                'active' => $currentPage === 'testimonial'
            ],
            [
                'title' => 'Tentang Kami',
                'url' => '/tentang-kami',
                'active' => $currentPage === 'about'
            ],
            [
                'title' => 'Kontak',
                'url' => '/kontak',
                'active' => $currentPage === 'contact'
            ]
        ];
    }

    /**
     * Get latest blog posts for homepage slider/featured section
     */
    private function getLatestBlogPosts($limit = 3): array
    {
        return $this->blogPostModel->getFeaturedPosts($limit);
    }

    /**
     * Helper method to format WhatsApp URL
     */
    protected function formatWhatsAppUrl($phone): string
    {
        // Remove non-numeric characters
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);

        // Add country code if not present
        if (substr($cleanPhone, 0, 2) !== '62') {
            if (substr($cleanPhone, 0, 1) === '0') {
                $cleanPhone = '62' . substr($cleanPhone, 1);
            } else {
                $cleanPhone = '62' . $cleanPhone;
            }
        }

        return 'https://wa.me/' . $cleanPhone;
    }
}