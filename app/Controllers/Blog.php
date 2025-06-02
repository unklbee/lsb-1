<?php

namespace App\Controllers;

class Blog extends BaseController
{
    public function index()
    {
        $seoData = [
            'title' => 'Blog Service Laptop Bandung - Tips & Tutorial Komputer',
            'description' => 'Blog informatif seputar service laptop, tips perawatan komputer, tutorial teknologi, dan panduan troubleshooting dari teknisi berpengalaman di Bandung.',
            'keywords' => 'blog service laptop bandung, tips laptop, tutorial komputer, perawatan laptop, troubleshooting pc',
            'canonical' => base_url('/blog'),
            'og_title' => 'Blog Tips & Tutorial Service Laptop Bandung',
            'og_description' => 'Artikel informatif, tips, dan tutorial seputar service laptop dan komputer dari para ahli teknisi di Bandung.',
            'og_image' => base_url('assets/images/blog-service-laptop-bandung.jpg')
        ];

        // Get blog posts (in real app, this would come from database)
        $posts = $this->getBlogPosts();

        // Categories
        $categories = [
            'tips-perawatan' => 'Tips Perawatan',
            'troubleshooting' => 'Troubleshooting',
            'tutorial' => 'Tutorial',
            'review-hardware' => 'Review Hardware',
            'berita-teknologi' => 'Berita Teknologi'
        ];

        // Global data for navigation
        $globalSeo = [
            'site_name' => 'LaptopService Bandung',
            'business_name' => 'CV. Teknologi Solusi Digital',
            'phone' => '+62-22-1234-5678',
            'whatsapp' => '+62-812-3456-7890',
            'email' => 'info@laptopservicebandung.com'
        ];

        $navigation = [
            ['title' => 'Beranda', 'url' => '/', 'active' => false],
            ['title' => 'Layanan', 'url' => '/layanan', 'active' => false],
            ['title' => 'Blog', 'url' => '/blog', 'active' => true],
            ['title' => 'FAQ', 'url' => '/faq', 'active' => false],
            ['title' => 'Testimonial', 'url' => '/testimonial', 'active' => false],
            ['title' => 'Tentang Kami', 'url' => '/tentang-kami', 'active' => false],
            ['title' => 'Kontak', 'url' => '/kontak', 'active' => false]
        ];

        $data = [
            'seo' => $seoData,
            'posts' => $posts,
            'categories' => $categories,
            'globalSeo' => $globalSeo,
            'navigation' => $navigation,
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => base_url()],
                ['name' => 'Blog', 'url' => base_url('/blog')]
            ]
        ];

        return view('blog/index', $data);
    }

    public function detail($slug)
    {
        $post = $this->getPostBySlug($slug);

        if (!$post) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Artikel tidak ditemukan');
        }

        $seoData = [
            'title' => $post['title'] . ' - Blog Service Laptop Bandung',
            'description' => $post['excerpt'],
            'keywords' => $post['keywords'],
            'canonical' => base_url('/blog/' . $slug),
            'og_title' => $post['title'],
            'og_description' => $post['excerpt'],
            'og_image' => $post['featured_image'],
            'og_type' => 'article'
        ];

        // Related posts
        $relatedPosts = $this->getRelatedPosts($post['category'], $slug);

        // Global data
        $globalSeo = [
            'site_name' => 'LaptopService Bandung',
            'business_name' => 'CV. Teknologi Solusi Digital',
            'phone' => '+62-22-1234-5678',
            'whatsapp' => '+62-812-3456-7890',
            'email' => 'info@laptopservicebandung.com'
        ];

        $navigation = [
            ['title' => 'Beranda', 'url' => '/', 'active' => false],
            ['title' => 'Layanan', 'url' => '/layanan', 'active' => false],
            ['title' => 'Blog', 'url' => '/blog', 'active' => true],
            ['title' => 'FAQ', 'url' => '/faq', 'active' => false],
            ['title' => 'Testimonial', 'url' => '/testimonial', 'active' => false],
            ['title' => 'Tentang Kami', 'url' => '/tentang-kami', 'active' => false],
            ['title' => 'Kontak', 'url' => '/kontak', 'active' => false]
        ];

        $data = [
            'seo' => $seoData,
            'post' => $post,
            'relatedPosts' => $relatedPosts,
            'globalSeo' => $globalSeo,
            'navigation' => $navigation,
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => base_url()],
                ['name' => 'Blog', 'url' => base_url('/blog')],
                ['name' => $post['title'], 'url' => base_url('/blog/' . $slug)]
            ]
        ];

        return view('blog/detail', $data);
    }

    public function category($category)
    {
        $allPosts = $this->getBlogPosts();
        $filteredPosts = array_filter($allPosts, function($post) use ($category) {
            return $post['category'] === $category;
        });

        $categoryNames = [
            'tips-perawatan' => 'Tips Perawatan',
            'troubleshooting' => 'Troubleshooting',
            'tutorial' => 'Tutorial',
            'review-hardware' => 'Review Hardware',
            'berita-teknologi' => 'Berita Teknologi'
        ];

        $categoryName = $categoryNames[$category] ?? 'Kategori';

        $seoData = [
            'title' => $categoryName . ' - Blog Service Laptop Bandung',
            'description' => 'Artikel kategori ' . $categoryName . ' seputar service laptop dan komputer dari teknisi Bandung berpengalaman.',
            'keywords' => 'blog ' . strtolower($categoryName) . ', service laptop bandung',
            'canonical' => base_url('/blog/category/' . $category)
        ];

        $globalSeo = [
            'site_name' => 'LaptopService Bandung',
            'business_name' => 'CV. Teknologi Solusi Digital',
            'phone' => '+62-22-1234-5678',
            'whatsapp' => '+62-812-3456-7890',
            'email' => 'info@laptopservicebandung.com'
        ];

        $navigation = [
            ['title' => 'Beranda', 'url' => '/', 'active' => false],
            ['title' => 'Layanan', 'url' => '/layanan', 'active' => false],
            ['title' => 'Blog', 'url' => '/blog', 'active' => true],
            ['title' => 'FAQ', 'url' => '/faq', 'active' => false],
            ['title' => 'Testimonial', 'url' => '/testimonial', 'active' => false],
            ['title' => 'Tentang Kami', 'url' => '/tentang-kami', 'active' => false],
            ['title' => 'Kontak', 'url' => '/kontak', 'active' => false]
        ];

        $data = [
            'seo' => $seoData,
            'posts' => array_values($filteredPosts),
            'category' => $category,
            'categoryName' => $categoryName,
            'totalPosts' => count($filteredPosts),
            'globalSeo' => $globalSeo,
            'navigation' => $navigation
        ];

        return view('blog/category', $data);
    }

    private function getBlogPosts()
    {
        return [
            [
                'id' => 1,
                'title' => 'Cara Merawat Laptop Agar Awet dan Tahan Lama',
                'slug' => 'cara-merawat-laptop-agar-awet',
                'excerpt' => 'Tips mudah merawat laptop agar awet dan performa tetap optimal. Panduan lengkap dari teknisi service laptop Bandung berpengalaman.',
                'content' => $this->getArticleContent('merawat-laptop'),
                'featured_image' => base_url('assets/images/blog/cara-merawat-laptop.jpg'),
                'category' => 'tips-perawatan',
                'author' => 'Tim Teknisi LaptopService',
                'published_date' => '2024-01-15',
                'updated_date' => '2024-01-15',
                'reading_time' => '5 menit',
                'keywords' => 'cara merawat laptop, tips laptop awet, perawatan laptop bandung',
                'featured' => true
            ],
            [
                'id' => 2,
                'title' => 'Tanda-tanda Laptop Perlu Service Segera',
                'slug' => 'tanda-laptop-perlu-service',
                'excerpt' => 'Kenali tanda-tanda laptop yang perlu service segera sebelum kerusakan semakin parah. Ciri-ciri yang wajib diwaspadai oleh pengguna laptop.',
                'content' => $this->getArticleContent('tanda-service'),
                'featured_image' => base_url('assets/images/blog/tanda-laptop-service.jpg'),
                'category' => 'troubleshooting',
                'author' => 'Ahmad Teknisi',
                'published_date' => '2024-01-20',
                'updated_date' => '2024-01-20',
                'reading_time' => '4 menit',
                'keywords' => 'tanda laptop rusak, kapan service laptop, ciri laptop bermasalah',
                'featured' => true
            ],
            [
                'id' => 3,
                'title' => 'Upgrade SSD vs HDD: Mana yang Lebih Baik?',
                'slug' => 'upgrade-ssd-vs-hdd-mana-lebih-baik',
                'excerpt' => 'Perbandingan lengkap SSD dan HDD untuk upgrade laptop. Pelajari kelebihan, kekurangan, dan rekomendasi upgrade storage terbaik.',
                'content' => $this->getArticleContent('ssd-vs-hdd'),
                'featured_image' => base_url('assets/images/blog/ssd-vs-hdd.jpg'),
                'category' => 'tutorial',
                'author' => 'Budi Hardware Specialist',
                'published_date' => '2024-01-25',
                'updated_date' => '2024-01-25',
                'reading_time' => '7 menit',
                'keywords' => 'upgrade ssd, ssd vs hdd, upgrade storage laptop',
                'featured' => false
            ],
            [
                'id' => 4,
                'title' => 'Tips Mengatasi Laptop Overheat dan Panas Berlebih',
                'slug' => 'tips-mengatasi-laptop-overheat',
                'excerpt' => 'Solusi praktis mengatasi laptop yang cepat panas dan overheat. Tips dari teknisi service laptop Bandung untuk menjaga suhu optimal.',
                'content' => $this->getArticleContent('overheat'),
                'featured_image' => base_url('assets/images/blog/laptop-overheat.jpg'),
                'category' => 'troubleshooting',
                'author' => 'Dedi Cooling Expert',
                'published_date' => '2024-01-30',
                'updated_date' => '2024-01-30',
                'reading_time' => '6 menit',
                'keywords' => 'laptop overheat, laptop panas, cooling laptop, thermal paste',
                'featured' => true
            ],
            [
                'id' => 5,
                'title' => 'Panduan Backup Data Sebelum Service Laptop',
                'slug' => 'panduan-backup-data-sebelum-service',
                'excerpt' => 'Langkah-langkah penting untuk backup data sebelum service laptop. Pastikan data penting Anda aman selama proses perbaikan.',
                'content' => $this->getArticleContent('backup-data'),
                'featured_image' => base_url('assets/images/blog/backup-data.jpg'),
                'category' => 'tutorial',
                'author' => 'Sari Data Specialist',
                'published_date' => '2024-02-01',
                'updated_date' => '2024-02-01',
                'reading_time' => '5 menit',
                'keywords' => 'backup data laptop, cara backup, keamanan data service',
                'featured' => false
            ],
            [
                'id' => 6,
                'title' => 'Panduan Lengkap Upgrade Windows 11 di Laptop Lama',
                'slug' => 'panduan-upgrade-windows-11-laptop-lama',
                'excerpt' => 'Tutorial step-by-step upgrade Windows 11 di laptop lama. Cek kompatibilitas, syarat minimum, dan cara bypass TPM requirement.',
                'content' => $this->getArticleContent('windows-11'),
                'featured_image' => base_url('assets/images/blog/upgrade-windows-11.jpg'),
                'category' => 'tutorial',
                'author' => 'Eko Windows Specialist',
                'published_date' => '2024-02-05',
                'updated_date' => '2024-02-05',
                'reading_time' => '8 menit',
                'keywords' => 'upgrade windows 11, windows 11 laptop lama, tutorial windows 11',
                'featured' => false
            ],
            [
                'id' => 7,
                'title' => 'Tips Optimasi Gaming Laptop untuk Performa Maksimal',
                'slug' => 'tips-optimasi-gaming-laptop-performa-maksimal',
                'excerpt' => 'Panduan lengkap optimasi gaming laptop untuk FPS tinggi dan temperature stabil. Tips dari teknisi gaming laptop Bandung.',
                'content' => $this->getArticleContent('gaming-laptop'),
                'featured_image' => base_url('assets/images/blog/optimasi-gaming-laptop.jpg'),
                'category' => 'tips-perawatan',
                'author' => 'Fajar Gaming Expert',
                'published_date' => '2024-02-10',
                'updated_date' => '2024-02-10',
                'reading_time' => '10 menit',
                'keywords' => 'optimasi gaming laptop, gaming laptop bandung, tips gaming',
                'featured' => true
            ],
            [
                'id' => 8,
                'title' => 'Panduan Membeli Laptop Bekas yang Berkualitas',
                'slug' => 'panduan-membeli-laptop-bekas-berkualitas',
                'excerpt' => 'Tips memilih laptop second berkualitas dan menghindari laptop bermasalah. Checklist lengkap dari teknisi berpengalaman.',
                'content' => $this->getArticleContent('laptop-bekas'),
                'featured_image' => base_url('assets/images/blog/laptop-bekas.jpg'),
                'category' => 'review-hardware',
                'author' => 'Indra Hardware Reviewer',
                'published_date' => '2024-02-15',
                'updated_date' => '2024-02-15',
                'reading_time' => '7 menit',
                'keywords' => 'laptop bekas, tips beli laptop second, laptop second bandung',
                'featured' => false
            ]
        ];
    }

    private function getPostBySlug($slug)
    {
        $posts = $this->getBlogPosts();
        foreach ($posts as $post) {
            if ($post['slug'] === $slug) {
                return $post;
            }
        }
        return null;
    }

    private function getRelatedPosts($category, $currentSlug)
    {
        $posts = $this->getBlogPosts();
        $related = [];

        foreach ($posts as $post) {
            if ($post['category'] === $category && $post['slug'] !== $currentSlug) {
                $related[] = $post;
            }
        }

        return array_slice($related, 0, 3);
    }

    private function getArticleContent($type)
    {
        $contents = [
            'merawat-laptop' => '<h2>Tips Merawat Laptop Agar Awet</h2>
                <p>Laptop adalah investasi penting yang perlu dirawat dengan baik. Berikut tips dari teknisi service laptop Bandung untuk menjaga laptop tetap awet:</p>
                <h3>1. Jaga Kebersihan Laptop</h3>
                <p>Bersihkan laptop secara rutin dari debu dan kotoran. Gunakan compressed air untuk membersihkan keyboard dan ventilasi.</p>
                <h3>2. Hindari Overheating</h3>
                <p>Pastikan ventilasi laptop tidak tertutup. Gunakan cooling pad jika diperlukan dan hindari penggunaan di tempat tidur atau sofa.</p>
                <h3>3. Kelola Battery dengan Baik</h3>
                <p>Jangan biarkan battery habis total. Charge hingga 80-90% dan hindari overcharging.</p>
                <h3>4. Update Software Rutin</h3>
                <p>Selalu update OS dan driver untuk performa optimal dan keamanan terbaik.</p>
                <h3>5. Gunakan Antivirus Terpercaya</h3>
                <p>Install dan update antivirus secara rutin untuk melindungi dari malware dan virus.</p>
                <h3>6. Hindari Guncangan dan Benturan</h3>
                <p>Laptop memiliki komponen sensitif seperti harddisk yang mudah rusak jika terkena benturan.</p>',

            'tanda-service' => '<h2>Tanda-tanda Laptop Perlu Service</h2>
                <p>Kenali tanda-tanda ini agar laptop Anda bisa segera mendapat penanganan yang tepat:</p>
                <h3>1. Performa Menurun Drastis</h3>
                <p>Laptop menjadi sangat lambat, sering hang, atau aplikasi sering crash.</p>
                <h3>2. Overheat Berlebihan</h3>
                <p>Laptop cepat panas, fan bekerja keras terus-menerus, atau bahkan mati mendadak karena panas.</p>
                <h3>3. Masalah Display</h3>
                <p>Layar bergaris, berkedip, atau muncul dead pixel yang mengganggu.</p>
                <h3>4. Keyboard atau Touchpad Bermasalah</h3>
                <p>Beberapa tombol tidak berfungsi atau touchpad tidak responsif.</p>
                <h3>5. Battery Cepat Habis</h3>
                <p>Battery laptop tidak bisa bertahan lama meskipun sudah di-charge penuh.</p>
                <h3>6. Bunyi Aneh dari Hardware</h3>
                <p>Suara klik-klik dari harddisk atau fan yang berisik menandakan komponen bermasalah.</p>',

            'ssd-vs-hdd' => '<h2>SSD vs HDD: Perbandingan Lengkap</h2>
                <p>Memilih storage yang tepat sangat penting untuk performa laptop optimal:</p>
                <h3>Kelebihan SSD</h3>
                <ul>
                <li>Kecepatan baca/tulis hingga 10x lebih cepat</li>
                <li>Lebih tahan guncangan dan getaran</li>
                <li>Konsumsi daya lebih rendah</li>
                <li>Tidak ada bunyi saat beroperasi</li>
                <li>Ukuran fisik lebih kecil</li>
                <li>Tidak menghasilkan panas berlebih</li>
                </ul>
                <h3>Kelebihan HDD</h3>
                <ul>
                <li>Harga per GB lebih murah</li>
                <li>Kapasitas tersedia hingga beberapa TB</li>
                <li>Cocok untuk storage data besar</li>
                <li>Teknologi mature dan proven</li>
                </ul>
                <h3>Rekomendasi Upgrade</h3>
                <p>Untuk performa optimal, gunakan SSD sebagai system drive (OS dan aplikasi) dan HDD untuk storage data. Kombinasi ini memberikan speed dan kapasitas terbaik.</p>
                <h3>Tips Pemilihan SSD</h3>
                <p>Pilih SSD dengan interface SATA 3.0 atau NVMe untuk kecepatan maksimal. Kapasitas 256GB-512GB ideal untuk sistem operasi dan aplikasi.</p>',

            'overheat' => '<h2>Mengatasi Laptop Overheat</h2>
                <p>Overheat adalah masalah umum laptop yang bisa merusak komponen internal:</p>
                <h3>Penyebab Overheat</h3>
                <ul>
                <li>Debu menumpuk di ventilasi dan heatsink</li>
                <li>Thermal paste sudah kering</li>
                <li>Fan tidak bekerja optimal atau rusak</li>
                <li>Penggunaan aplikasi berat berlebihan</li>
                <li>Laptop digunakan di permukaan yang menutupi ventilasi</li>
                </ul>
                <h3>Solusi Overheat</h3>
                <ol>
                <li><strong>Cleaning Internal:</strong> Bersihkan debu dari ventilasi dan komponen internal</li>
                <li><strong>Ganti Thermal Paste:</strong> Replace thermal paste yang sudah mengering</li>
                <li><strong>Gunakan Cooling Pad:</strong> Bantu sirkulasi udara dengan cooling pad</li>
                <li><strong>Atur Power Management:</strong> Kurangi performa processor saat tidak diperlukan</li>
                <li><strong>Tutup Aplikasi Berat:</strong> Monitor task manager dan tutup aplikasi yang menggunakan CPU tinggi</li>
                </ol>
                <h3>Pencegahan Overheat</h3>
                <p>Gunakan laptop di permukaan keras dan rata, bersihkan ventilasi rutin, dan hindari multitasking berat dalam waktu lama.</p>
                <p>Jika masalah berlanjut, segera bawa ke service laptop Bandung terpercaya untuk penanganan profesional.</p>',

            'backup-data' => '<h2>Backup Data Sebelum Service</h2>
                <p>Backup data adalah langkah wajib sebelum service laptop untuk mencegah kehilangan data penting:</p>
                <h3>Metode Backup</h3>
                <ol>
                <li><strong>External Drive:</strong> Copy data ke harddisk eksternal atau flashdisk</li>
                <li><strong>Cloud Storage:</strong> Upload ke Google Drive, Dropbox, atau OneDrive</li>
                <li><strong>Network Storage:</strong> Backup ke NAS atau komputer lain di jaringan</li>
                <li><strong>System Image:</strong> Buat image lengkap sistem untuk restore cepat</li>
                </ol>
                <h3>Data yang Wajib Dibackup</h3>
                <ul>
                <li>Dokumen penting (Office files, PDF)</li>
                <li>Foto dan video pribadi</li>
                <li>Bookmark browser dan password tersimpan</li>
                <li>Setting aplikasi dan game saves</li>
                <li>Email dan contacts</li>
                <li>License key software berbayar</li>
                </ul>
                <h3>Tools Backup Recommended</h3>
                <ul>
                <li><strong>Windows:</strong> File History, Backup and Restore</li>
                <li><strong>Third Party:</strong> Acronis True Image, AOMEI Backupper</li>
                <li><strong>Cloud:</strong> Google Backup and Sync, OneDrive, Dropbox</li>
                </ul>
                <h3>Tips Backup yang Efektif</h3>
                <p>Buat backup secara rutin, bukan hanya sebelum service. Gunakan rule 3-2-1: 3 copy data, 2 media berbeda, 1 offsite storage. Test restore sesekali untuk memastikan backup berfungsi.</p>',

            'windows-11' => '<h2>Panduan Upgrade Windows 11</h2>
                <p>Windows 11 menawarkan performa dan keamanan lebih baik. Berikut panduan upgrade lengkap:</p>
                <h3>Syarat Minimum Windows 11</h3>
                <ul>
                <li>Processor: Intel 8th Gen atau AMD Ryzen 2000 series ke atas</li>
                <li>RAM: 4GB minimum (8GB recommended)</li>
                <li>Storage: 64GB SSD (lebih besar untuk performa optimal)</li>
                <li>TPM 2.0 (Trusted Platform Module)</li>
                <li>Secure Boot capable dan UEFI firmware</li>
                <li>DirectX 12 compatible graphics</li>
                </ul>
                <h3>Cara Cek Kompatibilitas</h3>
                <p>Download PC Health Check dari Microsoft untuk mengecek kompatibilitas laptop Anda. Tools ini akan memberikan laporan lengkap kesiapan sistem.</p>
                <h3>Proses Upgrade</h3>
                <ol>
                <li>Backup semua data penting</li>
                <li>Update Windows 10 ke versi terbaru (21H2 atau newer)</li>
                <li>Enable TPM 2.0 dan Secure Boot di BIOS</li>
                <li>Jalankan Windows Update untuk cek availability</li>
                <li>Ikuti proses upgrade otomatis</li>
                <li>Install driver terbaru setelah upgrade</li>
                </ol>
                <h3>Bypass TPM Requirement</h3>
                <p>Untuk laptop lama tanpa TPM 2.0, bisa menggunakan registry edit atau tools third party. Namun tidak direkomendasikan karena alasan keamanan.</p>',

            'gaming-laptop' => '<h2>Tips Optimasi Gaming Laptop</h2>
                <p>Maksimalkan performa gaming laptop dengan tips dari teknisi service laptop Bandung:</p>
                <h3>Hardware Optimization</h3>
                <ul>
                <li>Upgrade RAM ke 16GB atau lebih untuk gaming modern</li>
                <li>Install SSD NVMe untuk loading game super cepat</li>
                <li>Pastikan cooling system optimal dan thermal paste fresh</li>
                <li>Update driver VGA secara rutin dari website resmi</li>
                <li>Monitor temperature CPU dan GPU saat gaming</li>
                </ul>
                <h3>Software Optimization</h3>
                <ul>
                <li>Disable startup programs yang tidak perlu</li>
                <li>Set power plan ke High Performance atau Ultimate Performance</li>
                <li>Update DirectX, Visual C++ Redistributable, dan .NET Framework</li>
                <li>Gunakan Game Mode Windows 10/11</li>
                <li>Disable Windows Update saat gaming</li>
                <li>Set graphics card untuk prioritas performa vs battery</li>
                </ul>
                <h3>In-Game Settings</h3>
                <ul>
                <li>Atur resolution sesuai kemampuan GPU</li>
                <li>Turunkan anti-aliasing jika FPS drop</li>
                <li>Disable V-Sync jika tidak perlu</li>
                <li>Monitor usage GPU dan CPU via overlay</li>
                </ul>
                <h3>Maintenance Gaming Laptop</h3>
                <p>Bersihkan laptop setiap 3-6 bulan, monitor temperature saat gaming (CPU <85°C, GPU <80°C), dan gunakan cooling pad untuk gaming session panjang. Jangan lupa update BIOS dan firmware secara berkala.</p>',

            'laptop-bekas' => '<h2>Panduan Membeli Laptop Bekas</h2>
                <p>Tips dari teknisi service laptop Bandung untuk membeli laptop second berkualitas:</p>
                <h3>Cek Fisik Laptop</h3>
                <ul>
                <li>Periksa kondisi layar (dead pixel, garis, brightness merata)</li>
                <li>Test semua port USB, HDMI, audio, ethernet</li>
                <li>Cek keyboard (semua tombol berfungsi, backlight jika ada)</li>
                <li>Test touchpad dan sensitivity</li>
                <li>Periksa kondisi engsel dan body laptop</li>
                <li>Cek kondisi adapter/charger original</li>
                </ul>
                <h3>Cek Hardware Internal</h3>
                <ul>
                <li>Jalankan stress test CPU dengan Prime95 atau AIDA64</li>
                <li>Test GPU dengan FurMark atau 3DMark</li>
                <li>Cek kondisi harddisk dengan CrystalDiskInfo</li>
                <li>Test RAM dengan MemTest86 atau Windows Memory Diagnostic</li>
                <li>Monitor temperature saat load tinggi</li>
                <li>Cek battery health dan cycle count</li>
                </ul>
                <h3>Software dan Sistem</h3>
                <ul>
                <li>Pastikan Windows original dan activated</li>
                <li>Cek Windows Update berjalan normal</li>
                <li>Test WiFi, Bluetooth, webcam, speaker</li>
                <h3>Software dan Sistem</h3>
                <ul>
                <li>Pastikan Windows original dan activated</li>
                <li>Cek Windows Update berjalan normal</li>
                <li>Test WiFi, Bluetooth, webcam, speaker</li>
                <li>Periksa driver devices sudah terinstall</li>
                <li>Scan virus dan malware</li>
                </ul>
                <h3>Dokumen dan Garansi</h3>
                <p>Pastikan ada nota pembelian original, cek sisa garansi resmi (jika masih ada), tanyakan history perbaikan sebelumnya, dan minta software/driver original jika tersedia.</p>
                <h3>Nego dan Pembelian</h3>
                <ul>
                <li>Riset harga pasaran laptop sejenis</li>
                <li>Hitung biaya upgrade yang mungkin diperlukan</li>
                <li>Nego berdasarkan kondisi dan kekurangan yang ditemukan</li>
                <li>Minta garansi toko minimal 1-3 bulan</li>
                </ul>
                <h3>Red Flags yang Harus Dihindari</h3>
                <ul>
                <li>Laptop bekas banjir atau liquid damage</li>
                <li>Temperature terlalu panas saat idle</li>
                <li>Harddisk dengan bad sector banyak</li>
                <li>Battery completely dead</li>
                <li>Penjual tidak mengizinkan test mendalam</li>
                </ul>'
        ];

        return $contents[$type] ?? '<p>Konten artikel akan segera tersedia. Silakan hubungi kami untuk informasi lebih lanjut tentang topik ini.</p>';
    }

    // Method untuk search functionality
    public function search()
    {
        $query = $this->request->getGet('q');

        if (empty($query)) {
            return redirect()->to('/blog');
        }

        $allPosts = $this->getBlogPosts();
        $searchResults = [];

        foreach ($allPosts as $post) {
            // Search in title, excerpt, and keywords
            if (stripos($post['title'], $query) !== false ||
                stripos($post['excerpt'], $query) !== false ||
                stripos($post['keywords'], $query) !== false) {
                $searchResults[] = $post;
            }
        }

        $seoData = [
            'title' => 'Hasil Pencarian: "' . $query . '" - Blog Service Laptop Bandung',
            'description' => 'Hasil pencarian artikel untuk "' . $query . '" di blog service laptop Bandung.',
            'keywords' => 'search, ' . $query . ', blog service laptop bandung',
            'canonical' => base_url('/blog/search?q=' . urlencode($query))
        ];

        $globalSeo = [
            'site_name' => 'LaptopService Bandung',
            'business_name' => 'CV. Teknologi Solusi Digital',
            'phone' => '+62-22-1234-5678',
            'whatsapp' => '+62-812-3456-7890',
            'email' => 'info@laptopservicebandung.com'
        ];

        $navigation = [
            ['title' => 'Beranda', 'url' => '/', 'active' => false],
            ['title' => 'Layanan', 'url' => '/layanan', 'active' => false],
            ['title' => 'Blog', 'url' => '/blog', 'active' => true],
            ['title' => 'FAQ', 'url' => '/faq', 'active' => false],
            ['title' => 'Testimonial', 'url' => '/testimonial', 'active' => false],
            ['title' => 'Tentang Kami', 'url' => '/tentang-kami', 'active' => false],
            ['title' => 'Kontak', 'url' => '/kontak', 'active' => false]
        ];

        $data = [
            'seo' => $seoData,
            'posts' => $searchResults,
            'query' => $query,
            'totalResults' => count($searchResults),
            'globalSeo' => $globalSeo,
            'navigation' => $navigation,
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => base_url()],
                ['name' => 'Blog', 'url' => base_url('/blog')],
                ['name' => 'Pencarian: ' . $query, 'url' => '']
            ]
        ];

        return view('blog/search', $data);
    }

    // Method untuk pagination jika diperlukan
    public function page($page = 1)
    {
        $perPage = 6;
        $allPosts = $this->getBlogPosts();
        $totalPosts = count($allPosts);
        $totalPages = ceil($totalPosts / $perPage);

        $offset = ($page - 1) * $perPage;
        $posts = array_slice($allPosts, $offset, $perPage);

        $seoData = [
            'title' => 'Blog Service Laptop Bandung - Halaman ' . $page,
            'description' => 'Kumpulan artikel tips dan tutorial service laptop halaman ' . $page . '. Tips perawatan laptop dan troubleshooting dari teknisi Bandung.',
            'keywords' => 'blog service laptop bandung, tips laptop, tutorial komputer',
            'canonical' => base_url('/blog/page/' . $page)
        ];

        $globalSeo = [
            'site_name' => 'LaptopService Bandung',
            'business_name' => 'CV. Teknologi Solusi Digital',
            'phone' => '+62-22-1234-5678',
            'whatsapp' => '+62-812-3456-7890',
            'email' => 'info@laptopservicebandung.com'
        ];

        $navigation = [
            ['title' => 'Beranda', 'url' => '/', 'active' => false],
            ['title' => 'Layanan', 'url' => '/layanan', 'active' => false],
            ['title' => 'Blog', 'url' => '/blog', 'active' => true],
            ['title' => 'FAQ', 'url' => '/faq', 'active' => false],
            ['title' => 'Testimonial', 'url' => '/testimonial', 'active' => false],
            ['title' => 'Tentang Kami', 'url' => '/tentang-kami', 'active' => false],
            ['title' => 'Kontak', 'url' => '/kontak', 'active' => false]
        ];

        $data = [
            'seo' => $seoData,
            'posts' => $posts,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalPosts' => $totalPosts,
            'hasNext' => $page < $totalPages,
            'hasPrev' => $page > 1,
            'nextPage' => $page + 1,
            'prevPage' => $page - 1,
            'globalSeo' => $globalSeo,
            'navigation' => $navigation,
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => base_url()],
                ['name' => 'Blog', 'url' => base_url('/blog')],
                ['name' => 'Halaman ' . $page, 'url' => '']
            ]
        ];

        return view('blog/index', $data);
    }

    // Method untuk RSS feed
    public function rss()
    {
        $posts = array_slice($this->getBlogPosts(), 0, 10); // Latest 10 posts

        $this->response->setContentType('application/rss+xml');

        $rss = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $rss .= '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">' . "\n";
        $rss .= '<channel>' . "\n";
        $rss .= '<title>Blog Service Laptop Bandung</title>' . "\n";
        $rss .= '<description>Tips dan tutorial service laptop terbaru dari teknisi Bandung</description>' . "\n";
        $rss .= '<link>' . base_url('/blog') . '</link>' . "\n";
        $rss .= '<atom:link href="' . base_url('/blog/rss') . '" rel="self" type="application/rss+xml" />' . "\n";
        $rss .= '<language>id-ID</language>' . "\n";
        $rss .= '<lastBuildDate>' . date('r') . '</lastBuildDate>' . "\n";

        foreach ($posts as $post) {
            $rss .= '<item>' . "\n";
            $rss .= '<title><![CDATA[' . $post['title'] . ']]></title>' . "\n";
            $rss .= '<description><![CDATA[' . $post['excerpt'] . ']]></description>' . "\n";
            $rss .= '<link>' . base_url('/blog/' . $post['slug']) . '</link>' . "\n";
            $rss .= '<guid>' . base_url('/blog/' . $post['slug']) . '</guid>' . "\n";
            $rss .= '<pubDate>' . date('r', strtotime($post['published_date'])) . '</pubDate>' . "\n";
            $rss .= '<author>info@laptopservicebandung.com (' . $post['author'] . ')</author>' . "\n";
            $rss .= '</item>' . "\n";
        }

        $rss .= '</channel>' . "\n";
        $rss .= '</rss>';

        return $this->response->setBody($rss);
    }

    // Method untuk sitemap khusus blog
    public function sitemap()
    {
        $posts = $this->getBlogPosts();

        $this->response->setContentType('application/xml');

        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Blog index
        $sitemap .= '<url>' . "\n";
        $sitemap .= '<loc>' . base_url('/blog') . '</loc>' . "\n";
        $sitemap .= '<lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
        $sitemap .= '<changefreq>daily</changefreq>' . "\n";
        $sitemap .= '<priority>0.8</priority>' . "\n";
        $sitemap .= '</url>' . "\n";

        // Blog posts
        foreach ($posts as $post) {
            $sitemap .= '<url>' . "\n";
            $sitemap .= '<loc>' . base_url('/blog/' . $post['slug']) . '</loc>' . "\n";
            $sitemap .= '<lastmod>' . $post['updated_date'] . '</lastmod>' . "\n";
            $sitemap .= '<changefreq>monthly</changefreq>' . "\n";
            $sitemap .= '<priority>0.6</priority>' . "\n";
            $sitemap .= '</url>' . "\n";
        }

        $sitemap .= '</urlset>';

        return $this->response->setBody($sitemap);
    }
}