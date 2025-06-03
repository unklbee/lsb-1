<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

    <form action="/admin/blog/posts/update/<?= $post['id'] ?>" method="POST" id="post-form">
        <?= csrf_field() ?>

        <div class="p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Edit Artikel</h1>
                    <p class="text-gray-600 mt-1">Edit dan perbarui konten artikel blog</p>

                    <!-- Article info -->
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <span>ID: #<?= $post['id'] ?></span>
                        <span class="mx-2">•</span>
                        <span>Dibuat: <?= date('d M Y H:i', strtotime($post['created_at'])) ?></span>
                        <span class="mx-2">•</span>
                        <span>Terakhir update: <?= date('d M Y H:i', strtotime($post['updated_at'])) ?></span>
                        <?php if (!empty($post['view_count'])): ?>
                            <span class="mx-2">•</span>
                            <span><i class="fas fa-eye mr-1"></i><?= number_format($post['view_count']) ?> views</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="flex space-x-3">
                    <a href="/admin/blog/posts"
                       class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>

                    <?php if ($post['is_published']): ?>
                        <a href="/blog/<?= $post['slug'] ?>"
                           target="_blank"
                           class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
                            <i class="fas fa-external-link-alt mr-2"></i>
                            Lihat Artikel
                        </a>
                    <?php endif; ?>

                    <button type="button"
                            onclick="saveDraft()"
                            class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors duration-200">
                        <i class="fas fa-save mr-2"></i>
                        Update Draft
                    </button>

                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        <i class="fas fa-check mr-2"></i>
                        Update Artikel
                    </button>
                </div>
            </div>

            <!-- Status Alert -->
            <?php if (!$post['is_published']): ?>
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <span>Artikel ini masih dalam status <strong>Draft</strong> dan belum dipublikasikan.</span>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Error Messages -->
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span class="font-medium">Terjadi kesalahan:</span>
                    </div>
                    <ul class="list-disc list-inside text-sm">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Title -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Judul Artikel *
                        </label>
                        <input type="text"
                               id="title"
                               name="title"
                               value="<?= old('title', esc($post['title'])) ?>"
                               placeholder="Masukkan judul artikel yang menarik..."
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required>

                        <!-- Auto-generated slug preview -->
                        <div class="mt-2 p-2 bg-gray-50 rounded text-sm text-gray-600">
                            <strong>URL saat ini:</strong> /blog/<?= $post['slug'] ?>
                        </div>
                    </div>

                    <!-- Excerpt -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">
                            Ringkasan Artikel *
                        </label>
                        <textarea id="excerpt"
                                  name="excerpt"
                                  rows="3"
                                  placeholder="Tulis ringkasan singkat artikel (maksimal 300 karakter)..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  maxlength="300"
                                  required><?= old('excerpt', esc($post['excerpt'])) ?></textarea>

                        <div class="flex justify-between mt-2 text-sm text-gray-500">
                            <span>Ringkasan akan muncul di preview artikel dan deskripsi SEO</span>
                            <span id="excerpt-counter">0/300</span>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                            Konten Artikel *
                        </label>

                        <!-- Editor Toolbar -->
                        <div class="border border-gray-300 rounded-t-lg p-2 bg-gray-50 flex flex-wrap gap-2">
                            <button type="button" onclick="formatText('bold')" class="p-2 hover:bg-gray-200 rounded" title="Bold">
                                <i class="fas fa-bold"></i>
                            </button>
                            <button type="button" onclick="formatText('italic')" class="p-2 hover:bg-gray-200 rounded" title="Italic">
                                <i class="fas fa-italic"></i>
                            </button>
                            <button type="button" onclick="formatText('underline')" class="p-2 hover:bg-gray-200 rounded" title="Underline">
                                <i class="fas fa-underline"></i>
                            </button>
                            <div class="border-l border-gray-300 mx-2"></div>
                            <button type="button" onclick="insertHeading(2)" class="p-2 hover:bg-gray-200 rounded text-sm" title="Heading 2">
                                H2
                            </button>
                            <button type="button" onclick="insertHeading(3)" class="p-2 hover:bg-gray-200 rounded text-sm" title="Heading 3">
                                H3
                            </button>
                            <div class="border-l border-gray-300 mx-2"></div>
                            <button type="button" onclick="insertList('ul')" class="p-2 hover:bg-gray-200 rounded" title="Bullet List">
                                <i class="fas fa-list-ul"></i>
                            </button>
                            <button type="button" onclick="insertList('ol')" class="p-2 hover:bg-gray-200 rounded" title="Numbered List">
                                <i class="fas fa-list-ol"></i>
                            </button>
                            <div class="border-l border-gray-300 mx-2"></div>
                            <button type="button" onclick="insertLink()" class="p-2 hover:bg-gray-200 rounded" title="Insert Link">
                                <i class="fas fa-link"></i>
                            </button>
                            <button type="button" onclick="insertImage()" class="p-2 hover:bg-gray-200 rounded" title="Insert Image">
                                <i class="fas fa-image"></i>
                            </button>
                        </div>

                        <textarea id="content"
                                  name="content"
                                  rows="20"
                                  placeholder="Tulis konten artikel Anda di sini..."
                                  class="w-full px-3 py-2 border-l border-r border-b border-gray-300 rounded-b-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-y"
                                  required><?= old('content', esc($post['content'])) ?></textarea>

                        <div class="mt-2 text-sm text-gray-500">
                            <span id="word-counter">0 kata</span> •
                            <span id="reading-time">0 menit membaca</span>
                        </div>
                    </div>

                    <!-- SEO Settings -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class="fas fa-search mr-2 text-blue-600"></i>
                            Pengaturan SEO
                        </h3>

                        <div class="space-y-4">
                            <!-- SEO Title -->
                            <div>
                                <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-2">
                                    SEO Title
                                </label>
                                <input type="text"
                                       id="meta_title"
                                       name="meta_title"
                                       value="<?= old('meta_title', esc($post['meta_title'])) ?>"
                                       placeholder="Akan otomatis menggunakan judul artikel jika kosong"
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
                                          placeholder="Akan otomatis menggunakan excerpt jika kosong"
                                          maxlength="160"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?= old('meta_description', esc($post['meta_description'])) ?></textarea>

                                <div class="flex justify-between mt-1 text-sm text-gray-500">
                                    <span>Optimal: 150-160 karakter</span>
                                    <span id="meta-desc-counter">0/160</span>
                                </div>
                            </div>

                            <!-- Keywords -->
                            <div>
                                <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-2">
                                    Keywords
                                </label>
                                <input type="text"
                                       id="meta_keywords"
                                       name="meta_keywords"
                                       value="<?= old('meta_keywords', esc($post['meta_keywords'])) ?>"
                                       placeholder="keyword1, keyword2, keyword3"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">

                                <p class="mt-1 text-sm text-gray-500">Pisahkan dengan koma. Maksimal 10 keywords.</p>
                            </div>

                            <!-- Custom Slug -->
                            <div>
                                <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                                    URL Slug
                                </label>
                                <input type="text"
                                       id="slug"
                                       name="slug"
                                       value="<?= old('slug', esc($post['slug'])) ?>"
                                       placeholder="url-artikel-ini"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">

                                <p class="mt-1 text-sm text-gray-500">
                                    <i class="fas fa-exclamation-triangle text-yellow-500 mr-1"></i>
                                    Hati-hati mengubah slug, akan mempengaruhi URL artikel yang sudah dipublikasi
                                </p>
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
                            Pengaturan Publikasi
                        </h3>

                        <div class="space-y-4">
                            <!-- Category -->
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kategori *
                                </label>
                                <select id="category_id"
                                        name="category_id"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        required>
                                    <option value="">Pilih Kategori</option>
                                    <?php if (!empty($categories)): ?>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?= $category['id'] ?>"
                                                <?= (old('category_id', $post['category_id']) == $category['id']) ? 'selected' : '' ?>>
                                                <?= esc($category['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>

                                <a href="/admin/blog/categories/create"
                                   target="_blank"
                                   class="mt-2 inline-flex items-center text-sm text-blue-600 hover:text-blue-700">
                                    <i class="fas fa-plus mr-1"></i>
                                    Buat kategori baru
                                </a>
                            </div>

                            <!-- Author -->
                            <div>
                                <label for="author" class="block text-sm font-medium text-gray-700 mb-2">
                                    Penulis *
                                </label>
                                <input type="text"
                                       id="author"
                                       name="author"
                                       value="<?= old('author', esc($post['author'])) ?>"
                                       placeholder="Nama penulis"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       required>
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Status
                                </label>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="radio"
                                               name="is_published"
                                               value="0"
                                            <?= (old('is_published', $post['is_published']) == '0') ? 'checked' : '' ?>
                                               class="mr-2">
                                        <span class="text-sm">Draft</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio"
                                               name="is_published"
                                               value="1"
                                            <?= (old('is_published', $post['is_published']) == '1') ? 'checked' : '' ?>
                                               class="mr-2">
                                        <span class="text-sm">Publikasi</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Featured -->
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox"
                                           name="is_featured"
                                           value="1"
                                        <?= (old('is_featured', $post['is_featured']) == '1') ? 'checked' : '' ?>
                                           class="mr-2">
                                    <span class="text-sm font-medium text-gray-700">Jadikan artikel featured</span>
                                </label>
                                <p class="mt-1 text-sm text-gray-500">Artikel featured akan ditampilkan di halaman utama</p>
                            </div>

                            <!-- Published Date -->
                            <?php if ($post['published_at']): ?>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Tanggal Publikasi
                                    </label>
                                    <div class="text-sm text-gray-600 bg-gray-50 p-2 rounded">
                                        <i class="fas fa-calendar mr-1"></i>
                                        <?= date('d M Y H:i', strtotime($post['published_at'])) ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class="fas fa-image mr-2 text-green-600"></i>
                            Gambar Utama
                        </h3>

                        <div id="image-upload-area" class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-gray-400 transition-colors duration-200">
                            <?php if (!empty($post['featured_image'])): ?>
                            <div id="image-preview">
                                <img id="preview-img"
                                     src="<?= esc($post['featured_image']) ?>"
                                     alt="<?= esc($post['title']) ?>"
                                     class="max-w-full h-auto rounded-lg mb-3">
                                <div class="flex justify-center space-x-2">
                                    <button type="button"
                                            onclick="changeImage()"
                                            class="px-3 py-1 bg-gray-600 text-white rounded text-sm hover:bg-gray-700">
                                        Ganti
                                    </button>
                                    <button type="button"
                                            onclick="removeImage()"
                                            class="px-3 py-1 bg-red-600 text-white rounded text-sm hover:bg-red-700">
                                        Hapus
                                    </button>
                                </div>
                            </div>

                            <div id="image-placeholder" class="hidden">
                                <?php else: ?>
                                <div id="image-preview" class="hidden">
                                    <img id="preview-img" src="" alt="Preview" class="max-w-full h-auto rounded-lg mb-3">
                                    <div class="flex justify-center space-x-2">
                                        <button type="button"
                                                onclick="changeImage()"
                                                class="px-3 py-1 bg-gray-600 text-white rounded text-sm hover:bg-gray-700">
                                            Ganti
                                        </button>
                                        <button type="button"
                                                onclick="removeImage()"
                                                class="px-3 py-1 bg-red-600 text-white rounded text-sm hover:bg-red-700">
                                            Hapus
                                        </button>
                                    </div>
                                </div>

                                <div id="image-placeholder">
                                    <?php endif; ?>
                                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                    <p class="text-gray-600 mb-2">Klik untuk upload gambar</p>
                                    <p class="text-sm text-gray-500">PNG, JPG, JPEG maksimal 2MB</p>
                                    <button type="button"
                                            onclick="document.getElementById('featured_image_file').click()"
                                            class="mt-3 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                        Pilih Gambar
                                    </button>
                                </div>
                            </div>

                            <input type="file"
                                   id="featured_image_file"
                                   accept="image/*"
                                   class="hidden"
                                   onchange="handleImageUpload(this)">

                            <input type="hidden"
                                   id="featured_image"
                                   name="featured_image"
                                   value="<?= old('featured_image', esc($post['featured_image'])) ?>">
                        </div>
                    </div>

                    <!-- Article Statistics -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class="fas fa-chart-bar mr-2 text-purple-600"></i>
                            Statistik Artikel
                        </h3>

                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Total Views</span>
                                <span class="font-medium text-gray-900"><?= number_format($post['view_count'] ?? 0) ?></span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Reading Time</span>
                                <span class="font-medium text-gray-900"><?= $post['reading_time'] ?? '5 menit' ?></span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Word Count</span>
                                <span class="font-medium text-gray-900" id="current-word-count">
                            <?= str_word_count(strip_tags($post['content'])) ?> kata
                        </span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Status</span>
                                <span class="font-medium <?= $post['is_published'] ? 'text-green-600' : 'text-yellow-600' ?>">
                            <?= $post['is_published'] ? 'Published' : 'Draft' ?>
                        </span>
                            </div>

                            <?php if ($post['is_featured']): ?>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Featured</span>
                                    <span class="font-medium text-yellow-600">
                                <i class="fas fa-star mr-1"></i>Yes
                            </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Hapus Artikel</h3>
            </div>

            <p class="text-gray-600 mb-6">
                Apakah Anda yakin ingin menghapus artikel "<strong><?= esc($post['title']) ?></strong>"?
                Tindakan ini tidak dapat dibatalkan.
                <?php if ($post['is_published']): ?>
                    <br><br>
                    <span class="text-red-600 font-medium">
                    <i class="fas fa-warning mr-1"></i>
                    Artikel ini sudah dipublikasi dan mungkin sudah diindeks oleh search engine.
                </span>
                <?php endif; ?>
            </p>

            <div class="flex justify-end space-x-3">
                <button onclick="closeDeleteModal()"
                        class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors duration-200">
                    Batal
                </button>
                <button onclick="confirmDelete()"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200">
                    Hapus
                </button>
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

        // Initialize counters
        document.addEventListener('DOMContentLoaded', function() {
            const excerpt = document.getElementById('excerpt');
            const metaTitle = document.getElementById('meta_title');
            const metaDesc = document.getElementById('meta_description');
            const content = document.getElementById('content');

            if (excerpt) {
                excerpt.addEventListener('input', () => updateCounter('excerpt', 'excerpt-counter', 300));
                updateCounter('excerpt', 'excerpt-counter', 300);
            }

            if (metaTitle) {
                metaTitle.addEventListener('input', () => updateCounter('meta_title', 'meta-title-counter', 60));
                updateCounter('meta_title', 'meta-title-counter', 60);
            }

            if (metaDesc) {
                metaDesc.addEventListener('input', () => updateCounter('meta_description', 'meta-desc-counter', 160));
                updateCounter('meta_description', 'meta-desc-counter', 160);
            }

            if (content) {
                content.addEventListener('input', updateWordCount);
                updateWordCount();
            }
        });

        // Word count and reading time
        function updateWordCount() {
            const content = document.getElementById('content').value;
            const words = content.trim().split(/\s+/).filter(word => word.length > 0);
            const wordCount = words.length;
            const readingTime = Math.ceil(wordCount / 200); // 200 words per minute

            document.getElementById('word-counter').textContent = `${wordCount} kata`;
            document.getElementById('reading-time').textContent = `${readingTime} menit membaca`;
            document.getElementById('current-word-count').textContent = `${wordCount} kata`;
        }

        // Text formatting functions
        function formatText(command) {
            const textarea = document.getElementById('content');
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const selectedText = textarea.value.substring(start, end);

            let formattedText = '';
            switch(command) {
                case 'bold':
                    formattedText = `**${selectedText}**`;
                    break;
                case 'italic':
                    formattedText = `*${selectedText}*`;
                    break;
                case 'underline':
                    formattedText = `<u>${selectedText}</u>`;
                    break;
            }

            textarea.value = textarea.value.substring(0, start) + formattedText + textarea.value.substring(end);
            textarea.focus();
            textarea.setSelectionRange(start + formattedText.length, start + formattedText.length);
        }

        function insertHeading(level) {
            const textarea = document.getElementById('content');
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const selectedText = textarea.value.substring(start, end) || 'Heading Text';

            const heading = `\n${'#'.repeat(level)} ${selectedText}\n`;

            textarea.value = textarea.value.substring(0, start) + heading + textarea.value.substring(end);
            textarea.focus();
        }

        function insertList(type) {
            const textarea = document.getElementById('content');
            const start = textarea.selectionStart;
            const listItem = type === 'ul' ? '\n- List item\n' : '\n1. List item\n';

            textarea.value = textarea.value.substring(0, start) + listItem + textarea.value.substring(start);
            textarea.focus();
        }

        function insertLink() {
            const url = prompt('Masukkan URL:');
            const text = prompt('Masukkan teks link:') || url;

            if (url) {
                const textarea = document.getElementById('content');
                const start = textarea.selectionStart;
                const link = `[${text}](${url})`;

                textarea.value = textarea.value.substring(0, start) + link + textarea.value.substring(start);
                textarea.focus();
            }
        }

        function insertImage() {
            const url = prompt('Masukkan URL gambar:');
            const alt = prompt('Masukkan alt text:') || 'Image';

            if (url) {
                const textarea = document.getElementById('content');
                const start = textarea.selectionStart;
                const image = `![${alt}](${url})`;

                textarea.value = textarea.value.substring(0, start) + image + textarea.value.substring(start);
                textarea.focus();
            }
        }

        // Image handling - FIXED VERSION
        function handleImageUpload(input) {
            const file = input.files[0];
            if (!file) return;

            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                input.value = ''; // Reset input
                return;
            }

            // Validate file type
            if (!file.type.startsWith('image/')) {
                alert('File harus berupa gambar.');
                input.value = ''; // Reset input
                return;
            }

            // Show loading while uploading
            const uploadArea = document.getElementById('image-upload-area');
            const originalContent = uploadArea.innerHTML;

            uploadArea.innerHTML = `
                <div class="flex flex-col items-center">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mb-2"></div>
                    <p class="text-gray-600">Mengupload gambar...</p>
                </div>
            `;

            // Create FormData for upload
            const formData = new FormData();
            formData.append('image', file);
            formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

            // Upload image to server
            fetch('/admin/media/upload-image', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Success - show preview with real image URL
                        uploadArea.innerHTML = `
                        <div id="image-preview">
                            <img id="preview-img"
                                 src="${data.image_url}"
                                 alt="Preview"
                                 class="max-w-full h-auto rounded-lg mb-3">
                            <div class="flex justify-center space-x-2">
                                <button type="button"
                                        onclick="changeImage()"
                                        class="px-3 py-1 bg-gray-600 text-white rounded text-sm hover:bg-gray-700">
                                    Ganti
                                </button>
                                <button type="button"
                                        onclick="removeImage()"
                                        class="px-3 py-1 bg-red-600 text-white rounded text-sm hover:bg-red-700">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    `;

                        // Set the real image path
                        document.getElementById('featured_image').value = data.image_url;

                    } else {
                        // Error - restore original content and show error
                        uploadArea.innerHTML = originalContent;
                        alert('Gagal mengupload gambar: ' + (data.message || 'Error tidak diketahui'));
                    }
                })
                .catch(error => {
                    // Network error - restore original content
                    uploadArea.innerHTML = originalContent;
                    alert('Terjadi kesalahan saat mengupload gambar. Silakan coba lagi.');
                    console.error('Upload error:', error);
                })
                .finally(() => {
                    // Reset file input
                    input.value = '';
                });
        }

        function changeImage() {
            document.getElementById('featured_image_file').click();
        }

        function removeImage() {
            document.getElementById('featured_image').value = '';
            document.getElementById('image-placeholder').classList.remove('hidden');
            document.getElementById('image-preview').classList.add('hidden');
            document.getElementById('featured_image_file').value = '';
        }

        // Save as draft
        function saveDraft() {
            // Set status to draft
            document.querySelector('input[name="is_published"][value="0"]').checked = true;

            // Submit form
            document.getElementById('post-form').submit();
        }

        // Delete post functionality
        function deletePost() {
            document.getElementById('delete-modal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('delete-modal').classList.add('hidden');
        }

        function confirmDelete() {
            showLoading();
            closeDeleteModal();

            fetch(`/admin/blog/posts/delete/<?= $post['id'] ?>`, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    hideLoading();
                    if (data.success) {
                        window.location.href = '/admin/blog/posts';
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    hideLoading();
                    alert('Terjadi kesalahan: ' + error);
                });
        }

        // Enhanced form submission handler - FIXED VERSION
        document.getElementById('post-form').addEventListener('submit', function(e) {
            console.log('Form submission triggered');

            // Stop auto-save during submission
            if (autoSaveInterval) {
                clearInterval(autoSaveInterval);
            }

            const isPublishing = document.querySelector('input[name="is_published"]:checked')?.value === '1';

            if (isPublishing) {
                // Validation for publishing
                const title = document.getElementById('title').value.trim();
                const excerpt = document.getElementById('excerpt').value.trim();
                const content = document.getElementById('content').value.trim();
                const category = document.getElementById('category_id').value;

                console.log('Validation check:', { title: !!title, excerpt: !!excerpt, content: !!content, category: !!category });

                if (!title || !excerpt || !content || !category) {
                    e.preventDefault();
                    alert('Semua field wajib harus diisi untuk publikasi');
                    // Restart auto-save
                    setTimeout(() => startAutoSave(), 1000);
                    return false;
                }

                if (content.split(' ').length < 100) {
                    if (!confirm('Konten artikel masih pendek (kurang dari 100 kata). Yakin ingin publikasi?')) {
                        e.preventDefault();
                        // Restart auto-save
                        setTimeout(() => startAutoSave(), 1000);
                        return false;
                    }
                }
            }

            // Disable submit button to prevent double submission
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';

            // Show loading
            console.log('Showing loading for form submission');
            showLoading();

            // Add hidden field to track submission
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'form_submitted';
            hiddenInput.value = '1';
            this.appendChild(hiddenInput);

            // Shorter timeout for better UX
            const timeoutId = setTimeout(() => {
                const spinner = document.getElementById('loading-spinner');
                if (spinner && !spinner.classList.contains('hidden')) {
                    console.warn('Form submission timeout, but continuing...');
                    hideLoading();

                    // Re-enable button
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;

                    // Show timeout message but don't stop the form
                    alert('Proses update memakan waktu lebih lama dari biasanya. Mohon tunggu...');

                    // Check if actually submitted by trying to navigate away
                    setTimeout(() => {
                        if (confirm('Masih dalam proses. Apakah ingin refresh halaman untuk melihat status terbaru?')) {
                            window.location.reload();
                        }
                    }, 5000);
                }
            }, 10000); // 10 seconds timeout

            // Clear timeout if form actually submits
            this.addEventListener('beforesubmit', () => {
                clearTimeout(timeoutId);
            });

            // Don't prevent default - let form submit normally
            return true;
        });

        // Auto-save functionality (setiap 60 detik untuk edit mode)
        let autoSaveInterval;

        function startAutoSave() {
            autoSaveInterval = setInterval(() => {
                const title = document.getElementById('title').value;
                const content = document.getElementById('content').value;

                if (title && content) {
                    autoSavePost();
                }
            }, 60000); // 60 seconds
        }

        function autoSavePost() {
            const form = document.getElementById('post-form');
            if (!form) return;

            const formData = new FormData(form);
            formData.append('auto_save', '1');

            fetch(`/admin/blog/posts/auto-save/<?= $post['id'] ?>`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => {
                    if (!response.ok) {
                        console.warn('Auto-save failed with status:', response.status);
                        return null;
                    }
                    return response.json();
                })
                .then(data => {
                    if (data && data.success) {
                        showAutoSaveIndicator();
                    } else if (data) {
                        console.warn('Auto-save error:', data.message);
                    }
                })
                .catch(error => {
                    console.warn('Auto-save failed:', error);
                });
        }

        function showAutoSaveIndicator() {
            // Create temporary indicator
            const indicator = document.createElement('div');
            indicator.className = 'fixed top-4 right-4 bg-green-500 text-white px-3 py-2 rounded shadow-lg z-50';
            indicator.innerHTML = '<i class="fas fa-check mr-2"></i>Auto-saved';
            document.body.appendChild(indicator);

            setTimeout(() => {
                indicator.remove();
            }, 2000);
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Start auto-save after delay
            setTimeout(() => {
                startAutoSave();
            }, 5000);
        });

        // Cleanup on page unload
        window.addEventListener('beforeunload', function() {
            if (autoSaveInterval) {
                clearInterval(autoSaveInterval);
            }
        });
    </script>
<?= $this->endSection() ?>