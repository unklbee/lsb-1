<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

    <div class="p-6">
        <!-- Page Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Kategori Blog</h1>
                <p class="text-gray-600 mt-1">Kelola kategori untuk mengorganisir artikel blog</p>
            </div>

            <div class="flex space-x-3">
                <a href="/admin/blog/posts"
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Posts
                </a>
                <a href="/admin/blog/categories/create"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Kategori
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <i class="fas fa-tags text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Kategori</p>
                        <p class="text-2xl font-bold text-gray-900"><?= count($categories ?? []) ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <i class="fas fa-eye text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Aktif</p>
                        <p class="text-2xl font-bold text-gray-900">
                            <?= count(array_filter($categories ?? [], function ($cat) {
                                return $cat['is_active'] == 1;
                            })) ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <i class="fas fa-newspaper text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Posts</p>
                        <p class="text-2xl font-bold text-gray-900"><?= $totalPosts ?? 0 ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <i class="fas fa-chart-bar text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Avg Posts/Kategori</p>
                        <p class="text-2xl font-bold text-gray-900">
                            <?= count($categories ?? []) > 0 ? round(($totalPosts ?? 0) / count($categories), 1) : 0 ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-lg shadow">
            <!-- Filters and Actions -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                    <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-4">
                        <!-- Search -->
                        <div class="relative">
                            <input type="text"
                                   id="search-input"
                                   placeholder="Cari kategori..."
                                   class="w-full md:w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <select id="status-filter"
                                class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Status</option>
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>

                    <div class="flex items-center space-x-2">
                        <!-- Bulk Actions -->
                        <select id="bulk-action"
                                class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Aksi Bulk</option>
                            <option value="activate">Aktifkan</option>
                            <option value="deactivate">Nonaktifkan</option>
                            <option value="delete">Hapus</option>
                        </select>

                        <button onclick="executeBulkAction()"
                                class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors duration-200">
                            Jalankan
                        </button>
                    </div>
                </div>
            </div>

            <!-- Categories Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" id="select-all" class="rounded">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kategori
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Slug
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jumlah Post
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Urutan
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
                    <?php if (empty($categories)): ?>
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <i class="fas fa-tags text-4xl mb-4"></i>
                                    <p class="text-lg font-medium">Belum ada kategori</p>
                                    <p class="text-sm">Buat kategori pertama untuk mengorganisir artikel blog</p>
                                    <a href="/admin/blog/categories/create"
                                       class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                        <i class="fas fa-plus mr-2"></i>
                                        Buat Kategori Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($categories as $category): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" name="selected_categories[]" value="<?= $category['id'] ?>"
                                           class="rounded">
                                </td>

                                <td class="px-6 py-4">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">
                                            <?= esc($category['name']) ?>
                                        </div>
                                        <?php if (!empty($category['description'])): ?>
                                            <div class="text-sm text-gray-500 mt-1">
                                                <?= esc(substr($category['description'], 0, 100)) ?><?= strlen($category['description']) > 100 ? '...' : '' ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <code class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-sm">
                                        <?= esc($category['slug']) ?>
                                    </code>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center">
                                        <span class="text-sm font-medium text-gray-900">
                                            <?= $category['post_count'] ?? 0 ?>
                                        </span>
                                        <?php if (($category['post_count'] ?? 0) > 0): ?>
                                            <a href="/admin/blog/posts?category=<?= $category['id'] ?>"
                                               class="ml-2 text-blue-600 hover:text-blue-800"
                                               title="Lihat posts">
                                                <i class="fas fa-external-link-alt text-xs"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if ($category['is_active']): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Aktif
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Nonaktif
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <span><?= $category['sort_order'] ?? 0 ?></span>
                                        <div class="flex flex-col">
                                            <button onclick="moveCategory(<?= $category['id'] ?>, 'up')"
                                                    class="text-gray-400 hover:text-gray-600"
                                                    title="Pindah ke atas">
                                                <i class="fas fa-chevron-up text-xs"></i>
                                            </button>
                                            <button onclick="moveCategory(<?= $category['id'] ?>, 'down')"
                                                    class="text-gray-400 hover:text-gray-600"
                                                    title="Pindah ke bawah">
                                                <i class="fas fa-chevron-down text-xs"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div>
                                        <p><?= date('d M Y', strtotime($category['created_at'])) ?></p>
                                        <p class="text-xs text-gray-400">
                                            Update: <?= date('d M Y', strtotime($category['updated_at'])) ?>
                                        </p>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <!-- View on frontend -->
                                        <a href="/blog/category/<?= $category['slug'] ?>"
                                           target="_blank"
                                           class="text-blue-600 hover:text-blue-900"
                                           title="Lihat di website">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>

                                        <!-- Edit -->
                                        <a href="/admin/blog/categories/edit/<?= $category['id'] ?>"
                                           class="text-indigo-600 hover:text-indigo-900"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Toggle Status -->
                                        <button onclick="toggleStatus(<?= $category['id'] ?>, <?= $category['is_active'] ? 'false' : 'true' ?>)"
                                                class="text-<?= $category['is_active'] ? 'yellow' : 'green' ?>-600 hover:text-<?= $category['is_active'] ? 'yellow' : 'green' ?>-900"
                                                title="<?= $category['is_active'] ? 'Nonaktifkan' : 'Aktifkan' ?>">
                                            <i class="fas fa-<?= $category['is_active'] ? 'eye-slash' : 'eye' ?>"></i>
                                        </button>

                                        <!-- Delete -->
                                        <button onclick="deleteCategory(<?= $category['id'] ?>, '<?= esc($category['name']) ?>', <?= $category['post_count'] ?? 0 ?>)"
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

            <!-- Pagination (if needed) -->
            <?php if (count($categories) > 20): ?>
                <div class="px-6 py-3 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Showing 1 to <?= min(20, count($categories)) ?> of <?= count($categories) ?> results
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
                <h3 class="text-lg font-medium text-gray-900">Hapus Kategori</h3>
            </div>

            <div id="delete-content">
                <!-- Content will be filled by JavaScript -->
            </div>

            <div class="flex justify-end space-x-3 mt-6">
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

    <!-- Move Category Modal -->
    <div id="move-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-arrows-alt text-blue-600"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Atur Urutan Kategori</h3>
            </div>

            <div class="mb-4">
                <label for="new-sort-order" class="block text-sm font-medium text-gray-700 mb-2">
                    Urutan Baru
                </label>
                <input type="number"
                       id="new-sort-order"
                       min="0"
                       max="999"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <p class="mt-1 text-sm text-gray-500">Angka yang lebih kecil akan muncul lebih dulu</p>
            </div>

            <div class="flex justify-end space-x-3">
                <button onclick="closeMoveModal()"
                        class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors duration-200">
                    Batal
                </button>
                <button onclick="confirmMove()"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    Simpan
                </button>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
    <script>
        let categoryToDelete = null;
        let categoryToMove = null;

        // Search functionality
        document.getElementById('search-input').addEventListener('input', function () {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const name = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase() || '';
                const slug = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';

                if (name.includes(searchTerm) || slug.includes(searchTerm)) {
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

                const statusElement = row.querySelector('td:nth-child(5) span');
                if (!statusElement) return;

                const isActive = statusElement.textContent.includes('Aktif');
                const showRow = (status === '1' && isActive) || (status === '0' && !isActive);

                row.style.display = showRow ? '' : 'none';
            });
        });

        // Select all functionality
        document.getElementById('select-all').addEventListener('change', function () {
            const checkboxes = document.querySelectorAll('input[name="selected_categories[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Bulk actions
        function executeBulkAction() {
            const action = document.getElementById('bulk-action').value;
            const checkedBoxes = document.querySelectorAll('input[name="selected_categories[]"]:checked');

            if (!action) {
                alert('Pilih aksi yang ingin dilakukan');
                return;
            }

            if (checkedBoxes.length === 0) {
                alert('Pilih minimal satu kategori');
                return;
            }

            const categoryIds = Array.from(checkedBoxes).map(cb => cb.value);

            if (action === 'delete') {
                if (!confirm(`Hapus ${categoryIds.length} kategori yang dipilih?`)) {
                    return;
                }
            }

            // Execute bulk action via AJAX
            showLoading();

            fetch('/admin/blog/categories/bulk-action', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    action: action,
                    category_ids: categoryIds
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

        // Toggle category status
        function toggleStatus(categoryId, activate) {
            showLoading();

            fetch(`/admin/blog/categories/toggle-status/${categoryId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({activate: activate})
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

        // Move category
        function moveCategory(categoryId, direction) {
            categoryToMove = categoryId;

            // Get current sort order
            const row = document.querySelector(`input[value="${categoryId}"]`).closest('tr');
            const currentOrder = parseInt(row.querySelector('td:nth-child(6) span').textContent);

            let newOrder;
            if (direction === 'up') {
                newOrder = Math.max(0, currentOrder - 1);
            } else {
                newOrder = currentOrder + 1;
            }

            document.getElementById('new-sort-order').value = newOrder;
            document.getElementById('move-modal').classList.remove('hidden');
        }

        function closeMoveModal() {
            document.getElementById('move-modal').classList.add('hidden');
            categoryToMove = null;
        }

        function confirmMove() {
            const newOrder = document.getElementById('new-sort-order').value;

            if (!categoryToMove || !newOrder) return;

            showLoading();
            closeMoveModal();

            fetch(`/admin/blog/categories/update-order/${categoryToMove}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({sort_order: parseInt(newOrder)})
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

        // Delete category
        function deleteCategory(categoryId, categoryName, postCount) {
            categoryToDelete = categoryId;

            let deleteContent = `
        <p class="text-gray-600 mb-4">
            Apakah Anda yakin ingin menghapus kategori "<strong>${categoryName}</strong>"?
        </p>
    `;

            if (postCount > 0) {
                deleteContent += `
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
                <div class="flex">
                    <i class="fas fa-exclamation-triangle text-yellow-400 mr-2 mt-0.5"></i>
                    <div>
                        <p class="text-yellow-800 font-medium">Perhatian!</p>
                        <p class="text-yellow-700 text-sm">
                            Kategori ini memiliki <strong>${postCount} artikel</strong>.
                            Artikel-artikel tersebut akan menjadi tanpa kategori.
                        </p>
                    </div>
                </div>
            </div>
        `;
            }

            deleteContent += `<p class="text-gray-600">Tindakan ini tidak dapat dibatalkan.</p>`;

            document.getElementById('delete-content').innerHTML = deleteContent;
            document.getElementById('delete-modal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('delete-modal').classList.add('hidden');
            categoryToDelete = null;
        }

        function confirmDelete() {
            if (!categoryToDelete) return;

            showLoading();
            closeDeleteModal();

            fetch(`/admin/blog/categories/delete/${categoryToDelete}`, {
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
                        window.location.href = '/admin/blog/categories/create';
                        break;
                    case 'f':
                        e.preventDefault();
                        document.getElementById('search-input').focus();
                        break;
                }
            }
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function () {
            console.log('Categories management loaded');

            // Show shortcuts info
            console.log('Keyboard shortcuts:');
            console.log('Ctrl+N: New category');
            console.log('Ctrl+F: Focus search');
        });
    </script>
<?= $this->endSection() ?>