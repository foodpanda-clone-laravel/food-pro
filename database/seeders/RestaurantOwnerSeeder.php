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
                'email' => 'junaidkhan2@example.com',
                'first_name' => 'junaid',
                'last_name' => 'junaid',
                'phone_number' => '1234567890',
                'password' => bcrypt('password123'),
            ]);
            $user->assignRole('Restaurant Owner');


            $owner = RestaurantOwner::create([
                'cnic' => '12345-6789012-8',
                'user_id' => $user->id,
                'bank_name' => 'Meezan Bank',
                'iban' => 'PK36SCBL0000001123456902',
                'account_owner_title' => 'junaid khan',
            ]);


            $restaurant = Restaurant::create([
                'name' => 'bbq ',
                'owner_id' => $owner->id,
                'opening_time' => '09:00',
                'closing_time' => '22:00',
                'cuisine' => 'Italian',
                'logo_path' => null, // Assuming no logo yet
                'business_type' => 'Restaurant',
            ]);
            Branch::create([
                'address' => 'allama iqbal town',
                'city' => 'lahore',
                'postal_code' => '54000',
                'restaurant_id' => $restaurant->id,
                'delivery_fee'=>200,
                'delivery_time'=>'45 minutes'
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }
}
