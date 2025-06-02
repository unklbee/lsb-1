<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
<?= $seo['title'] ?>
<?= $this->endSection() ?>

<?= $this->section('meta') ?>
    <meta name="description" content="<?= $seo['description'] ?>">
    <meta name="keywords" content="<?= $seo['keywords'] ?>">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= $seo['canonical'] ?>">

    <!-- Open Graph -->
    <meta property="og:title" content="<?= $seo['og_title'] ?>">
    <meta property="og:description" content="<?= $seo['og_description'] ?>">
    <meta property="og:image" content="<?= $seo['og_image'] ?>">
    <meta property="og:url" content="<?= current_url() ?>">

    <!-- RSS Feed -->
    <link rel="alternate" type="application/rss+xml" title="Blog Service Laptop Bandung"
          href="<?= base_url('/blog/rss') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <!-- Breadcrumb -->
    <section class="bg-gray-50 py-6">
        <div class="container mx-auto px-4">
            <nav class="flex items-center space-x-2 text-sm">
                <?php foreach ($breadcrumbs as $index => $breadcrumb): ?>
                    <?php if ($index < count($breadcrumbs) - 1): ?>
                        <a href="<?= $breadcrumb['url'] ?>"
                           class="text-blue-600 hover:text-blue-700"><?= $breadcrumb['name'] ?></a>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5l7 7-7 7"></path>
                        </svg>
                    <?php else: ?>
                        <span class="text-gray-600"><?= $breadcrumb['name'] ?></span>
                    <?php endif; ?>
                <?php endforeach; ?>
            </nav>
        </div>
    </section>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 text-white py-16">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-4xl md:text-5xl font-bold mb-6">
                    Blog <span class="text-yellow-400">Service Laptop Bandung</span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-200 mb-8 leading-relaxed">
                    Tips, tutorial, dan panduan lengkap seputar perawatan laptop dan komputer dari para teknisi
                    berpengalaman di Bandung.
                </p>

                <!-- Search Blog -->
                <div class="max-w-2xl mx-auto">
                    <form action="/blog/search" method="GET" class="relative">
                        <input type="text" name="q" placeholder="Cari artikel..."
                               class="w-full px-6 py-4 pr-12 rounded-lg text-gray-900 text-lg focus:outline-none focus:ring-2 focus:ring-yellow-400"
                               value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>">
                        <button type="submit" class="absolute right-4 top-1/2 transform -translate-y-1/2">
                            <svg class="w-6 h-6 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Navigation -->
    <section class="py-8 bg-white border-b border-gray-200">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap justify-center gap-4">
                <a href="/blog"
                   class="category-link <?= !isset($_GET['category']) ? 'active' : '' ?> px-6 py-3 rounded-lg font-semibold transition-colors duration-300">
                    Semua Artikel
                </a>
                <?php foreach ($categories as $categorySlug => $categoryName): ?>
                    <a href="/blog/category/<?= $categorySlug ?>"
                       class="category-link px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-blue-600 hover:text-white transition-colors duration-300">
                        <?= $categoryName ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Featured Articles -->
