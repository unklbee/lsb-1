<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // SEO Data
        $seoData = [
            'title' => 'Service Laptop Bandung Terpercaya - Perbaikan Laptop & Komputer Profesional',
            'description' => 'Service laptop Bandung terbaik dengan teknisi berpengalaman. Perbaikan laptop, komputer, upgrade hardware dengan garansi. Melayani panggilan ke rumah dan kantor.',
            'keywords' => 'service laptop bandung, perbaikan laptop bandung, service komputer bandung, teknisi laptop bandung, upgrade laptop bandung',
            'canonical' => base_url(),
            'og_title' => 'Service Laptop Bandung #1 - Perbaikan Profesional',
            'og_description' => 'Layanan service laptop Bandung terpercaya sejak 2015. Teknisi berpengalaman, spare part original, garansi resmi. Hubungi sekarang!',
            'og_image' => base_url('assets/images/service-laptop-bandung-og.jpg'),
            'schema_type' => 'LocalBusiness'
        ];

        // Service data for homepage
        $services = [
            [
                'name' => 'Service Laptop',
                'description' => 'Perbaikan semua merk laptop dengan teknisi berpengalaman',
                'icon' => 'laptop',
                'price_start' => 'Mulai 50rb'
            ],
            [
                'name' => 'Service Komputer',
                'description' => 'Perbaikan PC desktop, upgrade hardware, instalasi software',
                'icon' => 'desktop',
                'price_start' => 'Mulai 75rb'
            ],
            [
                'name' => 'Upgrade Hardware',
                'description' => 'Upgrade RAM, SSD, processor untuk performa maksimal',
                'icon' => 'memory',
                'price_start' => 'Mulai 100rb'
            ],
            [
                'name' => 'Data Recovery',
                'description' => 'Pemulihan data hilang atau rusak dengan tingkat keberhasilan tinggi',
                'icon' => 'hard-drive',
                'price_start' => 'Mulai 200rb'
            ]
        ];

        // Testimonials
        $testimonials = [
            [
                'name' => 'Ahmad Rifai',
                'location' => 'Dago, Bandung',
                'rating' => 5,
                'comment' => 'Service laptop Bandung terbaik! Laptop saya yang mati total bisa hidup lagi. Pelayanan cepat dan harga terjangkau.',
                'service' => 'Perbaikan Motherboard'
            ],
            [
                'name' => 'Sari Indrawati',
                'location' => 'Cihampelas, Bandung',
                'rating' => 5,
                'comment' => 'Rekomendasi banget untuk service laptop di Bandung. Teknisinya profesional dan honest. Laptop gaming saya kembali normal.',
                'service' => 'Cleaning & Thermal Paste'
            ],
            [
                'name' => 'Dedi Kurniawan',
                'location' => 'Antapani, Bandung',
                'rating' => 5,
                'comment' => 'Sudah 3x service laptop disini, selalu puas. Harga service laptop Bandung paling kompetitif dengan kualitas terjamin.',
                'service' => 'Upgrade SSD & RAM'
            ]
        ];

        // FAQ for homepage
        $faqs = [
            [
                'question' => 'Berapa lama proses service laptop di Bandung?',
                'answer' => 'Untuk service ringan seperti cleaning 1-2 hari. Service berat seperti ganti motherboard 3-7 hari tergantung ketersediaan spare part.'
            ],
            [
                'question' => 'Apakah ada garansi service laptop?',
                'answer' => 'Ya, kami memberikan garansi 1-3 bulan untuk setiap perbaikan tergantung jenis kerusakan dan spare part yang diganti.'
            ],
            [
                'question' => 'Melayani panggilan service laptop ke rumah?',
                'answer' => 'Ya, kami melayani service laptop panggilan untuk area Bandung dan sekitarnya dengan biaya transportasi minimal.'
            ]
        ];

        // Merge with global data for view
        $globalSeo = [
            'site_name' => 'LaptopService Bandung',
            'business_name' => 'CV. Teknologi Solusi Digital',
            'phone' => '+62-22-1234-5678',
            'whatsapp' => '+62-812-3456-7890',
            'email' => 'info@laptopservicebandung.com',
            'address' => 'Jl. Soekarno Hatta No. 123, Bandung 40132',
            'social_media' => [
                'facebook' => 'https://facebook.com/laptopservicebandung',
                'instagram' => 'https://instagram.com/laptopservice_bdg',
                'youtube' => 'https://youtube.com/@laptopservicebandung'
            ]
        ];

        $navigation = [
            [
                'title' => 'Beranda',
                'url' => '/',
                'active' => true
            ],
            [
                'title' => 'Layanan',
                'url' => '/layanan',
                'active' => false
            ],
            [
                'title' => 'Blog',
                'url' => '/blog',
                'active' => false
            ],
            [
                'title' => 'FAQ',
                'url' => '/faq',
                'active' => false
            ],
            [
                'title' => 'Testimonial',
                'url' => '/testimonial',
                'active' => false
            ],
            [
                'title' => 'Tentang Kami',
                'url' => '/tentang-kami',
                'active' => false
            ],
            [
                'title' => 'Kontak',
                'url' => '/kontak',
                'active' => false
            ]
        ];

        $data = [
            'seo' => $seoData,
            'services' => $services,
            'testimonials' => $testimonials,
            'faqs' => $faqs,
            'stats' => [
                'experience' => '8+ Tahun',
                'customers' => '5000+',
                'satisfaction' => '98%',
                'warranty' => '3 Bulan'
            ],
            'globalSeo' => $globalSeo,
            'navigation' => $navigation
        ];

        return view('home/index', $data);
    }
}