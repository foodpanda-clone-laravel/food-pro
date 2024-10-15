<?php

namespace Database\Seeders;

use App\Models\User\Customer;
use App\Models\User\User;
use Illuminate\Database\Seeder;
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
         // Find the user (or create one first)
         $user = User::Create([
            'email' => 'johndoe@example.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone_number' => '1234567890',
            'password' => bcrypt('password123'),
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
        $customer->givePermissionTo($permissionIds);
    }
    }
