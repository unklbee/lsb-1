<?php

namespace App\Controllers;

use App\Models\TestimonialModel;

class Testimonial extends BaseController
{
    protected TestimonialModel $testimonialModel;

    public function __construct()
    {
        $this->testimonialModel = new TestimonialModel();
    }

    public function index(): string
    {
        $seoData = [
            'title' => 'Testimoni Service Laptop Bandung - Ulasan Pelanggan Terpercaya',
            'description' => 'Baca testimoni dan ulasan nyata dari pelanggan service laptop Bandung. Pengalaman positif perbaikan laptop, komputer, dan upgrade hardware dengan teknisi profesional.',
            'keywords' => 'testimoni service laptop bandung, ulasan pelanggan, review service komputer, pengalaman service laptop',
            'canonical' => base_url('/testimonial'),
            'og_title' => 'Testimoni Service Laptop Bandung - Kepuasan Pelanggan',
            'og_description' => 'Baca pengalaman nyata pelanggan yang telah menggunakan jasa service laptop dan komputer terpercaya di Bandung.',
            'og_image' => base_url('assets/images/testimoni-service-laptop-bandung.jpg')
        ];

        // Get published testimonials with pagination
        $page = (int) ($this->request->getGet('page') ?? 1);
        $perPage = 12;
        $offset = ($page - 1) * $perPage;

        $testimonials = $this->testimonialModel->getPublishedTestimonials();
        $totalTestimonials = count($testimonials);

        // Apply pagination
        $paginatedTestimonials = array_slice($testimonials, $offset, $perPage);
        $totalPages = ceil($totalTestimonials / $perPage);

        // Get featured testimonials for hero section
        $featuredTestimonials = $this->testimonialModel->getFeaturedTestimonials(3);

        // Get average rating
        $ratingData = $this->testimonialModel->getAverageRating();

        // Group testimonials by service type for filtering
        $serviceTypes = [];
        foreach ($testimonials as $testimonial) {
            $serviceTypes[$testimonial['service_type']] = $testimonial['service_type'];
        }

        // Calculate rating distribution
        $ratingDistribution = $this->calculateRatingDistribution($testimonials);

        $data = [
            'seo' => $seoData,
            'testimonials' => $paginatedTestimonials,
            'featuredTestimonials' => $featuredTestimonials,
            'totalTestimonials' => $totalTestimonials,
            'averageRating' => $ratingData['avg_rating'],
            'totalReviews' => $ratingData['total_reviews'],
            'serviceTypes' => $serviceTypes,
            'ratingDistribution' => $ratingDistribution,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'hasNext' => $page < $totalPages,
            'hasPrev' => $page > 1,
            'nextPage' => $page + 1,
            'prevPage' => $page - 1,
            'globalSeo' => $this->globalSettings,
            'navigation' => $this->getNavigationData('testimonial'),
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => base_url()],
                ['name' => 'Testimoni', 'url' => base_url('/testimonial')]
            ]
        ];

        return view('testimonial/index', $data);
    }

    /**
     * Filter testimonials by service type
     */
    public function filter($serviceType = null)
    {
        $testimonials = $this->testimonialModel->getPublishedTestimonials();

        if ($serviceType && $serviceType !== 'all') {
            $testimonials = array_filter($testimonials, function($testimonial) use ($serviceType) {
                return strtolower(str_replace(' ', '-', $testimonial['service_type'])) === $serviceType;
            });
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data' => array_values($testimonials)
        ]);
    }

    /**
     * Submit new testimonial
     */
    public function submit()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email',
            'phone' => 'permit_empty|min_length[10]|max_length[15]',
            'location' => 'permit_empty|max_length[100]',
            'service_type' => 'required|max_length[100]',
            'rating' => 'required|integer|greater_than[0]|less_than[6]',
            'comment' => 'required|min_length[10]|max_length[1000]'
        ], [
            'name' => [
                'required' => 'Nama wajib diisi',
                'min_length' => 'Nama minimal 3 karakter',
                'max_length' => 'Nama maksimal 100 karakter'
            ],
            'email' => [
                'required' => 'Email wajib diisi',
                'valid_email' => 'Format email tidak valid'
            ],
            'phone' => [
                'min_length' => 'Nomor telepon minimal 10 digit',
                'max_length' => 'Nomor telepon maksimal 15 digit'
            ],
            'service_type' => [
                'required' => 'Jenis layanan wajib dipilih'
            ],
            'rating' => [
                'required' => 'Rating wajib dipilih',
                'greater_than' => 'Rating minimal 1 bintang',
                'less_than' => 'Rating maksimal 5 bintang'
            ],
            'comment' => [
                'required' => 'Komentar wajib diisi',
                'min_length' => 'Komentar minimal 10 karakter',
                'max_length' => 'Komentar maksimal 1000 karakter'
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => $validation->getErrors()
                ]);
            }
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'location' => $this->request->getPost('location'),
            'service_type' => $this->request->getPost('service_type'),
            'rating' => $this->request->getPost('rating'),
            'comment' => $this->request->getPost('comment'),
            'is_published' => 0, // Admin needs to approve
            'is_featured' => 0,
            'sort_order' => 0
        ];

        try {
            $this->testimonialModel->insert($data);

            $message = 'Terima kasih atas testimoni Anda! Testimoni akan ditampilkan setelah diverifikasi oleh admin.';

            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => $message
                ]);
            }

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            log_message('error', 'Testimonial submission error: ' . $e->getMessage());

            $errorMessage = 'Maaf, terjadi kesalahan. Silakan coba lagi atau hubungi kami via WhatsApp.';

            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $errorMessage
                ]);
            }

            return redirect()->back()->withInput()->with('error', $errorMessage);
        }
    }

    /**
     * Get testimonials JSON for API
     */
    public function getTestimonialsJson()
    {
        $limit = $this->request->getGet('limit') ?? 10;
        $serviceType = $this->request->getGet('service_type');
        $featured = $this->request->getGet('featured');

        if ($featured) {
            $testimonials = $this->testimonialModel->getFeaturedTestimonials($limit);
        } else {
            $testimonials = $this->testimonialModel->getPublishedTestimonials();

            if ($serviceType) {
                $testimonials = array_filter($testimonials, function($testimonial) use ($serviceType) {
                    return strtolower($testimonial['service_type']) === strtolower($serviceType);
                });
            }

            $testimonials = array_slice($testimonials, 0, $limit);
        }

        return $this->response->setContentType('application/json')
            ->setBody(json_encode([
                'status' => 'success',
                'data' => array_values($testimonials),
                'total' => count($testimonials)
            ]));
    }

    /**
     * Calculate rating distribution for chart display
     */
    private function calculateRatingDistribution($testimonials): array
    {
        $distribution = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
        $total = count($testimonials);

        foreach ($testimonials as $testimonial) {
            $rating = (int) $testimonial['rating'];
            if (isset($distribution[$rating])) {
                $distribution[$rating]++;
            }
        }

        // Convert to percentages
        foreach ($distribution as $rating => $count) {
            $distribution[$rating] = $total > 0 ? round(($count / $total) * 100, 1) : 0;
        }

        return $distribution;
    }

    /**
     * Get service statistics
     */
    public function getStats()
    {
        $testimonials = $this->testimonialModel->getPublishedTestimonials();
        $ratingData = $this->testimonialModel->getAverageRating();

        $stats = [
            'total_reviews' => $ratingData['total_reviews'],
            'average_rating' => $ratingData['avg_rating'],
            'rating_distribution' => $this->calculateRatingDistribution($testimonials),
            'latest_review' => !empty($testimonials) ? $testimonials[0] : null
        ];

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $stats
        ]);
    }

    /**
     * RSS feed for testimonials
     */
    public function rss()
    {
        $testimonials = $this->testimonialModel->getPublishedTestimonials();
        $testimonials = array_slice($testimonials, 0, 20); // Latest 20

        $this->response->setContentType('application/rss+xml');

        $rss = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $rss .= '<rss version="2.0">' . "\n";
        $rss .= '<channel>' . "\n";
        $rss .= '<title>Testimoni Service Laptop Bandung</title>' . "\n";
        $rss .= '<description>Testimoni dan ulasan pelanggan service laptop Bandung terpercaya</description>' . "\n";
        $rss .= '<link>' . base_url('/testimonial') . '</link>' . "\n";
        $rss .= '<language>id-ID</language>' . "\n";
        $rss .= '<lastBuildDate>' . date('r') . '</lastBuildDate>' . "\n";

        foreach ($testimonials as $testimonial) {
            $rss .= '<item>' . "\n";
            $rss .= '<title><![CDATA[Testimoni dari ' . $testimonial['name'] . ' - ' . $testimonial['service_type'] . ']]></title>' . "\n";
            $rss .= '<description><![CDATA[' . $testimonial['comment'] . ' - Rating: ' . $testimonial['rating'] . '/5]]></description>' . "\n";
            $rss .= '<link>' . base_url('/testimonial') . '</link>' . "\n";
            $rss .= '<guid>' . base_url('/testimonial#testimonial-' . $testimonial['id']) . '</guid>' . "\n";
            $rss .= '<pubDate>' . date('r', strtotime($testimonial['created_at'])) . '</pubDate>' . "\n";
            $rss .= '<category>' . $testimonial['service_type'] . '</category>' . "\n";
            $rss .= '</item>' . "\n";
        }

        $rss .= '</channel>' . "\n";
        $rss .= '</rss>';

        return $this->response->setBody($rss);
    }
}