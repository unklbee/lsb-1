<!-- app/Views/admin/layouts/main.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Panel' ?> - LaptopService Bandung CMS</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- TinyMCE for WYSIWYG editor -->
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <style>
        .sidebar-active {
            transform: translateX(0);
        }

        .sidebar-inactive {
            transform: translateX(-100%);
        }
    </style>
</head>
<body class="bg-gray-100">
<!-- Navigation -->
<nav class="bg-blue-800 text-white shadow-lg fixed w-full top-0 z-50">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <button id="sidebar-toggle" class="lg:hidden p-2 rounded-md hover:bg-blue-700">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="flex-shrink-0 ml-4 lg:ml-0">
                    <h1 class="text-xl font-bold">LaptopService CMS</h1>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <a href="<?= base_url() ?>" target="_blank" class="text-blue-200 hover:text-white">
                    <i class="fas fa-external-link-alt mr-2"></i>View Site
                </a>

                <div class="relative">
                    <button id="user-menu-toggle" class="flex items-center space-x-2 p-2 rounded-md hover:bg-blue-700">
                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-sm"></i>
                        </div>
                        <span class="hidden sm:block"><?= $user['first_name'] ?? 'Admin' ?></span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>

                    <div id="user-menu"
                         class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                        <a href="/admin/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-user mr-2"></i>Profile
                        </a>
                        <a href="/admin/settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-cog mr-2"></i>Settings
                        </a>
                        <div class="border-t border-gray-100"></div>
                        <a href="/admin/logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="flex">
    <!-- Sidebar -->
    <aside id="sidebar"
           class="sidebar-inactive lg:sidebar-active fixed lg:static inset-y-0 left-0 z-40 w-64 bg-white shadow-lg transition-transform duration-300 ease-in-out lg:translate-x-0">
        <div class="h-full px-3 py-4 overflow-y-auto mt-16 lg:mt-16">
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="/admin/dashboard"
                       class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 <?= uri_string() == 'admin/dashboard' ? 'bg-blue-100 text-blue-700' : '' ?>">
                        <i class="fas fa-tachometer-alt w-5 h-5"></i>
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li>

                <li>
                    <button type="button"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100"
                            onclick="toggleSubmenu('content-submenu')">
                        <i class="fas fa-edit w-5 h-5"></i>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">Konten</span>
                        <i class="fas fa-chevron-down w-3 h-3 transition-transform duration-200"
                           id="content-submenu-icon"></i>
                    </button>
                    <ul id="content-submenu" class="hidden py-2 space-y-2">
                        <li>
                            <a href="/admin/blog/posts"
                               class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 <?= strpos(uri_string(), 'admin/blog/posts') !== false ? 'bg-blue-100 text-blue-700' : '' ?>">
                                <i class="fas fa-newspaper w-4 h-4"></i>
                                <span class="ml-2">Artikel Blog</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/blog/categories"
                               class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 <?= strpos(uri_string(), 'admin/blog/categories') !== false ? 'bg-blue-100 text-blue-700' : '' ?>">
                                <i class="fas fa-tags w-4 h-4"></i>
                                <span class="ml-2">Kategori Blog</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/pages"
                               class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 <?= strpos(uri_string(), 'admin/pages') !== false ? 'bg-blue-100 text-blue-700' : '' ?>">
                                <i class="fas fa-file-alt w-4 h-4"></i>
                                <span class="ml-2">Halaman</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="/admin/services"
                       class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 <?= strpos(uri_string(), 'admin/services') !== false ? 'bg-blue-100 text-blue-700' : '' ?>">
                        <i class="fas fa-tools w-5 h-5"></i>
                        <span class="ml-3">Layanan</span>
                    </a>
                </li>

                <li>
                    <button type="button"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100"
                            onclick="toggleSubmenu('faq-submenu')">
                        <i class="fas fa-question-circle w-5 h-5"></i>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">FAQ</span>
                        <i class="fas fa-chevron-down w-3 h-3 transition-transform duration-200"
                           id="faq-submenu-icon"></i>
                    </button>
                    <ul id="faq-submenu" class="hidden py-2 space-y-2">
                        <li>
                            <a href="/admin/faq/questions"
                               class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 <?= strpos(uri_string(), 'admin/faq/questions') !== false ? 'bg-blue-100 text-blue-700' : '' ?>">
                                <i class="fas fa-question w-4 h-4"></i>
                                <span class="ml-2">Pertanyaan</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/faq/categories"
                               class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 <?= strpos(uri_string(), 'admin/faq/categories') !== false ? 'bg-blue-100 text-blue-700' : '' ?>">
                                <i class="fas fa-folder w-4 h-4"></i>
                                <span class="ml-2">Kategori FAQ</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="/admin/testimonials"
                       class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 <?= strpos(uri_string(), 'admin/testimonials') !== false ? 'bg-blue-100 text-blue-700' : '' ?>">
                        <i class="fas fa-star w-5 h-5"></i>
                        <span class="ml-3">Testimoni</span>
                    </a>
                </li>

                <li>
                    <a href="/admin/contact"
                       class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 <?= strpos(uri_string(), 'admin/contact') !== false ? 'bg-blue-100 text-blue-700' : '' ?>">
                        <i class="fas fa-envelope w-5 h-5"></i>
                        <span class="ml-3">Pesan Kontak</span>
                        <?php
                        // Uncomment when ContactMessageModel is implemented
                        /*
                        $contactModel = new \App\Models\ContactMessageModel();
                        $newMessages = $contactModel->where('status', 'new')->countAllResults();
                        if ($newMessages > 0):
                        */
                        $newMessages = 3; // Demo value
                        if ($newMessages > 0):
                            ?>
                            <span class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-1"><?= $newMessages ?></span>
                        <?php endif; ?>
                    </a>
                </li>

                <li>
                    <button type="button"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100"
                            onclick="toggleSubmenu('media-submenu')">
                        <i class="fas fa-images w-5 h-5"></i>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">Media</span>
                        <i class="fas fa-chevron-down w-3 h-3 transition-transform duration-200"
                           id="media-submenu-icon"></i>
                    </button>
                    <ul id="media-submenu" class="hidden py-2 space-y-2">
                        <li>
                            <a href="/admin/media/images"
                               class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">
                                <i class="fas fa-image w-4 h-4"></i>
                                <span class="ml-2">Gambar</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/media/upload"
                               class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">
                                <i class="fas fa-upload w-4 h-4"></i>
                                <span class="ml-2">Upload</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <button type="button"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100"
                            onclick="toggleSubmenu('settings-submenu')">
                        <i class="fas fa-cog w-5 h-5"></i>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">Pengaturan</span>
                        <i class="fas fa-chevron-down w-3 h-3 transition-transform duration-200"
                           id="settings-submenu-icon"></i>
                    </button>
                    <ul id="settings-submenu" class="hidden py-2 space-y-2">
                        <li>
                            <a href="/admin/settings/general"
                               class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">
                                <i class="fas fa-sliders-h w-4 h-4"></i>
                                <span class="ml-2">Umum</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/settings/seo"
                               class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">
                                <i class="fas fa-search w-4 h-4"></i>
                                <span class="ml-2">SEO</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/settings/email"
                               class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">
                                <i class="fas fa-envelope-open w-4 h-4"></i>
                                <span class="ml-2">Email</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="/admin/users"
                       class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 <?= strpos(uri_string(), 'admin/users') !== false ? 'bg-blue-100 text-blue-700' : '' ?>">
                        <i class="fas fa-users w-5 h-5"></i>
                        <span class="ml-3">Pengguna</span>
                    </a>
                </li>

                <li class="pt-4 border-t border-gray-200">
                    <a href="/admin/analytics" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-chart-bar w-5 h-5"></i>
                        <span class="ml-3">Analytics</span>
                    </a>
                </li>

                <li>
                    <a href="/admin/backup" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-database w-5 h-5"></i>
                        <span class="ml-3">Backup</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 ml-0 lg:ml-0 p-4 mt-16">
        <!-- Page Header -->
        <div class="mb-6">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2"><?= $title ?? 'Dashboard' ?></h1>

                    <!-- Breadcrumb -->
                    <?php if (isset($breadcrumbs)): ?>
                        <nav class="text-sm">
                            <ol class="list-none p-0 inline-flex">
                                <?php foreach ($breadcrumbs as $index => $breadcrumb): ?>
                                    <li class="flex items-center">
                                        <?php if ($index > 0): ?>
                                            <i class="fas fa-chevron-right mx-2 text-gray-400"></i>
                                        <?php endif; ?>
                                        <?php if (isset($breadcrumb['url'])): ?>
                                            <a href="<?= $breadcrumb['url'] ?>"
                                               class="text-blue-600 hover:text-blue-800"><?= $breadcrumb['name'] ?></a>
                                        <?php else: ?>
                                            <span class="text-gray-500"><?= $breadcrumb['name'] ?></span>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ol>
                        </nav>
                    <?php endif; ?>
                </div>

                <!-- Action Buttons -->
                <?php if (isset($actionButtons)): ?>
                    <div class="flex space-x-2">
                        <?php foreach ($actionButtons as $button): ?>
                            <a href="<?= $button['url'] ?>"
                               class="<?= $button['class'] ?? 'bg-blue-600 hover:bg-blue-700 text-white' ?> px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                                <?php if (isset($button['icon'])): ?>
                                    <i class="<?= $button['icon'] ?> mr-2"></i>
                                <?php endif; ?>
                                <?= $button['text'] ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 relative"
                 role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span><?= session()->getFlashdata('success') ?></span>
                    <button class="absolute top-0 bottom-0 right-0 px-4 py-3"
                            onclick="this.parentElement.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 relative" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span><?= session()->getFlashdata('error') ?></span>
                    <button class="absolute top-0 bottom-0 right-0 px-4 py-3"
                            onclick="this.parentElement.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('warning')): ?>
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4 relative"
                 role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <span><?= session()->getFlashdata('warning') ?></span>
                    <button class="absolute top-0 bottom-0 right-0 px-4 py-3"
                            onclick="this.parentElement.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        <?php endif; ?>

        <!-- Page Content -->
        <div class="bg-white rounded-lg shadow-sm">
            <?= $this->renderSection('content') ?>
        </div>
    </main>
