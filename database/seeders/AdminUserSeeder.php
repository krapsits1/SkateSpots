<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Check if the admin user already exists
        if (User::where('username', 'admin')->doesntExist()) {
            // Create admin user with username "admin" and password "admin123"
            User::create([
                'email' => 'skatesspots@gmail.com', // Email can be changed as needed
                'username' => 'admin',
                'password' => Hash::make('vetra2004'), // Hash the password for security
                'role' => 'admin', // Set the role as 'admin'
            ]);
        }
    }
}

