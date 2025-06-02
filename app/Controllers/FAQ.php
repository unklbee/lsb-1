<?php

namespace App\Controllers;

class Faq extends BaseController
{
    public function index()
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

        $faqCategories = [
            'umum' => [
                'title' => 'Pertanyaan Umum',
                'faqs' => [
                    [
                        'question' => 'Berapa lama waktu service laptop di Bandung?',
                        'answer' => 'Waktu service bervariasi tergantung jenis kerusakan:<br>
                        • Service ringan (cleaning, instalasi): 1-2 hari<br>
                        • Ganti komponen (layar, keyboard): 2-3 hari<br>
                        • Perbaikan motherboard: 3-7 hari<br>
                        • Tergantung ketersediaan spare part'
                    ],
                    [
                        'question' => 'Apakah ada garansi untuk service laptop?',
                        'answer' => 'Ya, kami memberikan garansi resmi untuk setiap perbaikan:<br>
                        • Garansi workmanship: 1-3 bulan<br>
                        • Garansi spare part: sesuai garansi distributor<br>
                        • Garansi tidak berlaku untuk kerusakan akibat benturan atau cairan'
                    ],
                    [
                        'question' => 'Berapa biaya diagnosa laptop?',
                        'answer' => 'Diagnosa awal GRATIS untuk semua pelanggan. Kami akan memberikan estimasi biaya yang transparan sebelum melakukan perbaikan. Tidak ada biaya tersembunyi.'
                    ],
                    [
                        'question' => 'Merk laptop apa saja yang bisa diservice?',
                        'answer' => 'Kami melayani service semua merk laptop:<br>
                        • ASUS, Acer, HP, Dell, Lenovo<br>
                        • Toshiba, MSI, Gigabyte<br>
                        • Apple MacBook (terbatas)<br>
                        • Merk lainnya dengan spare part tersedia'
                    ],
                    [
                        'question' => 'Apakah melayani panggilan ke rumah?',
                        'answer' => 'Ya, kami melayani service panggilan untuk area Bandung dan sekitarnya:<br>
                        • Biaya transportasi minimal Rp 25.000<br>
                        • Gratis ongkir untuk service di atas Rp 500.000<br>
                        • Jadwal fleksibel sesuai kebutuhan'
                    ]
                ]
            ],
            'service-laptop' => [
                'title' => 'Service Laptop',
                'faqs' => [
                    [
                        'question' => 'Laptop saya tidak mau nyala, apa penyebabnya?',
                        'answer' => 'Laptop tidak nyala bisa disebabkan beberapa faktor:<br>
                        • Adapter atau battery bermasalah<br>
                        • Motherboard rusak<br>
                        • RAM tidak terpasang dengan baik<br>
                        • Short circuit akibat cairan<br>
                        Perlu diagnosa lebih lanjut untuk memastikan penyebab pasti.'
                    ],
                    [
                        'question' => 'Layar laptop bergaris, bisa diperbaiki?',
                        'answer' => 'Layar bergaris umumnya disebabkan:<br>
                        • LCD panel rusak - perlu ganti layar<br>
                        • Kabel flexible bermasalah - bisa diperbaiki<br>
                        • VGA card rusak - perlu service motherboard<br>
                        Tim teknisi akan diagnosa untuk solusi terbaik.'
                    ],
                    [
                        'question' => 'Laptop sering hang dan lambat, kenapa?',
                        'answer' => 'Penyebab laptop lambat dan hang:<br>
                        • Harddisk bad sector atau penuh<br>
                        • RAM tidak mencukupi<br>
                        • Overheat karena debu<br>
                        • Virus atau malware<br>
                        • Sistem operasi corrupt<br>
                        Solusi: cleaning, upgrade hardware, atau instalasi ulang.'
                    ],
                    [
                        'question' => 'Keyboard laptop tidak berfungsi sebagian?',
                        'answer' => 'Masalah keyboard laptop:<br>
                        • Kotoran di bawah tombol - bisa dibersihkan<br>
                        • Flexible keyboard putus - perlu ganti<br>
                        • Kerusakan board keyboard - perlu replacement<br>
                        • Setting keyboard berubah - tinggal reset<br>
                        Diagnosa akan menentukan solusi yang tepat.'
                    ]
                ]
            ],
            'upgrade-hardware' => [
                'title' => 'Upgrade Hardware',
                'faqs' => [
                    [
                        'question' => 'RAM berapa GB yang cocok untuk laptop saya?',
                        'answer' => 'Rekomendasi kapasitas RAM:<br>
                        • 4GB: Untuk pemakaian ringan (browsing, office)<br>
                        • 8GB: Multitasking dan aplikasi sedang<br>
                        • 16GB: Gaming, editing video, programming<br>
                        • 32GB+: Workstation, rendering, virtualization<br>
                        Konsultasi gratis untuk menentukan kebutuhan optimal.'
                    ],
                    [
                        'question' => 'Upgrade SSD apakah membuat laptop lebih cepat?',
                        'answer' => 'Ya, upgrade ke SSD memberikan peningkatan signifikan:<br>
                        • Boot time 5-10x lebih cepat<br>
                        • Loading aplikasi instant<br>
                        • Transfer file lebih cepat<br>
                        • Laptop lebih responsif overall<br>
                        • Hemat battery dan tidak berisik'
                    ],
                    [
                        'question' => 'Bisa upgrade processor laptop?',
                        'answer' => 'Upgrade processor laptop sangat terbatas:<br>
                        • Kebanyakan laptop: processor soldered (tidak bisa)<br>
                        • Laptop lama tertentu: bisa upgrade terbatas<br>
                        • Lebih efektif upgrade RAM dan SSD<br>
                        • Konsultasi untuk cek kompatibilitas laptop Anda'
                    ],
                    [
                        'question' => 'Harddisk laptop bisa ditambah?',
                        'answer' => 'Penambahan storage laptop:<br>
                        • Ganti HDD dengan SSD kapasitas lebih besar<br>
                        • Tambah M.2 SSD jika ada slot kosong<br>
                        • External HDD/SSD untuk storage tambahan<br>
                        • Cloud storage untuk backup otomatis<br>
                        Tim akan cek slot available di laptop Anda.'
                    ]
                ]
            ],
            'data-recovery' => [
                'title' => 'Data Recovery',
                'faqs' => [
                    [
                        'question' => 'Berapa persen kemungkinan data bisa diselamatkan?',
                        'answer' => 'Tingkat keberhasilan recovery data:<br>
                        • Logical damage (delete, format): 85-95%<br>
                        • Physical damage ringan: 70-85%<br>
                        • Physical damage berat: 40-70%<br>
                        • Head crash, fire damage: 10-40%<br>
                        Analisa gratis untuk estimasi akurat.'
                    ],
                    [
                        'question' => 'Harddisk bunyi klik-klik, masih bisa recovery?',
                        'answer' => 'Bunyi klik-klik menandakan head crash:<br>
                        • Tingkat kesulitan tinggi<br>
                        • Perlu tools khusus dan cleanroom<br>
                        • Biaya recovery lebih mahal<br>
                        • Kemungkinan berhasil 20-60%<br>
                        • Jangan dinyalakan lagi untuk mencegah kerusakan lebih parah'
                    ],
                    [
                        'question' => 'Berapa lama proses data recovery?',
                        'answer' => 'Waktu recovery data bervariasi:<br>
                        • Logical recovery: 1-3 hari<br>
                        • Physical recovery ringan: 3-7 hari<br>
                        • Physical recovery berat: 1-2 minggu<br>
                        • Tergantung kapasitas dan tingkat kerusakan<br>
                        Update progress akan diberikan secara berkala.'
                    ],
                    [
                        'question' => 'Apakah data recovery bisa dilakukan sendiri?',
                        'answer' => 'Recovery mandiri berisiko tinggi:<br>
                        • Software recovery: bisa dicoba untuk logical damage<br>
                        • Physical damage: TIDAK disarankan<br>
                        • Bisa memperparah kerusakan<br>
                        • Mengurangi chance recovery profesional<br>
                        Konsultasi dulu dengan teknisi untuk saran terbaik.'
                    ]
                ]
            ],
            'harga-garansi' => [
                'title' => 'Harga & Garansi',
                'faqs' => [
                    [
                        'question' => 'Bagaimana sistem pembayaran service laptop?',
                        'answer' => 'Sistem pembayaran fleksibel:<br>
                        • DP 50% saat serahkan laptop<br>
                        • Pelunasan saat ambil laptop<br>
                        • Cash, transfer bank, e-wallet<br>
                        • Cicilan tersedia untuk service > Rp 1juta<br>
                        • Invoice resmi untuk semua transaksi'
                    ],
                    [
                        'question' => 'Apa saja yang termasuk dalam garansi service?',
                        'answer' => 'Garansi service mencakup:<br>
                        • Workmanship/pengerjaan teknisi<br>
                        • Spare part yang diganti<br>
                        • Tidak termasuk: liquid damage, impact damage<br>
                        • Garansi void jika dibuka di tempat lain<br>
                        • Klaim garansi dengan nota service'
                    ],
                    [
                        'question' => 'Apakah ada diskon untuk pelanggan setia?',
                        'answer' => 'Program loyalitas untuk pelanggan:<br>
                        • Diskon 10% untuk service ke-3 dan seterusnya<br>
                        • Promo khusus di hari besar<br>
                        • Maintenance package dengan harga spesial<br>
                        • Prioritas service untuk member<br>
                        • Konsultasi gratis selamanya'
                    ]
                ]
            ]
        ];

        $data = [
            'seo' => $seoData,
            'faqCategories' => $faqCategories,
            'globalSeo' => [
                'site_name' => 'LaptopService Bandung',
                'business_name' => 'CV. Teknologi Solusi Digital',
                'phone' => '+62-22-1234-5678',
                'whatsapp' => '+62-812-3456-7890',
                'email' => 'info@laptopservicebandung.com'
            ],
            'navigation' => [
                ['title' => 'Beranda', 'url' => '/', 'active' => false],
                ['title' => 'Layanan', 'url' => '/layanan', 'active' => false],
                ['title' => 'Blog', 'url' => '/blog', 'active' => false],
                ['title' => 'FAQ', 'url' => '/faq', 'active' => true],
                ['title' => 'Testimonial', 'url' => '/testimonial', 'active' => false],
                ['title' => 'Tentang Kami', 'url' => '/tentang-kami', 'active' => false],
                ['title' => 'Kontak', 'url' => '/kontak', 'active' => false]
            ],
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => base_url()],
                ['name' => 'FAQ', 'url' => base_url('/faq')]
            ]
        ];

        return view('faq/index', $data);
    }
}