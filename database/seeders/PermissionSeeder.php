<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('permissions')->insert([

            [
                'id' => 'P01',
                'code' => 'USER_VIEW',
                'name' => 'View User',
                'module' => 'User',
                'action' => 'View',
                'description' => 'Melihat data user',
            ],

            [
                'id' => 'P02',
                'code' => 'USER_CREATE',
                'name' => 'Create User',
                'module' => 'User',
                'action' => 'Create',
                'description' => 'Menambah user',
            ],

            [
                'id' => 'P03',
                'code' => 'USER_EDIT',
                'name' => 'Edit User',
                'module' => 'User',
                'action' => 'Edit',
                'description' => 'Mengubah user',
            ],

            [
                'id' => 'P04',
                'code' => 'USER_DELETE',
                'name' => 'Delete User',
                'module' => 'User',
                'action' => 'Delete',
                'description' => 'Menghapus user',
            ],

        ]);
    }
}
