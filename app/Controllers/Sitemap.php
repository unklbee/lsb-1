<?php

namespace App\Controllers;

class Sitemap extends BaseController
{
    public function index(): string
    {
        // Set content type to XML
        $this->response->setContentType('application/xml');

        // Generate sitemap URLs
        $urls = [
            [
                'loc' => base_url(),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'daily',
                'priority' => '1.0'
            ],
            [
                'loc' => base_url('/layanan'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.9'
            ],
            [
                'loc' => base_url('/layanan/service-laptop'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.9'
            ],
            [
                'loc' => base_url('/layanan/service-komputer'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.9'
            ],
            [
                'loc' => base_url('/layanan/upgrade-hardware'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.8'
            ],
            [
                'loc' => base_url('/layanan/data-recovery'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.8'
            ],
            [
                'loc' => base_url('/blog'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'daily',
                'priority' => '0.8'
            ],
            [
                'loc' => base_url('/faq'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => base_url('/testimonial'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.7'
            ],
            [
                'loc' => base_url('/tentang-kami'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.6'
            ],
            [
                'loc' => base_url('/kontak'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ]
        ];

        // Add blog posts (dynamic)
        $blogPosts = $this->getBlogPosts();
        foreach ($blogPosts as $post) {
            $urls[] = [
                'loc' => base_url('/blog/' . $post['slug']),
                'lastmod' => $post['updated_at'],
                'changefreq' => 'monthly',
                'priority' => '0.6'
            ];
        }

        $data = ['urls' => $urls];

        return view('sitemap/xml', $data);
    }

    private function getBlogPosts(): array
    {
        // This would typically come from your database
        // For now, returning sample data
        return [
            [
                'slug' => 'cara-merawat-laptop-agar-awet',
                'updated_at' => '2024-01-15'
            ],
            [
                'slug' => 'tanda-laptop-perlu-service',
                'updated_at' => '2024-01-20'
            ],
            [
                'slug' => 'upgrade-ssd-vs-hdd-mana-lebih-baik',
                'updated_at' => '2024-01-25'
            ],
            [
                'slug' => 'tips-mengatasi-laptop-overheat',
                'updated_at' => '2024-01-30'
            ],
            [
                'slug' => 'panduan-backup-data-sebelum-service',
                'updated_at' => '2024-02-01'
            ]
        ];
    }
}