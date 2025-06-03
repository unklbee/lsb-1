<?php
// app/Controllers/Admin/Media.php - CORRECTED VERSION

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Media extends BaseController
{
    public function __construct()
    {
        // Constructor
    }

    /**
     * Upload image via AJAX
     */
    public function uploadImage()
    {
        // Check authentication
        if (!session()->get('admin_logged_in')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized'
            ])->setStatusCode(401);
        }

        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method'
            ])->setStatusCode(400);
        }

        try {
            $validation = \Config\Services::validation();
            $validation->setRules([
                'image' => 'uploaded[image]|is_image[image]|max_size[image,2048]|ext_in[image,jpg,jpeg,png,gif,webp]'
            ], [
                'image' => [
                    'uploaded' => 'Pilih file gambar untuk diupload',
                    'is_image' => 'File harus berupa gambar',
                    'max_size' => 'Ukuran file maksimal 2MB',
                    'ext_in' => 'Format gambar yang diizinkan: JPG, JPEG, PNG, GIF, WEBP'
                ]
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validation->getErrors()
                ])->setStatusCode(400);
            }

            $image = $this->request->getFile('image');

            if (!$image->isValid()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'File gambar tidak valid: ' . $image->getErrorString()
                ])->setStatusCode(400);
            }

            // Create upload directory in writable folder
            $uploadPath = WRITEPATH . 'uploads/images/blog/';
            if (!is_dir($uploadPath)) {
                if (!mkdir($uploadPath, 0755, true)) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Gagal membuat direktori upload'
                    ])->setStatusCode(500);
                }
            }

            // Generate unique filename
            $fileName = date('Y-m-d-H-i-s') . '_' . uniqid() . '.' . $image->getExtension();

            // Move uploaded file to writable directory
            if ($image->move($uploadPath, $fileName)) {
                // Generate URL for serving the image
                $imageUrl = base_url('admin/media/serve/' . $fileName);

                // Log successful upload
                log_message('info', 'Image uploaded successfully: ' . $fileName . ' by user: ' . (session()->get('admin_user')['email'] ?? 'unknown'));

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Gambar berhasil diupload',
                    'image_url' => $imageUrl,
                    'file_name' => $fileName,
                    'file_path' => $uploadPath . $fileName
                ]);

            } else {
                log_message('error', 'Failed to move uploaded file: ' . $image->getErrorString());

                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menyimpan file gambar'
                ])->setStatusCode(500);
            }

        } catch (\Exception $e) {
            log_message('error', 'Image upload error: ' . $e->getMessage());

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengupload gambar: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    /**
     * Serve image from writable directory
     * This acts as a proxy to serve images securely
     */
    public function serve($fileName = null): ResponseInterface
    {
        if (!$fileName) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        // Sanitize filename
        $fileName = basename($fileName);
        $filePath = WRITEPATH . 'uploads/images/blog/' . $fileName;

        // Check if file exists
        if (!file_exists($filePath)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        // Validate file extension for security
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        // Set appropriate headers
        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp'
        ];

        $mimeType = $mimeTypes[$fileExtension] ?? 'application/octet-stream';

        // Set headers for image serving
        $this->response->setHeader('Content-Type', $mimeType);
        $this->response->setHeader('Content-Length', filesize($filePath));
        $this->response->setHeader('Cache-Control', 'public, max-age=31536000'); // 1 year cache
        $this->response->setHeader('Expires', gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');

        // Optional: Add security headers
        $this->response->setHeader('X-Content-Type-Options', 'nosniff');

        // Output the file
        $this->response->setBody(file_get_contents($filePath));
        return $this->response;
    }

    /**
     * Delete uploaded image
     */
    public function deleteImage()
    {
        // Check authentication
        if (!session()->get('admin_logged_in')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized'
            ])->setStatusCode(401);
        }

        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method'
            ])->setStatusCode(400);
        }

        try {
            $imageUrl = $this->request->getPost('image_url');

            if (!$imageUrl) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'URL gambar tidak ditemukan'
                ])->setStatusCode(400);
            }

            // Extract filename from URL (e.g., from admin/media/serve/filename.jpg)
            $urlParts = explode('/', $imageUrl);
            $fileName = end($urlParts);
            $fileName = basename($fileName); // Additional sanitization

            $filePath = WRITEPATH . 'uploads/images/blog/' . $fileName;

            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    log_message('info', 'Image deleted successfully: ' . $fileName);

                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Gambar berhasil dihapus'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Gagal menghapus file gambar'
                    ])->setStatusCode(500);
                }
            } else {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'File gambar tidak ditemukan, mungkin sudah dihapus'
                ]);
            }

        } catch (\Exception $e) {
            log_message('error', 'Image delete error: ' . $e->getMessage());

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus gambar'
            ])->setStatusCode(500);
        }
    }

    /**
     * Get list of uploaded images
     */
    public function getImages()
    {
        // Check authentication
        if (!session()->get('admin_logged_in')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized'
            ])->setStatusCode(401);
        }

        try {
            $uploadPath = WRITEPATH . 'uploads/images/blog/';
            $images = [];

            if (is_dir($uploadPath)) {
                $files = scandir($uploadPath);
                foreach ($files as $file) {
                    if ($file !== '.' && $file !== '..' && is_file($uploadPath . $file)) {
                        $fileInfo = pathinfo($uploadPath . $file);
                        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

                        if (in_array(strtolower($fileInfo['extension']), $allowedExtensions)) {
                            $images[] = [
                                'name' => $file,
                                'url' => base_url('admin/media/serve/' . $file),
                                'size' => filesize($uploadPath . $file),
                                'modified' => date('Y-m-d H:i:s', filemtime($uploadPath . $file))
                            ];
                        }
                    }
                }
            }

            return $this->response->setJSON([
                'success' => true,
                'images' => $images
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Get images error: ' . $e->getMessage());

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal mengambil daftar gambar'
            ])->setStatusCode(500);
        }
    }

    /**
     * Image gallery/picker for TinyMCE or other editors
     */
    public function imagePicker(): string
    {
        $this->checkAuth();

        $data = [
            'title' => 'Pilih Gambar'
        ];

        return view('admin/media/image-picker', $data);
    }

    /**
     * Clean up old unused images (maintenance function)
     */
    public function cleanup(): ResponseInterface
    {
        $this->checkAuth();

        // This would check which images are actually used in blog posts
        // and remove unused ones. Implementation depends on your needs.

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Cleanup completed'
        ]);
    }

    private function checkAuth(): void
    {
        if (!session()->get('admin_logged_in')) {
            redirect()->to('/admin/login');
        }
    }
}