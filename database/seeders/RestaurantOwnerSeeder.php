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
            'email' => 'shahidkapoor@example.com',
            'first_name' => 'shahid',
            'last_name' => 'kapoor',
            'phone_number' => '1234567890',
            'password' => bcrypt('password123'),
        ]);

       $owner = RestaurantOwner::create([
            'cnic' => '12345-6789012-4',
            'user_id' =>$user->id,
            'bank_name' => 'Meezan Bank',
            'iban' => 'PK36SCBL0000001123456902',
            'account_owner_title' => 'shahid Shah',
        ]);


        $restaurant= Restaurant::create([
            'name' => $user->first_name.' '.$user->last_name,
            'owner_id' => $owner->id,
            'opening_time' => '2024-10-01 09:00:00',
            'closing_time' => '2024-10-01 22:00:00',
            'cuisine' => 'Italian',
            'logo_path' => null, // Assuming no logo yet
            'business_type' => 'Restaurant',
        ]);
        Branch::create([
            'address'=>'programmers force',
            'city'=>'lahore',
            'postal_code'=>'54000',
            'restaurant_id'=>$restaurant->id,
        ]);
    }
}
