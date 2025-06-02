<?php

namespace App\Controllers;

class Services extends BaseController
{
    public function index()
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

        $services = [
            [
                'id' => 'service-laptop',
                'name' => 'Service Laptop',
                'short_description' => 'Perbaikan laptop semua merk dengan teknisi berpengalaman',
                'description' => 'Layanan service laptop profesional untuk semua merk dan tipe laptop. Kami menangani berbagai kerusakan mulai dari masalah software hingga perbaikan hardware kompleks.',
                'features' => [
                    'Perbaikan motherboard laptop',
                    'Ganti layar LCD/LED',
                    'Service keyboard dan touchpad',
                    'Perbaikan port charging',
                    'Cleaning dan thermal paste',
                    'Instalasi ulang Windows/Linux'
                ],
                'price_start' => 'Mulai 50rb',
                'duration' => '1-3 hari',
                'warranty' => '1-3 bulan',
                'icon' => 'laptop',
                'popular' => true
            ],
            [
                'id' => 'service-komputer',
                'name' => 'Service Komputer PC',
                'short_description' => 'Perbaikan komputer desktop dan PC rakitan',
                'description' => 'Service komputer PC desktop untuk masalah hardware dan software. Dari troubleshooting sederhana hingga perbaikan komponen yang rusak.',
                'features' => [
                    'Troubleshooting PC tidak nyala',
                    'Perbaikan PSU dan motherboard',
                    'Service VGA card',
                    'Cleaning hardware',
                    'Optimasi performa PC',
                    'Instalasi software'
                ],
                'price_start' => 'Mulai 75rb',
                'duration' => '1-2 hari',
                'warranty' => '1-3 bulan',
                'icon' => 'desktop'
            ],
            [
                'id' => 'upgrade-hardware',
                'name' => 'Upgrade Hardware',
                'short_description' => 'Upgrade RAM, SSD, dan komponen untuk performa maksimal',
                'description' => 'Tingkatkan performa laptop dan komputer Anda dengan upgrade hardware terbaik. Konsultasi gratis untuk memilih komponen yang tepat sesuai kebutuhan dan budget.',
                'features' => [
                    'Upgrade RAM untuk multitasking',
                    'Ganti HDD ke SSD untuk kecepatan',
                    'Upgrade processor (jika memungkinkan)',
                    'Upgrade VGA card gaming',
                    'Penambahan storage',
                    'Konsultasi hardware terbaik'
                ],
                'price_start' => 'Mulai 100rb',
                'duration' => '1-2 hari',
                'warranty' => '1-3 bulan',
                'icon' => 'memory'
            ],
            [
                'id' => 'data-recovery',
                'name' => 'Data Recovery',
                'short_description' => 'Pemulihan data hilang atau rusak dengan tingkat keberhasilan tinggi',
                'description' => 'Layanan pemulihan data profesional untuk harddisk rusak, file terhapus, atau sistem corrupt. Menggunakan tools profesional dengan tingkat keberhasilan tinggi.',
                'features' => [
                    'Recovery harddisk rusak/mati',
                    'Pemulihan file terhapus',
                    'Recovery data dari SSD',
                    'Pemulihan sistem corrupt',
                    'Backup data penting',
                    'Analisis kondisi storage'
                ],
                'price_start' => 'Mulai 200rb',
                'duration' => '2-7 hari',
                'warranty' => '1 bulan',
                'icon' => 'hard-drive'
            ],
            [
                'id' => 'instalasi-software',
                'name' => 'Instalasi Software',
                'short_description' => 'Instalasi sistem operasi dan software aplikasi',
                'description' => 'Instalasi lengkap sistem operasi Windows, Linux, Mac, dan berbagai software aplikasi sesuai kebutuhan Anda.',
                'features' => [
                    'Instalasi Windows 10/11',
                    'Instalasi Linux Ubuntu/Mint',
                    'Setup software office',
                    'Instalasi antivirus',
                    'Setup software desain',
                    'Konfigurasi sistem optimal'
                ],
                'price_start' => 'Mulai 50rb',
                'duration' => '1 hari',
                'warranty' => '1 bulan',
                'icon' => 'software'
            ],
            [
                'id' => 'maintenance-berkala',
                'name' => 'Maintenance Berkala',
                'short_description' => 'Perawatan rutin untuk menjaga performa optimal',
                'description' => 'Paket maintenance berkala untuk menjaga laptop dan komputer tetap dalam kondisi prima. Cocok untuk kantor dan bisnis.',
                'features' => [
                    'Cleaning hardware berkala',
                    'Update sistem dan driver',
                    'Optimasi performa',
                    'Backup data rutin',
                    'Monitoring kesehatan hardware',
                    'Laporan kondisi sistem'
                ],
                'price_start' => 'Mulai 150rb/bulan',
                'duration' => '2-4 jam',
                'warranty' => 'Sesuai kontrak',
                'icon' => 'maintenance'
            ],
            [
                'id' => 'upgrade-hardware',
                'name' => 'Upgrade Hardware',
                'short_description' => 'Upgrade RAM, SSD, dan komponen untuk performa maksimal',
                [
                    'id' => 'upgrade-hardware',
                    'name' => 'Upgrade Hardware',
                    'short_description' => 'Upgrade RAM, SSD, dan komponen untuk performa maksimal',
                    'description' => 'Tingkatkan performa laptop dan komputer Anda dengan upgrade hardware terbaik. Konsultasi gratis untuk memilih komponen yang tepat sesuai kebutuhan dan budget.',
                    'features' => [
                        'Upgrade RAM untuk multitasking',
                        'Ganti HDD ke SSD untuk kecepatan',
                        'Upgrade processor (jika memungkinkan)',
                        'Upgrade VGA card gaming',
                        'Penambahan storage',
                        'Konsultasi hardware terbaik'
                    ],
                    'price_start' => 'Mulai 100rb',
                    'duration' => '1-2 hari',
                    'warranty' => '1-3 bulan',
                    'icon' => 'memory'
                ],
                [
                    'id' => 'data-recovery',
                    'name' => 'Data Recovery',
                    'short_description' => 'Pemulihan data hilang atau rusak dengan tingkat keberhasilan tinggi',
                    'description' => 'Layanan pemulihan data profesional untuk harddisk rusak, file terhapus, atau sistem corrupt. Menggunakan tools profesional dengan tingkat keberhasilan tinggi.',
                    'features' => [
                        'Recovery harddisk rusak/mati',
                        'Pemulihan file terhapus',
                        'Recovery data dari SSD',
                        'Pemulihan sistem corrupt',
                        'Backup data penting',
                        'Analisis kondisi storage'
                    ],
                    'price_start' => 'Mulai 200rb',
                    'duration' => '2-7 hari',
                    'warranty' => '1 bulan',
                    'icon' => 'hard-drive'
                ],
                [
                    'id' => 'instalasi-software',
                    'name' => 'Instalasi Software',
                    'short_description' => 'Instalasi sistem operasi dan software aplikasi',
                    'description' => 'Instalasi lengkap sistem operasi Windows, Linux, Mac, dan berbagai software aplikasi sesuai kebutuhan Anda.',
                    'features' => [
                        'Instalasi Windows 10/11',
                        'Instalasi Linux Ubuntu/Mint',
                        'Setup software office',
                        'Instalasi antivirus',
                        'Setup software desain',
                        'Konfigurasi sistem optimal'
                    ],
                    'price_start' => 'Mulai 50rb',
                    'duration' => '1 hari',
                    'warranty' => '1 bulan',
                    'icon' => 'software'
                ],
                [
                    'id' => 'maintenance-berkala',
                    'name' => 'Maintenance Berkala',
                    'short_description' => 'Perawatan rutin untuk menjaga performa optimal',
                    'description' => 'Paket maintenance berkala untuk menjaga laptop dan komputer tetap dalam kondisi prima. Cocok untuk kantor dan bisnis.',
                    'features' => [
                        'Cleaning hardware berkala',
                        'Update sistem dan driver',
                        'Optimasi performa',
                        'Backup data rutin',
                        'Monitoring kesehatan hardware',
                        'Laporan kondisi sistem'
                    ],
                    'price_start' => 'Mulai 150rb/bulan',
                    'duration' => '2-4 jam',
                    'warranty' => 'Sesuai kontrak',
                    'icon' => 'maintenance'
                ]
            ],
        ];

