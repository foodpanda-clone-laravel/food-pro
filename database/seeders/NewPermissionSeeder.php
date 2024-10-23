<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

use Spatie\Permission\Models\Permission;

class NewPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::findByName('Restaurant Owner');
        $restaurantOwnerPermissions = [
            'user can view menu',
            'user can restore restaurant',
            'user can update order status',
            'user can view choices',
            'user can add choice ',
            'user can update choice',
            'user can view menu with menu count',
            'user can view menu item'


            ];

        foreach ($restaurantOwnerPermissions as $permission) {

            $permission = Permission::firstOrCreate(['name' => $permission]);
            $role->givePermissionTo($permission);

        }


        $role = Role::findByName('Admin');
        $adminPermissions = [
            'user can view menu',
            'user can view restaurants',
            'user can restore restaurant'


        ];

        foreach ($adminPermissions as $permission) {

            $permission = Permission::firstOrCreate(['name' => $permission]);
            $role->givePermissionTo($permission);

        }



    }
}