<?php
$featuredPosts = array_filter($posts, function ($post) {
    return $post['featured'];
});
?>
<?php if (!empty($featuredPosts)): ?>
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-gray-900 mb-12 text-center">Artikel Pilihan</h2>

            <div class="grid lg:grid-cols-3 gap-8">
                <?php foreach (array_slice($featuredPosts, 0, 3) as $post): ?>
                    <article
                            class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                        <div class="relative">
                            <img src="<?= $post['featured_image'] ?>" alt="<?= $post['title'] ?>"
                                 class="w-full h-48 object-cover" loading="lazy">
                            <div class="absolute top-4 left-4 bg-yellow-400 text-gray-900 px-3 py-1 rounded-full text-sm font-semibold">
                                Featured
                            </div>
                            <div class="absolute top-4 right-4 bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                <?= $categories[$post['category']] ?? $post['category'] ?>
                            </div>
                        </div>

                        <div class="p-8">
                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <?= date('d M Y', strtotime($post['published_date'])) ?>
                                <span class="mx-2">•</span>
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <?= $post['reading_time'] ?>
                            </div>

                            <h3 class="text-xl font-bold text-gray-900 mb-3 leading-tight">
                                <a href="/blog/<?= $post['slug'] ?>"
                                   class="hover:text-blue-600 transition-colors duration-300">
                                    <?= $post['title'] ?>
                                </a>
                            </h3>

                            <p class="text-gray-600 mb-6 leading-relaxed"><?= $post['excerpt'] ?></p>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <?= $post['author'] ?>
                                </div>
                                <a href="/blog/<?= $post['slug'] ?>"
                                   class="text-blue-600 hover:text-blue-700 font-semibold text-sm transition-colors duration-300">
                                    Baca Selengkapnya →
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

    <!-- All Articles -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between mb-12">
                <h2 class="text-3xl font-bold text-gray-900">
                    <?php if (isset($_GET['category'])): ?>
                        Artikel <?= $categories[$_GET['category']] ?? 'Kategori' ?>
                    <?php else: ?>
                        Semua Artikel
                    <?php endif; ?>
                </h2>

                <!-- Sort Options -->
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">Urutkan:</span>
                    <select id="sort-articles"
                            class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="latest">Terbaru</option>
                        <option value="oldest">Terlama</option>
                        <option value="popular">Populer</option>
                    </select>
                </div>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8" id="articles-container">
                <?php foreach ($posts as $post): ?>
                    <article
                            class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 overflow-hidden">
                        <div class="relative">
                            <img src="<?= $post['featured_image'] ?>" alt="<?= $post['title'] ?>"
                                 class="w-full h-48 object-cover" loading="lazy">
                            <div class="absolute top-4 right-4 bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                <?= $categories[$post['category']] ?? $post['category'] ?>
                            </div>
                            <?php if ($post['featured']): ?>
                                <div class="absolute top-4 left-4 bg-yellow-400 text-gray-900 px-3 py-1 rounded-full text-sm font-semibold">
                                    Featured
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="p-6">
                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <?= date('d M Y', strtotime($post['published_date'])) ?>
                                <span class="mx-2">•</span>
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <?= $post['reading_time'] ?>
                            </div>

                            <h3 class="text-xl font-bold text-gray-900 mb-3 leading-tight">
                                <a href="/blog/<?= $post['slug'] ?>"
                                   class="hover:text-blue-600 transition-colors duration-300">
                                    <?= $post['title'] ?>
                                </a>
                            </h3>

                            <p class="text-gray-600 mb-4 leading-relaxed"><?= substr($post['excerpt'], 0, 120) ?>...</p>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <?= $post['author'] ?>
                                </div>
                                <a href="/blog/<?= $post['slug'] ?>"
                                   class="text-blue-600 hover:text-blue-700 font-semibold text-sm transition-colors duration-300">
                                    Baca →
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <!-- Pagination (if implemented) -->
            <?php if (isset($totalPages) && $totalPages > 1): ?>
                <div class="flex justify-center mt-12">
                    <nav class="flex items-center space-x-2">
                        <?php if ($hasPrev): ?>
                            <a href="/blog/page/<?= $prevPage ?>"
                               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-300">
                                ← Sebelumnya
                            </a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <?php if ($i == $currentPage): ?>
                                <span class="px-4 py-2 bg-blue-600 text-white rounded-lg"><?= $i ?></span>
                            <?php else: ?>
                                <a href="/blog/page/<?= $i ?>"
                                   class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-300"><?= $i ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if ($hasNext): ?>
                            <a href="/blog/page/<?= $nextPage ?>"
                               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-300">
                                Selanjutnya →
                            </a>
                        <?php endif; ?>
                    </nav>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-16 bg-blue-600">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-2xl mx-auto text-white">
                <h2 class="text-3xl font-bold mb-4">Dapatkan Tips Laptop Terbaru</h2>
                <p class="text-xl text-blue-100 mb-8">
                    Berlangganan newsletter kami untuk mendapatkan tips, tutorial, dan update terbaru seputar service
                    laptop.
                </p>
                <form class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                    <input type="email" placeholder="Masukkan email Anda"
                           class="flex-1 px-6 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <button type="submit"
                            class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 px-8 py-3 rounded-lg font-semibold transition-colors duration-300">
                        Berlangganan
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-4xl mx-auto">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                    Butuh Bantuan <span class="text-blue-600">Service Laptop?</span>
                </h2>
                <p class="text-xl text-gray-600 mb-8">
                    Setelah membaca artikel-artikel kami, jika Anda masih memerlukan bantuan profesional, tim teknisi
                    kami siap membantu.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="<?= $globalSeo['whatsapp'] ?>?text=Halo, saya butuh bantuan service laptop"
                       class="bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-colors duration-300 flex items-center justify-center">
                        <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488z"/>
                        </svg>
                        Konsultasi Gratis
                    </a>
                    <a href="/layanan"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-colors duration-300 flex items-center justify-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Lihat Layanan
                    </a>
                </div>
            </div>
        </div>
    </section>

    <style>
        .category-link.active {
            background-color: #2563eb;
            color: white;
        }
    </style>

    <script>
        // Sort articles functionality
        document.getElementById('sort-articles').addEventListener('change', function (e) {
            const sortValue = e.target.value;
            const container = document.getElementById('articles-container');
            const articles = Array.from(container.children);

            articles.sort((a, b) => {
                // This is a basic implementation - in a real app, you'd sort based on actual data
                if (sortValue === 'latest') {
                    return 0; // Keep original order (already sorted by latest)
                } else if (sortValue === 'oldest') {
                    return 0; // Reverse order would be implemented here
                } else if (sortValue === 'popular') {
                    return 0; // Sort by view count would be implemented here
                }
            });

            // Re-append sorted articles
            articles.forEach(article => container.appendChild(article));
        });

        // Newsletter subscription
        document.querySelector('form').addEventListener('submit', function (e) {
            e.preventDefault();
            const email = this.querySelector('input[type="email"]').value;
            if (email) {
                alert('Terima kasih! Anda akan segera menerima newsletter kami.');
                this.reset();
            }
        });

        // Lazy loading for images
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src || img.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img[loading="lazy"]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    </script>

<?= $this->endSection() ?>