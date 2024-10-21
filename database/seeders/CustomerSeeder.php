<?php

namespace Database\Seeders;

use App\Models\User\Customer;
use App\Models\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try{
            DB::beginTransaction();
            // Find the user (or create one first)
            $user = User::Create([
                'email' => 'test_customer2@example.com',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'phone_number' => '1234567890',
                'password' => bcrypt('password'),
            ]);

            $customer = Customer::create([
                'user_id' => $user->id,
                'address' => '123 Main St',
                'delivery_address' => '456 Delivery St',
                'favorites' => 'Pizza, Burger',
            ]);
            $role = Role::findByName('Customer');
            $permissions = $role->permissions->toArray();
            $permissionIds = array_column($permissions,'id');
            $user->givePermissionTo($permissionIds);
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            dd($e->getMessage());
        }
         }
    }
