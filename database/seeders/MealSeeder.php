<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Meal;

class MealSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            ['id' => 'MEA000001', 'name' => 'Sarapan', 'order_no' => 1],
            ['id' => 'MEA000002', 'name' => 'Buah', 'order_no' => 2],
            ['id' => 'MEA000003', 'name' => 'Makan Siang', 'order_no' => 3],
            ['id' => 'MEA000004', 'name' => 'Snack', 'order_no' => 4],
            ['id' => 'MEA000005', 'name' => 'Makan Sore', 'order_no' => 5],
            ['id' => 'MEA000006', 'name' => 'Air Putih', 'order_no' => 6],
            ['id' => 'MEA000007', 'name' => 'Susu', 'order_no' => 7],

        ];

        foreach ($data as $meal) {

            Meal::updateOrCreate(

                ['id' => $meal['id']],

                [

                    'name' => $meal['name'],

                    'order_no' => $meal['order_no'],

                    'status' => 1

                ]

            );
        }
    }
}
