<?php

namespace Database\Seeders;

use App\Models\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create an admin user
        try{
            DB::beginTransaction();
            $admin = User::create([
                'first_name' => 'admin',
                'last_name' => 'work',
                'phone_number' => '1234567890',
                'email' => 'admin_work@gmail.com',
                'password' => bcrypt('password'),
            ]);
            $admin->assignRole('Admin');
            $role = Role::findByName('Admin');
            $permissions = $role->permissions->toArray();
            $permissionIds = array_column($permissions, 'id');
            $admin->givePermissionTo($permissionIds);
            DB::commit();
        }
        catch(\Exception $e){
            dd($e);
            DB::rollBack();
        }
    }
}
