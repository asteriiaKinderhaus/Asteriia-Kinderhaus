<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gender;

class GenderSeeder extends Seeder
{
    public function run(): void
    {
        Gender::insert([
            [
                'id' => 'L',
                'gender' => 'Laki-laki'
            ],
            [
                'id' => 'P',
                'gender' => 'Perempuan'
            ]
        ]);
    }
}
