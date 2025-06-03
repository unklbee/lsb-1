<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

    <div class="p-6">
        <!-- Page Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Kelola Artikel Blog</h1>
                <p class="text-gray-600 mt-1">Kelola semua artikel blog, edit konten, dan publikasi</p>
            </div>

            <div class="flex space-x-3">
                <a href="/admin/blog/categories"
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    <i class="fas fa-tags mr-2"></i>
                    Kelola Kategori
                </a>
                <a href="/admin/blog/posts/create"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    Tulis Artikel Baru
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <i class="fas fa-newspaper text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Artikel</p>
                        <p class="text-2xl font-bold text-gray-900"><?= count($posts) ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Terpublikasi</p>
                        <p class="text-2xl font-bold text-gray-900">
                            <?= count(array_filter($posts, function ($post) {
                                return $post['is_published'] == 1;
                            })) ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <i class="fas fa-edit text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Draft</p>
                        <p class="text-2xl font-bold text-gray-900">
                            <?= count(array_filter($posts, function ($post) {
                                return $post['is_published'] == 0;
                            })) ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <i class="fas fa-star text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Featured</p>
                        <p class="text-2xl font-bold text-gray-900">
                            <?= count(array_filter($posts, function ($post) {
                                return $post['is_featured'] == 1;
                            })) ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="p-6 border-b border-gray-200">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                    <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-4">
                        <!-- Search -->
                        <div class="relative">
                            <input type="text"
                                   id="search-input"
                                   placeholder="Cari artikel..."
                                   class="w-full md:w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <select id="status-filter"
                                class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Status</option>
                            <option value="1">Terpublikasi</option>
                            <option value="0">Draft</option>
                        </select>

                        <!-- Category Filter -->
                        <select id="category-filter"
                                class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Kategori</option>
                            <?php
                            $categories = array_unique(array_column($posts, 'category_name'));
                            foreach ($categories as $category):
                                if ($category):
                                    ?>
                                    <option value="<?= $category ?>"><?= $category ?></option>
                                <?php
                                endif;
                            endforeach;
                            ?>
                        </select>
                    </div>

                    <div class="flex items-center space-x-2">
                        <!-- Bulk Actions -->
                        <select id="bulk-action"
                                class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Aksi Bulk</option>
                            <option value="publish">Publikasikan</option>
                            <option value="unpublish">Jadikan Draft</option>
                            <option value="feature">Jadikan Featured</option>
                            <option value="unfeature">Hapus Featured</option>
                            <option value="delete">Hapus</option>
                        </select>

                        <button onclick="executeBulkAction()"
                                class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors duration-200">
                            Jalankan
                        </button>
                    </div>
                </div>
            </div>

            <!-- Posts Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" id="select-all" class="rounded">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Artikel
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kategori
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Views
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (empty($posts)): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <i class="fas fa-newspaper text-4xl mb-4"></i>
                                    <p class="text-lg font-medium">Belum ada artikel</p>
                                    <p class="text-sm">Mulai dengan menulis artikel pertama Anda</p>
                                    <a href="/admin/blog/posts/create"
                                       class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                        <i class="fas fa-plus mr-2"></i>
                                        Tulis Artikel Baru
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($posts as $post): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" name="selected_posts[]" value="<?= $post['id'] ?>"
                                           class="rounded">
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-start space-x-3">
                                        <?php if (!empty($post['featured_image'])): ?>
                                            <img src="<?= $post['featured_image'] ?>"
                                                 alt="<?= esc($post['title']) ?>"
                                                 class="w-16 h-12 object-cover rounded">
                                        <?php else: ?>
                                            <div class="w-16 h-12 bg-gray-200 rounded flex items-center justify-center">
                                                <i class="fas fa-image text-gray-400"></i>
                                            </div>
                                        <?php endif; ?>

                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                <?= esc($post['title']) ?>
                                            </p>
                                            <p class="text-sm text-gray-500 truncate">
                                                <?= esc(substr(strip_tags($post['excerpt'] ?? ''), 0, 100)) ?>...
                                            </p>
                                            <div class="flex items-center mt-1 space-x-2 text-xs text-gray-400">
                                                <span><?= $post['author'] ?? 'Admin' ?></span>
                                                <span>•</span>
                                                <span><?= $post['reading_time'] ?? '5 menit' ?></span>
                                                <?php if ($post['is_featured']): ?>
                                                    <span>•</span>
                                                    <span class="text-yellow-500">
                                                        <i class="fas fa-star"></i> Featured
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if (!empty($post['category_name'])): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <?= esc($post['category_name']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-gray-400">-</span>
                                    <?php endif; ?>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if ($post['is_published']): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Published
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-edit mr-1"></i>
                                            Draft
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="flex items-center">
                                        <i class="fas fa-eye text-gray-400 mr-1"></i>
                                        <?= number_format($post['view_count'] ?? 0) ?>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div>
                                        <p><?= date('d M Y', strtotime($post['created_at'])) ?></p>
                                        <p class="text-xs text-gray-400">
                                            Update: <?= date('d M Y', strtotime($post['updated_at'])) ?>
                                        </p>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <!-- Quick Actions -->
                                        <?php if ($post['is_published']): ?>
                                            <a href="/blog/<?= $post['slug'] ?>"
                                               target="_blank"
                                               class="text-blue-600 hover:text-blue-900"
                                               title="Lihat">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        <?php endif; ?>

                                        <a href="/admin/blog/posts/edit/<?= $post['id'] ?>"
                                           class="text-indigo-600 hover:text-indigo-900"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <button onclick="duplicatePost(<?= $post['id'] ?>)"
                                                class="text-green-600 hover:text-green-900"
                                                title="Duplikat">
                                            <i class="fas fa-copy"></i>
                                        </button>

                                        <button onclick="togglePublish(<?= $post['id'] ?>, <?= $post['is_published'] ? 'false' : 'true' ?>)"
                                                class="text-<?= $post['is_published'] ? 'yellow' : 'green' ?>-600 hover:text-<?= $post['is_published'] ? 'yellow' : 'green' ?>-900"
                                                title="<?= $post['is_published'] ? 'Unpublish' : 'Publish' ?>">
                                            <i class="fas fa-<?= $post['is_published'] ? 'eye-slash' : 'eye' ?>"></i>
                                        </button>

                                        <button onclick="deletePost(<?= $post['id'] ?>, '<?= esc($post['title']) ?>')"
                                                class="text-red-600 hover:text-red-900"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination would go here if needed -->
            <?php if (count($posts) > 20): ?>
                <div class="px-6 py-3 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Showing 1 to <?= min(20, count($posts)) ?> of <?= count($posts) ?> results
                        </div>
                        <div class="flex space-x-2">
                            <button class="px-3 py-1 text-sm bg-gray-200 text-gray-600 rounded">Previous</button>
                            <button class="px-3 py-1 text-sm bg-blue-600 text-white rounded">1</button>
                            <button class="px-3 py-1 text-sm bg-gray-200 text-gray-600 rounded">Next</button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
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
                Apakah Anda yakin ingin menghapus artikel "<span id="delete-post-title"></span>"?
                Tindakan ini tidak dapat dibatalkan.
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
        let postToDelete = null;

        // Search functionality
        document.getElementById('search-input').addEventListener('input', function () {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const title = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase() || '';
                const category = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';

                if (title.includes(searchTerm) || category.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Status filter
        document.getElementById('status-filter').addEventListener('change', function () {
            const status = this.value;
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                if (!status) {
                    row.style.display = '';
                    return;
                }

                const statusElement = row.querySelector('td:nth-child(4) span');
                if (!statusElement) return;

                const isPublished = statusElement.textContent.includes('Published');
                const showRow = (status === '1' && isPublished) || (status === '0' && !isPublished);

                row.style.display = showRow ? '' : 'none';
            });
        });

        // Category filter
        document.getElementById('category-filter').addEventListener('change', function () {
            const category = this.value;
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                if (!category) {
                    row.style.display = '';
                    return;
                }

                const categoryElement = row.querySelector('td:nth-child(3)');
                const rowCategory = categoryElement?.textContent.trim() || '';

                row.style.display = rowCategory === category ? '' : 'none';
            });
        });

        // Select all functionality
        document.getElementById('select-all').addEventListener('change', function () {
            const checkboxes = document.querySelectorAll('input[name="selected_posts[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Bulk actions
        function executeBulkAction() {
            const action = document.getElementById('bulk-action').value;
            const checkedBoxes = document.querySelectorAll('input[name="selected_posts[]"]:checked');

            if (!action) {
                alert('Pilih aksi yang ingin dilakukan');
                return;
            }

            if (checkedBoxes.length === 0) {
                alert('Pilih minimal satu artikel');
                return;
            }

            const postIds = Array.from(checkedBoxes).map(cb => cb.value);

            if (action === 'delete') {
                if (!confirm(`Hapus ${postIds.length} artikel yang dipilih?`)) {
                    return;
                }
            }

            // Execute bulk action via AJAX
            showLoading();

            fetch('/admin/blog/posts/bulk-action', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    action: action,
                    post_ids: postIds
                })
            })
                .then(response => response.json())
                .then(data => {
                    hideLoading();
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    hideLoading();
                    alert('Terjadi kesalahan: ' + error);
                });
        }

        // Toggle publish status
        function togglePublish(postId, publish) {
            showLoading();

            fetch(`/admin/blog/posts/toggle-publish/${postId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({publish: publish})
            })
                .then(response => response.json())
                .then(data => {
                    hideLoading();
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    hideLoading();
                    alert('Terjadi kesalahan: ' + error);
                });
        }

        // Duplicate post
        function duplicatePost(postId) {
            if (!confirm('Duplikat artikel ini?')) return;

            showLoading();

            fetch(`/admin/blog/posts/duplicate/${postId}`, {
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

        // Delete post
        function deletePost(postId, title) {
            postToDelete = postId;
            document.getElementById('delete-post-title').textContent = title;
            document.getElementById('delete-modal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('delete-modal').classList.add('hidden');
            postToDelete = null;
        }

        function confirmDelete() {
            if (!postToDelete) return;

            showLoading();
            closeDeleteModal();

            fetch(`/admin/blog/posts/delete/${postToDelete}`, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    hideLoading();
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    hideLoading();
                    alert('Terjadi kesalahan: ' + error);
                });
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function (e) {
            if (e.ctrlKey || e.metaKey) {
                switch (e.key) {
                    case 'n':
                        e.preventDefault();
                        window.location.href = '/admin/blog/posts/create';
                        break;
                    case 'f':
                        e.preventDefault();
                        document.getElementById('search-input').focus();
                        break;
                }
            }
        });

        // Auto-save draft functionality (if needed)
        function autoSave() {
            // Implementation for auto-saving drafts
            console.log('Auto-save functionality can be implemented here');
        }

        // Initialize tooltips or other UI enhancements
        document.addEventListener('DOMContentLoaded', function () {
            // Add any initialization code here
            console.log('Blog posts management loaded');
        });
    </script>
<?= $this->endSection() ?>