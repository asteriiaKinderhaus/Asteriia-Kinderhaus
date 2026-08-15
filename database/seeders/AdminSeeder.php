<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'id'       => 'USR0000001',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role_id'  => 'ADM',
        ]);

        Admin::create([
            'id'        => 'ADM0000001',
            'name'      => 'Administrator',
            'telephone' => '08123456789',
            'address'   => 'Asteriia Kinderhaus',
            'email'     => 'admin@asteriia.com',
            'users_id'  => 'USR0000001',
        ]);
    }
}
