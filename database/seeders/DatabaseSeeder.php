<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            GenderSeeder::class,
            AdminSeeder::class,
            PermissionSeeder::class,
            RolePermissionSeeder::class,
            SchoolClassSeeder::class,
            
           // FacilitatorClassSeeder::class,
        ]);
    }
}
