<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactMessageModel extends Model
{
    protected $table = 'contact_messages';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'name', 'email', 'phone', 'service_type', 'subject', 'message',
        'ip_address', 'user_agent', 'status', 'admin_notes', 'replied_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getNewMessages()
    {
        return $this->where('status', 'new')
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    public function getMessagesByStatus($status)
    {
        return $this->where('status', $status)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    public function markAsRead($id)
    {
        return $this->update($id, ['status' => 'read']);
    }

    public function markAsReplied($id, $notes = null)
    {
        return $this->update($id, [
            'status' => 'replied',
            'replied_at' => date('Y-m-d H:i:s'),
            'admin_notes' => $notes
        ]);
    }
}
