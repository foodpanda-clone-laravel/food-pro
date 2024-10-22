<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;

use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder

{

public function run()

{

// Create roles

$adminRole = Role::create(['name' => 'Admin']);

$restaurantOwnerRole = Role::create(['name' => 'Restaurant Owner']);

$customerRole = Role::create(['name' => 'Customer']);

// Admin Permissions

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

foreach ($adminPermissions as $permission) {

$permission = Permission::firstOrCreate(['name' => $permission]);

$adminRole->givePermissionTo($permission);

}

// Restaurant Owner Permissions

$restaurantOwnerPermissions = [
'user can register their account',

'user can update restaurant',

'user can delete restaurant',

'user can view order',

'user can update order',

'user can create menu item',

'user can edit menu item',

'user can remove menu item',

'user can view revenue report',

'user can add add-ons',

'user can update add-ons',

'user can delete add-ons',

'user can view ratings and feedback',

];

foreach ($restaurantOwnerPermissions as $permission) {

$permission = Permission::firstOrCreate(['name' => $permission]);

$restaurantOwnerRole->givePermissionTo($permission);

}

// Customer Permissions

$customerPermissions = [

'user can view order',

'user can cancel order',

'user can rate orders',

'user can view rewards and badges',

];

foreach ($customerPermissions as $permission) {

$permission = Permission::firstOrCreate(['name' => $permission]);

$customerRole->givePermissionTo($permission);

}

}

}