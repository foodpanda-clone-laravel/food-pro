<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Find the user (or create one first)
         $user = User::Create([
            'email' => 'johndoe@example.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone_number' => '1234567890',
            'password' => bcrypt('password123'),
        ]);

        // Create a customer linked to the user
        Customer::create([
            'user_id' => $user->id,
            'address' => '123 Main St',
            'delivery_address' => '456 Delivery St',
            'favorites' => 'Pizza, Burger',
        ]);
    }
    }
