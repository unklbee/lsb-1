<?php

// app/Filters/SecurityHeadersFilter.php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class SecurityHeadersFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // No action needed before
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Add security headers
        $response->setHeader('X-Content-Type-Options', 'nosniff')
            ->setHeader('X-Frame-Options', 'DENY')
            ->setHeader('X-XSS-Protection', '1; mode=block')
            ->setHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
            ->setHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=()')
            ->setHeader('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');

        // CSP for admin pages
        if (strpos($request->getUri()->getPath(), '/admin') === 0) {
            $csp = "default-src 'self'; ";
            $csp .= "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.tailwindcss.com https://cdn.tiny.cloud; ";
            $csp .= "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.tailwindcss.com https://cdnjs.cloudflare.com; ";
            $csp .= "font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com; ";
            $csp .= "img-src 'self' data: https:; ";
            $csp .= "connect-src 'self';";

            $response->setHeader('Content-Security-Policy', $csp);
        }

        return $response;
    }
}