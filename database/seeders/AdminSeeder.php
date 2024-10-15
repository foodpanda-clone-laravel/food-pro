<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; 
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
        $admin = User::create([
            'first_name' => 'Admin',        
            'last_name' => '2',           
            'phone_number' => '1234567890',  
            'email' => 'admin2@example.com',   
            'password' => Hash::make('password'), 
        ]);
        $admin->assignRole('Admin');
        $role = Role::findByName('Admin');
        
        $permissions = $role->permissions->toArray();
        $permissionIds = array_column($permissions, 'id');
        $admin->givePermissionTo($permissionIds);
    }
}
