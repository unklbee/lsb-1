<?php

// app/Filters/ThrottleFilter.php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ThrottleFilter implements FilterInterface
{
    private $maxAttempts = 5;    // Max attempts
    private $timeWindow = 900;   // 15 minutes in seconds
    private $cachePrefix = 'throttle_';

    public function before(RequestInterface $request, $arguments = null)
    {
        $cache = \Config\Services::cache();
        $ip = $request->getIPAddress();
        $uri = $request->getUri()->getPath();

        // Create unique key for this IP and endpoint
        $key = $this->cachePrefix . md5($ip . $uri);

        // Get current attempt count
        $attempts = $cache->get($key) ?: 0;

        if ($attempts >= $this->maxAttempts) {
            // Log throttled request
            log_message('warning', "Request throttled for IP: {$ip} on endpoint: {$uri}");

            $response = service('response');

            if ($request->isAJAX()) {
                return $response->setJSON([
                    'status' => 'error',
                    'message' => 'Terlalu banyak percobaan. Silakan coba lagi dalam 15 menit.'
                ])->setStatusCode(429);
            }

            return $response->setStatusCode(429)
                ->setBody('Too Many Requests - Silakan coba lagi dalam 15 menit.');
        }

        // Increment attempt count
        $cache->save($key, $attempts + 1, $this->timeWindow);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Reset counter on successful request (status 200-299)
        $statusCode = $response->getStatusCode();

        if ($statusCode >= 200 && $statusCode < 300) {
            $cache = \Config\Services::cache();
            $ip = $request->getIPAddress();
            $uri = $request->getUri()->getPath();
            $key = $this->cachePrefix . md5($ip . $uri);

            $cache->delete($key);
        }
    }
}
