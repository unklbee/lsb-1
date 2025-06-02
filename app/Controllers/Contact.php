<?php

namespace App\Controllers;

class Contact extends BaseController
{
    public function index()
    {
        $seoData = [
            'title' => 'Kontak Service Laptop Bandung - Hubungi Teknisi Terpercaya',
            'description' => 'Hubungi service laptop Bandung terpercaya. Konsultasi gratis, panggilan ke rumah, dan layanan 24/7. Teknisi berpengalaman siap membantu Anda.',
            'keywords' => 'kontak service laptop bandung, nomor telepon service laptop, alamat service komputer bandung, teknisi laptop bandung',
            'canonical' => base_url('/kontak'),
            'og_title' => 'Hubungi Service Laptop Bandung Sekarang',
            'og_description' => 'Konsultasi gratis dan layanan profesional service laptop Bandung. Hubungi kami sekarang untuk solusi terbaik.',
            'og_image' => base_url('assets/images/kontak-service-laptop-bandung.jpg')
        ];

        // Contact information
        $contactInfo = [
            'phone' => [
                'primary' => '+62-22-1234-5678',
                'secondary' => '+62-22-8765-4321'
            ],
            'whatsapp' => '+62-812-3456-7890',
            'email' => [
                'info' => 'info@laptopservicebandung.com',
                'support' => 'support@laptopservicebandung.com'
            ],
            'address' => [
                'street' => 'Jl. Soekarno Hatta No. 123',
                'district' => 'Bandung Wetan',
                'city' => 'Bandung',
                'province' => 'Jawa Barat',
                'postal_code' => '40132',
                'full' => 'Jl. Soekarno Hatta No. 123, Bandung Wetan, Bandung, Jawa Barat 40132'
            ],
            'coordinates' => [
                'lat' => -6.9175,
                'lng' => 107.6191
            ],
            'social_media' => [
                'facebook' => 'https://facebook.com/laptopservicebandung',
                'instagram' => 'https://instagram.com/laptopservice_bdg',
                'youtube' => 'https://youtube.com/@laptopservicebandung',
                'tiktok' => 'https://tiktok.com/@laptopservicebdg'
            ]
        ];

        // Business hours
        $businessHours = [
            'weekdays' => [
                'days' => 'Senin - Jumat',
                'hours' => '08:00 - 20:00'
            ],
            'saturday' => [
                'days' => 'Sabtu',
                'hours' => '08:00 - 18:00'
            ],
            'sunday' => [
                'days' => 'Minggu',
                'hours' => '09:00 - 17:00'
            ],
            'emergency' => 'Layanan darurat 24/7 (via WhatsApp)'
        ];

        // Service areas
        $serviceAreas = [
            'primary' => [
                'Bandung Pusat', 'Bandung Utara', 'Bandung Selatan',
                'Bandung Timur', 'Bandung Barat'
            ],
            'secondary' => [
                'Cimahi', 'Padalarang', 'Margahayu',
                'Dayeuhkolot', 'Banjaran', 'Soreang'
            ],
            'coverage' => 'Melayani seluruh Bandung Raya dan sekitarnya'
        ];

        // FAQ Contact
        $contactFAQ = [
            [
                'question' => 'Bagaimana cara konsultasi sebelum service?',
                'answer' => 'Anda bisa konsultasi gratis melalui WhatsApp, telepon, atau datang langsung ke workshop kami. Tim akan mendengarkan keluhan dan memberikan saran terbaik.'
            ],
            [
                'question' => 'Apakah bisa antar jemput laptop?',
                'answer' => 'Ya, kami melayani antar jemput untuk area Bandung dengan biaya transportasi minimal. Gratis antar jemput untuk service di atas Rp 500.000.'
            ],
            [
                'question' => 'Berapa lama respon time customer service?',
                'answer' => 'WhatsApp dan telepon: respon dalam 5-15 menit (jam kerja). Email: maksimal 2 jam. Layanan darurat 24/7 via WhatsApp.'
            ]
        ];

        $data = [
            'seo' => $seoData,
            'contactInfo' => $contactInfo,
            'businessHours' => $businessHours,
            'serviceAreas' => $serviceAreas,
            'contactFAQ' => $contactFAQ,
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
                ['title' => 'FAQ', 'url' => '/faq', 'active' => false],
                ['title' => 'Testimonial', 'url' => '/testimonial', 'active' => false],
                ['title' => 'Tentang Kami', 'url' => '/tentang-kami', 'active' => false],
                ['title' => 'Kontak', 'url' => '/kontak', 'active' => true]
            ],
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => base_url()],
                ['name' => 'Kontak', 'url' => base_url('/kontak')]
            ]
        ];

        return view('contact/index', $data);
    }

    public function send()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email',
            'phone' => 'required|min_length[10]|max_length[15]',
            'service_type' => 'required',
            'message' => 'required|min_length[10]|max_length[1000]'
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
                'required' => 'Nomor telepon wajib diisi',
                'min_length' => 'Nomor telepon minimal 10 digit',
                'max_length' => 'Nomor telepon maksimal 15 digit'
            ],
            'service_type' => [
                'required' => 'Jenis layanan wajib dipilih'
            ],
            'message' => [
                'required' => 'Pesan wajib diisi',
                'min_length' => 'Pesan minimal 10 karakter',
                'max_length' => 'Pesan maksimal 1000 karakter'
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        // Get form data
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'service_type' => $this->request->getPost('service_type'),
            'message' => $this->request->getPost('message'),
            'created_at' => date('Y-m-d H:i:s'),
            'ip_address' => $this->request->getIPAddress()
        ];

        try {
            // Save to database (implement your database logic here)
            // $contactModel = new ContactModel();
            // $contactModel->insert($data);

            // Send email notification (implement email logic here)
            // $this->sendEmailNotification($data);

            // Send WhatsApp notification (implement WhatsApp API here)
            // $this->sendWhatsAppNotification($data);

            return redirect()->back()->with('success', 'Pesan Anda telah terkirim! Tim kami akan segera menghubungi Anda.');

        } catch (\Exception $e) {
            log_message('error', 'Contact form error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Maaf, terjadi kesalahan. Silakan coba lagi atau hubungi kami via WhatsApp.');
        }
    }

    private function sendEmailNotification($data)
    {
        $email = \Config\Services::email();

        $email->setFrom('noreply@laptopservicebandung.com', 'LaptopService Bandung');
        $email->setTo('info@laptopservicebandung.com');
        $email->setSubject('Pesan Baru dari Website - ' . $data['service_type']);

        $message = "
        <h2>Pesan Baru dari Website</h2>
        <p><strong>Nama:</strong> {$data['name']}</p>
        <p><strong>Email:</strong> {$data['email']}</p>
        <p><strong>Telepon:</strong> {$data['phone']}</p>
        <p><strong>Jenis Layanan:</strong> {$data['service_type']}</p>
        <p><strong>Pesan:</strong></p>
        <p>{$data['message']}</p>
        <hr>
        <p><small>Dikirim pada: {$data['created_at']}<br>
        IP Address: {$data['ip_address']}</small></p>
        ";

        $email->setMessage($message);

        return $email->send();
    }

    private function sendWhatsAppNotification($data)
    {
        // Implement WhatsApp API integration here
        // This could be using services like Fonnte, Wablas, or official WhatsApp Business API

        $message = "🔔 *Pesan Baru dari Website*\n\n";
        $message .= "👤 *Nama:* {$data['name']}\n";
        $message .= "📧 *Email:* {$data['email']}\n";
        $message .= "📱 *Telepon:* {$data['phone']}\n";
        $message .= "🔧 *Layanan:* {$data['service_type']}\n\n";
        $message .= "💬 *Pesan:*\n{$data['message']}\n\n";
        $message .= "📅 *Waktu:* {$data['created_at']}";

        // Send to admin WhatsApp number
        // Implementation depends on your chosen WhatsApp service

        return true;
    }
}