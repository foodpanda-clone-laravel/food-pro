<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Contracts\Role;

class NewAdminPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::findByName('Admin');
        $adminPermissions = [
           'user can view application',
           'user can manage application',
           'user can view all orders',
           'user can view deactivated restaurants',

            
            ];

        foreach ($adminPermissions as $permission) {

            $permission = Permission::firstOrCreate(['name' => $permission]);
            $role->givePermissionTo($permission);
            
            }

    }
}
