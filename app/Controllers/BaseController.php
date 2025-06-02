<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    protected $request;
    protected $helpers = ['url', 'form', 'html', 'seo'];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Load global data for all views
        $this->loadGlobalData();
    }

    protected function getGlobalData()
    {
        return [
            'site_name' => 'LaptopService Bandung',
            'business_name' => 'CV. Teknologi Solusi Digital',
            'phone' => '+62-22-1234-5678',
            'whatsapp' => '+62-812-3456-7890',
            'email' => 'info@laptopservicebandung.com',
            'address' => 'Jl. Soekarno Hatta No. 123, Bandung 40132',
            'maps_embed' => 'https://maps.google.com/embed?pb=!1m18!1m12...',
            'social_media' => [
                'facebook' => 'https://facebook.com/laptopservicebandung',
                'instagram' => 'https://instagram.com/laptopservice_bdg',
                'youtube' => 'https://youtube.com/@laptopservicebandung'
            ],
            'business_hours' => [
                'senin' => '08:00 - 20:00',
                'selasa' => '08:00 - 20:00',
                'rabu' => '08:00 - 20:00',
                'kamis' => '08:00 - 20:00',
                'jumat' => '08:00 - 20:00',
                'sabtu' => '08:00 - 18:00',
                'minggu' => '09:00 - 17:00'
            ]
        ];
    }

    protected function getNavigationData($currentPage = '')
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

    protected function loadGlobalData()
    {
        // Global SEO settings
        $globalSeo = $this->getGlobalData();

        // Navigation menu
        $navigation = $this->getNavigationData();

        // Make data available to all views
        $viewData = [
            'globalSeo' => $globalSeo,
            'navigation' => $navigation
        ];

        // Store in service for global access
        service('renderer')->setData($viewData);
    }

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
            default:
                return '';
        }
    }

    private function generateLocalBusinessSchema($data)
    {
        // Get global data from service instead of view helper
        $globalSeo = [
            'business_name' => 'CV. Teknologi Solusi Digital',
            'phone' => '+62-22-1234-5678',
            'email' => 'info@laptopservicebandung.com',
            'address' => 'Jl. Soekarno Hatta No. 123, Bandung 40132'
        ];

        $schema = [
            "@context" => "https://schema.org",
            "@type" => "LocalBusiness",
            "name" => $globalSeo['business_name'],
            "description" => $data['description'] ?? "Service laptop dan komputer terpercaya di Bandung",
            "url" => base_url(),
            "telephone" => $globalSeo['phone'],
            "email" => $globalSeo['email'],
            "address" => [
                "@type" => "PostalAddress",
                "streetAddress" => "Jl. Soekarno Hatta No. 123",
                "addressLocality" => "Bandung",
                "addressRegion" => "Jawa Barat",
                "postalCode" => "40132",
                "addressCountry" => "ID"
            ],
            "geo" => [
                "@type" => "GeoCoordinates",
                "latitude" => -6.9175,
                "longitude" => 107.6191
            ],
            "openingHoursSpecification" => [
                [
                    "@type" => "OpeningHoursSpecification",
                    "dayOfWeek" => ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
                    "opens" => "08:00",
                    "closes" => "20:00"
                ],
                [
                    "@type" => "OpeningHoursSpecification",
                    "dayOfWeek" => "Saturday",
                    "opens" => "08:00",
                    "closes" => "18:00"
                ],
                [
                    "@type" => "OpeningHoursSpecification",
                    "dayOfWeek" => "Sunday",
                    "opens" => "09:00",
                    "closes" => "17:00"
                ]
            ],
            "priceRange" => "$",
            "aggregateRating" => [
                "@type" => "AggregateRating",
                "ratingValue" => "4.8",
                "reviewCount" => "350",
                "bestRating" => "5",
                "worstRating" => "1"
            ]
        ];

        return json_encode($schema, JSON_UNESCAPED_SLASHES);
    }

    private function generateServiceSchema($data)
    {
        $schema = [
            "@context" => "https://schema.org",
            "@type" => "Service",
            "name" => $data['name'],
            "description" => $data['description'],
            "provider" => [
                "@type" => "LocalBusiness",
                "name" => 'CV. Teknologi Solusi Digital'
            ],
            "areaServed" => [
                "@type" => "City",
                "name" => "Bandung"
            ],
            "offers" => [
                "@type" => "Offer",
                "priceRange" => $data['price_range'] ?? "$"
            ]
        ];

        return json_encode($schema, JSON_UNESCAPED_SLASHES);
    }

    private function generateReviewSchema($reviews)
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

    private function generateFAQSchema($faqs)
    {
        $faqSchemas = [];
        foreach ($faqs as $faq) {
            $faqSchemas[] = [
                "@type" => "Question",
                "name" => $faq['question'],
                "acceptedAnswer" => [
                    "@type" => "Answer",
                    "text" => $faq['answer']
                ]
            ];
        }

        return json_encode([
            "@context" => "https://schema.org",
            "@type" => "FAQPage",
            "mainEntity" => $faqSchemas
        ], JSON_UNESCAPED_SLASHES);
    }
}