<?php

// app/Controllers/Admin/Testimonials.php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TestimonialModel;

class Testimonials extends BaseController
{
    protected $testimonialModel;

    public function __construct()
    {
        $this->testimonialModel = new TestimonialModel();
    }

    public function index()
    {
        $this->checkAuth();

        $testimonials = $this->testimonialModel->orderBy('created_at', 'DESC')->findAll();

        $data = [
            'title' => 'Kelola Testimoni',
            'testimonials' => $testimonials,
            'user' => session()->get('admin_user')
        ];

        return view('admin/testimonials/index', $data);
    }

    public function create()
    {
        $this->checkAuth();

        $data = [
            'title' => 'Tambah Testimoni',
            'user' => session()->get('admin_user')
        ];

        return view('admin/testimonials/create', $data);
    }

    public function store()
    {
        $this->checkAuth();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|max_length[255]',
            'service_type' => 'required|max_length[255]',
            'rating' => 'required|integer|greater_than[0]|less_than[6]',
            'comment' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'location' => $this->request->getPost('location'),
            'service_type' => $this->request->getPost('service_type'),
            'rating' => $this->request->getPost('rating'),
            'comment' => $this->request->getPost('comment'),
            'photo' => $this->request->getPost('photo'),
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
            'is_published' => $this->request->getPost('is_published') ? 1 : 0,
            'sort_order' => $this->request->getPost('sort_order') ?: 0
        ];

        if ($this->testimonialModel->insert($data)) {
            return redirect()->to('/admin/testimonials')->with('success', 'Testimoni berhasil ditambahkan');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan testimoni');
        }
    }

    public function edit($id)
    {
        $this->checkAuth();

        $testimonial = $this->testimonialModel->find($id);
        if (!$testimonial) {
            return redirect()->to('/admin/testimonials')->with('error', 'Testimoni tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Testimoni',
            'testimonial' => $testimonial,
            'user' => session()->get('admin_user')
        ];

        return view('admin/testimonials/edit', $data);
    }

    public function update($id)
    {
        $this->checkAuth();

        $testimonial = $this->testimonialModel->find($id);
        if (!$testimonial) {
            return redirect()->to('/admin/testimonials')->with('error', 'Testimoni tidak ditemukan');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|max_length[255]',
            'service_type' => 'required|max_length[255]',
            'rating' => 'required|integer|greater_than[0]|less_than[6]',
            'comment' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'location' => $this->request->getPost('location'),
            'service_type' => $this->request->getPost('service_type'),
            'rating' => $this->request->getPost('rating'),
            'comment' => $this->request->getPost('comment'),
            'photo' => $this->request->getPost('photo'),
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
            'is_published' => $this->request->getPost('is_published') ? 1 : 0,
            'sort_order' => $this->request->getPost('sort_order') ?: 0
        ];

        if ($this->testimonialModel->update($id, $data)) {
            return redirect()->to('/admin/testimonials')->with('success', 'Testimoni berhasil diupdate');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengupdate testimoni');
        }
    }

    public function delete($id)
    {
        $this->checkAuth();

        $testimonial = $this->testimonialModel->find($id);
        if (!$testimonial) {
            return $this->response->setJSON(['success' => false, 'message' => 'Testimoni tidak ditemukan']);
        }

        if ($this->testimonialModel->delete($id)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Testimoni berhasil dihapus']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus testimoni']);
        }
    }

    private function checkAuth()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }
    }
}