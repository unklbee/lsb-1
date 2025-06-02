<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CMSSeeder extends Seeder
{
    public function run()
    {
        // 1. Insert Settings
        $settings = [
            [
                'key' => 'site_name',
                'value' => 'LaptopService Bandung',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Nama Website',
                'description' => 'Nama website yang akan ditampilkan di header dan footer'
            ],
            [
                'key' => 'business_name',
                'value' => 'CV. Teknologi Solusi Digital',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Nama Perusahaan',
                'description' => 'Nama resmi perusahaan'
            ],
            [
                'key' => 'tagline',
                'value' => 'Service Laptop & Komputer Terpercaya di Bandung',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Tagline',
                'description' => 'Tagline website'
            ],
            [
                'key' => 'phone_primary',
                'value' => '+62-22-1234-5678',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'Telepon Utama',
                'description' => 'Nomor telepon utama'
            ],
            [
                'key' => 'phone_secondary',
                'value' => '+62-22-8765-4321',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'Telepon Kedua',
                'description' => 'Nomor telepon alternatif'
            ],
            [
                'key' => 'whatsapp',
                'value' => '+62-812-3456-7890',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'WhatsApp',
                'description' => 'Nomor WhatsApp untuk chat'
            ],
            [
                'key' => 'email_primary',
                'value' => 'info@laptopservicebandung.com',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'Email Utama',
                'description' => 'Email utama perusahaan'
            ],
            [
                'key' => 'email_support',
                'value' => 'support@laptopservicebandung.com',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'Email Support',
                'description' => 'Email untuk dukungan teknis'
            ],
            [
                'key' => 'address',
                'value' => 'Jl. Soekarno Hatta No. 123, Bandung Wetan, Bandung, Jawa Barat 40132',
                'type' => 'textarea',
                'group' => 'contact',
                'label' => 'Alamat Lengkap',
                'description' => 'Alamat lengkap workshop'
            ],
            [
                'key' => 'coordinates_lat',
                'value' => '-6.9175',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'Latitude',
                'description' => 'Koordinat latitude untuk maps'
            ],
            [
                'key' => 'coordinates_lng',
                'value' => '107.6191',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'Longitude',
                'description' => 'Koordinat longitude untuk maps'
            ],
            [
                'key' => 'business_hours',
                'value' => json_encode([
                    'weekdays' => ['days' => 'Senin - Jumat', 'hours' => '08:00 - 20:00'],
                    'saturday' => ['days' => 'Sabtu', 'hours' => '08:00 - 18:00'],
                    'sunday' => ['days' => 'Minggu', 'hours' => '09:00 - 17:00'],
                    'emergency' => 'Layanan darurat 24/7 (via WhatsApp)'
                ]),
                'type' => 'json',
                'group' => 'contact',
                'label' => 'Jam Operasional',
                'description' => 'Jam operasional bisnis'
            ],
            [
                'key' => 'social_media',
                'value' => json_encode([
                    'facebook' => 'https://facebook.com/laptopservicebandung',
                    'instagram' => 'https://instagram.com/laptopservice_bdg',
                    'youtube' => 'https://youtube.com/@laptopservicebandung',
                    'tiktok' => 'https://tiktok.com/@laptopservicebdg',
                    'twitter' => ''
                ]),
                'type' => 'json',
                'group' => 'social',
                'label' => 'Media Sosial',
                'description' => 'Link media sosial'
            ],
            [
                'key' => 'stats',
                'value' => json_encode([
                    'experience' => '8+ Tahun',
                    'customers' => '5000+',
                    'satisfaction' => '98%',
                    'warranty' => '3 Bulan'
                ]),
                'type' => 'json',
                'group' => 'homepage',
                'label' => 'Statistik',
                'description' => 'Statistik untuk homepage'
            ],
            [
                'key' => 'meta_description',
                'value' => 'Service laptop dan komputer terpercaya di Bandung dengan teknisi berpengalaman. Perbaikan profesional, spare part original, garansi resmi.',
                'type' => 'textarea',
                'group' => 'seo',
                'label' => 'Meta Description Default',
                'description' => 'Meta description default untuk halaman utama'
            ],
            [
                'key' => 'meta_keywords',
                'value' => 'service laptop bandung, perbaikan komputer, teknisi laptop, upgrade hardware bandung',
                'type' => 'textarea',
                'group' => 'seo',
                'label' => 'Meta Keywords Default',
                'description' => 'Meta keywords default'
            ]
        ];

        foreach ($settings as $setting) {
            $setting['created_at'] = date('Y-m-d H:i:s');
            $setting['updated_at'] = date('Y-m-d H:i:s');
        }
        $this->db->table('settings')->insertBatch($settings);

        // 2. Insert FAQ Categories
        $faqCategories = [
            [
                'name' => 'Pertanyaan Umum',
                'slug' => 'umum',
                'description' => 'Pertanyaan umum seputar layanan service laptop',
                'is_active' => 1,
                'sort_order' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Service Laptop',
                'slug' => 'service-laptop',
                'description' => 'FAQ khusus service laptop',
                'is_active' => 1,
                'sort_order' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Upgrade Hardware',
                'slug' => 'upgrade-hardware',
                'description' => 'FAQ tentang upgrade hardware',
                'is_active' => 1,
                'sort_order' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Data Recovery',
                'slug' => 'data-recovery',
                'description' => 'FAQ seputar pemulihan data',
                'is_active' => 1,
                'sort_order' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Harga & Garansi',
                'slug' => 'harga-garansi',
                'description' => 'FAQ tentang harga dan garansi layanan',
                'is_active' => 1,
                'sort_order' => 5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];
        $this->db->table('faq_categories')->insertBatch($faqCategories);

        // 3. Insert Blog Categories
        $blogCategories = [
            [
                'name' => 'Tips Perawatan',
                'slug' => 'tips-perawatan',
                'description' => 'Tips dan panduan merawat laptop agar awet',
                'meta_title' => 'Tips Perawatan Laptop - Blog Service Laptop Bandung',
                'meta_description' => 'Kumpulan tips perawatan laptop dari teknisi berpengalaman',
                'is_active' => 1,
                'sort_order' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Troubleshooting',
                'slug' => 'troubleshooting',
                'description' => 'Panduan mengatasi masalah laptop dan komputer',
                'meta_title' => 'Troubleshooting Laptop - Blog Service Laptop Bandung',
                'meta_description' => 'Panduan troubleshooting untuk berbagai masalah laptop',
                'is_active' => 1,
                'sort_order' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Tutorial',
                'slug' => 'tutorial',
                'description' => 'Tutorial lengkap seputar teknologi dan komputer',
                'meta_title' => 'Tutorial Komputer - Blog Service Laptop Bandung',
                'meta_description' => 'Tutorial step-by-step untuk berbagai kebutuhan teknologi',
                'is_active' => 1,
                'sort_order' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Review Hardware',
                'slug' => 'review-hardware',
                'description' => 'Review dan rekomendasi hardware terbaru',
                'meta_title' => 'Review Hardware - Blog Service Laptop Bandung',
                'meta_description' => 'Review hardware laptop dan komputer terbaru',
                'is_active' => 1,
                'sort_order' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Berita Teknologi',
                'slug' => 'berita-teknologi',
                'description' => 'Update berita dan tren teknologi terkini',
                'meta_title' => 'Berita Teknologi - Blog Service Laptop Bandung',
                'meta_description' => 'Berita teknologi terkini dan trend industri IT',
                'is_active' => 1,
                'sort_order' => 5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];
        $this->db->table('blog_categories')->insertBatch($blogCategories);

        // 4. Insert Services
        $services = [
            [
                'name' => 'Service Laptop',
                'slug' => 'service-laptop',
                'short_description' => 'Perbaikan laptop semua merk dengan teknisi berpengalaman',
                'description' => 'Layanan service laptop profesional untuk semua merk dan tipe laptop. Kami menangani berbagai kerusakan mulai dari masalah software hingga perbaikan hardware kompleks seperti motherboard, layar, keyboard, dan komponen lainnya.',
                'features' => json_encode([
                    'Perbaikan motherboard laptop',
                    'Ganti layar LCD/LED/OLED',
                    'Service keyboard dan touchpad',
                    'Perbaikan port charging dan USB',
                    'Cleaning internal dan thermal paste',
                    'Instalasi ulang Windows/Linux/Mac',
                    'Recovery data dari harddisk rusak',
                    'Upgrade RAM dan SSD'
                ]),
                'benefits' => json_encode([
                    'Teknisi bersertifikat dengan pengalaman 8+ tahun',
                    'Spare part original dan berkualitas',
                    'Garansi resmi 1-3 bulan',
                    'Diagnosa gratis dan estimasi transparan',
                    'Layanan antar jemput ke rumah/kantor',
                    'Support after sales yang responsif'
                ]),
                'process' => json_encode([
                    'Konsultasi dan diagnosa awal',
                    'Estimasi biaya dan waktu pengerjaan',
                    'Persetujuan customer dan pembayaran DP',
                    'Proses perbaikan oleh teknisi ahli',
                    'Quality control dan testing',
                    'Penyerahan laptop dan garansi'
                ]),
                'price_start' => 'Mulai 50rb',
                'duration' => '1-3 hari',
                'warranty' => '1-3 bulan',
                'icon' => 'laptop',
                'featured_image' => '/assets/images/services/service-laptop.jpg',
                'meta_title' => 'Service Laptop Bandung Profesional - Garansi Resmi',
                'meta_description' => 'Service laptop semua merk di Bandung dengan teknisi berpengalaman. Perbaikan motherboard, layar, keyboard dengan garansi resmi.',
                'meta_keywords' => 'service laptop bandung, perbaikan laptop, teknisi laptop bandung',
                'is_popular' => 1,
                'is_active' => 1,
                'sort_order' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Service Komputer PC',
                'slug' => 'service-komputer',
                'short_description' => 'Perbaikan komputer desktop dan PC rakitan',
                'description' => 'Service komputer PC desktop profesional untuk masalah hardware dan software. Dari troubleshooting sederhana hingga perbaikan komponen kompleks seperti motherboard, PSU, dan VGA card.',
                'features' => json_encode([
                    'Troubleshooting PC tidak nyala',
                    'Perbaikan PSU dan motherboard',
                    'Service VGA card dan sound card',
                    'Cleaning hardware menyeluruh',
                    'Optimasi performa dan overclocking',
                    'Instalasi software dan driver',
                    'Setup jaringan dan sharing',
                    'Backup dan recovery system'
                ]),
                'benefits' => json_encode([
                    'Diagnosa menggunakan tools profesional',
                    'Perbaikan semua merk PC',
                    'Spare part bergaransi resmi',
                    'Optimasi performa maksimal',
                    'Konsultasi upgrade gratis',
                    'Maintenance berkala tersedia'
                ]),
                'process' => json_encode([
                    'Analisa kerusakan PC',
                    'Diagnosa komponen satu per satu',
                    'Estimasi biaya perbaikan',
                    'Perbaikan dan penggantian part',
                    'Testing stabilitas sistem',
                    'Optimasi dan fine tuning'
                ]),
                'price_start' => 'Mulai 75rb',
                'duration' => '1-2 hari',
                'warranty' => '1-3 bulan',
                'icon' => 'desktop',
                'featured_image' => '/assets/images/services/service-komputer.jpg',
                'meta_title' => 'Service Komputer PC Bandung - Teknisi Berpengalaman',
                'meta_description' => 'Service komputer desktop dan PC rakitan di Bandung. Perbaikan motherboard, VGA, PSU dengan garansi resmi.',
                'meta_keywords' => 'service komputer bandung, perbaikan pc, service desktop bandung',
                'is_popular' => 0,
                'is_active' => 1,
                'sort_order' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Upgrade Hardware',
                'slug' => 'upgrade-hardware',
                'short_description' => 'Upgrade RAM, SSD, dan komponen untuk performa maksimal',
                'description' => 'Tingkatkan performa laptop dan komputer Anda dengan upgrade hardware terbaik. Konsultasi gratis untuk memilih komponen yang tepat sesuai kebutuhan, budget, dan kompatibilitas sistem.',
                'features' => json_encode([
                    'Upgrade RAM DDR3/DDR4/DDR5',
                    'Migrasi HDD ke SSD NVMe',
                    'Upgrade processor (desktop)',
                    'Upgrade VGA card gaming',
                    'Penambahan storage SATA/NVMe',
                    'Upgrade motherboard dan chipset',
                    'Konsultasi hardware terbaik',
                    'Benchmark performa sebelum/sesudah'
                ]),
                'benefits' => json_encode([
                    'Konsultasi hardware gratis',
                    'Produk original bergaransi',
                    'Instalasi dan setup profesional',
                    'Testing kompatibilitas menyeluruh',
                    'Optimasi BIOS dan driver',
                    'Garansi instalasi dan performa'
                ]),
                'process' => json_encode([
                    'Analisa kebutuhan dan budget',
                    'Rekomendasi hardware optimal',
                    'Pemesanan dan pengadaan part',
                    'Instalasi dan konfigurasi',
                    'Testing performa dan stabilitas',
                    'Optimasi sistem final'
                ]),
                'price_start' => 'Mulai 100rb',
                'duration' => '1-2 hari',
                'warranty' => '1-3 bulan',
                'icon' => 'memory',
                'featured_image' => '/assets/images/services/upgrade-hardware.jpg',
                'meta_title' => 'Upgrade Hardware Laptop & PC Bandung - RAM SSD VGA',
                'meta_description' => 'Upgrade RAM, SSD, VGA card untuk laptop dan PC di Bandung. Konsultasi gratis, instalasi profesional, garansi resmi.',
                'meta_keywords' => 'upgrade ram bandung, upgrade ssd bandung, upgrade hardware laptop',
                'is_popular' => 1,
                'is_active' => 1,
                'sort_order' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Data Recovery',
                'slug' => 'data-recovery',
                'short_description' => 'Pemulihan data hilang atau rusak dengan tingkat keberhasilan tinggi',
                'description' => 'Layanan pemulihan data profesional untuk harddisk rusak, file terhapus, atau sistem corrupt. Menggunakan tools dan software profesional dengan tingkat keberhasilan hingga 95%.',
                'features' => json_encode([
                    'Recovery harddisk mati/rusak',
                    'Pemulihan file terhapus permanen',
                    'Recovery data dari SSD rusak',
                    'Pemulihan sistem corrupt/crash',
                    'Recovery dari RAID array',
                    'Backup data penting otomatis',
                    'Analisis forensik digital',
                    'Recovery dari media rusak'
                ]),
                'benefits' => json_encode([
                    'Tools recovery profesional',
                    'Tingkat keberhasilan hingga 95%',
                    'Tidak ada biaya jika data tidak bisa diselamatkan',
                    'Proses aman dan terjamin',
                    'Kerahasiaan data terjaga',
                    'Konsultasi dan analisa gratis'
                ]),
                'process' => json_encode([
                    'Analisa kondisi storage',
                    'Estimasi kemungkinan recovery',
                    'Proses recovery dengan tools khusus',
                    'Verifikasi integritas data',
                    'Transfer data ke media baru',
                    'Penyerahan dan backup recommendation'
                ]),
                'price_start' => 'Mulai 200rb',
                'duration' => '2-7 hari',
                'warranty' => '1 bulan',
                'icon' => 'hard-drive',
                'featured_image' => '/assets/images/services/data-recovery.jpg',
                'meta_title' => 'Data Recovery Bandung - Pemulihan Data Harddisk Rusak',
                'meta_description' => 'Layanan data recovery profesional di Bandung. Pemulihan file terhapus, harddisk rusak dengan tingkat keberhasilan tinggi.',
                'meta_keywords' => 'data recovery bandung, pemulihan data, recovery harddisk rusak',
                'is_popular' => 0,
                'is_active' => 1,
                'sort_order' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];
        $this->db->table('services')->insertBatch($services);

        // 5. Insert Testimonials
        $testimonials = [
            [
                'name' => 'Ahmad Rifai',
                'email' => 'ahmad.rifai@email.com',
                'phone' => '081234567890',
                'location' => 'Dago, Bandung',
                'service_type' => 'Perbaikan Motherboard',
                'rating' => 5,
                'comment' => 'Service laptop Bandung terbaik! Laptop saya yang mati total bisa hidup lagi. Pelayanan cepat dan harga terjangkau. Teknisinya profesional dan jujur dalam memberikan penjelasan.',
                'photo' => null,
                'is_featured' => 1,
                'is_published' => 1,
                'sort_order' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Sari Indrawati',
                'email' => 'sari.indra@email.com',
                'phone' => '081234567891',
                'location' => 'Cihampelas, Bandung',
                'service_type' => 'Cleaning & Thermal Paste',
                'rating' => 5,
                'comment' => 'Rekomendasi banget untuk service laptop di Bandung. Teknisinya profesional dan honest. Laptop gaming saya yang sering overheat sekarang kembali normal dan dingin.',
                'photo' => null,
                'is_featured' => 1,
                'is_published' => 1,
                'sort_order' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Dedi Kurniawan',
                'email' => 'dedi.k@email.com',
                'phone' => '081234567892',
                'location' => 'Antapani, Bandung',
                'service_type' => 'Upgrade SSD & RAM',
                'rating' => 5,
                'comment' => 'Sudah 3x service laptop disini, selalu puas. Harga service laptop Bandung paling kompetitif dengan kualitas terjamin. Staff ramah dan komunikatif.',
                'photo' => null,
                'is_featured' => 1,
                'is_published' => 1,
                'sort_order' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Maya Kusuma',
                'email' => 'maya.kusuma@email.com',
                'phone' => '081234567893',
                'location' => 'Buah Batu, Bandung',
                'service_type' => 'Data Recovery',
                'rating' => 5,
                'comment' => 'Data penting di harddisk saya berhasil diselamatkan 100%. Proses recovery cepat dan profesional. Sangat berterima kasih kepada tim teknisi yang sudah membantu.',
                'photo' => null,
                'is_featured' => 0,
                'is_published' => 1,
                'sort_order' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Randi Pratama',
                'email' => 'randi.p@email.com',
                'phone' => '081234567894',
                'location' => 'Cibeunying, Bandung',
                'service_type' => 'Service Komputer',
                'rating' => 4,
                'comment' => 'PC saya yang tidak nyala akhirnya bisa diperbaiki. Ternyata PSU yang rusak. Teknisi menjelaskan dengan detail dan memberikan rekomendasi maintenance.',
                'photo' => null,
                'is_featured' => 0,
                'is_published' => 1,
                'sort_order' => 5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];
        $this->db->table('testimonials')->insertBatch($testimonials);

        // 6. Insert Users (Admin)
        $users = [
            [
                'username' => 'admin',
                'email' => 'admin@laptopservicebandung.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'role' => 'super_admin',
                'avatar' => null,
                'is_active' => 1,
                'last_login' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'editor',
                'email' => 'editor@laptopservicebandung.com',
                'password' => password_hash('editor123', PASSWORD_DEFAULT),
                'first_name' => 'Content',
                'last_name' => 'Editor',
                'role' => 'editor',
                'avatar' => null,
                'is_active' => 1,
                'last_login' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];
        $this->db->table('users')->insertBatch($users);

        // 7. Insert Pages
        $pages = [
            [
                'title' => 'Tentang Kami',
                'slug' => 'tentang-kami',
                'content' => '<h2>Tentang LaptopService Bandung</h2><p>LaptopService Bandung adalah perusahaan yang bergerak di bidang jasa perbaikan dan maintenance laptop, komputer, serta perangkat teknologi lainnya...</p>',
                'excerpt' => 'Mengenal lebih dekat LaptopService Bandung, penyedia jasa service laptop dan komputer terpercaya di Bandung sejak 2015.',
                'featured_image' => '/assets/images/about-us.jpg',
                'template' => 'about',
                'meta_title' => 'Tentang Kami - Service Laptop Bandung Terpercaya',
                'meta_description' => 'Mengenal LaptopService Bandung, penyedia jasa service laptop dan komputer terpercaya dengan teknisi berpengalaman sejak 2015.',
                'meta_keywords' => 'tentang laptopservice bandung, profil perusahaan, service laptop bandung',
                'is_published' => 1,
                'show_in_menu' => 1,
                'sort_order' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Kebijakan Privasi',
                'slug' => 'kebijakan-privasi',
                'content' => '<h2>Kebijakan Privasi</h2><p>Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi pribadi Anda...</p>',
                'excerpt' => 'Kebijakan privasi dan perlindungan data pelanggan LaptopService Bandung.',
                'featured_image' => null,
                'template' => 'page',
                'meta_title' => 'Kebijakan Privasi - LaptopService Bandung',
                'meta_description' => 'Kebijakan privasi dan perlindungan data pelanggan LaptopService Bandung.',
                'meta_keywords' => 'kebijakan privasi, privacy policy, perlindungan data',
                'is_published' => 1,
                'show_in_menu' => 0,
                'sort_order' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Syarat dan Ketentuan',
                'slug' => 'syarat-ketentuan',
                'content' => '<h2>Syarat dan Ketentuan</h2><p>Syarat dan ketentuan penggunaan layanan LaptopService Bandung...</p>',
                'excerpt' => 'Syarat dan ketentuan penggunaan layanan LaptopService Bandung.',
                'featured_image' => null,
                'template' => 'page',
                'meta_title' => 'Syarat dan Ketentuan - LaptopService Bandung',
                'meta_description' => 'Syarat dan ketentuan penggunaan layanan LaptopService Bandung.',
                'meta_keywords' => 'syarat ketentuan, terms of service, aturan layanan',
                'is_published' => 1,
                'show_in_menu' => 0,
                'sort_order' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];
        $this->db->table('pages')->insertBatch($pages);
    }
}