</div>

<!-- Sidebar Overlay for Mobile -->
<div id="sidebar-overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden"
     onclick="closeSidebar()"></div>

<!-- Loading Spinner -->
<div id="loading-spinner" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg flex items-center">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mr-3"></div>
        <span class="text-gray-700">Loading...</span>
    </div>
</div>

<script>
    // Sidebar Toggle
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');

    function toggleSidebar() {
        sidebar.classList.toggle('sidebar-active');
        sidebar.classList.toggle('sidebar-inactive');
        sidebarOverlay.classList.toggle('hidden');
    }

    function closeSidebar() {
        sidebar.classList.remove('sidebar-active');
        sidebar.classList.add('sidebar-inactive');
        sidebarOverlay.classList.add('hidden');
    }

    sidebarToggle.addEventListener('click', toggleSidebar);

    // User Menu Toggle
    const userMenuToggle = document.getElementById('user-menu-toggle');
    const userMenu = document.getElementById('user-menu');

    userMenuToggle.addEventListener('click', function () {
        userMenu.classList.toggle('hidden');
    });

    // Close user menu when clicking outside
    document.addEventListener('click', function (event) {
        if (!userMenuToggle.contains(event.target) && !userMenu.contains(event.target)) {
            userMenu.classList.add('hidden');
        }
    });

    // Submenu Toggle Function
    function toggleSubmenu(submenuId) {
        const submenu = document.getElementById(submenuId);
        const icon = document.getElementById(submenuId + '-icon');

        submenu.classList.toggle('hidden');

        if (submenu.classList.contains('hidden')) {
            icon.style.transform = 'rotate(0deg)';
        } else {
            icon.style.transform = 'rotate(180deg)';
        }
    }

    // Auto-expand active submenu
    document.addEventListener('DOMContentLoaded', function () {
        // Check for active submenu items and expand their parent
        const activeSubmenuItems = document.querySelectorAll('.pl-11.bg-blue-100');
        activeSubmenuItems.forEach(function (item) {
            const submenu = item.closest('ul[id$="-submenu"]');
            if (submenu) {
                submenu.classList.remove('hidden');
                const icon = document.getElementById(submenu.id + '-icon');
                if (icon) {
                    icon.style.transform = 'rotate(180deg)';
                }
            }
        });
    });

    // AJAX Helper Function
    function showLoading() {
        document.getElementById('loading-spinner').classList.remove('hidden');
    }

    function hideLoading() {
        document.getElementById('loading-spinner').classList.add('hidden');
    }

    // Form Submit with Loading
    function submitFormWithLoading(formId) {
        const form = document.getElementById(formId);
        if (form) {
            form.addEventListener('submit', function () {
                showLoading();
            });
        }
    }

    // Auto-hide flash messages after 5 seconds
    setTimeout(function () {
        const alerts = document.querySelectorAll('[role="alert"]');
        alerts.forEach(function (alert) {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.5s';
            setTimeout(function () {
                alert.remove();
            }, 500);
        });
    }, 5000);

    // Confirm Delete Function
    function confirmDelete(message = 'Apakah Anda yakin ingin menghapus item ini?') {
        return confirm(message);
    }

    // Bulk Action Helper
    function handleBulkAction() {
        const checkboxes = document.querySelectorAll('input[name="selected_items[]"]:checked');
        if (checkboxes.length === 0) {
            alert('Pilih minimal satu item untuk melakukan aksi bulk.');
            return false;
        }
        return true;
    }

    // Select All Checkbox
    function toggleSelectAll(selectAllCheckbox) {
        const checkboxes = document.querySelectorAll('input[name="selected_items[]"]');
        checkboxes.forEach(function (checkbox) {
            checkbox.checked = selectAllCheckbox.checked;
        });
    }

    // Initialize TinyMCE if present
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                selector: '.tinymce',
                height: 400,
                menubar: false,
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'preview', 'help', 'wordcount'
                ],
                toolbar: 'undo redo | blocks | ' +
                    'bold italic forecolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size:14px }'
            });
        }
    });

    // Search functionality
    function initSearch() {
        const searchInput = document.getElementById('search-input');
        if (searchInput) {
            searchInput.addEventListener('input', function () {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('tbody tr');

                rows.forEach(function (row) {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
    }

    // Initialize search on page load
    document.addEventListener('DOMContentLoaded', initSearch);
</script>

<!-- Custom CSS -->
<?= $this->renderSection('css') ?>

<!-- Custom JavaScript -->
<?= $this->renderSection('javascript') ?>
</body>
</html>