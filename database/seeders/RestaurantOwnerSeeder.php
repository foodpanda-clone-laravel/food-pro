<?php

namespace Database\Seeders;

use App\Models\Restaurant\Branch;
use App\Models\Restaurant\Restaurant;
use App\Models\User\RestaurantOwner;
use App\Models\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

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
                'email' => 'spice_bazaar@example.com',
                'first_name' => 'arham',
                'last_name' => 'imdad',
                'phone_number' => '1234567890',
                'password' => bcrypt('password'),
            ]);
            $user->assignRole('Restaurant Owner');


            $owner = RestaurantOwner::create([
                'cnic' => '1234567890199',
                'user_id' => $user->id,
                'bank_name' => 'Meezan Bank',
                'iban' => 'PK36SCBL0000001123456919',
                'account_owner_title' => 'Irtaza Ahmad',
            ]);


            $restaurant = Restaurant::create([
                'name' => 'Spice Bazar',
                'owner_id' => $owner->id,
                'opening_time' => '09:00',
                'closing_time' => '22:00',
                'cuisine' => 'Italian',
                'logo_path' => 'spice_bazaar_logo.png', // Assuming no logo yet
                'business_type' => 'restaurant',
            ]);
            Branch::create([
                'address' => 'Johar Town',
                'city' => 'lahore',
                'postal_code' => '54000',
                'restaurant_id' => $restaurant->id,
                'delivery_fee'=>200,
                'delivery_time'=>'45 minutes'
            ]);

            $role = Role::findByName('Restaurant Owner');
            $permissions = $role->permissions->toArray();
            $permissionIds = array_column($permissions, 'id');
            $user->givePermissionTo($permissionIds);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }
}
