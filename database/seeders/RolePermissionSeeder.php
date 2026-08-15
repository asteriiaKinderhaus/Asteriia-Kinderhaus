<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('role_permissions')->insert([

            [
                'role_id' => 'ADM',
                'permission_id' => 'P01'
            ],

            [
                'role_id' => 'ADM',
                'permission_id' => 'P02'
            ],

            [
                'role_id' => 'ADM',
                'permission_id' => 'P03'
            ],

            [
                'role_id' => 'ADM',
                'permission_id' => 'P04'
            ],

        ]);
    }
}
