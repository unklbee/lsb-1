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

    <!-- FAQ Schema -->
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "FAQPage",
          "mainEntity": [
        <?php
        $allFaqs = [];
        foreach ($faqCategories as $category => $data) {
            foreach ($data['faqs'] as $faq) {
                $allFaqs[] = $faq;
            }
        }
        ?>
    <?php foreach ($allFaqs as $index => $faq): ?>
    {
      "@type": "Question",
      "name": "<?= htmlspecialchars($faq['question']) ?>",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<?= htmlspecialchars(strip_tags($faq['answer'])) ?>"
      }
    }<?= $index < count($allFaqs) - 1 ? ',' : '' ?>
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
                    FAQ <span class="text-yellow-400">Service Laptop Bandung</span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-200 mb-8 leading-relaxed">
                    Temukan jawaban untuk pertanyaan yang sering diajukan seputar layanan service laptop, komputer, dan upgrade hardware di Bandung.
                </p>

                <!-- Search FAQ -->
                <div class="max-w-2xl mx-auto">
                    <div class="relative">
                        <input type="text" id="faq-search" placeholder="Cari pertanyaan..." class="w-full px-6 py-4 pr-12 rounded-lg text-gray-900 text-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                        <svg class="absolute right-4 top-1/2 transform -translate-y-1/2 w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Categories Navigation -->
    <section class="py-8 bg-white border-b border-gray-200">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap justify-center gap-4">
                <button onclick="showAllFAQ()" class="faq-category-btn active px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors duration-300">
                    Semua FAQ
                </button>
                <?php foreach ($faqCategories as $categorySlug => $categoryData): ?>
                    <button onclick="showFAQCategory('<?= $categorySlug ?>')" class="faq-category-btn px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-blue-600 hover:text-white transition-colors duration-300" data-category="<?= $categorySlug ?>">
                        <?= $categoryData['title'] ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- FAQ Content -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <?php foreach ($faqCategories as $categorySlug => $categoryData): ?>
                    <div class="faq-category-content" data-category="<?= $categorySlug ?>">
                        <div class="mb-12">
                            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-8 text-center">
                                <?= $categoryData['title'] ?>
                            </h2>

                            <div class="grid md:grid-cols-2 gap-6">
                                <?php foreach ($categoryData['faqs'] as $index => $faq): ?>
                                    <div class="faq-item bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                                        <button class="w-full px-8 py-6 text-left flex justify-between items-start hover:bg-gray-50 transition-colors duration-300 rounded-xl" onclick="toggleFAQ('<?= $categorySlug ?>-<?= $index ?>')">
                                            <h3 class="text-lg font-semibold text-gray-900 pr-4 leading-relaxed"><?= $faq['question'] ?></h3>
                                            <svg id="faq-icon-<?= $categorySlug ?>-<?= $index ?>" class="w-6 h-6 text-gray-500 transform transition-transform duration-300 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                        <div id="faq-answer-<?= $categorySlug ?>-<?= $index ?>" class="hidden px-8 pb-6">
                                            <div class="text-gray-600 leading-relaxed"><?= nl2br($faq['answer']) ?></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <!-- No Results -->
                <div id="no-results" class="hidden text-center py-12">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.29-1.009-5.824-2.562M15 9.34c-.817-.243-1.661-.34-2.5-.34a9.98 9.98 0 00-2.5.34m0 0a15.923 15.923 0 014.908 1.934M6.34 15c.817.243 1.661.34 2.5.34a9.98 9.98 0 002.5-.34m-4.908-1.934c-.807-.025-1.566-.087-2.27-.25a15.106 15.106 0 01-2.37-.75l-.31-.17"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak ada hasil ditemukan</h3>
                    <p class="text-gray-600">Coba gunakan kata kunci yang berbeda atau hubungi kami langsung.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Support -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-4xl mx-auto">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                    Masih Ada <span class="text-blue-600">Pertanyaan?</span>
                </h2>
                <p class="text-xl text-gray-600 mb-8">
                    Tim customer service kami siap membantu Anda 24/7 untuk menjawab pertanyaan dan memberikan solusi terbaik.
                </p>

                <div class="grid md:grid-cols-3 gap-8 mb-12">
                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">WhatsApp</h3>
                        <p class="text-gray-600 mb-4">Chat langsung dengan teknisi</p>
                        <a href="<?= $globalSeo['whatsapp'] ?>" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors duration-300 inline-block">
                            Chat Sekarang
                        </a>
                    </div>

                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Telepon</h3>
                        <p class="text-gray-600 mb-4">Hubungi langsung customer service</p>
                        <a href="tel:<?= $globalSeo['phone'] ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors duration-300 inline-block">
                            <?= $globalSeo['phone'] ?>
                        </a>
                    </div>

                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Email</h3>
                        <p class="text-gray-600 mb-4">Kirim pertanyaan detail</p>
                        <a href="/kontak" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors duration-300 inline-block">
                            Kirim Email
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // FAQ functionality
        function toggleFAQ(id) {
            const answer = document.getElementById(`faq-answer-${id}`);
            const icon = document.getElementById(`faq-icon-${id}`);

            if (answer.classList.contains('hidden')) {
                answer.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                answer.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }

        // Category filtering
        function showAllFAQ() {
            document.querySelectorAll('.faq-category-content').forEach(content => {
                content.style.display = 'block';
            });

            document.querySelectorAll('.faq-category-btn').forEach(btn => {
                btn.classList.remove('active', 'bg-blue-600', 'text-white');
                btn.classList.add('bg-gray-100', 'text-gray-700');
            });

            event.target.classList.add('active', 'bg-blue-600', 'text-white');
            event.target.classList.remove('bg-gray-100', 'text-gray-700');

            document.getElementById('no-results').classList.add('hidden');
        }

        function showFAQCategory(category) {
            document.querySelectorAll('.faq-category-content').forEach(content => {
                content.style.display = 'none';
            });

            document.querySelector(`[data-category="${category}"]`).style.display = 'block';

            document.querySelectorAll('.faq-category-btn').forEach(btn => {
                btn.classList.remove('active', 'bg-blue-600', 'text-white');
                btn.classList.add('bg-gray-100', 'text-gray-700');
            });

            event.target.classList.add('active', 'bg-blue-600', 'text-white');
            event.target.classList.remove('bg-gray-100', 'text-gray-700');

            document.getElementById('no-results').classList.add('hidden');
        }

        // Search functionality
        document.getElementById('faq-search').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const faqItems = document.querySelectorAll('.faq-item');
            let hasResults = false;

            if (searchTerm === '') {
                showAllFAQ();
                return;
            }

            // Hide all categories first
            document.querySelectorAll('.faq-category-content').forEach(content => {
                content.style.display = 'none';
            });

            // Show matching items
            faqItems.forEach(item => {
                const question = item.querySelector('h3').textContent.toLowerCase();
                const answer = item.querySelector('.text-gray-600').textContent.toLowerCase();

                if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                    item.style.display = 'block';
                    item.closest('.faq-category-content').style.display = 'block';
                    hasResults = true;
                } else {
                    item.style.display = 'none';
                }
            });

            // Show no results if nothing found
            if (!hasResults) {
                document.getElementById('no-results').classList.remove('hidden');
            } else {
                document.getElementById('no-results').classList.add('hidden');
            }

            // Reset category buttons
            document.querySelectorAll('.faq-category-btn').forEach(btn => {
                btn.classList.remove('active', 'bg-blue-600', 'text-white');
                btn.classList.add('bg-gray-100', 'text-gray-700');
            });
        });

        // Initialize - show all FAQ by default
        document.addEventListener('DOMContentLoaded', function() {
            showAllFAQ();
        });
    </script>

<?= $this->endSection() ?>