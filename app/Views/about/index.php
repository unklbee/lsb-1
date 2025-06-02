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

<!-- Organization Schema -->
<script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "<?= $companyInfo['name'] ?>",
          "description": "<?= htmlspecialchars($companyInfo['description']) ?>",
          "foundingDate": "<?= $companyInfo['founded_year'] ?>",
          "url": "<?= base_url() ?>",
          "logo": "<?= base_url('assets/images/logo.png') ?>",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "<?= $globalSeo['address'] ?>",
            "addressLocality": "Bandung",
            "addressRegion": "Jawa Barat",
            "addressCountry": "ID"
          },
          "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "<?= $globalSeo['phone'] ?>",
            "contactType": "customer service",
            "availableLanguage": ["Indonesian"]
          },
          "sameAs": [
            "<?= $globalSeo['social_media']['facebook'] ?>",
            "<?= $globalSeo['social_media']['instagram'] ?>",
            "<?= $globalSeo['social_media']['youtube'] ?>"
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
<section class="bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 text-white py-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-black opacity-10"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">
                    Tentang <span class="text-yellow-400"><?= $companyInfo['name'] ?></span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-200 mb-8 leading-relaxed">
                    <?= $companyInfo['tagline'] ?>
                </p>
                <p class="text-lg text-gray-300 mb-8 leading-relaxed">
                    <?= $companyInfo['description'] ?>
                </p>

                <!-- Key Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <?php foreach ($achievements as $achievement): ?>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-yellow-400 mb-2"><?= $achievement['number'] ?><?= $achievement['suffix'] ?></div>
                            <div class="text-sm text-gray-300"><?= explode(' ', $achievement['title'])[0] ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="relative">
                <img src="/assets/images/about-workshop.jpg" alt="Workshop Service Laptop Bandung" class="rounded-2xl shadow-2xl w-full" loading="eager">
                <div class="absolute -bottom-6 -right-6 bg-yellow-400 text-blue-900 p-6 rounded-xl shadow-xl">
                    <div class="text-xl font-bold">Sejak <?= $companyInfo['founded_year'] ?></div>
                    <div class="text-sm font-semibold">Melayani Bandung</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating elements -->
    <div class="absolute top-20 left-10 w-20 h-20 bg-yellow-400 rounded-full opacity-20 animate-bounce"></div>
    <div class="absolute bottom-20 right-20 w-16 h-16 bg-blue-400 rounded-full opacity-20 animate-pulse"></div>
</section>

<!-- Company Achievements -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Pencapaian <span class="text-blue-600">Kami</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Lebih dari <?= intval($companyStats['experience']) ?> tahun pengalaman melayani masyarakat Bandung dengan dedikasi dan profesionalisme tinggi.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php foreach ($achievements as $achievement): ?>
                <div class="text-center p-8 bg-gray-50 rounded-xl hover:bg-blue-50 transition-colors duration-300 transform hover:-translate-y-2 hover:shadow-lg">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <?php
                        $iconClasses = [
                            'users' => 'fas fa-users',
                            'calendar' => 'fas fa-calendar-alt',
                            'star' => 'fas fa-star',
                            'clock' => 'fas fa-clock'
                        ];
                        ?>
                        <i class="<?= $iconClasses[$achievement['icon']] ?? 'fas fa-chart-line' ?> text-2xl text-blue-600"></i>
                    </div>
                    <div class="text-4xl font-bold text-blue-600 mb-3"><?= $achievement['number'] ?><?= $achievement['suffix'] ?></div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3"><?= $achievement['title'] ?></h3>
                    <p class="text-gray-600"><?= $achievement['description'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Vision & Mission -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-2 gap-16">
            <!-- Vision -->
            <div class="bg-white rounded-2xl p-8 shadow-lg">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-eye text-blue-600 text-xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Visi Kami</h2>
                </div>
                <p class="text-gray-700 text-lg leading-relaxed">
                    <?= $companyInfo['vision'] ?>
                </p>
            </div>

            <!-- Mission -->
            <div class="bg-white rounded-2xl p-8 shadow-lg">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-bullseye text-green-600 text-xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Misi Kami</h2>
                </div>
                <ul class="space-y-4">
                    <?php foreach ($companyInfo['mission'] as $mission): ?>
                        <li class="flex items-start">
                            <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1 mr-3">
                                <i class="fas fa-check text-white text-sm"></i>
                            </div>
                            <span class="text-gray-700 leading-relaxed"><?= $mission ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Company Values -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Nilai-Nilai <span class="text-blue-600">Perusahaan</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Prinsip dan nilai yang menjadi fondasi dalam setiap layanan yang kami berikan kepada pelanggan.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($companyInfo['values'] as $valueTitle => $valueDesc): ?>
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-8 border border-blue-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mb-6">
                        <?php
                        $valueIcons = [
                            'Integritas' => 'fas fa-handshake',
                            'Kualitas' => 'fas fa-award',
                            'Profesionalisme' => 'fas fa-user-tie',
                            'Inovasi' => 'fas fa-lightbulb',
                            'Kepuasan Pelanggan' => 'fas fa-heart'
                        ];
                        ?>
                        <i class="<?= $valueIcons[$valueTitle] ?? 'fas fa-star' ?> text-white text-lg"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3"><?= $valueTitle ?></h3>
                    <p class="text-gray-600 leading-relaxed"><?= $valueDesc ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Tim <span class="text-blue-600">Profesional</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Teknisi dan staff berpengalaman yang siap memberikan layanan terbaik untuk kebutuhan service laptop dan komputer Anda.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php foreach ($teamMembers as $member): ?>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="relative">
                        <img src="<?= $member['photo'] ?>" alt="<?= $member['name'] ?>" class="w-full h-64 object-cover" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 text-white">
                            <div class="text-sm font-semibold bg-blue-600 px-3 py-1 rounded-full">
                                <?= $member['experience'] ?>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2"><?= $member['name'] ?></h3>
                        <p class="text-blue-600 font-semibold mb-3"><?= $member['position'] ?></p>
                        <p class="text-gray-600 text-sm mb-4"><?= $member['description'] ?></p>

                        <div class="border-t border-gray-200 pt-4">
                            <p class="text-sm text-gray-500 mb-2">Spesialisasi:</p>
                            <p class="text-sm font-medium text-gray-900"><?= $member['specialization'] ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Mengapa Memilih <span class="text-blue-600">Kami?</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Keunggulan dan komitmen yang membuat kami menjadi pilihan utama untuk layanan service laptop di Bandung.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($whyChooseUs as $reason): ?>
                <div class="text-center p-8 hover:bg-gray-50 rounded-xl transition-colors duration-300">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <?php
                        $reasonIcons = [
                            'award' => 'fas fa-award',
                            'shield-check' => 'fas fa-shield-alt',
                            'check-circle' => 'fas fa-check-circle',
                            'calculator' => 'fas fa-calculator',
                            'zap' => 'fas fa-bolt',
                            'headphones' => 'fas fa-headphones'
                        ];
                        ?>
                        <i class="<?= $reasonIcons[$reason['icon']] ?? 'fas fa-star' ?> text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4"><?= $reason['title'] ?></h3>
                    <p class="text-gray-600 leading-relaxed"><?= $reason['description'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Certifications -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Sertifikasi & <span class="text-blue-600">Partnership</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Komitmen kami terhadap profesionalisme dibuktikan dengan berbagai sertifikasi dan kemitraan resmi.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <?php foreach ($certifications as $cert): ?>
                <div class="bg-white rounded-xl p-8 shadow-lg text-center hover:shadow-xl transition-shadow duration-300">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-certificate text-2xl text-yellow-600"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2"><?= $cert['name'] ?></h3>
                    <p class="text-blue-600 font-semibold mb-2"><?= $cert['issuer'] ?></p>
                    <p class="text-gray-500"><?= $cert['year'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Featured Testimonials -->
<?php if (!empty($testimonials)): ?>
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Kata <span class="text-blue-600">Pelanggan</span>
                </h2>
                <p class="text-xl text-gray-600">Testimoni dari pelanggan yang telah merasakan layanan kami</p>
            </div>

            <div class="grid lg:grid-cols-3 gap-8">
                <?php foreach ($testimonials as $testimonial): ?>
                    <div class="bg-gray-50 rounded-xl p-8 relative">
                        <div class="flex items-center mb-4">
                            <div class="flex text-yellow-400 mr-3">
                                <?php for ($i = 0; $i < $testimonial['rating']; $i++): ?>
                                    <i class="fas fa-star"></i>
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
                <a href="/testimonial" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-colors duration-300 inline-block">
                    Lihat Semua Testimoni
                </a>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- Location & Contact -->
<section class="py-20 bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 text-white">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold mb-6">
                    Kunjungi <span class="text-yellow-400">Workshop Kami</span>
                </h2>
                <p class="text-xl text-gray-200 mb-8 leading-relaxed">
                    Datang langsung ke workshop kami untuk konsultasi gratis dan melihat proses service laptop secara transparan.
                </p>

                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="w-6 h-6 text-yellow-400 mr-4 mt-1">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-2">Alamat Workshop</h3>
                            <p class="text-gray-300"><?= $globalSeo['address'] ?></p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="w-6 h-6 text-yellow-400 mr-4 mt-1">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-2">Jam Operasional</h3>
                            <div class="text-gray-300 space-y-1">
                                <p><?= $globalSeo['business_hours']['weekdays']['days'] ?>: <?= $globalSeo['business_hours']['weekdays']['hours'] ?></p>
                                <p><?= $globalSeo['business_hours']['saturday']['days'] ?>: <?= $globalSeo['business_hours']['saturday']['hours'] ?></p>
                                <p><?= $globalSeo['business_hours']['sunday']['days'] ?>: <?= $globalSeo['business_hours']['sunday']['hours'] ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="w-6 h-6 text-yellow-400 mr-4 mt-1">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-2">Hubungi Kami</h3>
                            <p class="text-gray-300"><?= $globalSeo['phone'] ?></p>
                            <p class="text-gray-300"><?= $globalSeo['email'] ?></p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 mt-8">
                    <a href="<?= $globalSeo['whatsapp'] ?>" class="bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-colors duration-300 flex items-center justify-center">
                        <i class="fab fa-whatsapp text-2xl mr-3"></i>
                        WhatsApp
                    </a>
                    <a href="/kontak" class="bg-transparent border-2 border-white hover:bg-white hover:text-blue-900 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-envelope mr-3"></i>
                        Kontak Kami
                    </a>
                </div>
            </div>

            <div class="relative">
                <!-- Google Maps Placeholder -->
                <div class="bg-gray-200 rounded-2xl h-96 flex items-center justify-center">
                    <div class="text-center text-gray-600">
                        <i class="fas fa-map-marker-alt text-6xl mb-4"></i>
                        <p class="text-lg font-semibold mb-2">Google Maps</p>
                        <p>Lokasi Workshop Kami</p>
                        <a href="https://maps.google.com/?q=<?= urlencode($globalSeo['address']) ?>" target="_blank" class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors duration-300">
                            Buka di Google Maps
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
            Siap Bekerja Sama <span class="text-blue-600">Dengan Kami?</span>
        </h2>
        <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
            Bergabunglah dengan ribuan pelanggan yang telah mempercayakan kebutuhan service laptop mereka kepada kami.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/layanan" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-colors duration-300 inline-block">
                Lihat Layanan Kami
            </a>
            <a href="/testimonial" class="bg-transparent border-2 border-blue-600 hover:bg-blue-600 hover:text-white text-blue-600 px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300 inline-block">
                Baca Testimoni
            </a>
        </div>
    </div>
</section>

<script>
    // Smooth animations on scroll
    function animateOnScroll() {
        const elements = document.querySelectorAll('.animate-on-scroll');
        const windowHeight = window.innerHeight;

        elements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;

            if (elementTop < windowHeight - 100) {
                element.classList.add('animate-fade-in');
            }
        });
    }

    // Counter animation for achievements
    function animateCounters() {
        const counters = document.querySelectorAll('.counter');

        counters.forEach(counter => {
            const target = parseInt(counter.dataset.target);
            const increment = target / 100;
            let current = 0;

            const updateCounter = () => {
                if (current < target) {
                    current += increment;
                    counter.textContent = Math.ceil(current);
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = target;
                }
            };

            updateCounter();
        });
    }

    // Initialize animations
    document.addEventListener('DOMContentLoaded', function() {
        // Add CSS for animations
        const style = document.createElement('style');
        style.textContent = `
                .animate-on-scroll {
                    opacity: 0;
                    transform: translateY(30px);
                    transition: all 0.6s ease-out;
                }
                .animate-fade-in {
                    opacity: 1;
                    transform: translateY(0);
                }
            `;
        // document.head.appendChild(style);

        // Add animate class to elements
        document.querySelectorAll('.bg-gray-50, .bg-white').forEach(section => {
            section.classList.add('animate-on-scroll');
        });

        // Run animations
        animateOnScroll();
        window.addEventListener('scroll', animateOnScroll);

        // Animate counters when they come into view
        const achievementSection = document.querySelector('#achievements');
        if (achievementSection) {
            const observer = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting) {
                    animateCounters();
                    observer.disconnect();
                }
            }, { threshold: 0.5 });

            observer.observe(achievementSection);
        }
    });

    // Team member card hover effects
    document.addEventListener('DOMContentLoaded', function() {
        const teamCards = document.querySelectorAll('.team-card');

        teamCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px) scale(1.02)';
                this.style.transition = 'all 0.3s ease';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Add parallax effect to hero section
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelector('.hero-bg');
            if (parallax) {
                const speed = scrolled * 0.5;
                parallax.style.transform = `translateY(${speed}px)`;
            }
        });

        // Smooth scroll for navigation links
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

        // Add loading animation for images
        const images = document.querySelectorAll('img[loading="lazy"]');
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.style.opacity = '0';
                    img.style.transition = 'opacity 0.5s ease';

                    img.onload = function() {
                        this.style.opacity = '1';
                    };

                    observer.unobserve(img);
                }
            });
        });

        images.forEach(img => imageObserver.observe(img));

        // Interactive stats hover effects
        const statCards = document.querySelectorAll('.stat-card');
        statCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                const icon = this.querySelector('i');
                if (icon) {
                    icon.style.transform = 'rotate(360deg)';
                    icon.style.transition = 'transform 0.6s ease';
                }
            });

            card.addEventListener('mouseleave', function() {
                const icon = this.querySelector('i');
                if (icon) {
                    icon.style.transform = 'rotate(0deg)';
                }
            });
        });

        // Add typing effect to hero title
        const heroTitle = document.querySelector('.hero-title');
        if (heroTitle) {
            const text = heroTitle.textContent;
            heroTitle.textContent = '';
            let i = 0;

            function typeWriter() {
                if (i < text.length) {
                    heroTitle.textContent += text.charAt(i);
                    i++;
                    setTimeout(typeWriter, 50);
                }
            }

            setTimeout(typeWriter, 1000);
        }
    });

    // Add schema markup for the team
    const teamSchema = {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "<?= $companyInfo['name'] ?>",
        "employee": [
            <?php foreach ($teamMembers as $index => $member): ?>
            {
                "@type": "Person",
                "name": "<?= htmlspecialchars($member['name']) ?>",
                "jobTitle": "<?= htmlspecialchars($member['position']) ?>",
                "description": "<?= htmlspecialchars($member['description']) ?>",
                "worksFor": {
                    "@type": "Organization",
                    "name": "<?= $companyInfo['name'] ?>"
                }
            }<?= $index < count($teamMembers) - 1 ? ',' : '' ?>
            <?php endforeach; ?>
        ]
    };

    // Add team schema to head
    const teamScript = document.createElement('script');
    teamScript.type = 'application/ld+json';
    teamScript.textContent = JSON.stringify(teamSchema);
    document.head.appendChild(teamScript);

    // Intersection Observer for fade-in animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe all sections for animation
    document.querySelectorAll('section').forEach(section => {
        observer.observe(section);
    });
</script>

<?= $this->endSection() ?>