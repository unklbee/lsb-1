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
    <meta property="og:locale" content="id_ID">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $seo['og_title'] ?>">
    <meta name="twitter:description" content="<?= $seo['og_description'] ?>">
    <meta name="twitter:image" content="<?= $seo['og_image'] ?>">

    <!-- Structured Data -->
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "LocalBusiness",
          "name": "<?= $globalSeo['business_name'] ?>",
          "description": "Service laptop Bandung terpercaya dengan teknisi berpengalaman. Melayani perbaikan laptop, komputer, upgrade hardware dengan garansi resmi.",
          "url": "<?= base_url() ?>",
          "telephone": "<?= $globalSeo['phone'] ?>",
          "email": "<?= $globalSeo['email'] ?>",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "<?= $globalSeo['address'] ?>",
            "addressLocality": "Bandung",
            "addressRegion": "Jawa Barat",
            "postalCode": "40132",
            "addressCountry": "ID"
          },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": -6.9175,
    "longitude": 107.6191
  },
  "openingHoursSpecification": [
    {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
      "opens": "08:00",
      "closes": "20:00"
    },
    {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": "Saturday",
      "opens": "08:00",
      "closes": "18:00"
    },
    {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": "Sunday",
      "opens": "09:00",
      "closes": "17:00"
    }
  ],
  "priceRange": "$$",
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.8",
    "reviewCount": "350",
    "bestRating": "5"
  },
  "sameAs": [
    "<?= $globalSeo['social_media']['facebook'] ?>",
    "<?= $globalSeo['social_media']['instagram'] ?>",
    "<?= $globalSeo['social_media']['youtube'] ?>"
  ]
}
    </script>

    <!-- FAQ Schema -->
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "FAQPage",
          "mainEntity": [
        <?php foreach ($faqs as $index => $faq): ?>
    {
      "@type": "Question",
      "name": "<?= htmlspecialchars($faq['question']) ?>",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<?= htmlspecialchars($faq['answer']) ?>"
      }
    }<?= $index < count($faqs) - 1 ? ',' : '' ?>
        <?php endforeach; ?>
        ]
      }
    </script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <!-- Hero Section -->
    <section
            class="hero-section bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                        <span class="text-yellow-400">Service Laptop Bandung</span><br>
                        Terpercaya & Profesional
                    </h1>
                    <p class="text-xl md:text-2xl text-gray-200 leading-relaxed">
                        Teknisi berpengalaman 8+ tahun melayani perbaikan laptop, komputer, dan upgrade hardware dengan
                        garansi resmi di Bandung.
                    </p>
                    <div class="flex flex-wrap gap-4 pt-4">
                        <a href="<?= $globalSeo['whatsapp'] ?>"
                           class="bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                            📱 WhatsApp Sekarang
                        </a>
                        <a href="/layanan"
                           class="bg-transparent border-2 border-white hover:bg-white hover:text-blue-900 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300">
                            Lihat Layanan
                        </a>
                    </div>

                    <!-- Quick Stats -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-8">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-yellow-400"><?= $stats['experience'] ?></div>
                            <div class="text-sm text-gray-300">Pengalaman</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-yellow-400"><?= $stats['customers'] ?></div>
                            <div class="text-sm text-gray-300">Pelanggan</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-yellow-400"><?= $stats['satisfaction'] ?></div>
                            <div class="text-sm text-gray-300">Kepuasan</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-yellow-400"><?= $stats['warranty'] ?></div>
                            <div class="text-sm text-gray-300">Garansi</div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <img src="/assets/images/hero-laptop-repair.jpg" alt="Service Laptop Bandung Profesional"
                         class="rounded-2xl shadow-2xl w-full" loading="eager">
                    <div class="absolute -bottom-6 -right-6 bg-yellow-400 text-blue-900 p-6 rounded-xl shadow-xl">
                        <div class="text-2xl font-bold">⭐ 4.8/5</div>
                        <div class="text-sm font-semibold">Rating Google</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Floating elements -->
        <div class="absolute top-20 left-10 w-20 h-20 bg-yellow-400 rounded-full opacity-20 animate-bounce"></div>
        <div class="absolute bottom-20 right-20 w-16 h-16 bg-blue-400 rounded-full opacity-20 animate-pulse"></div>
    </section>

    <!-- Services Section -->
    <section class="py-20 bg-gray-50" id="layanan">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Layanan <span class="text-blue-600">Service Laptop Bandung</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Kami menyediakan berbagai layanan perbaikan dan upgrade untuk laptop dan komputer Anda dengan
                    standar kualitas terbaik.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php foreach ($services as $service): ?>
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 p-8 text-center">
                        <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <!-- Dynamic icon based on service type -->
                                <?php if ($service['icon'] == 'laptop'): ?>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                <?php elseif ($service['icon'] == 'desktop'): ?>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 17v-2m3 2v-4m3 4v-6m2 10H4a2 2 0 01-2-2V5a2 2 0 012-2h16a2 2 0 012 2v12a2 2 0 01-2 2z"></path>
                                <?php elseif ($service['icon'] == 'memory'): ?>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                <?php else: ?>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2"></path>
                                <?php endif; ?>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3"><?= $service['name'] ?></h3>
                        <p class="text-gray-600 mb-4 leading-relaxed"><?= $service['description'] ?></p>
                        <div class="text-blue-600 font-semibold text-lg mb-4"><?= $service['price_start'] ?></div>
                        <a href="/layanan/<?= url_title(strtolower($service['name']), '-', true) ?>"
                           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors duration-300 inline-block">
                            Detail Layanan
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="text-center mt-12">
                <a href="/layanan"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-colors duration-300 inline-block">
                    Lihat Semua Layanan Service Laptop Bandung
                </a>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Mengapa Pilih <span class="text-blue-600">Service Laptop Bandung</span> Kami?
                </h2>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="text-center p-8">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Teknisi Berpengalaman</h3>
                    <p class="text-gray-600">Teknisi bersertifikat dengan pengalaman 8+ tahun menangani berbagai merk
                        laptop dan komputer.</p>
                </div>

                <div class="text-center p-8">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Proses Cepat</h3>
                    <p class="text-gray-600">Service laptop Bandung dengan waktu pengerjaan cepat, diagnosis gratis, dan
                        estimasi biaya transparan.</p>
                </div>

                <div class="text-center p-8">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Garansi Resmi</h3>
                    <p class="text-gray-600">Semua perbaikan dilengkapi garansi 1-3 bulan untuk memberikan ketenangan
                        pikiran Anda.</p>
                </div>

                <div class="text-center p-8">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Layanan Antar Jemput</h3>
                    <p class="text-gray-600">Melayani panggilan ke rumah dan kantor di seluruh area Bandung dengan biaya
                        transportasi minimal.</p>
                </div>

                <div class="text-center p-8">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Harga Kompetitif</h3>
                    <p class="text-gray-600">Service laptop Bandung dengan harga terjangkau, spare part original, dan
                        tanpa biaya tersembunyi.</p>
                </div>

                <div class="text-center p-8">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM12 18a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V18.75A.75.75 0 0112 18z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Support 24/7</h3>
                    <p class="text-gray-600">Tim customer service siap membantu Anda kapan saja melalui WhatsApp dan
                        telepon.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-gray-50" id="testimonial">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Testimoni <span class="text-blue-600">Service Laptop Bandung</span>
                </h2>
                <p class="text-xl text-gray-600">Kepuasan pelanggan adalah prioritas utama kami</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($testimonials as $testimonial): ?>
                    <div class="bg-white rounded-xl shadow-lg p-8 relative">
                        <div class="flex items-center mb-4">
                            <div class="flex text-yellow-400 mr-3">
                                <?php for ($i = 0; $i < $testimonial['rating']; $i++): ?>
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                <?php endfor; ?>
                            </div>
                            <span class="text-sm text-gray-500"><?= $testimonial['service_type'] ?></span>
                        </div>

                        <blockquote class="text-gray-700 mb-6 italic leading-relaxed">
                            "<?= $testimonial['comment'] ?>"
                        </blockquote>

                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                                <?= substr($testimonial['name'], 0, 1) ?>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900"><?= $testimonial['name'] ?></div>
                                <div class="text-sm text-gray-500"><?= $testimonial['location'] ?></div>
                            </div>
                        </div>

                        <div class="absolute top-6 right-6 text-blue-200 text-6xl font-serif">"</div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="text-center mt-12">
                <a href="/testimonial"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-colors duration-300 inline-block">
                    Lihat Semua Testimoni
                </a>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-white" id="faq">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    FAQ <span class="text-blue-600">Service Laptop Bandung</span>
                </h2>
                <p class="text-xl text-gray-600">Pertanyaan yang sering diajukan tentang layanan kami</p>
            </div>

            <div class="max-w-4xl mx-auto space-y-6">
                <?php foreach ($faqs as $index => $faq): ?>
                    <div class="bg-gray-50 rounded-xl border border-gray-200">
                        <button class="w-full px-8 py-6 text-left flex justify-between items-center hover:bg-gray-100 transition-colors duration-300 rounded-xl"
                                onclick="toggleFAQ(<?= $index ?>)">
                            <h3 class="text-lg font-semibold text-gray-900 pr-4"><?= $faq['question'] ?></h3>
                            <svg id="faq-icon-<?= $index ?>"
                                 class="w-6 h-6 text-gray-500 transform transition-transform duration-300" fill="none"
                                 stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="faq-answer-<?= $index ?>" class="hidden px-8 pb-6">
                            <p class="text-gray-600 leading-relaxed"><?= $faq['answer'] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="text-center mt-12">
                <p class="text-gray-600 mb-6">Masih ada pertanyaan lain?</p>
                <a href="/faq"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-colors duration-300 inline-block mr-4">
                    Lihat FAQ Lengkap
                </a>
                <a href="/kontak"
                   class="bg-transparent border-2 border-blue-600 hover:bg-blue-600 hover:text-white text-blue-600 px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300 inline-block">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-blue-600 to-indigo-700 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-6">
                    Laptop Bermasalah? <br>
                    <span class="text-yellow-400">Hubungi Service Laptop Bandung Sekarang!</span>
                </h2>
                <p class="text-xl md:text-2xl text-gray-200 mb-8 leading-relaxed">
                    Dapatkan diagnosis gratis dan estimasi biaya transparan. Teknisi profesional siap membantu Anda
                    24/7.
                </p>

                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center mb-12">
                    <a href="tel:<?= $globalSeo['phone'] ?>"
                       class="bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        Telepon Sekarang
                    </a>
                    <a href="<?= $globalSeo['whatsapp'] ?>"
                       class="bg-transparent border-2 border-white hover:bg-white hover:text-blue-600 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300 flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488z"></path>
                        </svg>
                        WhatsApp
                    </a>
                </div>

                <div class="grid md:grid-cols-3 gap-8 text-center">
                    <div>
                        <div class="text-3xl font-bold text-yellow-400 mb-2">24/7</div>
                        <div class="text-lg">Customer Support</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-yellow-400 mb-2">1-7 Hari</div>
                        <div class="text-lg">Waktu Pengerjaan</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-yellow-400 mb-2">3 Bulan</div>
                        <div class="text-lg">Garansi Service</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Background elements -->
        <div class="absolute top-10 left-10 w-32 h-32 bg-white opacity-5 rounded-full"></div>
        <div class="absolute bottom-10 right-10 w-24 h-24 bg-yellow-400 opacity-10 rounded-full"></div>
    </section>

    <script>
        function toggleFAQ(index) {
            const answer = document.getElementById(`faq-answer-${index}`);
            const icon = document.getElementById(`faq-icon-${index}`);

            if (answer.classList.contains('hidden')) {
                answer.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                answer.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }

        // Schema markup for reviews
        const reviewSchema = {
            "@context": "https://schema.org",
            "@type": "ItemList",
            "itemListElement": [
                <?php foreach ($testimonials as $index => $testimonial): ?>
                {
                    "@type": "Review",
                    "position": <?= $index + 1 ?>,
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
                    "itemReviewed": {
                        "@type": "LocalBusiness",
                        "name": "<?= $globalSeo['business_name'] ?>"
                    }
                }<?= $index < count($testimonials) - 1 ? ',' : '' ?>
                <?php endforeach; ?>
            ]
        };

        // Add review schema to head
        const script = document.createElement('script');
        script.type = 'application/ld+json';
        script.textContent = JSON.stringify(reviewSchema);
        document.head.appendChild(script);
    </script>

<?= $this->endSection() ?>