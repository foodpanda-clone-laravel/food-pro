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
            'first_name' => 'Admin',        
            'last_name' => 'User',           
            'phone_number' => '1234567890',  
            'email' => 'admin@example.com',   
            'password' => Hash::make('password'), 
        ]);
    }
}
