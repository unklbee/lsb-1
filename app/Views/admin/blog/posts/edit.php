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

                        <?php if (isset($validation) && $validation->hasError('title')): ?>
                            <p class="mt-1 text-sm text-red-600"><?= $validation->getError('title') ?></p>
                        <?php endif; ?>
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

                        <?php if (isset($validation) && $validation->hasError('excerpt')): ?>
                            <p class="mt-1 text-sm text-red-600"><?= $validation->getError('excerpt') ?></p>
                        <?php endif; ?>
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
                            <div class="border-l border-gray-300 mx-2"></div>
                            <button type="button" onclick="undoChanges()" class="p-2 hover:bg-gray-200 rounded" title="Undo">
                                <i class="fas fa-undo"></i>
                            </button>
                            <button type="button" onclick="redoChanges()" class="p-2 hover:bg-gray-200 rounded" title="Redo">
                                <i class="fas fa-redo"></i>
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

                        <?php if (isset($validation) && $validation->hasError('content')): ?>
                            <p class="mt-1 text-sm text-red-600"><?= $validation->getError('content') ?></p>
                        <?php endif; ?>
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

                    <!-- Revision History -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            <i class="fas fa-history mr-2 text-gray-600"></i>
                            Riwayat Revisi
                        </h3>

                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900">Versi Saat Ini</p>
                                    <p class="text-sm text-gray-600">Terakhir diupdate <?= date('d M Y H:i', strtotime($post['updated_at'])) ?></p>
                                </div>
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Current</span>
                            </div>

                            <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900">Versi Awal</p>
                                    <p class="text-sm text-gray-600">Dibuat <?= date('d M Y H:i', strtotime($post['created_at'])) ?></p>
                                </div>
                                <button type="button" class="text-blue-600 hover:text-blue-800 text-sm">
                                    <i class="fas fa-eye mr-1"></i>Lihat
                                </button>
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

                                <?php if (isset($validation) && $validation->hasError('category_id')): ?>
                                    <p class="mt-1 text-sm text-red-600"><?= $validation->getError('category_id') ?></p>
                                <?php endif; ?>
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

                                <?php if (isset($validation) && $validation->hasError('author')): ?>
                                    <p class="mt-1 text-sm text-red-600"><?= $validation->getError('author') ?></p>
                                <?php endif; ?>
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

                            <div class="mt-3">
                                <label for="image_alt" class="block text-sm font-medium text-gray-700 mb-1">
                                    Alt Text (untuk SEO)
                                </label>
                                <input type="text"
                                       id="image_alt"
                                       name="image_alt"
                                       value="<?= old('image_alt', '') ?>"
                                       placeholder="Deskripsi gambar untuk accessibility"
                                       class="w-full px-3 py-1 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
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

                        <!-- Quick Actions -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                <i class="fas fa-bolt mr-2 text-yellow-600"></i>
                                Aksi Cepat
                            </h3>

                            <div class="space-y-2">
                                <button type="button"
                                        onclick="previewPost()"
                                        class="w-full px-3 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200 text-sm">
                                    <i class="fas fa-eye mr-2"></i>
                                    Preview Artikel
                                </button>

                                <button type="button"
                                        onclick="duplicatePost()"
                                        class="w-full px-3 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors duration-200 text-sm">
                                    <i class="fas fa-copy mr-2"></i>
                                    Duplikat Artikel
                                </button>

                                <button type="button"
                                        onclick="showSEOAnalysis()"
                                        class="w-full px-3 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors duration-200 text-sm">
                                    <i class="fas fa-chart-line mr-2"></i>
                                    Analisis SEO
                                </button>

                                <?php if ($post['is_published']): ?>
                                    <button type="button"
                                            onclick="shareArticle()"
                                            class="w-full px-3 py-2 bg-purple-100 text-purple-700 rounded-lg hover:bg-purple-200 transition-colors duration-200 text-sm">
                                        <i class="fas fa-share mr-2"></i>
                                        Share Artikel
                                    </button>
                                <?php endif; ?>

                                <button type="button"
                                        onclick="deletePost()"
                                        class="w-full px-3 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors duration-200 text-sm">
                                    <i class="fas fa-trash mr-2"></i>
                                    Hapus Artikel
                                </button>
                            </div>
                        </div>

                        <!-- SEO Score -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                <i class="fas fa-search mr-2 text-blue-600"></i>
                                SEO Score
                            </h3>

                            <div class="text-center">
                                <div class="text-3xl font-bold text-gray-400" id="seo-score">--</div>
                                <p class="text-sm text-gray-500 mb-4">SEO Score</p>

                                <div id="seo-checklist" class="text-left space-y-2 text-sm">
                                    <div class="flex items-center text-gray-400">
                                        <i class="fas fa-circle text-xs mr-2"></i>
                                        <span>Judul optimal (50-60 karakter)</span>
                                    </div>
                                    <div class="flex items-center text-gray-400">
                                        <i class="fas fa-circle text-xs mr-2"></i>
                                        <span>Meta description (150-160 karakter)</span>
                                    </div>
                                    <div class="flex items-center text-gray-400">
                                        <i class="fas fa-circle text-xs mr-2"></i>
                                        <span>Gambar utama tersedia</span>
                                    </div>
                                    <div class="flex items-center text-gray-400">
                                        <i class="fas fa-circle text-xs mr-2"></i>
                                        <span>Konten minimal 300 kata</span>
                                    </div>
                                    <div class="flex items-center text-gray-400">
                                        <i class="fas fa-circle text-xs mr-2"></i>
                                        <span>Heading struktur (H2, H3)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </form>

    <!-- Preview Modal -->
    <div id="preview-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg max-w-4xl w-full max-h-full overflow-auto">
            <div class="flex justify-between items-center p-6 border-b">
                <h3 class="text-lg font-medium">Preview Artikel</h3>
                <button onclick="closePreview()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div id="preview-content" class="p-6">
                <!-- Preview content will be loaded here -->
            </div>
        </div>
    </div>

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
        // Include all the JavaScript from the create page
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

            // Initialize SEO scoring
            initSEOScoring();
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

        // Image upload handling (same as create page)
        function handleImageUpload(input) {
            const file = input.files[0];
            if (!file) return;

            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                return;
            }

            // Validate file type
            if (!file.type.startsWith('image/')) {
                alert('File harus berupa gambar.');
                return;
            }

            // Create preview
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-img').src = e.target.result;
                document.getElementById('image-placeholder').classList.add('hidden');
                document.getElementById('image-preview').classList.remove('hidden');

                // Set the image path (in real implementation, you'd upload to server first)
                document.getElementById('featured_image').value = 'path/to/uploaded/image.jpg';

                updateSEOScore();
            };
            reader.readAsDataURL(file);
        }

        function changeImage() {
            document.getElementById('featured_image_file').click();
        }

        function removeImage() {
            document.getElementById('featured_image').value = '';
            document.getElementById('image-placeholder').classList.remove('hidden');
            document.getElementById('image-preview').classList.add('hidden');
            document.getElementById('featured_image_file').value = '';
            updateSEOScore();
        }

        // Text formatting functions (same as create page)
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

        // Undo/Redo functionality
        let contentHistory = [];
        let historyIndex = -1;

        function saveToHistory() {
            const content = document.getElementById('content').value;
            contentHistory = contentHistory.slice(0, historyIndex + 1);
            contentHistory.push(content);
            historyIndex = contentHistory.length - 1;

            // Limit history to 50 entries
            if (contentHistory.length > 50) {
                contentHistory.shift();
                historyIndex--;
            }
        }

        function undoChanges() {
            if (historyIndex > 0) {
                historyIndex--;
                document.getElementById('content').value = contentHistory[historyIndex];
                updateWordCount();
            }
        }

        function redoChanges() {
            if (historyIndex < contentHistory.length - 1) {
                historyIndex++;
                document.getElementById('content').value = contentHistory[historyIndex];
                updateWordCount();
            }
        }

        // SEO Scoring (same as create page but updated for edit)
        function initSEOScoring() {
            const inputs = ['title', 'excerpt', 'meta_title', 'meta_description', 'content'];
            inputs.forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    element.addEventListener('input', updateSEOScore);
                }
            });

            updateSEOScore();
        }

        function updateSEOScore() {
            const title = document.getElementById('title').value;
            const metaTitle = document.getElementById('meta_title').value;
            const metaDesc = document.getElementById('meta_description').value;
            const content = document.getElementById('content').value;
            const featuredImage = document.getElementById('featured_image').value;

            let score = 0;
            const checks = document.querySelectorAll('#seo-checklist .fas');

            // Title length (50-60 chars)
            if ((metaTitle || title).length >= 50 && (metaTitle || title).length <= 60) {
                score += 20;
                checks[0].className = 'fas fa-check-circle text-green-500 text-xs mr-2';
            } else {
                checks[0].className = 'fas fa-circle text-gray-400 text-xs mr-2';
            }

            // Meta description (150-160 chars)
            if (metaDesc.length >= 150 && metaDesc.length <= 160) {
                score += 20;
                checks[1].className = 'fas fa-check-circle text-green-500 text-xs mr-2';
            } else {
                checks[1].className = 'fas fa-circle text-gray-400 text-xs mr-2';
            }

            // Featured image
            if (featuredImage) {
                score += 20;
                checks[2].className = 'fas fa-check-circle text-green-500 text-xs mr-2';
            } else {
                checks[2].className = 'fas fa-circle text-gray-400 text-xs mr-2';
            }

            // Content length (min 300 words)
            const wordCount = content.trim().split(/\s+/).filter(word => word.length > 0).length;
            if (wordCount >= 300) {
                score += 20;
                checks[3].className = 'fas fa-check-circle text-green-500 text-xs mr-2';
            } else {
                checks[3].className = 'fas fa-circle text-gray-400 text-xs mr-2';
            }

            // Heading structure (has H2 or H3)
            if (content.includes('## ') || content.includes('### ')) {
                score += 20;
                checks[4].className = 'fas fa-check-circle text-green-500 text-xs mr-2';
            } else {
                checks[4].className = 'fas fa-circle text-gray-400 text-xs mr-2';
            }

            // Update score display
            const scoreElement = document.getElementById('seo-score');
            scoreElement.textContent = score;

            // Color coding
            if (score >= 80) {
                scoreElement.className = 'text-3xl font-bold text-green-600';
            } else if (score >= 60) {
                scoreElement.className = 'text-3xl font-bold text-yellow-600';
            } else {
                scoreElement.className = 'text-3xl font-bold text-red-600';
            }
        }

        // Save as draft
        function saveDraft() {
            // Set status to draft
            document.querySelector('input[name="is_published"][value="0"]').checked = true;

            // Submit form
            document.getElementById('post-form').submit();
        }

        // Preview functionality
        function previewPost() {
            const title = document.getElementById('title').value;
            const excerpt = document.getElementById('excerpt').value;
            const content = document.getElementById('content').value;
            const author = document.getElementById('author').value;
            const featuredImage = document.getElementById('featured_image').value;

            if (!title || !content) {
                alert('Judul dan konten harus diisi untuk preview');
                return;
            }

            // Create preview content
            const previewHTML = `
        <article class="max-w-4xl mx-auto">
            ${featuredImage ? `<img src="${featuredImage}" alt="${title}" class="w-full h-64 object-cover rounded-lg mb-6">` : ''}
            <header class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">${title}</h1>
                <div class="flex items-center text-gray-600 text-sm">
                    <span>Oleh ${author}</span>
                    <span class="mx-2">•</span>
                    <span><?= date('d M Y', strtotime($post['updated_at'])) ?></span>
                    <span class="mx-2">•</span>
                    <span>${Math.ceil(content.split(' ').length / 200)} menit membaca</span>
                </div>
            </header>

            ${excerpt ? `<div class="text-lg text-gray-700 mb-6 italic">${excerpt}</div>` : ''}

            <div class="prose prose-lg max-w-none">
                ${formatContentForPreview(content)}
            </div>
        </article>
    `;

            document.getElementById('preview-content').innerHTML = previewHTML;
            document.getElementById('preview-modal').classList.remove('hidden');
        }

        function closePreview() {
            document.getElementById('preview-modal').classList.add('hidden');
        }

        function formatContentForPreview(content) {
            // Basic markdown to HTML conversion for preview
            return content
                .replace(/### (.*$)/gm, '<h3>$1</h3>')
                .replace(/## (.*$)/gm, '<h2>$1</h2>')
                .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                .replace(/\*(.*?)\*/g, '<em>$1</em>')
                .replace(/\[(.*?)\]\((.*?)\)/g, '<a href="$2" class="text-blue-600 hover:underline">$1</a>')
                .replace(/!\[(.*?)\]\((.*?)\)/g, '<img src="$2" alt="$1" class="max-w-full h-auto rounded-lg my-4">')
                .replace(/^\- (.*$)/gm, '<li>$1</li>')
                .replace(/^(\d+)\. (.*$)/gm, '<li>$1</li>')
                .replace(/\n/g, '<br>');
        }

        // Duplicate post
        function duplicatePost() {
            if (!confirm('Duplikat artikel ini? Akan dibuat copy dengan status draft.')) return;

            showLoading();

            fetch(`/admin/blog/posts/duplicate/<?= $post['id'] ?>`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    hideLoading();
                    if (data.success) {
                        window.location.href = `/admin/blog/posts/edit/${data.new_post_id}`;
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    hideLoading();
                    alert('Terjadi kesalahan: ' + error);
                });
        }

        // SEO Analysis Modal
        function showSEOAnalysis() {
            const title = document.getElementById('title').value;
            const content = document.getElementById('content').value;
            const metaDesc = document.getElementById('meta_description').value;

            if (!title || !content) {
                alert('Judul dan konten harus diisi untuk analisis SEO');
                return;
            }

            // Simple SEO analysis
            const analysis = {
                titleLength: title.length,
                contentWordCount: content.split(' ').length,
                metaDescLength: metaDesc.length,
                hasHeadings: /##/.test(content),
                hasImages: /!\[/.test(content),
                hasLinks: /\[.*\]\(.*\)/.test(content)
            };

            const recommendations = [];

            if (analysis.titleLength < 50) {
                recommendations.push('Judul terlalu pendek. Sebaiknya 50-60 karakter.');
            } else if (analysis.titleLength > 60) {
                recommendations.push('Judul terlalu panjang. Sebaiknya 50-60 karakter.');
            }

            if (analysis.contentWordCount < 300) {
                recommendations.push('Konten terlalu pendek. Minimal 300 kata untuk SEO yang baik.');
            }

            if (analysis.metaDescLength < 150) {
                recommendations.push('Meta description terlalu pendek. Sebaiknya 150-160 karakter.');
            }

            if (!analysis.hasHeadings) {
                recommendations.push('Tambahkan heading (H2, H3) untuk struktur konten yang lebih baik.');
            }

            if (!analysis.hasImages) {
                recommendations.push('Tambahkan gambar untuk meningkatkan engagement.');
            }

            if (!analysis.hasLinks) {
                recommendations.push('Tambahkan link internal/eksternal yang relevan.');
            }

            const recommendationHTML = recommendations.length > 0
                ? recommendations.map(rec => `<li class="text-sm text-gray-600">${rec}</li>`).join('')
                : '<li class="text-sm text-green-600">SEO artikel sudah optimal!</li>';

            alert('Analisis SEO:\n\n' + recommendations.join('\n\n'));
        }

        // Share article functionality
        function shareArticle() {
            const title = document.getElementById('title').value;
            const url = `<?= base_url('/blog/' . $post['slug']) ?>`;

            if (navigator.share) {
                navigator.share({
                    title: title,
                    url: url
                });
            } else {
                // Fallback to copy URL
                navigator.clipboard.writeText(url).then(() => {
                    alert('URL artikel berhasil disalin ke clipboard!');
                });
            }
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

        // Auto-save functionality (setiap 60 detik untuk edit mode)
        let autoSaveInterval;

        function startAutoSave() {
            autoSaveInterval = setInterval(() => {
                const title = document.getElementById('title').value;
                const content = document.getElementById('content').value;

                if (title && content) {
                    // Auto-save via AJAX dengan proper error handling
                    autoSavePost();
                }
            }, 60000); // 60 seconds
        }

        function autoSavePost() {
            const form = document.getElementById('post-form');
            if (!form) return;

            const formData = new FormData(form);
            formData.append('auto_save', '1');

            // Add CSRF token manually
            const csrfToken = document.querySelector('input[name="csrf_test_name"]');
            if (csrfToken) {
                formData.append('csrf_test_name', csrfToken.value);
            }

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
                    // Don't show error to user for auto-save failures
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

        // Initialize content history for undo/redo
        function initContentHistory() {
            const content = document.getElementById('content').value;
            contentHistory = [content];
            historyIndex = 0;

            // Save to history on content change
            document.getElementById('content').addEventListener('input', function() {
                clearTimeout(this.saveTimeout);
                this.saveTimeout = setTimeout(() => {
                    saveToHistory();
                }, 1000);
            });
        }

        // Enhanced form submission handler with better error handling
        document.getElementById('post-form').addEventListener('submit', function(e) {
            console.log('Form submission triggered');

            // Stop auto-save during submission
            if (autoSaveInterval) {
                clearInterval(autoSaveInterval);
            }

            const isPublishing = document.querySelector('input[name="is_published"]:checked')?.value === '1';

            if (isPublishing) {
                // Validation for publishing
                const title = document.getElementById('title').value;
                const excerpt = document.getElementById('excerpt').value;
                const content = document.getElementById('content').value;
                const category = document.getElementById('category_id').value;

                console.log('Validation check:', { title: !!title, excerpt: !!excerpt, content: !!content, category: !!category });

                if (!title || !excerpt || !content || !category) {
                    e.preventDefault();
                    alert('Semua field wajib harus diisi untuk publikasi');
                    // Restart auto-save
                    startAutoSave();
                    return;
                }

                if (content.split(' ').length < 100) {
                    e.preventDefault();
                    if (!confirm('Konten artikel masih pendek. Yakin ingin publikasi?')) {
                        // Restart auto-save
                        startAutoSave();
                        return;
                    }
                }
            }

            // Mark as no unsaved changes
            hasUnsavedChanges = false;

            // Show loading with shorter timeout for form submission
            console.log('Showing loading for form submission');
            showLoadingWithTimeout();

            // Debug form data
            const formData = new FormData(this);
            console.log('Form action:', this.action);
            console.log('Form method:', this.method);

            // Shorter timeout for form submission
            setTimeout(() => {
                const spinner = document.getElementById('loading-spinner');
                if (spinner && !spinner.classList.contains('hidden')) {
                    console.warn('Form submission timeout, hiding loading');
                    hideLoadingWithTimeout();
                    alert('Proses update memakan waktu lama. Halaman akan di-refresh.');
                    // Auto refresh page
                    window.location.reload();
                }
            }, 10000); // Reduced to 10 seconds
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey || e.metaKey) {
                switch(e.key) {
                    case 's':
                        e.preventDefault();
                        document.getElementById('post-form').submit();
                        break;
                    case 'p':
                        e.preventDefault();
                        previewPost();
                        break;
                    case 'z':
                        if (!e.shiftKey) {
                            e.preventDefault();
                            undoChanges();
                        } else {
                            e.preventDefault();
                            redoChanges();
                        }
                        break;
                    case 'y':
                        e.preventDefault();
                        redoChanges();
                        break;
                }
            }
        });

        // Warn about unsaved changes
        let hasUnsavedChanges = false;

        function trackChanges() {
            const inputs = document.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                input.addEventListener('change', () => {
                    hasUnsavedChanges = true;
                });
            });
        }

        window.addEventListener('beforeunload', function(e) {
            if (hasUnsavedChanges) {
                e.preventDefault();
                e.returnValue = '';
                return 'Ada perubahan yang belum disimpan. Yakin ingin meninggalkan halaman?';
            }
        });

        // Initialize everything when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize content history first
            initContentHistory();

            // Start auto-save with delay to avoid immediate conflicts
            setTimeout(() => {
                startAutoSave();
            }, 5000); // Start auto-save after 5 seconds

            trackChanges();

            // Show keyboard shortcuts help
            console.log('Keyboard shortcuts:');
            console.log('Ctrl+S: Save');
            console.log('Ctrl+P: Preview');
            console.log('Ctrl+Z: Undo');
            console.log('Ctrl+Shift+Z / Ctrl+Y: Redo');
        });

        // Cleanup on page unload
        window.addEventListener('beforeunload', function() {
            if (autoSaveInterval) {
                clearInterval(autoSaveInterval);
            }
        });

        // Mark as saved when form is submitted
        document.getElementById('post-form').addEventListener('submit', function() {
            hasUnsavedChanges = false;
        });
    </script>
<?= $this->endSection() ?>