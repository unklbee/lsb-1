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
    <meta property="og:type" content="website">

    <!-- Reviews Schema -->
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "LocalBusiness",
          "name": "<?= $globalSeo['business_name'] ?>",
          "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "<?= $averageRating ?>",
            "reviewCount": "<?= $totalReviews ?>",
            "bestRating": "5",
            "worstRating": "1"
          },
          "review": [
        <?php foreach ($featuredTestimonials as $index => $testimonial): ?>
    {
      "@type": "Review",
      "author": {
        "@type": "Person",
        "name": "<?= htmlspecialchars($testimonial['name']) ?>"
      },
      "reviewRating": {
        "@type": "Rating",
        "ratingValue": "<?= $testimonial['rating'] ?>",
        "bestRating": "5"
      },
      "reviewBody": "<?= htmlspecialchars($testimonial['comment']) ?>",
      "datePublished": "<?= date('Y-m-d', strtotime($testimonial['created_at'])) ?>"
    }<?= $index < count($featuredTestimonials) - 1 ? ',' : '' ?>
        <?php endforeach; ?>
        ]
      }
    </script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <!-- Breadcrumb -->
    <section class="bg-gray-50 py-6">
        <div class="container mx-auto px-4">
            <nav class="flex items-center space-x-2 text-sm">
                <?php foreach ($breadcrumbs as $index => $breadcrumb): ?>
                    <?php if ($index < count($breadcrumbs) - 1): ?>
                        <a href="<?= $breadcrumb['url'] ?>" class="text-blue-600 hover:text-blue-700"><?= $breadcrumb['name'] ?></a>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
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
                    Testimoni <span class="text-yellow-400">Service Laptop Bandung</span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-200 mb-8 leading-relaxed">
                    Kepercayaan dan kepuasan pelanggan adalah prioritas utama kami. Baca pengalaman nyata dari ribuan pelanggan yang telah merasakan layanan profesional kami.
                </p>

                <!-- Rating Overview -->
                <div class="grid md:grid-cols-3 gap-8 mt-12">
                    <div class="text-center">
                        <div class="text-4xl md:text-5xl font-bold text-yellow-400 mb-2"><?= number_format($averageRating, 1) ?>/5</div>
                        <div class="flex justify-center text-yellow-400 text-2xl mb-2">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <?php if ($i <= $averageRating): ?>
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                <?php else: ?>
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                        <div class="text-lg">Rating Rata-rata</div>
                    </div>

                    <div class="text-center">
                        <div class="text-4xl md:text-5xl font-bold text-yellow-400 mb-2"><?= number_format($totalReviews) ?>+</div>
                        <div class="text-lg">Total Ulasan</div>
                    </div>

                    <div class="text-center">
                        <div class="text-4xl md:text-5xl font-bold text-yellow-400 mb-2">98%</div>
                        <div class="text-lg">Tingkat Kepuasan</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Rating Distribution -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">Distribusi Rating</h2>
                <div class="space-y-4">
                    <?php for ($rating = 5; $rating >= 1; $rating--): ?>
                        <div class="flex items-center">
                            <div class="flex items-center w-20">
                                <span class="text-sm font-medium text-gray-900 mr-2"><?= $rating ?></span>
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 mx-4">
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-yellow-400 h-2 rounded-full" style="width: <?= $ratingDistribution[$rating] ?>%"></div>
                                </div>
                            </div>
                            <span class="text-sm font-medium text-gray-900 w-12"><?= $ratingDistribution[$rating] ?>%</span>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Type Filter -->
    <section class="py-8 bg-gray-50 border-b border-gray-200">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap justify-center gap-4">
                <button onclick="filterTestimonials('all')" class="filter-btn active px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors duration-300">
                    Semua Testimoni
                </button>
                <?php foreach ($serviceTypes as $serviceType): ?>
                    <button onclick="filterTestimonials('<?= url_title(strtolower($serviceType), '-', true) ?>')" class="filter-btn px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-blue-600 hover:text-white transition-colors duration-300">
                        <?= $serviceType ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Featured Testimonials -->
