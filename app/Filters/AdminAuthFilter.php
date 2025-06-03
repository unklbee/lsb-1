<?php
// app/Filters/AdminAuthFilter.php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminAuthFilter implements FilterInterface
{
    /**
     * Check if user is authenticated admin
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Get current route
        $router = service('router');
        $controller = $router->controllerName();
        $method = $router->methodName();

        // Routes yang tidak memerlukan auth
        $publicRoutes = [
            'Auth::login',
            'Auth::authenticate',
            'Auth::forgotPassword',
            'Auth::resetPassword'
        ];

        $currentRoute = class_basename($controller) . '::' . $method;

        // Skip auth check untuk public routes
        if (in_array($currentRoute, $publicRoutes)) {
            return;
        }

        // Check authentication
        if (!$session->get('admin_logged_in') || !$session->get('admin_user')) {
            // Log unauthorized access
            log_message('warning', 'Unauthorized admin access blocked: ' . current_url() . ' from IP: ' . $request->getIPAddress());

            // Set flash message
            $session->setFlashdata('error', 'Anda harus login terlebih dahulu untuk mengakses halaman admin.');

            // Save intended URL
            $session->set('intended_url', current_url());

            // AJAX request handling
            if ($request->isAJAX()) {
                $response = service('response');
                return $response->setJSON([
                    'status' => 'error',
                    'message' => 'Unauthorized access',
                    'redirect' => base_url('/admin/login')
                ])->setStatusCode(401);
            }

            // Regular request redirect
            return redirect()->to('/admin/login');
        }

        // Check session timeout
        $lastActivity = $session->get('admin_last_activity');
        $timeout = 3600; // 1 hour

        if ($lastActivity && (time() - $lastActivity) > $timeout) {
            // Session expired
            log_message('info', 'Admin session expired for user: ' . ($session->get('admin_user')['email'] ?? 'unknown'));

            $session->destroy();
            $session->setFlashdata('error', 'Session Anda telah expired. Silakan login kembali.');

            if ($request->isAJAX()) {
                $response = service('response');
                return $response->setJSON([
                    'status' => 'error',
                    'message' => 'Session expired',
                    'redirect' => base_url('/admin/login')
                ])->setStatusCode(401);
            }

            return redirect()->to('/admin/login');
        }

        // Update last activity
        $session->set('admin_last_activity', time());

        // Check user role (optional)
        $user = $session->get('admin_user');
        if (!in_array($user['role'] ?? '', ['admin', 'super_admin'])) {
            log_message('warning', 'Insufficient role for admin access: ' . ($user['email'] ?? 'unknown') . ' with role: ' . ($user['role'] ?? 'none'));

            $session->setFlashdata('error', 'Anda tidak memiliki akses ke panel admin.');

            if ($request->isAJAX()) {
                $response = service('response');
                return $response->setJSON([
                    'status' => 'error',
                    'message' => 'Insufficient permissions'
                ])->setStatusCode(403);
            }

            return redirect()->to('/');
        }
    }

    /**
     * After filter - cleanup, logging, etc
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Log admin activity (optional)
        $session = session();
        $user = $session->get('admin_user');

        if ($user) {
            // Log successful admin action
            $router = service('router');
            $action = class_basename($router->controllerName()) . '::' . $router->methodName();

            // Only log POST actions to avoid spam
            if ($request->getMethod() === 'POST') {
                log_message('info', 'Admin action: ' . $user['email'] . ' performed ' . $action);
            }
        }
    }
}