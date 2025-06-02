<!-- app/Views/admin/dashboard/index.php -->
<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<!-- Dashboard Overview Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Artikel Blog -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Total Artikel</p>
                <p class="text-3xl font-bold"><?= $stats['total_posts'] ?? 24 ?></p>
                <div class="flex items-center mt-2">
                    <i class="fas fa-arrow-up text-green-300 mr-1"></i>
                    <span class="text-green-300 text-sm">+5 bulan ini</span>
                </div>
            </div>
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                <i class="fas fa-newspaper text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Pesan Kontak -->
    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-medium">Pesan Kontak</p>
                <p class="text-3xl font-bold"><?= $stats['contact_messages'] ?? 12 ?></p>
                <div class="flex items-center mt-2">
                    <i class="fas fa-clock text-yellow-300 mr-1"></i>
                    <span class="text-yellow-300 text-sm"><?= $stats['new_messages'] ?? 3 ?> baru</span>
                </div>
            </div>
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                <i class="fas fa-envelope text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Layanan -->
    <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm font-medium">Total Layanan</p>
                <p class="text-3xl font-bold"><?= $stats['total_services'] ?? 6 ?></p>
                <div class="flex items-center mt-2">
                    <i class="fas fa-check text-green-300 mr-1"></i>
                    <span class="text-green-300 text-sm">Aktif semua</span>
                </div>
            </div>
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                <i class="fas fa-tools text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Pengunjung Bulan Ini -->
    <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-orange-100 text-sm font-medium">Pengunjung</p>
                <p class="text-3xl font-bold"><?= $stats['monthly_visitors'] ?? '2.4K' ?></p>
                <div class="flex items-center mt-2">
                    <i class="fas fa-arrow-up text-green-300 mr-1"></i>
                    <span class="text-green-300 text-sm">+12% vs bulan lalu</span>
                </div>
            </div>
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                <i class="fas fa-users text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Quick Actions -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                <i class="fas fa-bolt text-yellow-500 mr-2"></i>
                Aksi Cepat
            </h3>
            <div class="space-y-3">
                <a href="/admin/blog/posts/create" class="flex items-center p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors duration-200">
                    <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-plus text-white"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Tulis Artikel Baru</p>
                        <p class="text-sm text-gray-500">Buat konten blog terbaru</p>
                    </div>
                </a>

                <a href="/admin/services/create" class="flex items-center p-3 bg-green-50 hover:bg-green-100 rounded-lg transition-colors duration-200">
                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-tools text-white"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Tambah Layanan</p>
                        <p class="text-sm text-gray-500">Buat layanan service baru</p>
                    </div>
                </a>

                <a href="/admin/contact" class="flex items-center p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors duration-200">
                    <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-envelope text-white"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Cek Pesan</p>
                        <p class="text-sm text-gray-500">Lihat pesan dari pelanggan</p>
                    </div>
                </a>

                <a href="/admin/settings/seo" class="flex items-center p-3 bg-orange-50 hover:bg-orange-100 rounded-lg transition-colors duration-200">
                    <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-search text-white"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Optimasi SEO</p>
                        <p class="text-sm text-gray-500">Tingkatkan ranking website</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Analytics -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">
                    <i class="fas fa-chart-line text-blue-500 mr-2"></i>
                    Aktivitas Website
                </h3>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded-md font-medium">7 Hari</button>
                    <button class="px-3 py-1 text-sm text-gray-500 hover:bg-gray-100 rounded-md">30 Hari</button>
                </div>
            </div>

            <!-- Mini Chart Placeholder -->
            <div class="h-48 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg flex items-center justify-center mb-6">
                <div class="text-center">
                    <i class="fas fa-chart-area text-4xl text-blue-300 mb-2"></i>
                    <p class="text-gray-500">Grafik Analytics</p>
                    <p class="text-sm text-gray-400">Data pengunjung dan interaksi</p>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center p-3 bg-gray-50 rounded-lg">
                    <p class="text-2xl font-bold text-gray-900"><?= $stats['today_visitors'] ?? 127 ?></p>
                    <p class="text-sm text-gray-500">Hari Ini</p>
                </div>
                <div class="text-center p-3 bg-gray-50 rounded-lg">
                    <p class="text-2xl font-bold text-gray-900"><?= $stats['page_views'] ?? '1.2K' ?></p>
                    <p class="text-sm text-gray-500">Page Views</p>
                </div>
                <div class="text-center p-3 bg-gray-50 rounded-lg">
                    <p class="text-2xl font-bold text-gray-900"><?= $stats['avg_duration'] ?? '2:45' ?></p>
                    <p class="text-sm text-gray-500">Avg. Duration</p>
                </div>
                <div class="text-center p-3 bg-gray-50 rounded-lg">
                    <p class="text-2xl font-bold text-gray-900"><?= $stats['bounce_rate'] ?? '32%' ?></p>
                    <p class="text-sm text-gray-500">Bounce Rate</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Posts -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">
                <i class="fas fa-newspaper text-green-500 mr-2"></i>
                Artikel Terbaru
            </h3>
            <a href="/admin/blog/posts" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>

        <div class="space-y-4">
            <?php
            $recentPosts = $recentPosts ?? [
                ['title' => 'Tips Merawat Laptop Gaming Agar Awet', 'date' => '2024-06-01', 'status' => 'published', 'views' => 245],
                ['title' => 'Cara Mengatasi Laptop Overheat', 'date' => '2024-05-30', 'status' => 'published', 'views' => 189],
                ['title' => 'Panduan Upgrade SSD di Laptop', 'date' => '2024-05-28', 'status' => 'draft', 'views' => 0],
                ['title' => 'Review Service Laptop Terbaik Bandung', 'date' => '2024-05-25', 'status' => 'published', 'views' => 312],
            ];
            ?>

            <?php foreach ($recentPosts as $post): ?>
                <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                    <div class="flex-1">
                        <p class="font-medium text-gray-900 mb-1"><?= $post['title'] ?></p>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-calendar mr-1"></i>
                            <?= date('d M Y', strtotime($post['created_at'])) ?>
                            <span class="mx-2">•</span>
                            <span class="px-2 py-1 text-xs rounded-full <?= $post['is_published'] == 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' ?>">
                            <?= ucfirst($post['is_published']) ?>
                        </span>
                            <?php if ($post['is_published'] == 'published'): ?>
                                <span class="mx-2">•</span>
                                <i class="fas fa-eye mr-1"></i>
                                <?= $post['views'] ?> views
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <a href="/admin/blog/posts/edit/<?= $post['title'] ?>" class="text-blue-600 hover:text-blue-700">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="/blog/<?= url_title(strtolower($post['title']), '-', true) ?>" target="_blank" class="text-gray-600 hover:text-gray-700">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Recent Messages & System Status -->
    <div class="space-y-6">
        <!-- Recent Contact Messages -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">
                    <i class="fas fa-envelope text-purple-500 mr-2"></i>
                    Pesan Terbaru
                </h3>
                <a href="/admin/contact" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            <div class="space-y-4">
                <?php
                $recentMessages = $recentMessages ?? [
                    ['name' => 'Ahmad Santoso', 'subject' => 'Service Laptop Gaming', 'time' => '2 jam lalu', 'unread' => true],
                    ['name' => 'Siti Nurhaliza', 'subject' => 'Upgrade RAM Laptop', 'time' => '5 jam lalu', 'unread' => true],
                    ['name' => 'Budi Prakoso', 'subject' => 'Data Recovery', 'time' => '1 hari lalu', 'unread' => false],
                ];
                ?>

                <?php foreach ($recentMessages as $message): ?>
                    <div class="flex items-start space-x-3 p-3 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                            <?= substr($message['name'], 0, 1) ?>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-900"><?= $message['name'] ?></p>
                                <?php if ($message['unread']): ?>
                                    <span class="ml-2 w-2 h-2 bg-red-500 rounded-full"></span>
                                <?php endif; ?>
                            </div>
                            <p class="text-sm text-gray-600 truncate"><?= $message['subject'] ?></p>
                            <p class="text-xs text-gray-400"><?= $message['time'] ?></p>
                        </div>
                        <button class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- System Status -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">
                <i class="fas fa-server text-green-500 mr-2"></i>
                Status Sistem
            </h3>

            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                        <span class="text-gray-700">Website Status</span>
                    </div>
                    <span class="text-green-600 font-medium">Online</span>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                        <span class="text-gray-700">Database</span>
                    </div>
                    <span class="text-green-600 font-medium">Connected</span>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-yellow-500 rounded-full mr-3"></div>
                        <span class="text-gray-700">Storage Space</span>
                    </div>
                    <span class="text-yellow-600 font-medium">78% Used</span>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                        <span class="text-gray-700">Last Backup</span>
                    </div>
                    <span class="text-green-600 font-medium">2 jam lalu</span>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                        <span class="text-gray-700">PHP Version</span>
                    </div>
                    <span class="text-blue-600 font-medium">8.1.2</span>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">Server uptime: 15 hari</span>
                    <a href="/admin/settings/system" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                        Detail <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Popular Content & SEO Performance -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
    <!-- Popular Content -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">
            <i class="fas fa-fire text-red-500 mr-2"></i>
            Konten Populer
        </h3>

        <div class="space-y-4">
            <?php
            $popularContent = $popularContent ?? [
                ['title' => 'Cara Service Laptop Yang Benar', 'type' => 'blog', 'views' => 1247, 'trend' => 'up'],
                ['title' => 'Service Laptop Gaming Bandung', 'type' => 'service', 'views' => 892, 'trend' => 'up'],
                ['title' => 'Tips Merawat Laptop Harian', 'type' => 'blog', 'views' => 756, 'trend' => 'down'],
                ['title' => 'Instalasi Windows 11', 'type' => 'service', 'views' => 634, 'trend' => 'up'],
                ['title' => 'Cleaning Laptop Profesional', 'type' => 'service', 'views' => 523, 'trend' => 'stable'],
            ];
            ?>

            <?php foreach ($popularContent as $index => $content): ?>
                <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                    <div class="flex items-center">
                    <span class="w-6 h-6 bg-gray-100 rounded-full flex items-center justify-center text-sm font-medium text-gray-600 mr-3">
                        <?= $index + 1 ?>
                    </span>
                        <div>
                            <p class="font-medium text-gray-900"><?= $content['title'] ?></p>
                            <div class="flex items-center text-sm text-gray-500">
                            <span class="px-2 py-1 text-xs rounded-full <?= $content['type'] == 'blog' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' ?>">
                                <?= ucfirst($content['type']) ?>
                            </span>
                                <span class="mx-2">•</span>
                                <i class="fas fa-eye mr-1"></i>
                                <?= number_format($content['views']) ?> views
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <?php if ($content['trend'] == 'up'): ?>
                            <i class="fas fa-arrow-up text-green-500"></i>
                        <?php elseif ($content['trend'] == 'down'): ?>
                            <i class="fas fa-arrow-down text-red-500"></i>
                        <?php else: ?>
                            <i class="fas fa-minus text-gray-500"></i>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- SEO Performance -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">
            <i class="fas fa-search text-blue-500 mr-2"></i>
            Performa SEO
        </h3>

        <!-- SEO Score -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-700">SEO Score Overall</span>
                <span class="text-2xl font-bold text-green-600">87/100</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3">
                <div class="bg-green-500 h-3 rounded-full" style="width: 87%"></div>
            </div>
        </div>

        <!-- SEO Metrics -->
        <div class="space-y-4">
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-search-plus text-blue-500 mr-3"></i>
                    <span class="text-gray-700">Kata Kunci Ranking</span>
                </div>
                <span class="font-semibold text-gray-900">23/30</span>
            </div>

            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-link text-green-500 mr-3"></i>
                    <span class="text-gray-700">Backlinks</span>
                </div>
                <span class="font-semibold text-gray-900">156</span>
            </div>

            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-tachometer-alt text-orange-500 mr-3"></i>
                    <span class="text-gray-700">Page Speed</span>
                </div>
                <span class="font-semibold text-gray-900">92/100</span>
            </div>

            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-mobile-alt text-purple-500 mr-3"></i>
                    <span class="text-gray-700">Mobile Friendly</span>
                </div>
                <span class="font-semibold text-green-600">
                    <i class="fas fa-check-circle mr-1"></i>
                    Passed
                </span>
            </div>
        </div>

        <!-- Top Keywords -->
        <div class="mt-6 pt-6 border-t border-gray-200">
            <h4 class="font-medium text-gray-900 mb-3">Top Keywords</h4>
            <div class="flex flex-wrap gap-2">
                <?php
                $topKeywords = ['service laptop bandung', 'repair laptop', 'laptop gaming service', 'upgrade laptop', 'cleaning laptop'];
                foreach ($topKeywords as $keyword):
                    ?>
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm"><?= $keyword ?></span>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity Timeline -->
<div class="mt-8">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">
            <i class="fas fa-history text-gray-500 mr-2"></i>
            Aktivitas Terbaru
        </h3>

        <div class="flow-root">
            <ul class="-mb-8">
                <?php
                $activities = $activities ?? [
                    ['type' => 'blog', 'action' => 'published', 'title' => 'Tips Merawat Laptop Gaming', 'user' => 'Admin', 'time' => '2 jam lalu'],
                    ['type' => 'contact', 'action' => 'received', 'title' => 'Pesan dari Ahmad Santoso', 'user' => 'System', 'time' => '3 jam lalu'],
                    ['type' => 'service', 'action' => 'updated', 'title' => 'Service Upgrade SSD', 'user' => 'Admin', 'time' => '5 jam lalu'],
                    ['type' => 'user', 'action' => 'login', 'title' => 'Login Admin Panel', 'user' => 'Admin', 'time' => '6 jam lalu'],
                    ['type' => 'backup', 'action' => 'completed', 'title' => 'Database Backup', 'user' => 'System', 'time' => '8 jam lalu'],
                ];
                ?>

                <?php foreach ($activities as $index => $activity): ?>
                    <li>
                        <div class="relative pb-8">
                            <?php if ($index < count($activities) - 1): ?>
                                <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                            <?php endif; ?>
                            <div class="relative flex items-start space-x-3">
                                <div class="relative">
                                    <?php
                                    $iconColors = [
                                        'blog' => 'bg-blue-500',
                                        'contact' => 'bg-green-500',
                                        'service' => 'bg-purple-500',
                                        'user' => 'bg-yellow-500',
                                        'backup' => 'bg-gray-500',
                                    ];
                                    $icons = [
                                        'blog' => 'fas fa-edit',
                                        'contact' => 'fas fa-envelope',
                                        'service' => 'fas fa-tools',
                                        'user' => 'fas fa-user',
                                        'backup' => 'fas fa-database',
                                    ];
                                    ?>
                                    <div class="h-10 w-10 rounded-full <?= $iconColors[$activity['type']] ?> flex items-center justify-center ring-8 ring-white">
                                        <i class="<?= $icons[$activity['type']] ?> text-white text-sm"></i>
                                    </div>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div>
                                        <div class="text-sm">
                                            <span class="font-medium text-gray-900"><?= $activity['title'] ?></span>
                                        </div>
                                        <p class="mt-0.5 text-sm text-gray-500">
                                            <?= ucfirst($activity['action']) ?> oleh <?= $activity['user'] ?>
                                        </p>
                                    </div>
                                    <div class="mt-2 text-sm text-gray-700">
                                        <p><?= $activity['time'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="mt-6 text-center">
            <a href="/admin/activity-log" class="text-blue-600 hover:text-blue-700 font-medium">
                Lihat Semua Aktivitas <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>
</div>

<!-- Welcome Message for New Users -->
<?php if (isset($isFirstLogin) && $isFirstLogin): ?>
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" id="welcome-modal">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-star text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Selamat Datang!</h3>
                <p class="text-gray-600 mb-6">
                    Terima kasih telah menggunakan LaptopService CMS.
                    Mari mulai dengan mengatur website Anda.
                </p>

                <div class="space-y-3 mb-6">
                    <a href="/admin/settings/general" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                        <i class="fas fa-cog mr-2"></i>
                        Pengaturan Website
                    </a>
                    <a href="/admin/blog/posts/create" class="block w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        Buat Artikel Pertama
                    </a>
                </div>

                <button onclick="closeWelcomeModal()" class="text-gray-500 hover:text-gray-700 text-sm">
                    Lewati untuk sekarang
                </button>
            </div>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script>
    // Welcome modal
    function closeWelcomeModal() {
        document.getElementById('welcome-modal').remove();
    }

    // Auto-refresh dashboard data every 5 minutes
    setInterval(function() {
        // Refresh statistics without page reload
        fetch('/admin/dashboard/stats')
            .then(response => response.json())
            .then(data => {
                // Update stats if needed
                console.log('Dashboard stats refreshed');
            })
            .catch(error => console.log('Error refreshing stats:', error));
    }, 300000); // 5 minutes

    // Initialize charts or additional dashboard features
    document.addEventListener('DOMContentLoaded', function() {
        // Add any chart initialization here
        console.log('Dashboard loaded successfully');

        // Auto-hide flash messages
        setTimeout(function() {
            const alerts = document.querySelectorAll('[role="alert"]');
            alerts.forEach(function(alert) {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, 5000);
    });

    // Quick action shortcuts
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey || e.metaKey) {
            switch(e.key) {
                case 'n':
                    e.preventDefault();
                    window.location.href = '/admin/blog/posts/create';
                    break;
                case 'm':
                    e.preventDefault();
                    window.location.href = '/admin/contact';
                    break;
            }
        }
    });

    // Real-time notifications (placeholder for WebSocket implementation)
    function checkNotifications() {
        // This would connect to WebSocket for real-time updates
        console.log('Checking for new notifications...');
    }

    // Check for notifications every minute
    setInterval(checkNotifications, 60000);
</script>
<?= $this->endSection() ?>