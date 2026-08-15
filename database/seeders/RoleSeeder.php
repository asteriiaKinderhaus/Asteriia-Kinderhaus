<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([

            [
                'id' => 'ADM',
                'nama' => 'Administrator',
                'keterangan' => 'Administrator Sistem',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id' => 'FAS',
                'nama' => 'Fasilitator',
                'keterangan' => 'Guru / Fasilitator',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id' => 'PAR',
                'nama' => 'Orang Tua',
                'keterangan' => 'Orang Tua Murid',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
