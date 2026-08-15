<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SchoolClass;

class SchoolClassSeeder extends Seeder
{
    public function run(): void
    {
        $classes = [

            [
                'id' => 'CLS000001',
                'name' => 'Baby Class',
                'capacity' => 10,
                'status' => 1,
            ],

            [
                'id' => 'CLS000002',
                'name' => 'Toddler A',
                'capacity' => 12,
                'status' => 1,
            ],

            [
                'id' => 'CLS000003',
                'name' => 'Toddler B',
                'capacity' => 12,
                'status' => 1,
            ],

            [
                'id' => 'CLS000004',
                'name' => 'Playgroup A',
                'capacity' => 15,
                'status' => 1,
            ],

            [
                'id' => 'CLS000005',
                'name' => 'Playgroup B',
                'capacity' => 15,
                'status' => 1,
            ],

        ];

        foreach ($classes as $class) {
            SchoolClass::updateOrCreate(
                ['id' => $class['id']],
                $class
            );
        }
    }
}
