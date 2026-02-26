<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Kyla Baguis',    'email' => 'kyla.baguis@email.com',   'password' => 'password123'],
            ['name' => 'Ronzhem Dioso',  'email' => 'ronzhem.dioso@email.com', 'password' => 'password123'],
            ['name' => 'Princess Cruz',  'email' => 'princess.cruz@email.com', 'password' => 'password123'],
            ['name' => 'Arnold Reyes',   'email' => 'arnold.reyes@email.com',  'password' => 'password123'],
            ['name' => 'Juan Dela Cruz', 'email' => 'juan.dela.cruz@email.com','password' => 'password123'],
        ];

        foreach ($users as $userData) {
            $user = new User();
            $user->name = $userData['name'];
            $user->email = $userData['email'];
            $user->password = Hash::make($userData['password']);
            $user->save();
        }
    }
}