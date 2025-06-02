<?php

// app/Controllers/Admin/Services.php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ServiceModel;

class Services extends BaseController
{
    protected $serviceModel;

    public function __construct()
    {
        $this->serviceModel = new ServiceModel();
    }

    public function index()
    {
        $this->checkAuth();

        $services = $this->serviceModel->orderBy('sort_order', 'ASC')->findAll();

        $data = [
            'title' => 'Kelola Layanan',
            'services' => $services,
            'user' => session()->get('admin_user')
        ];

        return view('admin/services/index', $data);
    }

    public function create()
    {
        $this->checkAuth();

        $data = [
            'title' => 'Tambah Layanan',
            'user' => session()->get('admin_user')
        ];

        return view('admin/services/create', $data);
    }

    public function store()
    {
        $this->checkAuth();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|max_length[255]',
            'short_description' => 'required',
            'description' => 'required',
            'price_start' => 'required|max_length[100]',
            'duration' => 'required|max_length[100]',
            'warranty' => 'required|max_length[100]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'slug' => $this->request->getPost('slug') ?: url_title(strtolower($this->request->getPost('name')), '-', true),
            'short_description' => $this->request->getPost('short_description'),
            'description' => $this->request->getPost('description'),
            'features' => json_encode($this->request->getPost('features') ?: []),
            'benefits' => json_encode($this->request->getPost('benefits') ?: []),
            'process' => json_encode($this->request->getPost('process') ?: []),
            'price_start' => $this->request->getPost('price_start'),
            'duration' => $this->request->getPost('duration'),
            'warranty' => $this->request->getPost('warranty'),
            'icon' => $this->request->getPost('icon'),
            'featured_image' => $this->request->getPost('featured_image'),
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
            'meta_keywords' => $this->request->getPost('meta_keywords'),
            'is_popular' => $this->request->getPost('is_popular') ? 1 : 0,
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'sort_order' => $this->request->getPost('sort_order') ?: 0
        ];

        if ($this->serviceModel->insert($data)) {
            return redirect()->to('/admin/services')->with('success', 'Layanan berhasil ditambahkan');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan layanan');
        }
    }

    public function edit($id)
    {
        $this->checkAuth();

        $service = $this->serviceModel->find($id);
        if (!$service) {
            return redirect()->to('/admin/services')->with('error', 'Layanan tidak ditemukan');
        }

        // Decode JSON fields
        $service['features'] = json_decode($service['features'], true) ?: [];
        $service['benefits'] = json_decode($service['benefits'], true) ?: [];
        $service['process'] = json_decode($service['process'], true) ?: [];

        $data = [
            'title' => 'Edit Layanan',
            'service' => $service,
            'user' => session()->get('admin_user')
        ];

        return view('admin/services/edit', $data);
    }

    public function update($id)
    {
        $this->checkAuth();

        $service = $this->serviceModel->find($id);
        if (!$service) {
            return redirect()->to('/admin/services')->with('error', 'Layanan tidak ditemukan');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|max_length[255]',
            'short_description' => 'required',
            'description' => 'required',
            'price_start' => 'required|max_length[100]',
            'duration' => 'required|max_length[100]',
            'warranty' => 'required|max_length[100]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'slug' => $this->request->getPost('slug') ?: url_title(strtolower($this->request->getPost('name')), '-', true),
            'short_description' => $this->request->getPost('short_description'),
            'description' => $this->request->getPost('description'),
            'features' => json_encode($this->request->getPost('features') ?: []),
            'benefits' => json_encode($this->request->getPost('benefits') ?: []),
            'process' => json_encode($this->request->getPost('process') ?: []),
            'price_start' => $this->request->getPost('price_start'),
            'duration' => $this->request->getPost('duration'),
            'warranty' => $this->request->getPost('warranty'),
            'icon' => $this->request->getPost('icon'),
            'featured_image' => $this->request->getPost('featured_image'),
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
            'meta_keywords' => $this->request->getPost('meta_keywords'),
            'is_popular' => $this->request->getPost('is_popular') ? 1 : 0,
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'sort_order' => $this->request->getPost('sort_order') ?: 0
        ];

        if ($this->serviceModel->update($id, $data)) {
            return redirect()->to('/admin/services')->with('success', 'Layanan berhasil diupdate');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengupdate layanan');
        }
    }

    public function delete($id)
    {
        $this->checkAuth();

        $service = $this->serviceModel->find($id);
        if (!$service) {
            return $this->response->setJSON(['success' => false, 'message' => 'Layanan tidak ditemukan']);
        }

        if ($this->serviceModel->delete($id)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Layanan berhasil dihapus']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus layanan']);
        }
    }

    private function checkAuth()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }
    }
}