<?php if (!empty($featuredTestimonials)): ?>
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Testimoni Pilihan</h2>
                <p class="text-xl text-gray-600">Pengalaman terbaik dari pelanggan setia kami</p>
            </div>

            <div class="grid lg:grid-cols-3 gap-8 mb-12">
                <?php foreach ($featuredTestimonials as $testimonial): ?>
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-8 shadow-lg border-2 border-blue-200 relative">
                        <div class="absolute -top-4 -left-4 w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>

                        <div class="flex items-center mb-4">
                            <div class="flex text-yellow-400 mr-3">
                                <?php for ($i = 0; $i < $testimonial['rating']; $i++): ?>
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                <?php endfor; ?>
                            </div>
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                            <?= $testimonial['service_type'] ?>
                        </span>
                        </div>

                        <blockquote class="text-gray-700 mb-6 italic leading-relaxed text-lg">
                            "<?= $testimonial['comment'] ?>"
                        </blockquote>

                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                                <?= substr($testimonial['name'], 0, 1) ?>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900"><?= $testimonial['name'] ?></div>
                                <div class="text-sm text-gray-500"><?= $testimonial['location'] ?? 'Bandung' ?></div>
                            </div>
                        </div>

                        <div class="absolute top-6 right-6 text-blue-200 text-6xl font-serif">"</div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

    <!-- All Testimonials -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Semua Testimoni</h2>
                <p class="text-xl text-gray-600">Total <?= number_format($totalTestimonials) ?> ulasan dari pelanggan kami</p>
            </div>

            <!-- Loading Indicator -->
            <div id="loading-indicator" class="hidden text-center py-8">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
                <p class="text-gray-600">Memuat testimoni...</p>
            </div>

            <!-- Testimonials Grid -->
            <div id="testimonials-grid" class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                <?php foreach ($testimonials as $testimonial): ?>
                    <div class="testimonial-item bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 p-6" data-service-type="<?= url_title(strtolower($testimonial['service_type']), '-', true) ?>">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex text-yellow-400">
                                <?php for ($i = 0; $i < $testimonial['rating']; $i++): ?>
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                <?php endfor; ?>
                            </div>
                            <span class="text-sm text-gray-500"><?= date('d M Y', strtotime($testimonial['created_at'])) ?></span>
                        </div>

                        <div class="mb-4">
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                                <?= $testimonial['service_type'] ?>
                            </span>
                        </div>

                        <blockquote class="text-gray-700 mb-6 leading-relaxed">
                            "<?= strlen($testimonial['comment']) > 150 ? substr($testimonial['comment'], 0, 150) . '...' : $testimonial['comment'] ?>"
                            <?php if (strlen($testimonial['comment']) > 150): ?>
                                <button onclick="showFullComment(this)" class="text-blue-600 hover:text-blue-700 font-medium ml-1">
                                    Baca selengkapnya
                                </button>
                                <span class="full-comment hidden"><?= $testimonial['comment'] ?></span>
                            <?php endif; ?>
                        </blockquote>

                        <div class="flex items-center">
                            <?php if ($testimonial['photo']): ?>
                                <img src="<?= $testimonial['photo'] ?>" alt="<?= $testimonial['name'] ?>" class="w-10 h-10 rounded-full mr-3 object-cover">
                            <?php else: ?>
                                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold mr-3">
                                    <?= substr($testimonial['name'], 0, 1) ?>
                                </div>
                            <?php endif; ?>
                            <div>
                                <div class="font-semibold text-gray-900"><?= $testimonial['name'] ?></div>
                                <div class="text-sm text-gray-500"><?= $testimonial['location'] ?? 'Bandung' ?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- No Results -->
            <div id="no-results" class="hidden text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.29-1.009-5.824-2.562M15 9.34c-.817-.243-1.661-.34-2.5-.34a9.98 9.98 0 00-2.5.34m0 0a15.923 15.923 0 014.908 1.934M6.34 15c.817.243 1.661.34 2.5.34a9.98 9.98 0 002.5-.34m-4.908-1.934c-.807-.025-1.566-.087-2.27-.25a15.106 15.106 0 01-2.37-.75l-.31-.17"></path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak ada testimoni ditemukan</h3>
                <p class="text-gray-600">Coba filter kategori lain atau lihat semua testimoni.</p>
            </div>

            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <div class="flex justify-center">
                    <nav class="flex items-center space-x-2">
                        <?php if ($hasPrev): ?>
                            <a href="/testimonial?page=<?= $prevPage ?>" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-300">
                                ← Sebelumnya
                            </a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <?php if ($i == $currentPage): ?>
                                <span class="px-4 py-2 bg-blue-600 text-white rounded-lg"><?= $i ?></span>
                            <?php else: ?>
                                <a href="/testimonial?page=<?= $i ?>" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-300"><?= $i ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if ($hasNext): ?>
                            <a href="/testimonial?page=<?= $nextPage ?>" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-300">
                                Selanjutnya →
                            </a>
                        <?php endif; ?>
                    </nav>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Submit Testimonial Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Bagikan Pengalaman Anda</h2>
                    <p class="text-xl text-gray-600">Sudah merasakan layanan kami? Ceritakan pengalaman Anda untuk membantu calon pelanggan lain.</p>
                </div>

                <div class="bg-gray-50 rounded-2xl p-8">
                    <form id="testimonial-form" class="space-y-6">
                        <?= csrf_field() ?>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-gray-700 font-semibold mb-2">Nama Lengkap *</label>
                                <input type="text" id="name" name="name" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Masukkan nama lengkap">
                            </div>

                            <div>
                                <label for="email" class="block text-gray-700 font-semibold mb-2">Email *</label>
                                <input type="email" id="email" name="email" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="email@example.com">
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="phone" class="block text-gray-700 font-semibold mb-2">Nomor Telepon</label>
                                <input type="tel" id="phone" name="phone"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="08xx-xxxx-xxxx">
                            </div>

                            <div>
                                <label for="location" class="block text-gray-700 font-semibold mb-2">Lokasi</label>
                                <input type="text" id="location" name="location"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Bandung">
                            </div>
                        </div>

                        <div>
                            <label for="service_type" class="block text-gray-700 font-semibold mb-2">Jenis Layanan *</label>
                            <select id="service_type" name="service_type" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Pilih jenis layanan</option>
                                <?php foreach ($serviceTypes as $serviceType): ?>
                                    <option value="<?= $serviceType ?>"><?= $serviceType ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Rating *</label>
                            <div class="flex space-x-2">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <button type="button" onclick="setRating(<?= $i ?>)" class="rating-star text-gray-300 hover:text-yellow-400 transition-colors duration-200">
                                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    </button>
                                <?php endfor; ?>
                            </div>
                            <input type="hidden" id="rating" name="rating" required>
                        </div>

                        <div>
                            <label for="comment" class="block text-gray-700 font-semibold mb-2">Testimoni Anda *</label>
                            <textarea id="comment" name="comment" rows="5" required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                      placeholder="Ceritakan pengalaman Anda menggunakan layanan service laptop kami..."></textarea>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-colors duration-300 flex items-center justify-center mx-auto">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Kirim Testimoni
                            </button>
                        </div>

                        <p class="text-sm text-gray-500 text-center">
                            Testimoni Anda akan ditampilkan setelah diverifikasi oleh admin untuk menjaga kualitas dan keaslian ulasan.
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">
                Siap Merasakan <span class="text-yellow-400">Layanan Terbaik?</span>
            </h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Bergabunglah dengan ribuan pelanggan yang telah merasakan layanan service laptop profesional dan terpercaya di Bandung.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?= $globalSeo['whatsapp'] ?>?text=Halo, saya tertarik dengan layanan service laptop" class="bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-colors duration-300 flex items-center justify-center">
                    <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488z"/>
                    </svg>
                    Konsultasi Gratis
                </a>
                <a href="/layanan" class="bg-transparent border-2 border-white hover:bg-white hover:text-blue-600 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300 flex items-center justify-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Lihat Layanan
                </a>
            </div>
        </div>
    </section>

    <script>
        let selectedRating = 0;

        // Rating functionality
        function setRating(rating) {
            selectedRating = rating;
            document.getElementById('rating').value = rating;

            const stars = document.querySelectorAll('.rating-star');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('text-gray-300');
                    star.classList.add('text-yellow-400');
                } else {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-300');
                }
            });
        }

        // Filter testimonials
        function filterTestimonials(serviceType) {
            const loadingIndicator = document.getElementById('loading-indicator');
            const testimonialsGrid = document.getElementById('testimonials-grid');
            const noResults = document.getElementById('no-results');

            // Show loading
            loadingIndicator.classList.remove('hidden');
            testimonialsGrid.style.opacity = '0.5';

            // Update filter buttons
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active', 'bg-blue-600', 'text-white');
                btn.classList.add('bg-gray-100', 'text-gray-700');
            });
            event.target.classList.add('active', 'bg-blue-600', 'text-white');
            event.target.classList.remove('bg-gray-100', 'text-gray-700');

            // Simulate loading delay
            setTimeout(() => {
                const testimonialItems = document.querySelectorAll('.testimonial-item');
                let visibleCount = 0;

                testimonialItems.forEach(item => {
                    const itemServiceType = item.getAttribute('data-service-type');

                    if (serviceType === 'all' || itemServiceType === serviceType) {
                        item.style.display = 'block';
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });

                // Show/hide no results message
                if (visibleCount === 0) {
                    noResults.classList.remove('hidden');
                } else {
                    noResults.classList.add('hidden');
                }

                // Hide loading
                loadingIndicator.classList.add('hidden');
                testimonialsGrid.style.opacity = '1';
            }, 500);
        }

        // Show full comment
        function showFullComment(button) {
            const fullComment = button.nextElementSibling;
            const parentQuote = button.closest('blockquote');

            parentQuote.innerHTML = '"' + fullComment.textContent + '"';
        }

        // Handle testimonial form submission
        document.getElementById('testimonial-form').addEventListener('submit', function(e) {
            e.preventDefault();

            // Validate rating
            if (selectedRating === 0) {
                alert('Silakan berikan rating untuk testimoni Anda');
                return;
            }

            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;

            // Show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = '<div class="animate-spin rounded-full h-6 w-6 border-b-2 border-white mx-auto"></div>';

            fetch('/testimonial/submit', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                        this.reset();
                        setRating(0); // Reset rating
                    } else {
                        alert(data.message || 'Terjadi kesalahan. Silakan coba lagi.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan. Silakan coba lagi atau hubungi kami via WhatsApp.');
                })
                .finally(() => {
                    // Reset button state
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalText;
                });
        });

        // Lazy loading for images
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.classList.remove('lazy');
                            imageObserver.unobserve(img);
                        }
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }

        // Smooth scroll animation for testimonials
        function animateOnScroll() {
            const elements = document.querySelectorAll('.testimonial-item');
            const windowHeight = window.innerHeight;

            elements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;

                if (elementTop < windowHeight - 100) {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }
            });
        }

        // Initialize animations
        document.addEventListener('DOMContentLoaded', function() {
            // Set initial animation state
            document.querySelectorAll('.testimonial-item').forEach(item => {
                item.style.opacity = '0';
                item.style.transform = 'translateY(30px)';
                item.style.transition = 'all 0.6s ease-out';
            });

            // Run animation
            animateOnScroll();
            window.addEventListener('scroll', animateOnScroll);
        });

        // Share testimonial functionality
        function shareTestimonial(name, comment, rating) {
            if (navigator.share) {
                navigator.share({
                    title: `Testimoni ${name} - Service Laptop Bandung`,
                    text: `"${comment}" - Rating: ${rating}/5 ⭐`,
                    url: window.location.href
                });
            } else {
                // Fallback to copy to clipboard
                const text = `Testimoni dari ${name}:\n"${comment}"\nRating: ${rating}/5 ⭐\n\nLihat testimoni lengkap: ${window.location.href}`;
                navigator.clipboard.writeText(text).then(() => {
                    alert('Testimoni telah disalin ke clipboard!');
                });
            }
        }

        // Auto-hide flash messages
        setTimeout(() => {
            const alerts = document.querySelectorAll('[role="alert"]');
            alerts.forEach(alert => {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);

        // Form validation enhancements
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('testimonial-form');
            const inputs = form.querySelectorAll('input, textarea, select');

            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    validateField(this);
                });

                input.addEventListener('input', function() {
                    clearFieldError(this);
                });
            });
        });

        function validateField(field) {
            const value = field.value.trim();
            const fieldName = field.getAttribute('name');

            // Clear previous errors
            clearFieldError(field);

            // Validate based on field type
            let isValid = true;
            let errorMessage = '';

            if (field.hasAttribute('required') && !value) {
                isValid = false;
                errorMessage = 'Field ini wajib diisi';
            } else if (fieldName === 'email' && value && !isValidEmail(value)) {
                isValid = false;
                errorMessage = 'Format email tidak valid';
            } else if (fieldName === 'phone' && value && value.length < 10) {
                isValid = false;
                errorMessage = 'Nomor telepon minimal 10 digit';
            } else if (fieldName === 'comment' && value && value.length < 10) {
                isValid = false;
                errorMessage = 'Testimoni minimal 10 karakter';
            }

            if (!isValid) {
                showFieldError(field, errorMessage);
            }

            return isValid;
        }

        function showFieldError(field, message) {
            field.classList.add('border-red-500');

            const errorDiv = document.createElement('div');
            errorDiv.className = 'text-red-500 text-sm mt-1 field-error';
            errorDiv.textContent = message;

            field.parentNode.appendChild(errorDiv);
        }

        function clearFieldError(field) {
            field.classList.remove('border-red-500');

            const errorDiv = field.parentNode.querySelector('.field-error');
            if (errorDiv) {
                errorDiv.remove();
            }
        }

        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            // Show all testimonials by default
            filterTestimonials('all');

            // Add smooth scroll behavior
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>

<?= $this->endSection() ?>