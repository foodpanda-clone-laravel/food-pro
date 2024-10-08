<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Make sure to import the User model

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create an admin user
        User::create([
            'first_name' => 'Admin',         // Admin first name
            'last_name' => 'User',           // Admin last name
            'phone_number' => '1234567890',  // Admin phone number (optional)
            'email' => 'admin@example.com',   // Admin email
            'password' => Hash::make('password'), // Admin password (hashed)
        ]);
    }
}
