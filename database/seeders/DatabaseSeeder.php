<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(RolePermissionSeeder::class);
        // $this->call(AdminSeeder::class);
        // $this->call(CustomerSeeder::class);
        $this->call(RestaurantOwnerSeeder::class);
        // $this->call(AssignAdminSeeder::class);

    }
}
