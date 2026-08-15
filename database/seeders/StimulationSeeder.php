<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StimulationSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('stimulations')->insert([

            // ===========================
            // RMT
            // ===========================

            [
                'id' => 'STM01',
                'category_id' => 'STI01',
                'name' => 'Merangkak',
            ],

            [
                'id' => 'STM02',
                'category_id' => 'STI01',
                'name' => 'Cross Crawl',
            ],

            [
                'id' => 'STM03',
                'category_id' => 'STI01',
                'name' => 'Balance',
            ],

            // ===========================
            // BBA
            // ===========================

            [
                'id' => 'STM04',
                'category_id' => 'STI02',
                'name' => 'Visual',
            ],

            [
                'id' => 'STM05',
                'category_id' => 'STI02',
                'name' => 'Auditori',
            ],

            // ===========================
            // Brain Gym
            // ===========================

            [
                'id' => 'STM06',
                'category_id' => 'STI03',
                'name' => 'Cross Crawl',
            ],

            [
                'id' => 'STM07',
                'category_id' => 'STI03',
                'name' => 'Lazy Eight',
            ],

        ]);
    }
}
