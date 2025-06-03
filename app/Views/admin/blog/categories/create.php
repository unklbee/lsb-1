<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

    <form action="/admin/blog/categories/store" method="POST" id="category-form">
        <?= csrf_field() ?>

        <div class="p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Tambah Kategori Blog</h1>
                    <p class="text-gray-600 mt-1">Buat kategori baru untuk mengorganisir artikel blog</p>
                </div>

                <div class="flex space-x-3">
                    <a href="/admin/blog/categories"
                       class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>

                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Kategori
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                            Informasi Dasar
                        </h3>

                        <div class="space-y-4">
                            <!-- Category Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Kategori *
                                </label>
                                <input type="text"
                                       id="name"
                                       name="name"
                                       value="<?= old('name') ?>"
                                       placeholder="Masukkan nama kategori..."
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       required>

                                <?php if (isset($validation) && $validation->hasError('name')): ?>
                                    <p class="mt-1 text-sm text-red-600"><?= $validation->getError('name') ?></p>
                                <?php endif; ?>
                            </div>

                            <!-- URL Slug -->
                            <div>
                                <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                                    URL Slug
                                </label>
                                <div class="flex">
                                <span class="inline-flex items-center px-3 py-2 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                    /blog/category/
                                </span>
                                    <input type="text"
                                           id="slug"
                                           name="slug"
                                           value="<?= old('slug') ?>"
                                           placeholder="akan-dibuat-otomatis"
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-r-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>

                                <div class="mt-2 flex items-center">
                                    <div id="slug-status" class="text-sm text-gray-500">
                                        Kosongkan untuk generate otomatis dari nama kategori
                                    </div>
                                    <button type="button"
                                            onclick="checkSlugAvailability()"
                                            class="ml-2 text-blue-600 hover:text-blue-800 text-sm">
                                        Cek Ketersediaan
                                    </button>
                                </div>

                                <?php if (isset($validation) && $validation->hasError('slug')): ?>
                                    <p class="mt-1 text-sm text-red-600"><?= $validation->getError('slug') ?></p>
                                <?php endif; ?>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                    Deskripsi Kategori
                                </label>
                                <textarea id="description"
                                          name="description"
                                          rows="4"
                                          placeholder="Deskripsi singkat tentang kategori ini..."
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                          maxlength="500"><?= old('description') ?></textarea>

                                <div class="flex justify-between mt-1 text-sm text-gray-500">
                                    <span>Deskripsi akan ditampilkan di halaman kategori</span>
                                    <span id="description-counter">0/500</span>
                                </div>

                                <?php if (isset($validation) && $validation->hasError('description')): ?>
                                    <p class="mt-1 text-sm text-red-600"><?= $validation->getError('description') ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Settings -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">
                                <i class="fas fa-search mr-2 text-green-600"></i>
                                Pengaturan SEO
                            </h3>
                            <button type="button"
                                    onclick="generateSeoSuggestions()"
                                    class="px-3 py-1 bg-green-100 text-green-700 rounded text-sm hover:bg-green-200 transition-colors duration-200">
                                <i class="fas fa-magic mr-1"></i>
                                Auto Generate
                            </button>
                        </div>

                        <div class="space-y-4">
                            <!-- SEO Title -->
                            <div>
                                <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-2">
                                    SEO Title
                                </label>
                                <input type="text"
                                       id="meta_title"
                                       name="meta_title"
                                       value="<?= old('meta_title') ?>"
                                       placeholder="Akan otomatis menggunakan nama kategori jika kosong"
                                       maxlength="60"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">

                                <div class="flex justify-between mt-1 text-sm text-gray-500">
                                    <span>Optimal: 50-60 karakter</span>
                                    <span id="meta-title-counter">0/60</span>
                                </div>
                            </div>

                            <!-- SEO Description -->
                            <div>
                                <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">
                                    Meta Description
                                </label>
                                <textarea id="meta_description"
                                          name="meta_description"
                                          rows="3"
                                          placeholder="Akan otomatis menggunakan deskripsi kategori jika kosong"
                                          maxlength="160"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?= old('meta_description') ?></textarea>

                                <div class="flex justify-between mt-1 text-sm text-gray-500">
                                    <span>Optimal: 150-160 karakter</span>
                                    <span id="meta-desc-counter">0/160</span>
                                </div>
                            </div>

                            <!-- SEO Preview -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Preview Google Search:</h4>
                                <div class="border border-gray-200 bg-white p-3 rounded">
                                    <div id="seo-preview-title"
                                         class="text-blue-600 text-lg hover:underline cursor-pointer">
                                        [Nama Kategori] - Blog Service Laptop Bandung
                                    </div>
                                    <div id="seo-preview-url" class="text-green-600 text-sm">
                                        <?= base_url('/blog/category/') ?>[slug]
                                    </div>
                                    <div id="seo-preview-description" class="text-gray-600 text-sm">
                                        [Deskripsi kategori akan muncul di sini...]
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Publish Settings -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class="fas fa-cog mr-2 text-gray-600"></i>
                            Pengaturan
                        </h3>

                        <div class="space-y-4">
                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Status
                                </label>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="radio"
                                               name="is_active"
                                               value="1"
                                            <?= old('is_active', '1') == '1' ? 'checked' : '' ?>
                                               class="mr-2">
                                        <span class="text-sm">Aktif</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio"
                                               name="is_active"
                                               value="0"
                                            <?= old('is_active') == '0' ? 'checked' : '' ?>
                                               class="mr-2">
                                        <span class="text-sm">Nonaktif</span>
                                    </label>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Kategori aktif akan ditampilkan di website</p>
                            </div>

                            <!-- Sort Order -->
                            <div>
                                <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                                    Urutan Tampil
                                </label>
                                <input type="number"
                                       id="sort_order"
                                       name="sort_order"
                                       value="<?= old('sort_order', '0') ?>"
                                       min="0"
                                       max="999"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">

                                <p class="mt-1 text-sm text-gray-500">Angka yang lebih kecil akan muncul lebih dulu</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tips & Guidelines -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class="fas fa-lightbulb mr-2 text-yellow-600"></i>
                            Tips & Panduan
                        </h3>

                        <div class="space-y-3 text-sm text-gray-600">
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5"></i>
                                <span>Gunakan nama kategori yang jelas dan mudah dipahami</span>
                            </div>

                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5"></i>
                                <span>Deskripsi membantu pengunjung memahami konten kategori</span>
                            </div>

                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5"></i>
                                <span>SEO title yang baik meningkatkan ranking di search engine</span>
                            </div>

                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5"></i>
                                <span>Slug yang bersih membuat URL lebih SEO-friendly</span>
                            </div>

                            <div class="flex items-start">
                                <i class="fas fa-info-circle text-blue-500 mr-2 mt-0.5"></i>
                                <span>Kategori dapat dinonaktifkan tanpa menghapus artikel</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class="fas fa-bolt mr-2 text-purple-600"></i>
                            Aksi Cepat
                        </h3>

                        <div class="space-y-2">
                            <button type="button"
                                    onclick="previewCategory()"
                                    class="w-full px-3 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200 text-sm">
                                <i class="fas fa-eye mr-2"></i>
                                Preview Kategori
                            </button>

                            <button type="button"
                                    onclick="resetForm()"
                                    class="w-full px-3 py-2 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 transition-colors duration-200 text-sm">
                                <i class="fas fa-undo mr-2"></i>
                                Reset Form
                            </button>

                            <button type="button"
                                    onclick="showSeoAnalysis()"
                                    class="w-full px-3 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors duration-200 text-sm">
                                <i class="fas fa-chart-line mr-2"></i>
                                Analisis SEO
                            </button>
                        </div>
                    </div>

                    <!-- Category Examples -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class="fas fa-list mr-2 text-indigo-600"></i>
                            Contoh Kategori
                        </h3>

                        <div class="space-y-3 text-sm">
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <div class="font-medium text-gray-900">Tips & Tutorial</div>
                                <div class="text-gray-600 text-xs mt-1">
                                    Untuk artikel panduan dan tips seputar laptop
                                </div>
                            </div>

                            <div class="p-3 bg-gray-50 rounded-lg">
                                <div class="font-medium text-gray-900">Troubleshooting</div>
                                <div class="text-gray-600 text-xs mt-1">
                                    Solusi masalah umum laptop dan komputer
                                </div>
                            </div>

                            <div class="p-3 bg-gray-50 rounded-lg">
                                <div class="font-medium text-gray-900">Hardware Review</div>
                                <div class="text-gray-600 text-xs mt-1">
                                    Review dan perbandingan hardware laptop
                                </div>
                            </div>

                            <div class="p-3 bg-gray-50 rounded-lg">
                                <div class="font-medium text-gray-900">Berita Teknologi</div>
                                <div class="text-gray-600 text-xs mt-1">
                                    Update terkini dunia teknologi laptop
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Preview Modal -->
    <div id="preview-modal"
         class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg max-w-2xl w-full max-h-full overflow-auto">
            <div class="flex justify-between items-center p-6 border-b">
                <h3 class="text-lg font-medium">Preview Kategori</h3>
                <button onclick="closePreview()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div id="preview-content" class="p-6">
                <!-- Preview content will be loaded here -->
            </div>
        </div>
    </div>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
    <script>
        // Character counters
        function updateCounter(inputId, counterId, maxLength) {
            const input = document.getElementById(inputId);
            const counter = document.getElementById(counterId);

            if (input && counter) {
                const length = input.value.length;
                counter.textContent = `${length}/${maxLength}`;

                // Change color based on length
                if (length > maxLength * 0.9) {
                    counter.className = 'text-red-500';
                } else if (length > maxLength * 0.7) {
                    counter.className = 'text-yellow-500';
                } else {
                    counter.className = 'text-gray-500';
                }
            }
        }

        // Initialize counters and events
        document.addEventListener('DOMContentLoaded', function () {
            const description = document.getElementById('description');
            const metaTitle = document.getElementById('meta_title');
            const metaDesc = document.getElementById('meta_description');
            const name = document.getElementById('name');
            const slug = document.getElementById('slug');

            // Setup character counters
            if (description) {
                description.addEventListener('input', () => {
                    updateCounter('description', 'description-counter', 500);
                    updateSeoPreview();
                });
                updateCounter('description', 'description-counter', 500);
            }

            if (metaTitle) {
                metaTitle.addEventListener('input', () => {
                    updateCounter('meta_title', 'meta-title-counter', 60);
                    updateSeoPreview();
                });
                updateCounter('meta_title', 'meta-title-counter', 60);
            }

            if (metaDesc) {
                metaDesc.addEventListener('input', () => {
                    updateCounter('meta_description', 'meta-desc-counter', 160);
                    updateSeoPreview();
                });
                updateCounter('meta_description', 'meta-desc-counter', 160);
            }

            // Auto-generate slug from name
            if (name) {
                name.addEventListener('input', function () {
                    if (!slug.value || slug.dataset.autoGenerated) {
                        generateSlug();
                    }
                    updateSeoPreview();
                });
            }

            if (slug) {
                slug.addEventListener('input', function () {
                    // Mark as manually edited
                    if (this.value) {
                        this.dataset.autoGenerated = 'false';
                    }
                    updateSeoPreview();
                    checkSlugAvailability();
                });
            }

            // Initial SEO preview update
            updateSeoPreview();
        });

        // Generate slug from name
        function generateSlug() {
            const name = document.getElementById('name').value;
            const slug = document.getElementById('slug');

            const generatedSlug = name.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');

            slug.value = generatedSlug;
            slug.dataset.autoGenerated = 'true';
            updateSeoPreview();
        }

        // Check slug availability
        function checkSlugAvailability() {
            const slug = document.getElementById('slug').value;
            const statusDiv = document.getElementById('slug-status');

            if (!slug) {
                statusDiv.textContent = 'Kosongkan untuk generate otomatis dari nama kategori';
                statusDiv.className = 'text-sm text-gray-500';
                return;
            }

            // Simple validation
            if (slug.length < 3) {
                statusDiv.textContent = 'Slug minimal 3 karakter';
                statusDiv.className = 'text-sm text-red-500';
                return;
            }

            if (!/^[a-z0-9-]+$/.test(slug)) {
                statusDiv.textContent = 'Slug hanya boleh mengandung huruf kecil, angka, dan tanda strip';
                statusDiv.className = 'text-sm text-red-500';
                return;
            }

            // Check availability via AJAX
            fetch('/admin/blog/categories/validate-slug', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'slug=' + encodeURIComponent(slug)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.available) {
                        statusDiv.textContent = '✓ Slug tersedia';
                        statusDiv.className = 'text-sm text-green-500';
                    } else {
                        statusDiv.textContent = '✗ Slug sudah digunakan';
                        statusDiv.className = 'text-sm text-red-500';
                    }
                })
                .catch(error => {
                    statusDiv.textContent = 'Gagal memeriksa ketersediaan slug';
                    statusDiv.className = 'text-sm text-yellow-500';
                });
        }

        // Update SEO preview
        function updateSeoPreview() {
            const name = document.getElementById('name').value;
            const slug = document.getElementById('slug').value;
            const metaTitle = document.getElementById('meta_title').value;
            const metaDesc = document.getElementById('meta_description').value;
            const description = document.getElementById('description').value;

            // Update preview title
            const previewTitle = document.getElementById('seo-preview-title');
            previewTitle.textContent = metaTitle || (name ? `${name} - Blog Service Laptop Bandung` : '[Nama Kategori] - Blog Service Laptop Bandung');

            // Update preview URL
            const previewUrl = document.getElementById('seo-preview-url');
            previewUrl.textContent = `${window.location.origin}/blog/category/${slug || '[slug]'}`;

            // Update preview description
            const previewDesc = document.getElementById('seo-preview-description');
            previewDesc.textContent = metaDesc || description || '[Deskripsi kategori akan muncul di sini...]';
        }

        // Generate SEO suggestions
        function generateSeoSuggestions() {
            const name = document.getElementById('name').value;
            const description = document.getElementById('description').value;

            if (!name) {
                alert('Masukkan nama kategori terlebih dahulu');
                return;
            }

            fetch('/admin/blog/categories/generate-seo-suggestions', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: `name=${encodeURIComponent(name)}&description=${encodeURIComponent(description)}`
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const suggestions = data.suggestions;

                        if (suggestions.meta_title && !document.getElementById('meta_title').value) {
                            document.getElementById('meta_title').value = suggestions.meta_title;
                            updateCounter('meta_title', 'meta-title-counter', 60);
                        }

                        if (suggestions.meta_description && !document.getElementById('meta_description').value) {
                            document.getElementById('meta_description').value = suggestions.meta_description;
                            updateCounter('meta_description', 'meta-desc-counter', 160);
                        }

                        if (suggestions.slug && !document.getElementById('slug').value) {
                            document.getElementById('slug').value = suggestions.slug;
                            document.getElementById('slug').dataset.autoGenerated = 'true';
                        }

                        updateSeoPreview();

                        // Show success message
                        const button = event.target;
                        const originalText = button.innerHTML;
                        button.innerHTML = '<i class="fas fa-check mr-1"></i>Generated!';
                        button.className = button.className.replace('bg-green-100 text-green-700', 'bg-green-200 text-green-800');

                        setTimeout(() => {
                            button.innerHTML = originalText;
                            button.className = button.className.replace('bg-green-200 text-green-800', 'bg-green-100 text-green-700');
                        }, 2000);
                    } else {
                        alert('Gagal generate SEO suggestions: ' + data.message);
                    }
                })
                .catch(error => {
                    alert('Terjadi kesalahan saat generate SEO suggestions');
                });
        }

        // Preview category
        function previewCategory() {
            const name = document.getElementById('name').value;
            const description = document.getElementById('description').value;
            const slug = document.getElementById('slug').value;

            if (!name) {
                alert('Nama kategori harus diisi untuk preview');
                return;
            }

            const previewHTML = `
        <div class="max-w-2xl mx-auto">
            <header class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">${name}</h1>
                <div class="text-gray-600">
                    <span class="text-sm">Kategori Blog</span>
                    <span class="mx-2">•</span>
                    <span class="text-sm">URL: /blog/category/${slug || 'category-slug'}</span>
                </div>
            </header>

            ${description ? `<div class="text-lg text-gray-700 mb-6">${description}</div>` : ''}

            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-medium text-gray-900 mb-2">Artikel dalam kategori ini:</h3>
                <div class="text-gray-600 text-sm">
                    <div class="space-y-2">
                        <div class="p-2 bg-white rounded border">📝 Contoh Artikel 1</div>
                        <div class="p-2 bg-white rounded border">📝 Contoh Artikel 2</div>
                        <div class="p-2 bg-white rounded border">📝 Contoh Artikel 3</div>
                    </div>
                </div>
            </div>
        </div>
    `;

            document.getElementById('preview-content').innerHTML = previewHTML;
            document.getElementById('preview-modal').classList.remove('hidden');
        }

        function closePreview() {
            document.getElementById('preview-modal').classList.add('hidden');
        }

        // Reset form
        function resetForm() {
            if (confirm('Reset form akan menghapus semua data yang sudah diisi. Lanjutkan?')) {
                document.getElementById('category-form').reset();
                updateCounter('description', 'description-counter', 500);
                updateCounter('meta_title', 'meta-title-counter', 60);
                updateCounter('meta_description', 'meta-desc-counter', 160);
                updateSeoPreview();

                // Reset slug auto-generation flag
                document.getElementById('slug').dataset.autoGenerated = 'true';
                document.getElementById('slug-status').textContent = 'Kosongkan untuk generate otomatis dari nama kategori';
                document.getElementById('slug-status').className = 'text-sm text-gray-500';
            }
        }

        // SEO Analysis
        function showSeoAnalysis() {
            const name = document.getElementById('name').value;
            const description = document.getElementById('description').value;
            const metaTitle = document.getElementById('meta_title').value;
            const metaDesc = document.getElementById('meta_description').value;
            const slug = document.getElementById('slug').value;

            if (!name) {
                alert('Nama kategori harus diisi untuk analisis SEO');
                return;
            }

            const analysis = {
                nameLength: name.length,
                hasDescription: description.length > 0,
                metaTitleLength: (metaTitle || name).length,
                metaDescLength: metaDesc.length,
                hasSlug: slug.length > 0,
                slugFormat: /^[a-z0-9-]+$/.test(slug)
            };

            const recommendations = [];

            if (analysis.nameLength < 3 || analysis.nameLength > 50) {
                recommendations.push('Nama kategori sebaiknya 3-50 karakter');
            }

            if (!analysis.hasDescription) {
                recommendations.push('Tambahkan deskripsi untuk SEO yang lebih baik');
            }

            if (analysis.metaTitleLength < 30 || analysis.metaTitleLength > 60) {
                recommendations.push('Meta title sebaiknya 30-60 karakter');
            }

            if (analysis.metaDescLength < 120 || analysis.metaDescLength > 160) {
                recommendations.push('Meta description sebaiknya 120-160 karakter');
            }

            if (!analysis.hasSlug) {
                recommendations.push('Slug akan di-generate otomatis dari nama');
            } else if (!analysis.slugFormat) {
                recommendations.push('Slug sebaiknya hanya menggunakan huruf kecil, angka, dan tanda strip');
            }

            const message = recommendations.length > 0
                ? 'Rekomendasi SEO:\n\n' + recommendations.join('\n\n')
                : 'SEO kategori sudah optimal!';

            alert(message);
        }

        // Form submission handler
        document.getElementById('category-form').addEventListener('submit', function (e) {
            const name = document.getElementById('name').value;

            if (!name.trim()) {
                e.preventDefault();
                alert('Nama kategori wajib diisi');
                document.getElementById('name').focus();
                return;
            }

            // Show loading
            showLoading();
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function (e) {
            if (e.ctrlKey || e.metaKey) {
                switch (e.key) {
                    case 's':
                        e.preventDefault();
                        document.getElementById('category-form').submit();
                        break;
                    case 'p':
                        e.preventDefault();
                        previewCategory();
                        break;
                    case 'r':
                        e.preventDefault();
                        resetForm();
                        break;
                }
            }
        });

        // Show shortcuts info
        console.log('Keyboard shortcuts:');
        console.log('Ctrl+S: Save category');
        console.log('Ctrl+P: Preview');
        console.log('Ctrl+R: Reset form');
    </script>
<?= $this->endSection() ?>