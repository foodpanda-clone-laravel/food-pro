<?php

namespace Database\Seeders;

use App\Models\Restaurant\Branch;
use App\Models\Restaurant\Restaurant;
use App\Models\User\RestaurantOwner;
use App\Models\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestaurantOwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::beginTransaction();
            // Create a user first
            $user = User::create([
                'email' => 'hadiya@example.com',
                'first_name' => 'hadiya',
                'last_name' => 'asif',
                'phone_number' => '1234567890',
                'password' => bcrypt('password123'),
            ]);

            $owner = RestaurantOwner::create([
                'cnic' => '12345-6789012-4',
                'user_id' => $user->id,
                'bank_name' => 'Meezan Bank',
                'iban' => 'PK36SCBL0000001123456902',
                'account_owner_title' => 'shahid Shah',
            ]);


            $restaurant = Restaurant::create([
                'name' => 'OPTP',
                'owner_id' => $owner->id,
                'opening_time' => '09:00',
                'closing_time' => '22:00',
                'cuisine' => 'Italian',
                'logo_path' => null, // Assuming no logo yet
                'business_type' => 'Restaurant',
            ]);
            Branch::create([
                'address' => 'programmers force',
                'city' => 'lahore',
                'postal_code' => '54000',
                'restaurant_id' => $restaurant->id,
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
