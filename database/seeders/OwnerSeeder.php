<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use App\Models\RestaurantOwner;
use App\Models\User;
use Illuminate\Database\Seeder;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a user first
        $user = User::create([
            'email' => 'adeel@example.com',
            'first_name' => 'Adeel',
            'last_name' => 'Shah',
            'phone_number' => '1234567890',
            'password' => bcrypt('password123'),
        ]);

        // Create a restaurant owner linked to the created user
       $owner = RestaurantOwner::create([
            'cnic' => '12345-6789012-3',
            'user_id' => $user->id, // Linking to the user
            'bank_name' => 'Meezan Bank',
            'iban' => 'PK36SCBL0000001123456702',
            'account_owner_title' => 'Adeel Shah',
        ]);


        Restaurant::create([
            'name' => 'Adeel’s Bistro',
            'owner_id' => $owner->id,
            'address' => '123 Main St',
            'postal_code' => '12345',
            'city' => 'Lahore',
            'opening_time' => '2024-10-01 09:00:00',
            'closing_time' => '2024-10-01 22:00:00',
            'cuisine' => 'Italian',
            'logo_path' => null, // Assuming no logo yet
            'business_type' => 'Sole Proprietorship',
        ]);
    }
}
