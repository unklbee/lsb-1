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

    <!-- Local Business Schema -->
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "LocalBusiness",
          "name": "<?= $globalSeo['business_name'] ?>",
  "description": "Service laptop dan komputer terpercaya di Bandung",
  "url": "<?= base_url() ?>",
  "telephone": "<?= $contactInfo['phone']['primary'] ?>",
  "email": "<?= $contactInfo['email']['info'] ?>",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "<?= $contactInfo['address']['street'] ?>",
    "addressLocality": "<?= $contactInfo['address']['city'] ?>",
    "addressRegion": "<?= $contactInfo['address']['province'] ?>",
    "postalCode": "<?= $contactInfo['address']['postal_code'] ?>",
    "addressCountry": "ID"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": <?= $contactInfo['coordinates']['lat'] ?>,
    "longitude": <?= $contactInfo['coordinates']['lng'] ?>
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
        "sameAs": [
          "<?= $contactInfo['social_media']['facebook'] ?>",
    "<?= $contactInfo['social_media']['instagram'] ?>",
    "<?= $contactInfo['social_media']['youtube'] ?>"
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
                    Hubungi <span class="text-yellow-400">Service Laptop Bandung</span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-200 mb-8 leading-relaxed">
                    Tim teknisi profesional kami siap membantu Anda 24/7. Konsultasi gratis, diagnosa cepat, dan solusi terbaik untuk laptop dan komputer Anda.
                </p>

                <!-- Quick Contact -->
                <div class="grid md:grid-cols-3 gap-6 mt-12">
                    <a href="tel:<?= $contactInfo['phone']['primary'] ?>" class="bg-blue-600 hover:bg-blue-700 rounded-xl p-6 transition-colors duration-300 transform hover:scale-105">
                        <svg class="w-8 h-8 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <h3 class="font-bold text-lg mb-2">Telepon</h3>
                        <p class="text-blue-100"><?= $contactInfo['phone']['primary'] ?></p>
                    </a>

                    <a href="<?= $contactInfo['whatsapp'] ?>" class="bg-green-600 hover:bg-green-700 rounded-xl p-6 transition-colors duration-300 transform hover:scale-105">
                        <svg class="w-8 h-8 mx-auto mb-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488z"/>
                        </svg>
                        <h3 class="font-bold text-lg mb-2">WhatsApp</h3>
                        <p class="text-green-100">Chat Langsung</p>
                    </a>

                    <a href="mailto:<?= $contactInfo['email']['info'] ?>" class="bg-purple-600 hover:bg-purple-700 rounded-xl p-6 transition-colors duration-300 transform hover:scale-105">
                        <svg class="w-8 h-8 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="font-bold text-lg mb-2">Email</h3>
                        <p class="text-purple-100"><?= $contactInfo['email']['info'] ?></p>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form & Info -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-16">
                <!-- Contact Form -->
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-8">Kirim Pesan</h2>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <form action="/kontak/send" method="POST" class="space-y-6">
                        <?= csrf_field() ?>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-gray-700 font-semibold mb-2">Nama Lengkap *</label>
                                <input type="text" id="name" name="name" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Masukkan nama lengkap"
                                       value="<?= old('name') ?>">
                                <?php if (isset($errors['name'])): ?>
                                    <p class="text-red-600 text-sm mt-1"><?= $errors['name'] ?></p>
                                <?php endif; ?>
                            </div>

                            <div>
                                <label for="phone" class="block text-gray-700 font-semibold mb-2">Nomor Telepon *</label>
                                <input type="tel" id="phone" name="phone" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="08xx-xxxx-xxxx"
                                       value="<?= old('phone') ?>">
                                <?php if (isset($errors['phone'])): ?>
                                    <p class="text-red-600 text-sm mt-1"><?= $errors['phone'] ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-gray-700 font-semibold mb-2">Email *</label>
                            <input type="email" id="email" name="email" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="email@example.com"
                                   value="<?= old('email') ?>">
                            <?php if (isset($errors['email'])): ?>
                                <p class="text-red-600 text-sm mt-1"><?= $errors['email'] ?></p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label for="service_type" class="block text-gray-700 font-semibold mb-2">Jenis Layanan *</label>
                            <select id="service_type" name="service_type" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Pilih jenis layanan</option>
                                <option value="Service Laptop" <?= old('service_type') == 'Service Laptop' ? 'selected' : '' ?>>Service Laptop</option>
                                <option value="Service Komputer" <?= old('service_type') == 'Service Komputer' ? 'selected' : '' ?>>Service Komputer</option>
                                <option value="Upgrade Hardware" <?= old('service_type') == 'Upgrade Hardware' ? 'selected' : '' ?>>Upgrade Hardware</option>
                                <option value="Data Recovery" <?= old('service_type') == 'Data Recovery' ? 'selected' : '' ?>>Data Recovery</option>
                                <option value="Konsultasi" <?= old('service_type') == 'Konsultasi' ? 'selected' : '' ?>>Konsultasi</option>
                                <option value="Lainnya" <?= old('service_type') == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                            </select>
                            <?php if (isset($errors['service_type'])): ?>
                                <p class="text-red-600 text-sm mt-1"><?= $errors['service_type'] ?></p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label for="message" class="block text-gray-700 font-semibold mb-2">Pesan *</label>
                            <textarea id="message" name="message" rows="5" required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                      placeholder="Jelaskan masalah laptop/komputer Anda atau layanan yang dibutuhkan..."><?= old('message') ?></textarea>
                            <?php if (isset($errors['message'])): ?>
                                <p class="text-red-600 text-sm mt-1"><?= $errors['message'] ?></p>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 px-8 rounded-lg font-semibold text-lg transition-colors duration-300 flex items-center justify-center">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Kirim Pesan
                        </button>
                    </form>
                </div>

                <!-- Contact Information -->
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-8">Informasi Kontak</h2>

                    <div class="space-y-8">
                        <!-- Address -->
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Alamat Workshop</h3>
                                <p class="text-gray-600 leading-relaxed"><?= $contactInfo['address']['full'] ?></p>
                                <a href="https://maps.google.com/?q=<?= urlencode($contactInfo['address']['full']) ?>" target="_blank" class="text-blue-600 hover:text-blue-700 font-semibold mt-2 inline-block">
                                    Lihat di Google Maps →
                                </a>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Telepon</h3>
                                <p class="text-gray-600 mb-1">
                                    <a href="tel:<?= $contactInfo['phone']['primary'] ?>" class="hover:text-blue-600">
                                        <?= $contactInfo['phone']['primary'] ?>
                                    </a>
                                </p>
                                <p class="text-gray-600">
                                    <a href="tel:<?= $contactInfo['phone']['secondary'] ?>" class="hover:text-blue-600">
                                        <?= $contactInfo['phone']['secondary'] ?>
                                    </a>
                                </p>
                                <p class="text-sm text-gray-500 mt-1">Tersedia 24/7 untuk emergency</p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Email</h3>
                                <p class="text-gray-600 mb-1">
                                    <a href="mailto:<?= $contactInfo['email']['info'] ?>" class="hover:text-blue-600">
                                        <?= $contactInfo['email']['info'] ?>
                                    </a>
                                </p>
                                <p class="text-gray-600">
                                    <a href="mailto:<?= $contactInfo['email']['support'] ?>" class="hover:text-blue-600">
                                        <?= $contactInfo['email']['support'] ?>
                                    </a>
                                </p>
                                <p class="text-sm text-gray-500 mt-1">Respon dalam 2 jam</p>
                            </div>
                        </div>

                        <!-- Business Hours -->
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Jam Operasional</h3>
                                <div class="space-y-1 text-gray-600">
                                    <p><span class="font-semibold"><?= $businessHours['weekdays']['days'] ?>:</span> <?= $businessHours['weekdays']['hours'] ?></p>
                                    <p><span class="font-semibold"><?= $businessHours['saturday']['days'] ?>:</span> <?= $businessHours['saturday']['hours'] ?></p>
                                    <p><span class="font-semibold"><?= $businessHours['sunday']['days'] ?>:</span> <?= $businessHours['sunday']['hours'] ?></p>
                                    <p class="text-sm text-green-600 font-semibold mt-2"><?= $businessHours['emergency'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Ikuti Kami</h3>
                        <div class="flex space-x-4">
                            <a href="<?= $contactInfo['social_media']['facebook'] ?>" target="_blank" class="w-12 h-12 bg-blue-600 text-white rounded-lg flex items-center justify-center hover:bg-blue-700 transition-colors duration-300">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a href="<?= $contactInfo['social_media']['instagram'] ?>" target="_blank" class="w-12 h-12 bg-pink-600 text-white rounded-lg flex items-center justify-center hover:bg-pink-700 transition-colors duration-300">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                            <a href="<?= $contactInfo['social_media']['youtube'] ?>" target="_blank" class="w-12 h-12 bg-red-600 text-white rounded-lg flex items-center justify-center hover:bg-red-700 transition-colors duration-300">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            </a>
                            <a href="<?= $contactInfo['social_media']['tiktok'] ?>" target="_blank" class="w-12 h-12 bg-gray-900 text-white rounded-lg flex items-center justify-center hover:bg-gray-800 transition-colors duration-300">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-.88-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Lokasi Workshop</h2>
                <p class="text-xl text-gray-600">Kunjungi workshop kami untuk konsultasi langsung dengan teknisi</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="h-96 bg-gray-200 flex items-center justify-center">
                    <!-- Replace with actual Google Maps embed -->
                    <div class="text-center">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <p class="text-gray-600 mb-4">Google Maps akan ditampilkan di sini</p>
                        <a href="https://maps.google.com/?q=<?= urlencode($contactInfo['address']['full']) ?>" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors duration-300 inline-block">
                            Buka di Google Maps
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Areas -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Area Layanan</h2>
                <p class="text-xl text-gray-600"><?= $serviceAreas['coverage'] ?></p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Area Utama</h3>
                    <div class="grid grid-cols-2 gap-2">
                        <?php foreach ($serviceAreas['primary'] as $area): ?>
                            <div class="bg-blue-50 text-blue-800 px-4 py-2 rounded-lg text-center font-semibold">
                                <?= $area ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Area Sekunder</h3>
                    <div class="grid grid-cols-2 gap-2">
                        <?php foreach ($serviceAreas['secondary'] as $area): ?>
                            <div class="bg-gray-50 text-gray-700 px-4 py-2 rounded-lg text-center font-semibold">
                                <?= $area ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="text-center mt-8">
                <p class="text-gray-600 mb-4">Area Anda tidak termasuk dalam daftar?</p>
                <a href="<?= $contactInfo['whatsapp'] ?>?text=Halo, apakah bisa service ke area saya?" class="bg-green-500 hover:bg-green-600 text-white px-8 py-3 rounded-lg font-semibold transition-colors duration-300 inline-block">
                    Tanyakan Sekarang
                </a>
            </div>
        </div>
    </section>

    <!-- FAQ Contact -->
<?php if (!empty($contactFAQ)): ?>
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">FAQ Kontak</h2>
                <p class="text-xl text-gray-600">Pertanyaan yang sering diajukan seputar kontak dan layanan kami</p>
            </div>

            <div class="max-w-3xl mx-auto space-y-6">
                <?php foreach ($contactFAQ as $index => $faq): ?>
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100">
                        <button class="w-full px-8 py-6 text-left flex justify-between items-center hover:bg-gray-50 transition-colors duration-300 rounded-xl" onclick="toggleContactFAQ(<?= $index ?>)">
                            <h3 class="text-lg font-semibold text-gray-900 pr-4"><?= $faq['question'] ?></h3>
                            <svg id="contact-faq-icon-<?= $index ?>" class="w-6 h-6 text-gray-500 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="contact-faq-answer-<?= $index ?>" class="hidden px-8 pb-6">
                            <p class="text-gray-600 leading-relaxed"><?= $faq['answer'] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">
                Siap untuk <span class="text-yellow-400">Memulai?</span>
            </h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Jangan biarkan laptop rusak mengganggu aktivitas Anda. Hubungi kami sekarang untuk solusi cepat dan profesional.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?= $contactInfo['whatsapp'] ?>?text=Halo, saya butuh bantuan service laptop" class="bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-colors duration-300 flex items-center justify-center">
                    <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488z"/>
                    </svg>
                    WhatsApp Sekarang
                </a>
                <a href="tel:<?= $contactInfo['phone']['primary'] ?>" class="bg-transparent border-2 border-white hover:bg-white hover:text-blue-600 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300 flex items-center justify-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    Telepon Langsung
                </a>
            </div>
        </div>
    </section>

    <script>
        // Contact FAQ functionality
        function toggleContactFAQ(index) {
            const answer = document.getElementById(`contact-faq-answer-${index}`);
            const icon = document.getElementById(`contact-faq-icon-${index}`);

            if (answer.classList.contains('hidden')) {
                answer.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                answer.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }

        // Form validation and enhancement
        document.querySelector('form').addEventListener('submit', function(e) {
            const phone = document.getElementById('phone').value;
            const phonePattern = /^[0-9+\-\s()]+$/;

            if (!phonePattern.test(phone)) {
                e.preventDefault();
                alert('Masukkan nomor telepon yang valid');
                return false;
            }

            // Show loading state
            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.innerHTML = '<svg class="animate-spin w-6 h-6 mr-3" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"></circle><path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" class="opacity-75"></path></svg>Mengirim...';
        });

        // Phone number formatting
        document.getElementById('phone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.startsWith('0')) {
                value = value.substring(1);
            }
            if (value.length > 0) {
                value = '0' + value;
            }
            e.target.value = value;
        });

        // Auto-resize textarea
        document.getElementById('message').addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });

        // Smooth scroll to form if there are errors
        <?php if (session()->getFlashdata('errors')): ?>
        document.querySelector('form').scrollIntoView({ behavior: 'smooth', block: 'center' });
        <?php endif; ?>

        // Copy contact info to clipboard
        function copyToClipboard(text, element) {
            navigator.clipboard.writeText(text).then(function() {
                const originalText = element.textContent;
                element.textContent = 'Tersalin!';
                element.classList.add('text-green-600');

                setTimeout(() => {
                    element.textContent = originalText;
                    element.classList.remove('text-green-600');
                }, 2000);
            });
        }

        // Add click-to-copy functionality
        document.querySelectorAll('a[href^="tel:"], a[href^="mailto:"]').forEach(link => {
            link.addEventListener('click', function(e) {
                if (e.shiftKey) {
                    e.preventDefault();
                    const text = this.textContent.trim();
                    copyToClipboard(text, this);
                }
            });
        });
    </script>

<?= $this->endSection() ?>