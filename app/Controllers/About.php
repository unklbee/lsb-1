<?php

namespace App\Controllers;

use App\Models\TestimonialModel;
use App\Models\ServiceModel;
use App\Models\SettingModel;

class About extends BaseController
{
    protected TestimonialModel $testimonialModel;
    protected ServiceModel $serviceModel;
    protected $settingModel;

    public function __construct()
    {
        $this->testimonialModel = new TestimonialModel();
        $this->serviceModel = new ServiceModel();
        $this->settingModel = new SettingModel();
    }

    public function index(): string
    {
        $seoData = [
            'title' => 'Tentang Kami - Service Laptop Bandung Terpercaya Sejak 2015',
            'description' => 'Mengenal LaptopService Bandung, penyedia jasa service laptop dan komputer terpercaya dengan teknisi berpengalaman sejak 2015. Komitmen pada kualitas dan kepuasan pelanggan.',
            'keywords' => 'tentang laptopservice bandung, profil perusahaan, sejarah service laptop bandung, visi misi, teknisi berpengalaman',
            'canonical' => base_url('/tentang-kami'),
            'og_title' => 'Tentang LaptopService Bandung - Teknisi Terpercaya',
            'og_description' => 'Pelajari lebih lanjut tentang LaptopService Bandung, komitmen kami terhadap kualitas service dan kepuasan pelanggan.',
            'og_image' => base_url('assets/images/tentang-kami-service-laptop-bandung.jpg')
        ];

        // Company information
        $companyInfo = [
            'founded_year' => '2015',
            'name' => $this->globalSettings['business_name'],
            'tagline' => $this->globalSettings['tagline'] ?? 'Service Laptop & Komputer Terpercaya',
            'description' => 'LaptopService Bandung adalah perusahaan yang bergerak di bidang jasa perbaikan dan maintenance laptop, komputer, serta perangkat teknologi lainnya. Dengan pengalaman lebih dari 8 tahun, kami telah melayani ribuan pelanggan di Bandung dan sekitarnya.',
            'vision' => 'Menjadi penyedia jasa service laptop dan komputer terdepan di Bandung yang dikenal karena kualitas, kepercayaan, dan inovasi dalam teknologi.',
            'mission' => [
                'Memberikan layanan service laptop dan komputer berkualitas tinggi dengan teknisi berpengalaman',
                'Menggunakan spare part original dan bergaransi untuk setiap perbaikan',
                'Memberikan harga yang kompetitif dan transparan tanpa biaya tersembunyi',
                'Membangun hubungan jangka panjang dengan pelanggan melalui kepercayaan dan kepuasan',
                'Terus berinovasi dan mengikuti perkembangan teknologi terkini'
            ],
            'values' => [
                'Integritas' => 'Berkomitmen pada kejujuran dan transparansi dalam setiap layanan',
                'Kualitas' => 'Mengutamakan kualitas dalam setiap perbaikan dan layanan',
                'Profesionalisme' => 'Bekerja dengan standar profesional dan etika yang tinggi',
                'Inovasi' => 'Selalu mengikuti perkembangan teknologi dan metode terbaru',
                'Kepuasan Pelanggan' => 'Mengutamakan kepuasan dan kepercayaan pelanggan'
            ]
        ];

        // Team information
        $teamMembers = [
            [
                'name' => 'Andi Kurniawan',
                'position' => 'Founder & Lead Technician',
                'experience' => '10+ Tahun',
                'specialization' => 'Motherboard Repair, Data Recovery',
                'photo' => '/assets/images/team/andi-kurniawan.jpg',
                'description' => 'Pendiri LaptopService Bandung dengan pengalaman lebih dari 10 tahun di bidang teknologi. Spesialis dalam perbaikan motherboard dan data recovery.'
            ],
            [
                'name' => 'Budi Santoso',
                'position' => 'Senior Technician',
                'experience' => '8+ Tahun',
                'specialization' => 'Hardware Upgrade, Gaming Laptop',
                'photo' => '/assets/images/team/budi-santoso.jpg',
                'description' => 'Teknisi senior yang ahli dalam upgrade hardware dan service laptop gaming. Berpengalaman menangani berbagai merk laptop.'
            ],
            [
                'name' => 'Sari Wulandari',
                'position' => 'Customer Service Manager',
                'experience' => '5+ Tahun',
                'specialization' => 'Customer Relations, Quality Control',
                'photo' => '/assets/images/team/sari-wulandari.jpg',
                'description' => 'Mengelola hubungan pelanggan dan memastikan kualitas layanan. Berpengalaman dalam menangani komplain dan kepuasan pelanggan.'
            ],
            [
                'name' => 'Dedi Prasetyo',
                'position' => 'Junior Technician',
                'experience' => '3+ Tahun',
                'specialization' => 'Software Installation, Virus Removal',
                'photo' => '/assets/images/team/dedi-prasetyo.jpg',
                'description' => 'Teknisi muda yang handal dalam instalasi software, pembersihan virus, dan optimasi sistem operasi.'
            ]
        ];

        // Company achievements
        $achievements = [
            [
                'title' => '5000+ Pelanggan Puas',
                'description' => 'Telah melayani lebih dari 5000 pelanggan dengan tingkat kepuasan 98%',
                'icon' => 'users',
                'number' => '5000+',
                'suffix' => 'Pelanggan'
            ],
            [
                'title' => '8+ Tahun Pengalaman',
                'description' => 'Berpengalaman lebih dari 8 tahun dalam industri service laptop',
                'icon' => 'calendar',
                'number' => '8+',
                'suffix' => 'Tahun'
            ],
            [
                'title' => '98% Tingkat Kepuasan',
                'description' => 'Tingkat kepuasan pelanggan mencapai 98% berdasarkan survey',
                'icon' => 'star',
                'number' => '98',
                'suffix' => '%'
            ],
            [
                'title' => '24/7 Customer Support',
                'description' => 'Layanan customer support yang tersedia 24 jam setiap hari',
                'icon' => 'clock',
                'number' => '24',
                'suffix' => '/7'
            ]
        ];

        // Services overview
        $services = $this->serviceModel->getActiveServices();
        $serviceCount = count($services);

        // Latest testimonials
        $testimonials = $this->testimonialModel->getFeaturedTestimonials(3);

        // Company stats from database or settings
        $companyStats = $this->globalSettings['stats'] ?? [
            'experience' => '8+ Tahun',
            'customers' => '5000+',
            'satisfaction' => '98%',
            'warranty' => '3 Bulan'
        ];

        // Certifications and partnerships
        $certifications = [
            [
                'name' => 'Certified Computer Technician',
                'issuer' => 'CompTIA A+',
                'year' => '2018'
            ],
            [
                'name' => 'Authorized Service Partner',
                'issuer' => 'ASUS Indonesia',
                'year' => '2019'
            ],
            [
                'name' => 'Certified Data Recovery Specialist',
                'issuer' => 'ACE Data Recovery',
                'year' => '2020'
            ]
        ];

        // Why choose us points
        $whyChooseUs = [
            [
                'title' => 'Teknisi Bersertifikat',
                'description' => 'Tim teknisi kami memiliki sertifikasi resmi dan pengalaman bertahun-tahun',
                'icon' => 'award'
            ],
            [
                'title' => 'Spare Part Original',
                'description' => 'Menggunakan spare part original dengan garansi resmi dari distributor',
                'icon' => 'shield-check'
            ],
            [
                'title' => 'Garansi Perbaikan',
                'description' => 'Setiap perbaikan dilengkapi garansi untuk memberikan ketenangan pikiran',
                'icon' => 'check-circle'
            ],
            [
                'title' => 'Harga Transparan',
                'description' => 'Estimasi biaya yang jelas tanpa biaya tersembunyi',
                'icon' => 'calculator'
            ],
            [
                'title' => 'Layanan Cepat',
                'description' => 'Proses diagnosa dan perbaikan yang cepat dengan kualitas terjamin',
                'icon' => 'zap'
            ],
            [
                'title' => 'Support 24/7',
                'description' => 'Customer support yang siap membantu kapan saja Anda membutuhkan',
                'icon' => 'headphones'
            ]
        ];

        $data = [
            'seo' => $seoData,
            'companyInfo' => $companyInfo,
            'teamMembers' => $teamMembers,
            'achievements' => $achievements,
            'services' => $services,
            'serviceCount' => $serviceCount,
            'testimonials' => $testimonials,
            'companyStats' => $companyStats,
            'certifications' => $certifications,
            'whyChooseUs' => $whyChooseUs,
            'globalSeo' => $this->globalSettings,
            'navigation' => $this->getNavigationData('about'),
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => base_url()],
                ['name' => 'Tentang Kami', 'url' => base_url('/tentang-kami')]
            ]
        ];

        return view('about/index', $data);
    }

    /**
     * Get company timeline for about page
     */
    private function getCompanyTimeline(): array
    {
        return [
            [
                'year' => '2015',
                'title' => 'Pendirian Perusahaan',
                'description' => 'LaptopService Bandung didirikan dengan visi menjadi penyedia layanan service laptop terpercaya di Bandung.',
                'milestone' => true
            ],
            [
                'year' => '2016',
                'title' => 'Ekspansi Layanan',
                'description' => 'Menambah layanan service komputer desktop dan upgrade hardware.',
                'milestone' => false
            ],
            [
                'year' => '2017',
                'title' => 'Partnership Resmi',
                'description' => 'Menjadi authorized service partner untuk beberapa brand laptop ternama.',
                'milestone' => true
            ],
            [
                'year' => '2018',
                'title' => 'Sertifikasi Teknisi',
                'description' => 'Seluruh teknisi mendapatkan sertifikasi resmi CompTIA A+.',
                'milestone' => false
            ],
            [
                'year' => '2019',
                'title' => '1000+ Pelanggan',
                'description' => 'Mencapai milestone 1000+ pelanggan yang telah dilayani.',
                'milestone' => true
            ],
            [
                'year' => '2020',
                'title' => 'Layanan Data Recovery',
                'description' => 'Menambah layanan khusus data recovery dengan peralatan canggih.',
                'milestone' => false
            ],
            [
                'year' => '2021',
                'title' => 'Workshop Baru',
                'description' => 'Pindah ke lokasi workshop yang lebih besar dengan fasilitas lengkap.',
                'milestone' => true
            ],
            [
                'year' => '2022',
                'title' => '5000+ Pelanggan',
                'description' => 'Mencapai milestone 5000+ pelanggan dengan tingkat kepuasan 98%.',
                'milestone' => true
            ],
            [
                'year' => '2023',
                'title' => 'Digitalisasi Layanan',
                'description' => 'Meluncurkan website resmi dan sistem booking online untuk kemudahan pelanggan.',
                'milestone' => false
            ]
        ];
    }

    /**
     * Get company information for API
     */
    public function getCompanyInfoJson()
    {
        $companyInfo = [
            'name' => $this->globalSettings['business_name'],
            'founded' => 2015,
            'experience' => '8+ years',
            'address' => $this->globalSettings['address'],
            'phone' => $this->globalSettings['phone'],
            'email' => $this->globalSettings['email'],
            'social_media' => $this->globalSettings['social_media'],
            'stats' => $this->globalSettings['stats']
        ];

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $companyInfo
        ]);
    }
}