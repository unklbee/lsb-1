<?php
// app/Controllers/Admin/BaseAdminController.php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Base controller untuk semua controller admin
 * Menangani authentikasi secara terpusat
 */
abstract class BaseAdminController extends BaseController
{
    protected $session;
    protected $adminUser = null;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->session = session();

        // Check authentication untuk semua method kecuali yang dikecualikan
        if (!$this->isPublicMethod()) {
            $this->requireAuth();
        }
    }

    /**
     * Method yang tidak memerlukan authentikasi
     * Override di child class jika diperlukan
     */
    protected function getPublicMethods(): array
    {
        return ['login', 'authenticate', 'forgotPassword', 'resetPassword'];
    }

    /**
     * Check apakah method saat ini adalah public method
     */
    private function isPublicMethod(): bool
    {
        $router = service('router');
        $currentMethod = $router->methodName();

        return in_array($currentMethod, $this->getPublicMethods());
    }

    /**
     * Require authentication untuk mengakses method
     */
    protected function requireAuth(): void
    {
        if (!$this->isLoggedIn()) {
            $this->redirectToLogin();
        }

        // Set admin user data
        $this->adminUser = $this->session->get('admin_user');
    }

    /**
     * Check apakah user sudah login
     */
    protected function isLoggedIn(): bool
    {
        return $this->session->get('admin_logged_in') === true &&
            $this->session->get('admin_user') !== null;
    }

    /**
     * Redirect ke halaman login
     */
    protected function redirectToLogin(): void
    {
        // Log unauthorized access
        log_message('warning', 'Unauthorized admin access attempt from IP: ' . $this->request->getIPAddress() . ' to URL: ' . current_url());

        // Set flash message
        $this->session->setFlashdata('error', 'Anda harus login terlebih dahulu untuk mengakses halaman admin.');

        // Simpan intended URL untuk redirect setelah login
        $this->session->set('intended_url', current_url());

        // Redirect dan stop execution
        header('Location: ' . base_url('/admin/login'));
        exit();
    }

    /**
     * Check role permission (jika ada sistem role)
     */
    protected function hasPermission(string $permission): bool
    {
        if (!$this->adminUser) {
            return false;
        }

        // Implementasi sederhana - admin memiliki semua permission
        // Bisa dikembangkan lebih kompleks sesuai kebutuhan
        return $this->adminUser['role'] === 'admin' || $this->adminUser['role'] === 'super_admin';
    }

    /**
     * Require specific permission
     */
    protected function requirePermission(string $permission): void
    {
        if (!$this->hasPermission($permission)) {
            // Log unauthorized access
            log_message('warning', 'Insufficient permission for user: ' . ($this->adminUser['username'] ?? 'unknown') . ' accessing: ' . current_url());

            $this->session->setFlashdata('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');

            // Redirect ke dashboard atau halaman yang sesuai
            header('Location: ' . base_url('/admin/dashboard'));
            exit();
        }
    }

    /**
     * Get current admin user
     */
    protected function getCurrentUser(): ?array
    {
        return $this->adminUser;
    }

    /**
     * Check if request is from authenticated admin (untuk AJAX)
     */
    protected function isAuthenticatedAjax(): bool
    {
        return $this->request->isAJAX() && $this->isLoggedIn();
    }

    /**
     * Standard JSON response untuk AJAX
     */
    protected function jsonResponse(array $data, int $statusCode = 200)
    {
        return $this->response->setStatusCode($statusCode)->setJSON($data);
    }

    /**
     * Unauthorized JSON response
     */
    protected function unauthorizedJson()
    {
        return $this->jsonResponse([
            'status' => 'error',
            'message' => 'Unauthorized access'
        ], 401);
    }

    /**
     * Forbidden JSON response
     */
    protected function forbiddenJson()
    {
        return $this->jsonResponse([
            'status' => 'error',
            'message' => 'Forbidden access'
        ], 403);
    }

    /**
     * Success JSON response
     */
    protected function successJson(array $data = [], string $message = 'Success')
    {
        return $this->jsonResponse([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ]);
    }

    /**
     * Error JSON response
     */
    protected function errorJson(string $message = 'Error occurred', array $errors = [])
    {
        return $this->jsonResponse([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors
        ], 400);
    }

    /**
     * Set common view data for admin pages
     */
    protected function setAdminViewData(array $data = []): array
    {
        return array_merge([
            'user' => $this->adminUser,
            'current_url' => current_url(),
            'is_admin' => true
        ], $data);
    }

    /**
     * Method untuk logout (bisa dipanggil dari controller manapun)
     */
    protected function doLogout(): void
    {
        // Log logout activity
        if ($this->adminUser) {
            log_message('info', 'Admin logout: ' . $this->adminUser['username'] . ' from IP: ' . $this->request->getIPAddress());
        }

        // Destroy session
        $this->session->destroy();

        // Set success message
        session()->setFlashdata('success', 'Anda telah berhasil logout.');

        // Redirect to login
        header('Location: ' . base_url('/admin/login'));
        exit();
    }

    /**
     * Update last activity
     */
    protected function updateLastActivity(): void
    {
        if ($this->adminUser) {
            $this->session->set('admin_last_activity', time());
        }
    }

    /**
     * Check session timeout
     */
    protected function checkSessionTimeout(): bool
    {
        $lastActivity = $this->session->get('admin_last_activity');
        $timeout = 3600; // 1 hour timeout

        if ($lastActivity && (time() - $lastActivity) > $timeout) {
            $this->session->setFlashdata('error', 'Session Anda telah expired. Silakan login kembali.');
            $this->doLogout();
            return false;
        }

        $this->updateLastActivity();
        return true;
    }
}