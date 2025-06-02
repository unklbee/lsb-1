<?php

// app/Controllers/Admin/ContactMessages.php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ContactMessageModel;

class ContactMessages extends BaseController
{
    protected $contactModel;

    public function __construct()
    {
        $this->contactModel = new ContactMessageModel();
    }

    public function index()
    {
        $this->checkAuth();

        $status = $this->request->getGet('status') ?: 'all';

        if ($status === 'all') {
            $messages = $this->contactModel->orderBy('created_at', 'DESC')->findAll();
        } else {
            $messages = $this->contactModel->getMessagesByStatus($status);
        }

        $stats = [
            'new' => $this->contactModel->where('status', 'new')->countAllResults(),
            'read' => $this->contactModel->where('status', 'read')->countAllResults(),
            'replied' => $this->contactModel->where('status', 'replied')->countAllResults(),
            'closed' => $this->contactModel->where('status', 'closed')->countAllResults(),
        ];

        $data = [
            'title' => 'Pesan Kontak',
            'messages' => $messages,
            'currentStatus' => $status,
            'stats' => $stats,
            'user' => session()->get('admin_user')
        ];

        return view('admin/contact/index', $data);
    }

    public function show($id)
    {
        $this->checkAuth();

        $message = $this->contactModel->find($id);
        if (!$message) {
            return redirect()->to('/admin/contact')->with('error', 'Pesan tidak ditemukan');
        }

        // Mark as read if status is new
        if ($message['status'] === 'new') {
            $this->contactModel->markAsRead($id);
            $message['status'] = 'read';
        }

        $data = [
            'title' => 'Detail Pesan',
            'message' => $message,
            'user' => session()->get('admin_user')
        ];

        return view('admin/contact/show', $data);
    }

    public function updateStatus($id)
    {
        $this->checkAuth();

        $status = $this->request->getPost('status');
        $notes = $this->request->getPost('admin_notes');

        $updateData = ['status' => $status];

        if ($notes) {
            $updateData['admin_notes'] = $notes;
        }

        if ($status === 'replied') {
            $updateData['replied_at'] = date('Y-m-d H:i:s');
        }

        if ($this->contactModel->update($id, $updateData)) {
            return redirect()->back()->with('success', 'Status pesan berhasil diupdate');
        } else {
            return redirect()->back()->with('error', 'Gagal mengupdate status pesan');
        }
    }

    public function delete($id)
    {
        $this->checkAuth();

        $message = $this->contactModel->find($id);
        if (!$message) {
            return $this->response->setJSON(['success' => false, 'message' => 'Pesan tidak ditemukan']);
        }

        if ($this->contactModel->delete($id)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Pesan berhasil dihapus']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus pesan']);
        }
    }

    private function checkAuth()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }
    }
}
