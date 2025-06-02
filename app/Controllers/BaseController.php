<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\SettingModel;

abstract class BaseController extends Controller
{
    protected $request;
    protected $helpers = ['url', 'form', 'html', 'seo'];
    protected $settingModel;
    protected array $globalSettings = [];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Initialize setting model
        $this->settingModel = new SettingModel();

        // Load global data for all views
        $this->loadGlobalData();
    }

    /**
     * Load global settings and make them available to all views
     */
    protected function loadGlobalData()
    {
        // Get global settings from database with caching
        $this->globalSettings = $this->getGlobalSettingsWithCache();

        // Navigation menu
        $navigation = $this->getNavigationData();

        // Make data available to all views
        $viewData = [
            'globalSeo' => $this->globalSettings,
            'navigation' => $navigation
        ];

        // Store in service for global access
        service('renderer')->setData($viewData);
    }

    /**
     * Get global settings with simple caching mechanism
     */
    protected function getGlobalSettingsWithCache(): array
    {
        // Simple file-based cache for settings (valid for 1 hour)
        $cacheFile = WRITEPATH . 'cache/global_settings.json';
        $cacheTime = 3600; // 1 hour

        if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $cacheTime) {
            $cached = json_decode(file_get_contents($cacheFile), true);
            if ($cached) {
                return $cached;
            }
        }

        // Get fresh data from database
        $allSettings = $this->settingModel->getAllSettings();

        // Process JSON fields
        $jsonFields = ['social_media', 'business_hours', 'stats'];
        foreach ($jsonFields as $field) {
            if (isset($allSettings[$field]) && is_string($allSettings[$field])) {
                $allSettings[$field] = json_decode($allSettings[$field], true) ?: [];
            }
        }

        // Format settings for easy access
        $globalSettings = [
            'site_name' => $allSettings['site_name'] ?? 'LaptopService Bandung',
            'business_name' => $allSettings['business_name'] ?? 'CV. Teknologi Solusi Digital',
            'tagline' => $allSettings['tagline'] ?? 'Service Laptop & Komputer Terpercaya',
            'phone' => $allSettings['phone_primary'] ?? '+62-22-1234-5678',
            'phone_secondary' => $allSettings['phone_secondary'] ?? '',
            'whatsapp' => $this->formatWhatsAppUrl($allSettings['whatsapp'] ?? '+62-812-3456-7890'),
            'whatsapp_raw' => $allSettings['whatsapp'] ?? '+62-812-3456-7890',
            'email' => $allSettings['email_primary'] ?? 'info@laptopservicebandung.com',
            'email_support' => $allSettings['email_support'] ?? 'support@laptopservicebandung.com',
            'address' => $allSettings['address'] ?? 'Jl. Soekarno Hatta No. 123, Bandung',
            'coordinates_lat' => $allSettings['coordinates_lat'] ?? '-6.9175',
            'coordinates_lng' => $allSettings['coordinates_lng'] ?? '107.6191',
            'social_media' => $allSettings['social_media'] ?? [
                    'facebook' => 'https://facebook.com/laptopservicebandung',
                    'instagram' => 'https://instagram.com/laptopservice_bdg',
                    'youtube' => 'https://youtube.com/@laptopservicebandung'
                ],
            'business_hours' => $allSettings['business_hours'] ?? [
                    'weekdays' => ['days' => 'Senin - Jumat', 'hours' => '08:00 - 20:00'],
                    'saturday' => ['days' => 'Sabtu', 'hours' => '08:00 - 18:00'],
                    'sunday' => ['days' => 'Minggu', 'hours' => '09:00 - 17:00']
                ],
            'stats' => $allSettings['stats'] ?? [
                    'experience' => '8+ Tahun',
                    'customers' => '5000+',
                    'satisfaction' => '98%',
                    'warranty' => '3 Bulan'
                ],
            'meta_description' => $allSettings['meta_description'] ?? 'Service laptop dan komputer terpercaya di Bandung',
            'meta_keywords' => $allSettings['meta_keywords'] ?? 'service laptop bandung, perbaikan komputer'
        ];

        // Cache the settings
        if (!file_exists(dirname($cacheFile))) {
            mkdir(dirname($cacheFile), 0755, true);
        }
        file_put_contents($cacheFile, json_encode($globalSettings));

        return $globalSettings;
    }

    /**
     * Clear settings cache (call this when settings are updated)
     */
    public function clearSettingsCache()
    {
        $cacheFile = WRITEPATH . 'cache/global_settings.json';
        if (file_exists($cacheFile)) {
            unlink($cacheFile);
        }
    }

    /**
     * Get navigation data
     */
    protected function getNavigationData($currentPage = ''): array
    {
        // This could also be made dynamic from database if needed
        return [
            [
                'title' => 'Beranda',
                'url' => '/',
                'active' => $currentPage === 'home'
            ],
            [
                'title' => 'Layanan',
                'url' => '/layanan',
                'active' => $currentPage === 'services',
                'submenu' => [
                    ['title' => 'Service Laptop', 'url' => '/layanan/service-laptop'],
                    ['title' => 'Service Komputer', 'url' => '/layanan/service-komputer'],
                    ['title' => 'Upgrade Hardware', 'url' => '/layanan/upgrade-hardware'],
                    ['title' => 'Data Recovery', 'url' => '/layanan/data-recovery']
                ]
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

    /**
     * Generate structured data for different types
     */
    protected function generateStructuredData($type, $data)
    {
        switch ($type) {
            case 'LocalBusiness':
                return $this->generateLocalBusinessSchema($data);
            case 'Service':
                return $this->generateServiceSchema($data);
            case 'Review':
                return $this->generateReviewSchema($data);
            case 'FAQ':
                return $this->generateFAQSchema($data);
            case 'Article':
                return $this->generateArticleSchema($data);
            default:
                return '';
        }
    }

    /**
     * Generate Local Business Schema
     */
    private function generateLocalBusinessSchema($data = []): string
    {
        $schema = [
            "@context" => "https://schema.org",
            "@type" => "LocalBusiness",
            "name" => $this->globalSettings['business_name'],
            "description" => $data['description'] ?? "Service laptop dan komputer terpercaya di Bandung",
            "url" => base_url(),
            "telephone" => $this->globalSettings['phone'],
            "email" => $this->globalSettings['email'],
            "address" => [
                "@type" => "PostalAddress",
                "streetAddress" => $this->globalSettings['address'],
                "addressLocality" => "Bandung",
                "addressRegion" => "Jawa Barat",
                "postalCode" => "40132",
                "addressCountry" => "ID"
            ],
            "geo" => [
                "@type" => "GeoCoordinates",
                "latitude" => (float)$this->globalSettings['coordinates_lat'],
                "longitude" => (float)$this->globalSettings['coordinates_lng']
            ],
            "openingHoursSpecification" => $this->generateOpeningHours(),
            "priceRange" => "$$",
            "aggregateRating" => [
                "@type" => "AggregateRating",
                "ratingValue" => "4.8",
                "reviewCount" => "350",
                "bestRating" => "5",
                "worstRating" => "1"
            ],
            "sameAs" => array_values($this->globalSettings['social_media'])
        ];

        return json_encode($schema, JSON_UNESCAPED_SLASHES);
    }

    /**
     * Generate opening hours from settings
     */
    private function generateOpeningHours(): array
    {
        $hours = $this->globalSettings['business_hours'];
        $openingHours = [];

        if (isset($hours['weekdays'])) {
            $openingHours[] = [
                "@type" => "OpeningHoursSpecification",
                "dayOfWeek" => ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
                "opens" => "08:00",
                "closes" => "20:00"
            ];
        }

        if (isset($hours['saturday'])) {
            $openingHours[] = [
                "@type" => "OpeningHoursSpecification",
                "dayOfWeek" => "Saturday",
                "opens" => "08:00",
                "closes" => "18:00"
            ];
        }

        if (isset($hours['sunday'])) {
            $openingHours[] = [
                "@type" => "OpeningHoursSpecification",
                "dayOfWeek" => "Sunday",
                "opens" => "09:00",
                "closes" => "17:00"
            ];
        }

        return $openingHours;
    }

    /**
     * Generate Service Schema
     */
    private function generateServiceSchema($data): string
    {
        $schema = [
            "@context" => "https://schema.org",
            "@type" => "Service",
            "name" => $data['name'],
            "description" => $data['description'],
            "provider" => [
                "@type" => "LocalBusiness",
                "name" => $this->globalSettings['business_name']
            ],
            "areaServed" => [
                "@type" => "City",
                "name" => "Bandung"
            ],
            "offers" => [
                "@type" => "Offer",
                "priceRange" => $data['price_range'] ?? "$$"
            ]
        ];

        return json_encode($schema, JSON_UNESCAPED_SLASHES);
    }

    /**
     * Generate Review Schema
     */
    private function generateReviewSchema($reviews): string
    {
        $reviewSchemas = [];
        foreach ($reviews as $review) {
            $reviewSchemas[] = [
                "@type" => "Review",
                "author" => [
                    "@type" => "Person",
                    "name" => $review['name']
                ],
                "reviewRating" => [
                    "@type" => "Rating",
                    "ratingValue" => $review['rating'],
                    "bestRating" => "5"
                ],
                "reviewBody" => $review['comment']
            ];
        }

        return json_encode([
            "@context" => "https://schema.org",
            "@type" => "ItemList",
            "itemListElement" => $reviewSchemas
        ], JSON_UNESCAPED_SLASHES);
    }

    /**
     * Generate FAQ Schema
     */
    private function generateFAQSchema($faqs): string
    {
        $faqSchemas = [];
        foreach ($faqs as $faq) {
            $faqSchemas[] = [
                "@type" => "Question",
                "name" => $faq['question'],
                "acceptedAnswer" => [
                    "@type" => "Answer",
                    "text" => strip_tags($faq['answer'])
                ]
            ];
        }

        return json_encode([
            "@context" => "https://schema.org",
            "@type" => "FAQPage",
            "mainEntity" => $faqSchemas
        ], JSON_UNESCAPED_SLASHES);
    }

    /**
     * Generate Article Schema
     */
    private function generateArticleSchema($article): string
    {
        $schema = [
            "@context" => "https://schema.org",
            "@type" => "Article",
            "headline" => $article['title'],
            "description" => $article['excerpt'],
            "image" => $article['featured_image'],
            "author" => [
                "@type" => "Person",
                "name" => $article['author']
            ],
            "publisher" => [
                "@type" => "Organization",
                "name" => $this->globalSettings['business_name'],
                "logo" => [
                    "@type" => "ImageObject",
                    "url" => base_url('assets/images/logo.png')
                ]
            ],
            "datePublished" => $article['published_at'],
            "dateModified" => $article['updated_at']
        ];

        return json_encode($schema, JSON_UNESCAPED_SLASHES);
    }
}