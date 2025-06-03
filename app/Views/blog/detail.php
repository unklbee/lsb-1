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
    <meta property="og:type" content="article">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $seo['og_title'] ?>">
    <meta name="twitter:description" content="<?= $seo['og_description'] ?>">
    <meta name="twitter:image" content="<?= $seo['og_image'] ?>">

    <!-- Article Schema -->
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "Article",
          "headline": "<?= htmlspecialchars($post['title']) ?>",
  "description": "<?= htmlspecialchars($post['excerpt']) ?>",
  "image": "<?= $post['featured_image'] ?>",
  "author": {
    "@type": "Person",
    "name": "<?= $post['author'] ?>"
  },
  "publisher": {
    "@type": "Organization",
    "name": "<?= $globalSeo['business_name'] ?>",
    "logo": {
      "@type": "ImageObject",
      "url": "<?= base_url('assets/images/logo.png') ?>"
    }
  },
  "datePublished": "<?= $post['published_at'] ?>",
  "dateModified": "<?= $post['updated_at'] ?>",
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "<?= current_url() ?>"
  }
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

    <!-- Article Header -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Article Meta -->
                <div class="flex items-center space-x-4 mb-6">
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                    <?= $post['category_id'] ?>
                </span>
                    <?php if ($post['is_featured'] == 1): ?>
                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">
                    Featured
                </span>
                    <?php endif; ?>
                </div>

                <!-- Article Title -->
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                    <?= $post['title'] ?>
                </h1>

                <!-- Article Info -->
                <div class="flex flex-wrap items-center gap-6 text-gray-600 mb-8">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span><?= $post['author'] ?></span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span><?= date('d F Y', strtotime($post['published_at'])) ?></span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span><?= $post['reading_time'] ?> baca</span>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="mb-8">
                    <img src="<?= $post['featured_image'] ?>" alt="<?= $post['title'] ?>"
                         class="w-full h-64 md:h-96 object-cover rounded-xl shadow-lg">
                </div>

                <!-- Share Buttons -->
                <div class="flex items-center justify-between border-y border-gray-200 py-6 mb-8">
                    <div class="text-gray-600 font-medium">Bagikan artikel ini:</div>
                    <div class="flex items-center space-x-4">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(current_url()) ?>"
                           target="_blank"
                           class="flex items-center justify-center w-10 h-10 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-colors duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url=<?= urlencode(current_url()) ?>&text=<?= urlencode($post['title']) ?>"
                           target="_blank"
                           class="flex items-center justify-center w-10 h-10 bg-blue-400 text-white rounded-full hover:bg-blue-500 transition-colors duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="https://wa.me/?text=<?= urlencode($post['title'] . ' - ' . current_url()) ?>"
                           target="_blank"
                           class="flex items-center justify-center w-10 h-10 bg-green-500 text-white rounded-full hover:bg-green-600 transition-colors duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488z"/>
                            </svg>
                        </a>
                        <button onclick="copyToClipboard()"
                                class="flex items-center justify-center w-10 h-10 bg-gray-600 text-white rounded-full hover:bg-gray-700 transition-colors duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Articles -->