        $data = [
            'seo' => $seoData,
            'services' => $services,
            'globalSeo' => [
                'site_name' => 'LaptopService Bandung',
                'business_name' => 'CV. Teknologi Solusi Digital',
                'phone' => '+62-22-1234-5678',
                'whatsapp' => '+62-812-3456-7890',
                'email' => 'info@laptopservicebandung.com',
                'social_media' => [
                    'facebook' => 'https://facebook.com/laptopservicebandung',
                    'instagram' => 'https://instagram.com/laptopservice_bdg',
                    'youtube' => 'https://youtube.com/@laptopservicebandung'
                ]
            ],
            'navigation' => [
                ['title' => 'Beranda', 'url' => '/', 'active' => false],
                ['title' => 'Layanan', 'url' => '/layanan', 'active' => true],
                ['title' => 'Blog', 'url' => '/blog', 'active' => false],
                ['title' => 'FAQ', 'url' => '/faq', 'active' => false],
                ['title' => 'Testimonial', 'url' => '/testimonial', 'active' => false],
                ['title' => 'Tentang Kami', 'url' => '/tentang-kami', 'active' => false],
                ['title' => 'Kontak', 'url' => '/kontak', 'active' => false]
            ],
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => base_url()],
                ['name' => 'Layanan', 'url' => base_url('/layanan')]
            ]
        ];

        return view('services/index', $data);
    }

    public function detail($slug)
    {
        // Get service by slug
        $service = $this->getServiceBySlug($slug);

        if (!$service) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Layanan tidak ditemukan');
        }

        $seoData = [
            'title' => $service['name'] . ' Bandung Profesional - Garansi Resmi',
            'description' => $service['description'] . ' Layanan ' . strtolower($service['name']) . ' terpercaya di Bandung dengan teknisi berpengalaman.',
            'keywords' => generate_keywords(strtolower($service['name']), 'bandung', [
                'teknisi ' . strtolower($service['name']),
                strtolower($service['name']) . ' murah',
                strtolower($service['name']) . ' berkualitas'
            ]),
            'canonical' => base_url('/layanan/' . $slug),
            'og_title' => $service['name'] . ' Bandung Terbaik',
            'og_description' => $service['short_description'],
            'og_image' => base_url('assets/images/layanan-' . $slug . '.jpg')
        ];

        // Related services
        $relatedServices = $this->getRelatedServices($slug);

        // FAQ specific to this service
        $serviceFAQs = $this->getServiceFAQs($slug);

        $data = [
            'seo' => $seoData,
            'service' => $service,
            'relatedServices' => $relatedServices,
            'faqs' => $serviceFAQs,
            'globalSeo' => [
                'site_name' => 'LaptopService Bandung',
                'business_name' => 'CV. Teknologi Solusi Digital',
                'phone' => '+62-22-1234-5678',
                'whatsapp' => '+62-812-3456-7890',
                'email' => 'info@laptopservicebandung.com',
                'social_media' => [
                    'facebook' => 'https://facebook.com/laptopservicebandung',
                    'instagram' => 'https://instagram.com/laptopservice_bdg',
                    'youtube' => 'https://youtube.com/@laptopservicebandung'
                ]
            ],
            'navigation' => [
                ['title' => 'Beranda', 'url' => '/', 'active' => false],
                ['title' => 'Layanan', 'url' => '/layanan', 'active' => true],
                ['title' => 'Blog', 'url' => '/blog', 'active' => false],
                ['title' => 'FAQ', 'url' => '/faq', 'active' => false],
                ['title' => 'Testimonial', 'url' => '/testimonial', 'active' => false],
                ['title' => 'Tentang Kami', 'url' => '/tentang-kami', 'active' => false],
                ['title' => 'Kontak', 'url' => '/kontak', 'active' => false]
            ],
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => base_url()],
                ['name' => 'Layanan', 'url' => base_url('/layanan')],
                ['name' => $service['name'], 'url' => base_url('/layanan/' . $slug)]
            ]
        ];

        return view('services/detail', $data);
    }

    private function getServiceBySlug($slug)
    {
        $services = [
            'service-laptop' => [
                'id' => 'service-laptop',
                'name' => 'Service Laptop',
                'slug' => 'service-laptop',
                'short_description' => 'Perbaikan laptop semua merk dengan teknisi berpengalaman',
                'description' => 'Layanan service laptop profesional untuk semua merk dan tipe laptop. Kami menangani berbagai kerusakan mulai dari masalah software hingga perbaikan hardware kompleks seperti motherboard, layar, keyboard, dan komponen lainnya.',
                'features' => [
                    'Perbaikan motherboard laptop',
                    'Ganti layar LCD/LED/OLED',
                    'Service keyboard dan touchpad',
                    'Perbaikan port charging dan USB',
                    'Cleaning internal dan thermal paste',
                    'Instalasi ulang Windows/Linux/Mac',
                    'Recovery data dari harddisk rusak',
                    'Upgrade RAM dan SSD'
                ],
                'benefits' => [
                    'Teknisi bersertifikat dengan pengalaman 8+ tahun',
                    'Spare part original dan berkualitas',
                    'Garansi resmi 1-3 bulan',
                    'Diagnosa gratis dan estimasi transparan',
                    'Layanan antar jemput ke rumah/kantor',
                    'Support after sales yang responsif'
                ],
                'price_start' => 'Mulai 50rb',
                'duration' => '1-3 hari',
                'warranty' => '1-3 bulan',
                'popular' => true,
                'process' => [
                    'Konsultasi dan diagnosa awal',
                    'Estimasi biaya dan waktu pengerjaan',
                    'Persetujuan customer dan pembayaran DP',
                    'Proses perbaikan oleh teknisi ahli',
                    'Quality control dan testing',
                    'Penyerahan laptop dan garansi'
                ]
            ],
            'service-komputer' => [
                'id' => 'service-komputer',
                'name' => 'Service Komputer PC',
                'slug' => 'service-komputer',
                'short_description' => 'Perbaikan komputer desktop dan PC rakitan',
                'description' => 'Service komputer PC desktop profesional untuk masalah hardware dan software. Dari troubleshooting sederhana hingga perbaikan komponen kompleks seperti motherboard, PSU, dan VGA card.',
                'features' => [
                    'Troubleshooting PC tidak nyala',
                    'Perbaikan PSU dan motherboard',
                    'Service VGA card dan sound card',
                    'Cleaning hardware menyeluruh',
                    'Optimasi performa dan overclocking',
                    'Instalasi software dan driver',
                    'Setup jaringan dan sharing',
                    'Backup dan recovery system'
                ],
                'benefits' => [
                    'Diagnosa menggunakan tools profesional',
                    'Perbaikan semua merk PC',
                    'Spare part bergaransi resmi',
                    'Optimasi performa maksimal',
                    'Konsultasi upgrade gratis',
                    'Maintenance berkala tersedia'
                ],
                'price_start' => 'Mulai 75rb',
                'duration' => '1-2 hari',
                'warranty' => '1-3 bulan',
                'process' => [
                    'Analisa kerusakan PC',
                    'Diagnosa komponen satu per satu',
                    'Estimasi biaya perbaikan',
                    'Perbaikan dan penggantian part',
                    'Testing stabilitas sistem',
                    'Optimasi dan fine tuning'
                ]
            ],
            'upgrade-hardware' => [
                'id' => 'upgrade-hardware',
                'name' => 'Upgrade Hardware',
                'slug' => 'upgrade-hardware',
                'short_description' => 'Upgrade RAM, SSD, dan komponen untuk performa maksimal',
                'description' => 'Tingkatkan performa laptop dan komputer Anda dengan upgrade hardware terbaik. Konsultasi gratis untuk memilih komponen yang tepat sesuai kebutuhan, budget, dan kompatibilitas sistem.',
                'features' => [
                    'Upgrade RAM DDR3/DDR4/DDR5',
                    'Migrasi HDD ke SSD NVMe',
                    'Upgrade processor (desktop)',
                    'Upgrade VGA card gaming',
                    'Penambahan storage SATA/NVMe',
                    'Upgrade motherboard dan chipset',
                    'Konsultasi hardware terbaik',
                    'Benchmark performa sebelum/sesudah'
                ],
                'benefits' => [
                    'Konsultasi hardware gratis',
                    'Produk original bergaransi',
                    'Instalasi dan setup profesional',
                    'Testing kompatibilitas menyeluruh',
                    'Optimasi BIOS dan driver',
                    'Garansi instalasi dan performa'
                ],
                'price_start' => 'Mulai 100rb',
                'duration' => '1-2 hari',
                'warranty' => '1-3 bulan',
                'process' => [
                    'Analisa kebutuhan dan budget',
                    'Rekomendasi hardware optimal',
                    'Pemesanan dan pengadaan part',
                    'Instalasi dan konfigurasi',
                    'Testing performa dan stabilitas',
                    'Optimasi sistem final'
                ]
            ],
            'data-recovery' => [
                'id' => 'data-recovery',
                'name' => 'Data Recovery',
                'slug' => 'data-recovery',
                'short_description' => 'Pemulihan data hilang atau rusak dengan tingkat keberhasilan tinggi',
                'description' => 'Layanan pemulihan data profesional untuk harddisk rusak, file terhapus, atau sistem corrupt. Menggunakan tools dan software profesional dengan tingkat keberhasilan hingga 95%.',
                'features' => [
                    'Recovery harddisk mati/rusak',
                    'Pemulihan file terhapus permanen',
                    'Recovery data dari SSD rusak',
                    'Pemulihan sistem corrupt/crash',
                    'Recovery dari RAID array',
                    'Backup data penting otomatis',
                    'Analisis forensik digital',
                    'Recovery dari media rusak'
                ],
                'benefits' => [
                    'Tools recovery profesional',
                    'Tingkat keberhasilan hingga 95%',
                    'Tidak ada biaya jika data tidak bisa diselamatkan',
                    'Proses aman dan terjamin',
                    'Kerahasiaan data terjaga',
                    'Konsultasi dan analisa gratis'
                ],
                'price_start' => 'Mulai 200rb',
                'duration' => '2-7 hari',
                'warranty' => '1 bulan',
                'process' => [
                    'Analisa kondisi storage',
                    'Estimasi kemungkinan recovery',
                    'Proses recovery dengan tools khusus',
                    'Verifikasi integritas data',
                    'Transfer data ke media baru',
                    'Penyerahan dan backup recommendation'
                ]
            ]
        ];

        return $services[$slug] ?? null;
    }

    private function getRelatedServices($currentSlug)
    {
        $allServices = [
            'service-laptop' => 'Service Laptop',
            'service-komputer' => 'Service Komputer PC',
            'upgrade-hardware' => 'Upgrade Hardware',
            'data-recovery' => 'Data Recovery'
        ];

        unset($allServices[$currentSlug]);

        return array_map(function($name, $slug) {
            return ['name' => $name, 'slug' => $slug];
        }, $allServices, array_keys($allServices));
    }

    private function getServiceFAQs($slug)
    {
        $faqs = [
            'service-laptop' => [
                [
                    'question' => 'Berapa lama waktu service laptop di Bandung?',
                    'answer' => 'Waktu service laptop bervariasi tergantung jenis kerusakan. Service ringan seperti cleaning 1-2 hari, ganti layar 2-3 hari, perbaikan motherboard 3-7 hari tergantung ketersediaan spare part.'
                ],
                [
                    'question' => 'Apakah ada garansi untuk service laptop?',
                    'answer' => 'Ya, kami memberikan garansi 1-3 bulan untuk setiap perbaikan laptop tergantung jenis kerusakan dan spare part yang diganti. Garansi mencakup workmanship dan spare part original.'
                ],
                [
                    'question' => 'Merk laptop apa saja yang bisa diservice?',
                    'answer' => 'Kami melayani service semua merk laptop termasuk ASUS, Acer, HP, Dell, Lenovo, Toshiba, MSI, Apple MacBook, dan merk lainnya.'
                ]
            ],
            'service-komputer' => [
                [
                    'question' => 'PC saya tidak mau nyala, bisa diperbaiki?',
                    'answer' => 'Ya, masalah PC tidak nyala bisa disebabkan berbagai faktor seperti PSU rusak, motherboard bermasalah, atau RAM error. Kami akan diagnosa dan perbaiki sesuai penyebabnya.'
                ],
                [
                    'question' => 'Berapa biaya service komputer di Bandung?',
                    'answer' => 'Biaya service komputer mulai dari 75rb untuk troubleshooting dan cleaning. Biaya perbaikan komponen tergantung jenis kerusakan dan spare part yang diperlukan.'
                ]
            ],
            'upgrade-hardware' => [
                [
                    'question' => 'RAM berapa GB yang cocok untuk laptop saya?',
                    'answer' => 'Kapasitas RAM optimal tergantung penggunaan. Untuk pemakaian ringan 8GB cukup, untuk multitasking dan gaming 16GB, untuk rendering dan workstation 32GB atau lebih.'
                ],
                [
                    'question' => 'Apakah upgrade SSD membuat laptop lebih cepat?',
                    'answer' => 'Ya, upgrade dari HDD ke SSD akan meningkatkan kecepatan booting, loading aplikasi, dan responsifitas sistem secara signifikan hingga 5-10x lebih cepat.'
                ]
            ],
            'data-recovery' => [
                [
                    'question' => 'Berapa persen kemungkinan data bisa diselamatkan?',
                    'answer' => 'Tingkat keberhasilan recovery data mencapai 85-95% tergantung kondisi storage dan jenis kerusakan. Physical damage memiliki tingkat keberhasilan lebih rendah dibanding logical damage.'
                ],
                [
                    'question' => 'Harddisk bunyi klik-klik, masih bisa recovery?',
                    'answer' => 'Bunyi klik-klik menandakan kerusakan fisik head harddisk. Masih ada kemungkinan recovery namun perlu penanganan khusus dan biaya lebih tinggi karena tingkat kesulitan.'
                ]
            ]
        ];

        return $faqs[$slug] ?? [];
    }
}