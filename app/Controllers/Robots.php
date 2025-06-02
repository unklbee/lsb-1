<?php

namespace App\Controllers;

class Robots extends BaseController
{
    public function index(): \CodeIgniter\HTTP\ResponseInterface
    {
        // Set content type to plain text
        $this->response->setContentType('text/plain');

        $content = "User-agent: *\n";
        $content .= "Allow: /\n";
        $content .= "Disallow: /admin/\n";
        $content .= "Disallow: /private/\n";
        $content .= "Disallow: /app/\n";
        $content .= "Disallow: /system/\n";
        $content .= "Disallow: /writable/\n";
        $content .= "\n";
        $content .= "# Sitemap\n";
        $content .= "Sitemap: " . base_url('/sitemap.xml') . "\n";

        return $this->response->setBody($content);
    }
}