<!-- app/Views/admin/auth/login.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - LaptopService Bandung CMS</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        .bg-gradient-admin {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #06b6d4 100%);
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            background: #60a5fa;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            background: #34d399;
            top: 20%;
            right: 10%;
            animation-delay: 2s;
        }

        .shape:nth-child(3) {
            width: 100px;
            height: 100px;
            background: #fbbf24;
            bottom: 20%;
            left: 15%;
            animation-delay: 4s;
        }

        .shape:nth-child(4) {
            width: 60px;
            height: 60px;
            background: #f87171;
            bottom: 10%;
            right: 20%;
            animation-delay: 1s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        .input-group {
            position: relative;
        }

        .input-group input:focus + label,
        .input-group input:not(:placeholder-shown) + label {
            transform: translateY(-1.5rem) scale(0.875);
            color: #2563eb;
        }

        .input-group label {
            position: absolute;
            left: 1rem;
            top: 1rem;
            transition: all 0.2s ease-in-out;
            pointer-events: none;
            color: #6b7280;
        }
    </style>
</head>
<body class="bg-gradient-admin min-h-screen flex items-center justify-center p-4">
<div class="floating-shapes">
    <div class="shape"></div>
    <div class="shape"></div>
    <div class="shape"></div>
    <div class="shape"></div>
</div>

<div class="login-container w-full max-w-md p-8 rounded-2xl shadow-2xl relative z-10">
    <!-- Logo and Header -->
    <div class="text-center mb-8">
        <div class="w-20 h-20 bg-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
            <i class="fas fa-laptop text-white text-2xl"></i>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 mb-2">LaptopService CMS</h1>
        <p class="text-gray-600">Masuk ke panel admin</p>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 relative" role="alert">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span><?= session()->getFlashdata('error') ?></span>
            </div>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 relative"
             role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span><?= session()->getFlashdata('success') ?></span>
            </div>
        </div>
    <?php endif; ?>

    <!-- Validation Errors -->
    <?php if (isset($validation) || session()->getFlashdata('errors')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
            <div class="flex items-center mb-2">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <span class="font-medium">Terjadi kesalahan:</span>
            </div>
            <ul class="list-disc list-inside text-sm">
                <?php
                $errors = isset($validation) ? $validation->getErrors() : session()->getFlashdata('errors');
                if (is_array($errors)):
                    foreach ($errors as $error):
                        ?>
                        <li><?= esc($error) ?></li>
                    <?php
                    endforeach;
                endif;
                ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Login Form -->
    <form action="<?= base_url('/admin/authenticate') ?>" method="POST" id="loginForm">
        <?= csrf_field() ?>

        <div class="space-y-6">
            <!-- Email Field -->
            <div class="input-group">
                <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder=" "
                        class="w-full px-4 py-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white"
                        value="<?= old('email') ?>"
                        required
                        autocomplete="email"
                >
                <label for="email" class="text-gray-500">Email</label>
            </div>

            <!-- Password Field -->
            <div class="input-group">
                <div class="relative">
                    <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder=" "
                            class="w-full px-4 py-4 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white"
                            required
                            autocomplete="current-password"
                    >
                    <label for="password" class="text-gray-500">Password</label>
                    <button
                            type="button"
                            onclick="togglePassword()"
                            class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                    >
                        <i id="password-icon" class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input
                            type="checkbox"
                            id="remember"
                            name="remember"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                    >
                    <label for="remember" class="ml-2 text-sm text-gray-600">Ingat saya</label>
                </div>

                <a href="<?= base_url('/admin/auth/forgot-password') ?>"
                   class="text-sm text-blue-600 hover:text-blue-700 hover:underline">
                    Lupa password?
                </a>
            </div>

            <!-- Submit Button -->
            <button
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-4 rounded-lg transition-all duration-200 transform hover:scale-[1.02] focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
                    id="submitBtn"
            >
                <span id="submitText">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Masuk
                </span>
                <span id="loadingText" class="hidden">
                    <i class="fas fa-spinner fa-spin mr-2"></i>
                    Memproses...
                </span>
            </button>
        </div>
    </form>

    <!-- Demo Credentials -->
    <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
        <div class="flex items-center text-yellow-800 mb-2">
            <i class="fas fa-info-circle mr-2"></i>
            <span class="font-medium">Demo Credentials:</span>
        </div>
        <div class="text-sm text-yellow-700">
            <p><strong>Email:</strong> admin@laptopservice.com</p>
            <p><strong>Password:</strong> admin123</p>
        </div>
    </div>

    <!-- Additional Links -->
    <div class="mt-8 pt-6 border-t border-gray-200 text-center">
        <p class="text-sm text-gray-600 mb-4">
            Belum punya akses? Hubungi administrator.
        </p>

        <div class="flex justify-center space-x-4 text-sm">
            <a href="<?= base_url() ?>" class="text-blue-600 hover:text-blue-700 hover:underline">
                <i class="fas fa-home mr-1"></i>
                Kembali ke Website
            </a>
            <span class="text-gray-300">|</span>
            <a href="#" class="text-blue-600 hover:text-blue-700 hover:underline">
                <i class="fas fa-question-circle mr-1"></i>
                Bantuan
            </a>
        </div>
    </div>

    <!-- Footer -->
    <div class="mt-8 text-center">
        <p class="text-xs text-gray-500">
            © <?= date('Y') ?> LaptopService Bandung.
            <br>Panel Admin v1.0
        </p>
    </div>
</div>

<script>
    // Toggle password visibility
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const passwordIcon = document.getElementById('password-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordIcon.className = 'fas fa-eye-slash';
        } else {
            passwordInput.type = 'password';
            passwordIcon.className = 'fas fa-eye';
        }
    }

    // Form submission with loading state
    document.getElementById('loginForm').addEventListener('submit', function (e) {
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        const loadingText = document.getElementById('loadingText');

        // Disable button and show loading
        submitBtn.disabled = true;
        submitText.classList.add('hidden');
        loadingText.classList.remove('hidden');

        // Debug: Log form data
        console.log('Form submitted');
        console.log('Email:', document.getElementById('email').value);
        console.log('Action:', this.action);

        // Re-enable button after 10 seconds as fallback
        setTimeout(function () {
            submitBtn.disabled = false;
            submitText.classList.remove('hidden');
            loadingText.classList.add('hidden');
        }, 10000);
    });

    // Auto-focus first empty input
    document.addEventListener('DOMContentLoaded', function () {
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');

        if (!emailInput.value) {
            emailInput.focus();
        } else {
            passwordInput.focus();
        }

        // Debug: Check form action
        const form = document.getElementById('loginForm');
        console.log('Form action URL:', form.action);
        console.log('Base URL:', '<?= base_url() ?>');
    });

    // Enter key navigation
    document.getElementById('email').addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            document.getElementById('password').focus();
        }
    });

    // Auto-fill demo credentials (for development only)
    document.addEventListener('DOMContentLoaded', function () {
        // Auto-fill demo credentials
        document.getElementById('email').value = 'admin@laptopservice.com';
        document.getElementById('password').value = 'admin123';
    });

    // Check for redirect parameter
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('redirect')) {
        console.log('Redirect parameter found:', urlParams.get('redirect'));
    }

    // Debug: Log current URL
    console.log('Current URL:', window.location.href);
    console.log('Current pathname:', window.location.pathname);
</script>
</body>
</html>