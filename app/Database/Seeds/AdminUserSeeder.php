<?php
// app/Database/Seeds/AdminUserSeeder.php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $userModel = new \App\Models\UserModel();

        // Check if admin user already exists
        $existingAdmin = $userModel->where('email', 'admin@laptopservice.com')->first();

        if (!$existingAdmin) {
            $data = [
                'username' => 'admin',
                'email' => 'admin@laptopservice.com',
                'password' => 'admin123', // Will be hashed by model
                'first_name' => 'Admin',
                'last_name' => 'LaptopService',
                'role' => 'super_admin',
                'is_active' => 1,
            ];

            $userModel->insert($data);

            echo "Default admin user created:\n";
            echo "Email: admin@laptopservice.com\n";
            echo "Password: admin123\n";
            echo "Please change the password after first login!\n";
        } else {
            echo "Admin user already exists.\n";
        }
    }
}