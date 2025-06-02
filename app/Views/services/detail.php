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
    <meta property="og:type" content="service">

    <!-- Service Schema -->
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "Service",
          "name": "<?= htmlspecialchars($service['name']) ?>",
  "description": "<?= htmlspecialchars($service['description']) ?>",
  "provider": {
    "@type": "LocalBusiness",
    "name": "<?= $globalSeo['business_name'] ?>",
    "address": {
      "@type": "PostalAddress",
      "addressLocality": "Bandung",
      "addressRegion": "Jawa Barat",
      "addressCountry": "ID"
    },
    "telephone": "<?= $globalSeo['phone'] ?>"
  },
  "areaServed": {
    "@type": "City",
    "name": "Bandung"
  },
  "offers": {
    "@type": "Offer",
    "priceRange": "<?= $service['price_start'] ?>"
  }
}
    </script>

    <!-- FAQ Schema -->
<?php if (!empty($faqs)): ?>
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
<?php endif; ?>
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
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold mb-6">
                        <?= $service['name'] ?> <span class="text-yellow-400">Bandung</span>
                    </h1>
                    <p class="text-xl text-gray-200 mb-8 leading-relaxed">
                        <?= $service['description'] ?>
                    </p>

                    <div class="grid grid-cols-3 gap-4 mb-8">
                        <div class="text-center p-4 bg-white bg-opacity-10 rounded-lg">
                            <div class="text-2xl font-bold text-yellow-400"><?= $service['price_start'] ?></div>
                            <div class="text-sm text-gray-300">Harga Mulai</div>
                        </div>
                        <div class="text-center p-4 bg-white bg-opacity-10 rounded-lg">
                            <div class="text-2xl font-bold text-yellow-400"><?= $service['duration'] ?></div>
                            <div class="text-sm text-gray-300">Pengerjaan</div>
                        </div>
                        <div class="text-center p-4 bg-white bg-opacity-10 rounded-lg">
                            <div class="text-2xl font-bold text-yellow-400"><?= $service['warranty'] ?></div>
                            <div class="text-sm text-gray-300">Garansi</div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="<?= $globalSeo['whatsapp'] ?>?text=Halo, saya tertarik dengan layanan <?= $service['name'] ?>" class="bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-colors duration-300 flex items-center justify-center">
                            <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488z"/>
                            </svg>
                            Konsultasi Gratis
                        </a>
                        <a href="tel:<?= $globalSeo['phone'] ?>" class="bg-transparent border-2 border-white hover:bg-white hover:text-blue-900 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300 flex items-center justify-center">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            Telepon Langsung
                        </a>
                    </div>
                </div>

                <div class="relative">
                    <img src="/assets/images/services/<?= $service['slug'] ?>.jpg" alt="<?= $service['name'] ?> Bandung" class="rounded-2xl shadow-2xl w-full" loading="eager">
                    <div class="absolute -bottom-6 -right-6 bg-yellow-400 text-blue-900 p-6 rounded-xl shadow-xl">
                        <div class="text-xl font-bold">Garansi Resmi</div>
                        <div class="text-sm font-semibold"><?= $service['warranty'] ?></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Features -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-16">
                <!-- Features -->
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-8">Fitur Layanan</h2>
                    <div class="space-y-4">
                        <?php foreach ($service['features'] as $feature): ?>
                            <div class="flex items-start space-x-4">
                                <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <span class="text-gray-700 text-lg"><?= $feature ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Benefits -->
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-8">Keunggulan Kami</h2>
                    <div class="space-y-4">
                        <?php foreach ($service['benefits'] as $benefit): ?>
                            <div class="flex items-start space-x-4">
                                <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <span class="text-gray-700 text-lg"><?= $benefit ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Process -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Proses <span class="text-blue-600"><?= $service['name'] ?></span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Proses yang sistematis dan transparan untuk memastikan kualitas terbaik.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($service['process'] as $index => $step): ?>
                    <div class="relative">
                        <div class="bg-white rounded-xl shadow-lg p-8 text-center h-full">
                            <div class="w-16 h-16 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold">
                                <?= $index + 1 ?>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4"><?= $step ?></h3>
                        </div>

                        <?php if ($index < count($service['process']) - 1): ?>
                            <div class="hidden lg:block absolute top-1/2 -right-4 transform -translate-y-1/2">
                                <svg class="w-8 h-8 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
<?php if (!empty($faqs)): ?>
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    FAQ <span class="text-blue-600"><?= $service['name'] ?></span>
                </h2>
                <p class="text-xl text-gray-600">Pertanyaan yang sering diajukan tentang layanan ini</p>
            </div>

            <div class="max-w-4xl mx-auto space-y-6">
                <?php foreach ($faqs as $index => $faq): ?>
                    <div class="bg-gray-50 rounded-xl border border-gray-200">
                        <button class="w-full px-8 py-6 text-left flex justify-between items-center hover:bg-gray-100 transition-colors duration-300 rounded-xl" onclick="toggleServiceFAQ(<?= $index ?>)">
                            <h3 class="text-lg font-semibold text-gray-900 pr-4"><?= $faq['question'] ?></h3>
                            <svg id="service-faq-icon-<?= $index ?>" class="w-6 h-6 text-gray-500 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="service-faq-answer-<?= $index ?>" class="hidden px-8 pb-6">
                            <p class="text-gray-600 leading-relaxed"><?= $faq['answer'] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

    <!-- Related Services -->
<?php if (!empty($relatedServices)): ?>
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Layanan <span class="text-blue-600">Lainnya</span>
                </h2>
                <p class="text-xl text-gray-600">Layanan service laptop dan komputer lainnya yang tersedia</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($relatedServices as $related): ?>
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 p-8 text-center">
                        <h3 class="text-xl font-bold text-gray-900 mb-4"><?= $related['name'] ?></h3>
                        <a href="/layanan/<?= $related['slug'] ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors duration-300 inline-block">
                            Lihat Detail
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">
                Siap untuk <span class="text-yellow-400"><?= $service['name'] ?>?</span>
            </h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Dapatkan konsultasi gratis dan estimasi biaya sekarang. Tim teknisi kami siap membantu Anda.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?= $globalSeo['whatsapp'] ?>?text=Halo, saya butuh <?= $service['name'] ?>" class="bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-colors duration-300 flex items-center justify-center">
                    <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488z"/>
                    </svg>
                    Pesan Sekarang
                </a>
                <a href="/kontak" class="bg-transparent border-2 border-white hover:bg-white hover:text-blue-600 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300 flex items-center justify-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Kontak Kami
                </a>
            </div>
        </div>
    </section>

    <script>
        function toggleServiceFAQ(index) {
            const answer = document.getElementById(`service-faq-answer-${index}`);
            const icon = document.getElementById(`service-faq-icon-${index}`);

            if (answer.classList.contains('hidden')) {
                answer.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                answer.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }
    </script>

<?= $this->endSection() ?>