<?php

namespace App\Controllers;

use App\Models\ServiceModel;
use App\Models\FaqModel;
use CodeIgniter\HTTP\ResponseInterface;

class Services extends BaseController
{
    protected $serviceModel;
    protected $faqModel;

    public function __construct()
    {
        $this->serviceModel = new ServiceModel();
        $this->faqModel = new FaqModel();
    }

    public function index(): string
    {
        $seoData = [
            'title' => 'Layanan Service Laptop & Komputer Bandung Profesional',
            'description' => 'Layanan lengkap service laptop dan komputer di Bandung. Perbaikan hardware, software, upgrade, data recovery dengan teknisi berpengalaman dan garansi resmi.',
            'keywords' => 'layanan service laptop bandung, service komputer bandung, perbaikan laptop, upgrade hardware bandung, data recovery bandung',
            'canonical' => base_url('/layanan'),
            'og_title' => 'Layanan Service Laptop Bandung Terlengkap',
            'og_description' => 'Service laptop, komputer, upgrade hardware, data recovery di Bandung. Teknisi profesional, spare part original, garansi resmi.',
            'og_image' => base_url('assets/images/layanan-service-laptop-bandung.jpg')
        ];

        // Get services from database
        $servicesData = $this->serviceModel->getActiveServices();

        // Format services for view
        $services = [];
        foreach ($servicesData as $service) {
            $features = json_decode($service['features'], true) ?: [];
            $services[] = [
                'id' => $service['slug'],
                'name' => $service['name'],
                'short_description' => $service['short_description'],
                'description' => $service['description'],
                'features' => $features,
                'price_start' => $service['price_start'],
                'duration' => $service['duration'],
                'warranty' => $service['warranty'],
                'icon' => $service['icon'],
                'popular' => (bool)$service['is_popular']
            ];
        }

        $data = [
            'seo' => $seoData,
            'services' => $services,
            'globalSeo' => $this->globalSettings,
            'navigation' => $this->getNavigationData('services'),
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => base_url()],
                ['name' => 'Layanan', 'url' => base_url('/layanan')]
            ]
        ];

        return view('services/index', $data);
    }

    public function detail($slug): string
    {
        // Get service by slug from database
        $service = $this->serviceModel->getBySlug($slug);

        if (!$service) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Layanan tidak ditemukan');
        }

        // Format service data
        $formattedService = [
            'id' => $service['slug'],
            'name' => $service['name'],
            'slug' => $service['slug'],
            'short_description' => $service['short_description'],
            'description' => $service['description'],
            'features' => $service['features'], // Already decoded in ServiceModel
            'benefits' => $service['benefits'], // Already decoded in ServiceModel
            'process' => $service['process'], // Already decoded in ServiceModel
            'price_start' => $service['price_start'],
            'duration' => $service['duration'],
            'warranty' => $service['warranty'],
            'popular' => (bool)$service['is_popular']
        ];

        $seoData = [
            'title' => $service['meta_title'] ?: $service['name'] . ' Bandung Profesional - Garansi Resmi',
            'description' => $service['meta_description'] ?: $service['description'],
            'keywords' => $service['meta_keywords'] ?: generate_keywords(strtolower($service['name']), 'bandung', [
                'teknisi ' . strtolower($service['name']),
                strtolower($service['name']) . ' murah',
                strtolower($service['name']) . ' berkualitas'
            ]),
            'canonical' => base_url('/layanan/' . $slug),
            'og_title' => $service['name'] . ' Bandung Terbaik',
            'og_description' => $service['short_description'],
            'og_image' => $service['featured_image'] ?: base_url('assets/images/layanan-' . $slug . '.jpg')
        ];

        // Get related services (other active services except current)
        $relatedServices = $this->getRelatedServices($service['id']);

        // Get FAQs specific to this service
        $serviceFAQs = $this->getServiceFAQs($slug);

        $data = [
            'seo' => $seoData,
            'service' => $formattedService,
            'relatedServices' => $relatedServices,
            'faqs' => $serviceFAQs,
            'globalSeo' => $this->globalSettings,
            'navigation' => $this->getNavigationData('services'),
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => base_url()],
                ['name' => 'Layanan', 'url' => base_url('/layanan')],
                ['name' => $service['name'], 'url' => base_url('/layanan/' . $slug)]
            ]
        ];

        return view('services/detail', $data);
    }

    /**
     * Get related services (exclude current service)
     */
    private function getRelatedServices($currentServiceId): array
    {
        return $this->serviceModel->select('id, name, slug')
            ->where('is_active', 1)
            ->where('id !=', $currentServiceId)
            ->orderBy('sort_order', 'ASC')
            ->limit(3)
            ->findAll();
    }

    /**
     * Get FAQs related to specific service
     * This could be enhanced to have service-specific FAQs
     */
    private function getServiceFAQs($serviceSlug): array
    {// For now, get general FAQs
        // You could create a service_faqs table or add service_slug to faqs table
        // to have service-specific FAQs

        $faqs = $this->faqModel->select('question, answer')
            ->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->limit(5)
            ->findAll();

        // You could also filter by keywords related to the service
        // For example, if service is 'service-laptop', get FAQs containing 'laptop'
        $serviceKeywords = $this->getServiceKeywords($serviceSlug);
        if (!empty($serviceKeywords)) {
            $filteredFaqs = [];
            foreach ($faqs as $faq) {
                foreach ($serviceKeywords as $keyword) {
                    if (stripos($faq['question'], $keyword) !== false ||
                        stripos($faq['answer'], $keyword) !== false) {
                        $filteredFaqs[] = $faq;
                        break; // Don't add the same FAQ multiple times
                    }
                }
            }

            // If we found service-specific FAQs, use them, otherwise use general FAQs
            if (!empty($filteredFaqs)) {
                return array_slice($filteredFaqs, 0, 5);
            }
        }

        return $faqs;
    }

    /**
     * Get keywords for filtering service-specific FAQs
     */
    private function getServiceKeywords($serviceSlug): array
    {
        $keywords = [
            'service-laptop' => ['laptop', 'notebook'],
            'service-komputer' => ['komputer', 'pc', 'desktop'],
            'upgrade-hardware' => ['upgrade', 'ram', 'ssd', 'hardware'],
            'data-recovery' => ['data', 'recovery', 'harddisk', 'file']
        ];

        return $keywords[$serviceSlug] ?? [];
    }

    /**
     * API endpoint to get services data (for admin or other uses)
     */
    public function getServicesJson(): ResponseInterface
    {
        $services = $this->serviceModel->getActiveServices();

        foreach ($services as &$service) {
            $service['features'] = json_decode($service['features'], true) ?: [];
            $service['benefits'] = json_decode($service['benefits'], true) ?: [];
            $service['process'] = json_decode($service['process'], true) ?: [];
        }

        return $this->response->setContentType('application/json')
            ->setBody(json_encode([
                'status' => 'success',
                'data' => $services
            ]));
    }

    /**
     * Get service by slug for API
     */
    public function getServiceJson($slug)
    {
        $service = $this->serviceModel->getBySlug($slug);

        if (!$service) {
            return $this->response->setStatusCode(404)
                ->setContentType('application/json')
                ->setBody(json_encode([
                    'status' => 'error',
                    'message' => 'Service not found'
                ]));
        }

        return $this->response->setContentType('application/json')
            ->setBody(json_encode([
                'status' => 'success',
                'data' => $service
            ]));
    }
}