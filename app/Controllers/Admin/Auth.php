<?php
// app/Controllers/Admin/Auth.php

namespace App\Controllers\Admin;

use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class Auth extends BaseAdminController
{
    /**
     * Public methods yang tidak memerlukan auth
     */
    protected function getPublicMethods(): array
    {
        return ['login', 'authenticate', 'forgotPassword', 'resetPassword', 'logout'];
    }

    public function login(): string|RedirectResponse
    {
        // Jika sudah login, redirect ke dashboard
        if ($this->isLoggedIn()) {
            return redirect()->to('/admin/dashboard');
        }

        return view('admin/auth/login', [
            'title' => 'Login Admin'
        ]);
    }

    public function authenticate()
    {
        // Jika sudah login, redirect ke dashboard
        if ($this->isLoggedIn()) {
            return redirect()->to('/admin/dashboard');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]'
        ], [
            'email' => [
                'required' => 'Email wajib diisi',
                'valid_email' => 'Format email tidak valid'
            ],
            'password' => [
                'required' => 'Password wajib diisi',
                'min_length' => 'Password minimal 6 karakter'
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $userModel = new UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Authenticate user
        $user = $userModel->authenticate($email, $password);

        if ($user) {
            // Check if user is admin
            if (!in_array($user['role'], ['admin', 'super_admin'])) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Akun Anda tidak memiliki akses ke panel admin.');
            }

            // Set session data
            $sessionData = [
                'admin_logged_in' => true,
                'admin_user' => $user,
                'admin_login_time' => time(),
                'admin_last_activity' => time()
            ];

            session()->set($sessionData);

            // Log successful login
            log_message('info', 'Admin login successful: ' . $user['email'] . ' from IP: ' . $this->request->getIPAddress());

            // Check for intended URL
            $intendedUrl = session()->get('intended_url');
            if ($intendedUrl) {
                session()->remove('intended_url');
                return redirect()->to($intendedUrl);
            }

            // Redirect to dashboard
            return redirect()->to('/admin/dashboard')
                ->with('success', 'Selamat datang, ' . $user['first_name'] . '!');

        } else {
            // Log failed login attempt
            log_message('warning', 'Admin login failed for email: ' . $email . ' from IP: ' . $this->request->getIPAddress());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Email atau password salah. Silakan coba lagi.');
        }
    }

    public function logout(): RedirectResponse
    {
        // Log logout
        if ($this->isLoggedIn()) {
            $user = session()->get('admin_user');
            log_message('info', 'Admin logout: ' . $user['email'] . ' from IP: ' . $this->request->getIPAddress());
        }

        // Destroy session
        session()->destroy();

        return redirect()->to('/admin/login')
            ->with('success', 'Anda telah berhasil logout.');
    }

    /**
     * Forgot password form
     */
    public function forgotPassword()
    {
        if ($this->isLoggedIn()) {
            return redirect()->to('/admin/dashboard');
        }

        return view('admin/auth/forgot-password', [
            'title' => 'Lupa Password'
        ]);
    }

    /**
     * Send reset password email
     */
    public function sendResetPassword()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'email' => 'required|valid_email'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $email = $this->request->getPost('email');
        $userModel = new UserModel();

        $user = $userModel->where('email', $email)
            ->where('is_active', 1)
            ->first();

        if ($user) {
            // Generate reset token
            $token = bin2hex(random_bytes(32));

            // Save token to database (you need to create password_resets table)
            // For now, just show success message

            log_message('info', 'Password reset requested for: ' . $email);
        }

        // Always show success message for security
        return redirect()->back()
            ->with('success', 'Jika email terdaftar, link reset password telah dikirim.');
    }

    /**
     * Reset password form
     */
    public function resetPassword($token = null)
    {
        if (!$token) {
            return redirect()->to('/admin/login')
                ->with('error', 'Token reset password tidak valid.');
        }

        // Verify token (implement token verification)

        return view('admin/auth/reset-password', [
            'title' => 'Reset Password',
            'token' => $token
        ]);
    }

    /**
     * Process password reset
     */
    public function updatePassword()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'token' => 'required',
            'password' => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        // Verify token and update password
        // Implementation depends on your password reset table structure

        return redirect()->to('/admin/login')
            ->with('success', 'Password berhasil direset. Silakan login dengan password baru.');
    }

    /**
     * Check if user is still logged in (AJAX)
     */
    public function checkSession()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(404);
        }

        return $this->response->setJSON([
            'logged_in' => $this->isLoggedIn(),
            'time_remaining' => $this->getSessionTimeRemaining()
        ]);
    }

    /**
     * Get remaining session time
     */
    private function getSessionTimeRemaining(): int
    {
        $lastActivity = session()->get('admin_last_activity');
        $timeout = 3600; // 1 hour

        if (!$lastActivity) {
            return 0;
        }

        $remaining = $timeout - (time() - $lastActivity);
        return max(0, $remaining);
    }
}