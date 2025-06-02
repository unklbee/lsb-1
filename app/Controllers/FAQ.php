<?php

namespace App\Controllers;

use App\Models\FaqModel;
use App\Models\FaqCategoryModel;
use CodeIgniter\HTTP\RedirectResponse;

class FAQ extends BaseController
{
    protected FaqModel $faqModel;
    protected FaqCategoryModel $faqCategoryModel;

    public function __construct()
    {
        $this->faqModel = new FaqModel();
        $this->faqCategoryModel = new FaqCategoryModel();
    }

    public function index(): string
    {
        $seoData = [
            'title' => 'FAQ Service Laptop Bandung - Pertanyaan yang Sering Diajukan',
            'description' => 'Kumpulan pertanyaan dan jawaban seputar service laptop, komputer, upgrade hardware, dan data recovery di Bandung. Informasi lengkap dari teknisi berpengalaman.',
            'keywords' => 'faq service laptop bandung, pertanyaan service komputer, tanya jawab teknisi, informasi service laptop',
            'canonical' => base_url('/faq'),
            'og_title' => 'FAQ Service Laptop Bandung - Tanya Jawab Lengkap',
            'og_description' => 'Dapatkan jawaban untuk pertanyaan umum seputar service laptop dan komputer di Bandung.',
            'og_image' => base_url('assets/images/faq-service-laptop-bandung.jpg')
        ];

        // Get FAQ categories with their FAQs
        $faqCategories = $this->getFaqCategoriesWithQuestions();

        $data = [
            'seo' => $seoData,
            'faqCategories' => $faqCategories,
            'globalSeo' => $this->globalSettings,
            'navigation' => $this->getNavigationData('faq'),
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => base_url()],
                ['name' => 'FAQ', 'url' => base_url('/faq')]
            ]
        ];

        return view('faq/index', $data);
    }

    /**
     * Get FAQ categories with their questions from database
     */
    private function getFaqCategoriesWithQuestions(): array
    {
        // Get active categories
        $categories = $this->faqCategoryModel->getActiveCategories();

        if (empty($categories)) {
            // If no categories exist, return sample data or empty array
            return $this->getSampleFaqData();
        }

        $faqCategories = [];

        foreach ($categories as $category) {
            // Get FAQs for this category
            $faqs = $this->faqModel->getByCategory($category['id']);

            // Only include categories that have FAQs
            if (!empty($faqs)) {
                $faqCategories[$category['slug']] = [
                    'title' => $category['name'],
                    'description' => $category['description'] ?? '',
                    'faqs' => $faqs
                ];
            }
        }

        // If no categories with FAQs exist, return sample data
        if (empty($faqCategories)) {
            return $this->getSampleFaqData();
        }

        return $faqCategories;
    }

    /**
     * Get FAQ by category slug
     */
    public function category($categorySlug = null): string|RedirectResponse
    {
        if (!$categorySlug) {
            return redirect()->to('/faq');
        }

        // Get category info
        $category = $this->faqCategoryModel->where('slug', $categorySlug)
            ->where('is_active', 1)
            ->first();

        if (!$category) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kategori FAQ tidak ditemukan');
        }

        // Get FAQs for this category
        $faqs = $this->faqModel->getByCategory($category['id']);

        $seoData = [
            'title' => $category['name'] . ' - FAQ Service Laptop Bandung',
            'description' => $category['description'] ?: 'FAQ ' . $category['name'] . ' service laptop dan komputer di Bandung.',
            'keywords' => 'faq ' . strtolower($category['name']) . ', service laptop bandung',
            'canonical' => base_url('/faq/category/' . $categorySlug),
            'og_title' => $category['name'] . ' - FAQ Service Laptop Bandung',
            'og_description' => $category['description'] ?: $category['name'],
            'og_image' => base_url('assets/images/faq-' . $categorySlug . '.jpg')
        ];

        $data = [
            'seo' => $seoData,
            'category' => $category,
            'faqs' => $faqs,
            'globalSeo' => $this->globalSettings,
            'navigation' => $this->getNavigationData('faq'),
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => base_url()],
                ['name' => 'FAQ', 'url' => base_url('/faq')],
                ['name' => $category['name'], 'url' => base_url('/faq/category/' . $categorySlug)]
            ]
        ];

        return view('faq/category', $data);
    }

    /**
     * Search FAQs
     */
    public function search()
    {
        $query = $this->request->getGet('q');

        if (empty($query) || strlen(trim($query)) < 3) {
            return redirect()->to('/faq')->with('error', 'Kata kunci pencarian minimal 3 karakter');
        }

        // Search in questions and answers
        $searchResults = $this->searchFaqs($query);

        $seoData = [
            'title' => 'Hasil Pencarian FAQ: "' . $query . '" - Service Laptop Bandung',
            'description' => 'Hasil pencarian FAQ untuk "' . $query . '" seputar service laptop dan komputer di Bandung.',
            'keywords' => 'search faq, ' . $query . ', service laptop bandung',
            'canonical' => base_url('/faq/search?q=' . urlencode($query)),
            'og_title' => 'Pencarian FAQ: ' . $query,
            'og_description' => 'Hasil pencarian FAQ untuk "' . $query . '"',
            'og_image' => base_url('assets/images/faq-search.jpg')
        ];

        $data = [
            'seo' => $seoData,
            'query' => $query,
            'searchResults' => $searchResults,
            'totalResults' => count($searchResults),
            'globalSeo' => $this->globalSettings,
            'navigation' => $this->getNavigationData('faq'),
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => base_url()],
                ['name' => 'FAQ', 'url' => base_url('/faq')],
                ['name' => 'Pencarian: ' . $query, 'url' => '']
            ]
        ];

        return view('faq/search', $data);
    }

    /**
     * Search FAQs in questions and answers
     */
    private function searchFaqs($query): array
    {
        return $this->faqModel->select('faqs.*, faq_categories.name as category_name, faq_categories.slug as category_slug')
            ->join('faq_categories', 'faq_categories.id = faqs.category_id', 'left')
            ->where('faqs.is_active', 1)
            ->groupStart()
            ->like('faqs.question', $query)
            ->orLike('faqs.answer', $query)
            ->groupEnd()
            ->orderBy('faqs.view_count', 'DESC')
            ->findAll();
    }

    /**
     * Get popular FAQs
     */
    public function popular()
    {
        $popularFaqs = $this->faqModel->getPopularFaqs(20);

        $seoData = [
            'title' => 'FAQ Populer - Service Laptop Bandung',
            'description' => 'Kumpulan pertanyaan yang paling sering ditanyakan seputar service laptop dan komputer di Bandung.',
            'keywords' => 'faq populer, pertanyaan populer service laptop bandung',
            'canonical' => base_url('/faq/popular'),
            'og_title' => 'FAQ Populer Service Laptop Bandung',
            'og_description' => 'Pertanyaan yang paling sering ditanyakan tentang service laptop',
            'og_image' => base_url('assets/images/faq-popular.jpg')
        ];

        $data = [
            'seo' => $seoData,
            'popularFaqs' => $popularFaqs,
            'globalSeo' => $this->globalSettings,
            'navigation' => $this->getNavigationData('faq'),
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => base_url()],
                ['name' => 'FAQ', 'url' => base_url('/faq')],
                ['name' => 'FAQ Populer', 'url' => base_url('/faq/popular')]
            ]
        ];

        return view('faq/popular', $data);
    }

    /**
     * Increment FAQ view count (AJAX)
     */
    public function incrementView($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(404);
        }

        $result = $this->faqModel->incrementViewCount($id);

        return $this->response->setJSON([
            'status' => $result ? 'success' : 'error',
            'message' => $result ? 'View count updated' : 'Failed to update view count'
        ]);
    }

    /**
     * API endpoint to get FAQs by category
     */
    public function getFaqsJson($categorySlug = null)
    {
        if ($categorySlug) {
            $category = $this->faqCategoryModel->where('slug', $categorySlug)
                ->where('is_active', 1)
                ->first();

            if (!$category) {
                return $this->response->setStatusCode(404)
                    ->setJSON(['error' => 'Category not found']);
            }

            $faqs = $this->faqModel->getByCategory($category['id']);
        } else {
            $faqs = $this->faqModel->getActiveFaqs();
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $faqs
        ]);
    }

    /**
     * API endpoint to get FAQ categories
     */
    public function getCategoriesJson()
    {
        $categories = $this->faqCategoryModel->getActiveCategories();

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $categories
        ]);
    }

    /**
     * Sample FAQ data for when database is empty
     * This provides fallback content during initial setup
     */
    private function getSampleFaqData(): array
    {
        return [
            'umum' => [
                'title' => 'Pertanyaan Umum',
                'description' => 'Pertanyaan umum seputar layanan service laptop',
                'faqs' => [
                    [
                        'id' => 0,
                        'question' => 'Berapa lama waktu service laptop di Bandung?',
                        'answer' => 'Waktu service bervariasi tergantung jenis kerusakan:<br>
                        • Service ringan (cleaning, instalasi): 1-2 hari<br>
                        • Ganti komponen (layar, keyboard): 2-3 hari<br>
                        • Perbaikan motherboard: 3-7 hari<br>
                        • Tergantung ketersediaan spare part',
                        'category_name' => 'Pertanyaan Umum',
                        'view_count' => 0
                    ],
                    [
                        'id' => 0,
                        'question' => 'Apakah ada garansi untuk service laptop?',
                        'answer' => 'Ya, kami memberikan garansi resmi untuk setiap perbaikan:<br>
                        • Garansi workmanship: 1-3 bulan<br>
                        • Garansi spare part: sesuai garansi distributor<br>
                        • Garansi tidak berlaku untuk kerusakan akibat benturan atau cairan',
                        'category_name' => 'Pertanyaan Umum',
                        'view_count' => 0
                    ]
                ]
            ],
            'service-laptop' => [
                'title' => 'Service Laptop',
                'description' => 'FAQ khusus service laptop',
                'faqs' => [
                    [
                        'id' => 0,
                        'question' => 'Laptop saya tidak mau nyala, apa penyebabnya?',
                        'answer' => 'Laptop tidak nyala bisa disebabkan beberapa faktor:<br>
                        • Adapter atau battery bermasalah<br>
                        • Motherboard rusak<br>
                        • RAM tidak terpasang dengan baik<br>
                        • Short circuit akibat cairan<br>
                        Perlu diagnosa lebih lanjut untuk memastikan penyebab pasti.',
                        'category_name' => 'Service Laptop',
                        'view_count' => 0
                    ]
                ]
            ]
        ];
    }

    /**
     * Submit new FAQ question (from users)
     */
    public function submitQuestion()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('/faq');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email',
            'question' => 'required|min_length[10]|max_length[500]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors()
            ]);
        }

        // Save question to database (you might want to create a separate table for user questions)
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'question' => $this->request->getPost('question'),
            'ip_address' => $this->request->getIPAddress(),
            'created_at' => date('Y-m-d H:i:s')
        ];

        // You can save to a 'user_questions' table or send via email
        // For now, we'll just return success

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Pertanyaan Anda telah dikirim. Tim kami akan segera merespons.'
        ]);
    }
}