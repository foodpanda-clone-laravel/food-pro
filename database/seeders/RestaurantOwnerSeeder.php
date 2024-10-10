<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use App\Models\RestaurantOwner;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Branch;

class RestaurantOwnerSeeder extends Seeder
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
            'email' => 'ali@example.com',
            'first_name' => 'ali',
            'last_name' => 'kh',
            'phone_number' => '1234567891',
            'password' => bcrypt('password123'),
        ]);

        $user->assignRole('Restaurant Owner');

       $owner = RestaurantOwner::create([
            'cnic' => '12345-6789012-4',
            'user_id' =>$user->id,
            'bank_name' => 'Meezan Bank',
            'iban' => 'PK36SCBL0000001123456902',
            'account_owner_title' => 'ali shoaib',
        ]);


        $restaurant= Restaurant::create([
            'name' => 'AFC',
            'owner_id' => $owner->id,
            'opening_time' => '2024-10-01 09:00:00',
            'closing_time' => '2024-10-01 22:00:00',
            'cuisine' => 'Desi',
            'logo_path' => null, // Assuming no logo yet
            'business_type' => 'Restaurant',
        ]);
        Branch::create([
            'address'=>'WT road',
            'city'=>'lahore',
            'postal_code'=>'54000',
            'restaurant_id'=>$restaurant->id,
        ]);
    }
}
