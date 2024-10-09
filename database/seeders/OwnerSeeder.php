<?php

namespace Database\Seeders;

use App\Models\Branch;
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
        // $user = User::create([
        //     'email' => 'rashid@example.com',
        //     'first_name' => 'rashid',
        //     'last_name' => 'Shah',
        //     'phone_number' => '1234567891',
        //     'password' => bcrypt('password123'),
        // ]);

        // Create a restaurant owner linked to the created user
    //    $owner = RestaurantOwner::create([
    //         'cnic' => '12345-6789012-2',
    //         'user_id' => $user->id, // Linking to the user
    //         'bank_name' => 'Meezan Bank',
    //         'iban' => 'PK36SCBL0000001123456702',
    //         'account_owner_title' => 'Rashid Shah',
    //     ]);

    $owner=RestaurantOwner::where('user_id', 18)->firstOrFail();


       $restuarant = Restaurant::create([
            'name' => 'Rashid Dahi bhallay',
            'owner_id' => $owner->id,

            'opening_time' => '2024-10-01 09:00:00',
            'closing_time' => '2024-10-01 22:00:00',
            'cuisine' => 'Italian',
            'logo_path' => null, // Assuming no logo yet
            'business_type' => 'Sole Proprietorship',
        ]);


        Branch::create([
            
            'restaurant_id' => 6,
            'address' => 'Bhalla Chowk',
            'postal_code' => '12345',
            'city' => 'Lahore'
        ]);

    }
}
