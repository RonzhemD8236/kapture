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
            ['fname' => 'Kyla',     'lname' => 'Baguis',    'email' => 'kyla.baguis@email.com',    'password' => 'password123', 'role' => 'admin',    'is_active' => true],
            ['fname' => 'Ronzhem',  'lname' => 'Dioso',     'email' => 'ronzhem.dioso@email.com',  'password' => 'password123', 'role' => 'admin',    'is_active' => true],
            ['fname' => 'Princess', 'lname' => 'Cruz',      'email' => 'princess.cruz@email.com',  'password' => 'password123', 'role' => 'customer', 'is_active' => true],
            ['fname' => 'Arnold',   'lname' => 'Reyes',     'email' => 'arnold.reyes@email.com',   'password' => 'password123', 'role' => 'customer', 'is_active' => true],
            ['fname' => 'Juan',     'lname' => 'Dela Cruz', 'email' => 'juan.dela.cruz@email.com', 'password' => 'password123', 'role' => 'customer', 'is_active' => false],
        ];

        foreach ($users as $u) {
            DB::table('users')->updateOrInsert(
                ['email' => $u['email']],
                [
                    'fname'         => $u['fname'],
                    'lname'         => $u['lname'],
                    'name'          => $u['fname'] . ' ' . $u['lname'],
                    'password'      => Hash::make($u['password']),
                    'role'          => $u['role'],
                    'is_active'     => $u['is_active'],
                    'profile_photo' => 'default.jpg',
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]
            );
        }
    }
}