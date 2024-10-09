<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssignAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(1);

    //     if ($user) {
            
    //         $user->assignRole('Admin');
    // }


    $adminPermissions = [

        'user can create user',
        
        'user can update user',
        
        'user can delete user',
        
        'user can create restaurant',
        
        'user can update restaurant',
        
        'user can delete restaurant',
        
        'user can view order',
        
        'user can update order',
        
        'user can cancel order',
        
        'user can create menu item',
        
        'user can edit menu item',
        
        'user can remove menu item',
        
        'user can view revenue report',
        
        'user can create rewards and badges',
        
        'user can update rewards and badges',
        
        'user can delete rewards and badges',
        
        'user can view payment',
        
        'user can view ratings and feedback',
        
        'user can add add-ons',
        
        'user can update add-ons',
        
        'user can delete add-ons',
        
        'user can assign roles',
        
        'user can change roles',
        
        'user can access backoffice dashboards',
        
        ];

        $user->givePermissionTo($adminPermissions);
}
}
