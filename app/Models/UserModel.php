<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'username', 'email', 'password', 'first_name', 'last_name',
        'role', 'avatar', 'is_active', 'last_login'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    public function getActiveUsers(): array
    {
        return $this->where('is_active', 1)->findAll();
    }

    public function authenticate($username, $password): object|bool|array|null
    {
        $user = $this->where('username', $username)
            ->orWhere('email', $username)
            ->where('is_active', 1)
            ->first();

        if ($user && password_verify($password, $user['password'])) {
            $this->updateLastLogin($user['id']);
            unset($user['password']);
            return $user;
        }

        return false;
    }

    public function updateLastLogin($id): bool
    {
        return $this->update($id, ['last_login' => date('Y-m-d H:i:s')]);
    }

    protected function hashPassword(array $data): array
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }
}