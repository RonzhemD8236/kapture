<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'email'       => 'princess.cruz@email.com',
                'title'       => 'Ms',
                'fname'       => 'Princess',
                'lname'       => 'Cruz',
                'addressline' => '789 Pine Rd',
                'town'        => 'Chicago',
                'zipcode'     => '60601',
                'phone'       => '555-003-0003',
            ],
            [
                'email'       => 'arnold.reyes@email.com',
                'title'       => 'Mr',
                'fname'       => 'Arnold',
                'lname'       => 'Reyes',
                'addressline' => '321 Elm St',
                'town'        => 'Houston',
                'zipcode'     => '77001',
                'phone'       => '555-004-0004',
            ],
            [
                'email'       => 'juan.dela.cruz@email.com',
                'title'       => 'Mr',
                'fname'       => 'Juan',
                'lname'       => 'Dela Cruz',
                'addressline' => '654 Maple Dr',
                'town'        => 'Phoenix',
                'zipcode'     => '85001',
                'phone'       => '555-005-0005',
            ],
        ];

        foreach ($customers as $data) {
            $user = DB::table('users')->where('email', $data['email'])->first();

            if (!$user) continue;

            DB::table('customer')->updateOrInsert(
                ['user_id' => $user->id],
                [
                    'title'       => $data['title'],
                    'fname'       => $data['fname'],
                    'lname'       => $data['lname'],
                    'addressline' => $data['addressline'],
                    'town'        => $data['town'],
                    'zipcode'     => $data['zipcode'],
                    'phone'       => $data['phone'],
                    'user_id'     => $user->id,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]
            );
        }
    }
}