<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class CustomerPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $role = Role::findByName('Customer');
        $customerPermissions = [

            'user can view favorites',

            'user can convert points to money',

            'user can add to favorites',

            'user can remove favorites',

            'user can edit profile',

            'user can update address',

            'user can view profile',

            'user can view order history',

            'user can view active order',

            'user can view order details',

        ];

        foreach ($customerPermissions as $permission) {

            $permission = Permission::firstOrCreate(['name' => $permission]);
            $role->givePermissionTo($permission);

        }
    }
}