<?php if (!empty($relatedPosts)): ?>
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <h2 class="text-3xl font-bold text-gray-900 mb-12 text-center">Artikel Terkait</h2>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($relatedPosts as $related): ?>
                        <article
                                class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                            <div class="relative">
                                <img src="<?= $related['featured_image'] ?>" alt="<?= $related['title'] ?>"
                                     class="w-full h-48 object-cover" loading="lazy">
                                <div class="absolute top-4 right-4 bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    <?= $related['category'] ?>
                                </div>
                            </div>

                            <div class="p-6">
                                <div class="flex items-center text-sm text-gray-500 mb-3">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <?= date('d M Y', strtotime($related['published_date'])) ?>
                                    <span class="mx-2">•</span>
                                    <?= $related['reading_time'] ?>
                                </div>

                                <h3 class="text-lg font-bold text-gray-900 mb-3 leading-tight">
                                    <a href="/blog/<?= $related['slug'] ?>"
                                       class="hover:text-blue-600 transition-colors duration-300">
                                        <?= $related['title'] ?>
                                    </a>
                                </h3>

                                <p class="text-gray-600 mb-4 text-sm leading-relaxed"><?= substr($related['excerpt'], 0, 100) ?>
                                    ...</p>

                                <a href="/blog/<?= $related['slug'] ?>"
                                   class="text-blue-600 hover:text-blue-700 font-semibold text-sm transition-colors duration-300">
                                    Baca Selengkapnya →
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <div class="text-center mt-12">
                    <a href="/blog"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-colors duration-300 inline-block">
                        Lihat Semua Artikel
                    </a>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

    <!-- Newsletter Subscription -->
    <section class="py-16 bg-blue-600">
        <div class="container mx-auto px-4">
            <div class="max-w-2xl mx-auto text-center text-white">
                <h2 class="text-3xl font-bold mb-4">Jangan Lewatkan Tips Terbaru</h2>
                <p class="text-xl text-blue-100 mb-8">
                    Berlangganan newsletter kami untuk mendapatkan artikel terbaru seputar service laptop dan tips
                    perawatan komputer.
                </p>
                <form class="flex flex-col sm:flex-row gap-4">
                    <input type="email" placeholder="Masukkan email Anda"
                           class="flex-1 px-6 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                           required>
                    <button type="submit"
                            class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 px-8 py-3 rounded-lg font-semibold transition-colors duration-300">
                        Berlangganan
                    </button>
                </form>
                <p class="text-sm text-blue-200 mt-4">
                    Kami menghormati privasi Anda. Unsubscribe kapan saja.
                </p>
            </div>
        </div>
    </section>

    <style>
        /* Custom prose styles for article content */
        .prose {
            color: #374151;
            line-height: 1.75;
        }

        .prose h2 {
            color: #1f2937;
            font-weight: 700;
            font-size: 1.5em;
            margin-top: 2em;
            margin-bottom: 1em;
            line-height: 1.3333333;
        }

        .prose h3 {
            color: #1f2937;
            font-weight: 600;
            font-size: 1.25em;
            margin-top: 1.6em;
            margin-bottom: 0.6em;
            line-height: 1.6;
        }

        .prose p {
            margin-top: 1.25em;
            margin-bottom: 1.25em;
        }

        .prose ul, .prose ol {
            margin-top: 1.25em;
            margin-bottom: 1.25em;
            padding-left: 1.625em;
        }

        .prose li {
            margin-top: 0.5em;
            margin-bottom: 0.5em;
        }

        .prose ul > li {
            position: relative;
            padding-left: 0.375em;
        }

        .prose ul > li::before {
            content: "";
            position: absolute;
            background-color: #2563eb;
            border-radius: 50%;
            width: 0.375em;
            height: 0.375em;
            top: calc(0.875em - 0.1875em);
            left: -1.25em;
        }

        .prose ol > li {
            position: relative;
            padding-left: 0.375em;
        }

        .prose ol > li::before {
            content: counter(list-item, decimal) ".";
            position: absolute;
            font-weight: 400;
            color: #6b7280;
            left: -1.625em;
        }

        .prose strong {
            color: #1f2937;
            font-weight: 600;
        }

        .prose blockquote {
            font-weight: 500;
            font-style: italic;
            color: #1f2937;
            border-left-width: 0.25rem;
            border-left-color: #e5e7eb;
            quotes: "\201C" "\201D" "\2018" "\2019";
            margin-top: 1.6em;
            margin-bottom: 1.6em;
            padding-left: 1em;
        }

        .prose code {
            color: #1f2937;
            font-weight: 600;
            font-size: 0.875em;
            background-color: #f3f4f6;
            padding: 0.25em 0.375em;
            border-radius: 0.25rem;
        }

        .prose pre {
            color: #e5e7eb;
            background-color: #1f2937;
            overflow-x: auto;
            font-size: 0.875em;
            line-height: 1.7142857;
            margin-top: 1.7142857em;
            margin-bottom: 1.7142857em;
            border-radius: 0.375rem;
            padding: 0.8571429em 1.1428571em;
        }
    </style>

    <script>
        // Copy to clipboard functionality
        function copyToClipboard() {
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(function () {
                // Show success message
                const button = event.target.closest('button');
                const originalHTML = button.innerHTML;
                button.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';

                setTimeout(() => {
                    button.innerHTML = originalHTML;
                }, 2000);
            }).catch(function () {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = url;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                alert('Link telah disalin!');
            });
        }

        // Newsletter subscription
        document.querySelector('form').addEventListener('submit', function (e) {
            e.preventDefault();
            const email = this.querySelector('input[type="email"]').value;
            if (email) {
                // Here you would typically send the email to your backend
                alert('Terima kasih! Anda telah berlangganan newsletter kami.');
                this.reset();
            }
        });

        // Reading progress indicator
        function updateReadingProgress() {
            const article = document.querySelector('.prose');
            const articleHeight = article.offsetHeight;
            const articleTop = article.offsetTop;
            const articleBottom = articleTop + articleHeight;
            const scrollTop = window.pageYOffset;
            const windowHeight = window.innerHeight;
            const scrollBottom = scrollTop + windowHeight;

            if (scrollTop >= articleTop && scrollTop <= articleBottom) {
                const progress = (scrollTop - articleTop) / (articleHeight - windowHeight);
                const progressPercentage = Math.min(100, Math.max(0, progress * 100));

                // You can use this to show a reading progress bar
                // document.querySelector('.reading-progress').style.width = progressPercentage + '%';
            }
        }

        // Smooth scrolling for anchor links within article
        document.querySelectorAll('.prose a[href^="#"]').forEach(anchor => {
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

        // Add reading progress tracking
        window.addEventListener('scroll', updateReadingProgress);
        window.addEventListener('resize', updateReadingProgress);

        // Track reading time (for analytics)
        let startTime = Date.now();
        let totalReadingTime = 0;

        window.addEventListener('beforeunload', function () {
            totalReadingTime = Date.now() - startTime;
            // Send reading time to analytics
            // gtag('event', 'reading_time', {
            //     'article_title': '<?= $post['title'] ?>',
            //     'reading_time_seconds': Math.round(totalReadingTime / 1000)
            // });
        });

        // Image lazy loading and optimization
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

            document.querySelectorAll('img[loading="lazy"]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    </script>

<?= $this->endSection() ?>