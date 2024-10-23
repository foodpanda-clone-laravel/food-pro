<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class UserPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(49);
        $role = Role::findByName('Customer');
        $permissions = $role->permissions->toArray();
        $permissionIds = array_column($permissions, 'id');
        $user->givePermissionTo($permissionIds);
    }
}
