<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class stimulation_categories extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('stimulation_categories')->insert([
            [
                'id' => 'STI01',
                'name' => 'RMT',
            ],
            [
                'id' => 'STI02',
                'name' => 'BBA',
            ],
            [
                'id' => 'STI03',
                'name' => 'Brain Gym',
            ],
        ]);
    }
}
