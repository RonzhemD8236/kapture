<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Kyla Baguis',    'email' => 'kyla.baguis@email.com',    'password' => 'password123', 'role' => 'admin',    'is_active' => true],
            ['name' => 'Ronzhem Dioso',  'email' => 'ronzhem.dioso@email.com',  'password' => 'password123', 'role' => 'admin',    'is_active' => true],
            ['name' => 'Princess Cruz',  'email' => 'princess.cruz@email.com',  'password' => 'password123', 'role' => 'customer', 'is_active' => true],
            ['name' => 'Arnold Reyes',   'email' => 'arnold.reyes@email.com',   'password' => 'password123', 'role' => 'customer', 'is_active' => true],
            ['name' => 'Juan Dela Cruz', 'email' => 'juan.dela.cruz@email.com', 'password' => 'password123', 'role' => 'customer', 'is_active' => false],
        ];

        foreach ($users as $userData) {
            DB::table('users')->updateOrInsert(
                ['email' => $userData['email']],
                [
                    'name'       => $userData['name'],
                    'password'   => Hash::make($userData['password']),
                    'role'       => $userData['role'],
                    'is_active'  => $userData['is_active'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}