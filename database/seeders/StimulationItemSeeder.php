<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StimulationItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('stimulation_items')->insert([

            /*
            |--------------------------------------------------------------------------
            | RMT
            |--------------------------------------------------------------------------
            */

            [
                'id' => 'SM001',
                'category_id' => 'STI01',
                'name' => 'Vestibular',
            ],
            [
                'id' => 'SM002',
                'category_id' => 'STI01',
                'name' => 'Proprioseptif',
            ],
            [
                'id' => 'SM003',
                'category_id' => 'STI01',
                'name' => 'Taktil',
            ],
            [
                'id' => 'SM004',
                'category_id' => 'STI01',
                'name' => 'Visual',
            ],
            [
                'id' => 'SM005',
                'category_id' => 'STI01',
                'name' => 'Auditori',
            ],

            /*
            |--------------------------------------------------------------------------
            | BBA
            |--------------------------------------------------------------------------
            */

            [
                'id' => 'SM006',
                'category_id' => 'STI02',
                'name' => 'Motorik Kasar',
            ],
            [
                'id' => 'SM007',
                'category_id' => 'STI02',
                'name' => 'Motorik Halus',
            ],
            [
                'id' => 'SM008',
                'category_id' => 'STI02',
                'name' => 'Bahasa',
            ],
            [
                'id' => 'SM009',
                'category_id' => 'STI02',
                'name' => 'Kognitif',
            ],
            [
                'id' => 'SM010',
                'category_id' => 'STI02',
                'name' => 'Sosial Emosional',
            ],

            /*
            |--------------------------------------------------------------------------
            | Brain Gym
            |--------------------------------------------------------------------------
            */

            [
                'id' => 'SM011',
                'category_id' => 'STI03',
                'name' => 'Cross Crawl',
            ],
            [
                'id' => 'SM012',
                'category_id' => 'STI03',
                'name' => 'Lazy Eight',
            ],
            [
                'id' => 'SM013',
                'category_id' => 'STI03',
                'name' => 'Hook Up',
            ],
            [
                'id' => 'SM014',
                'category_id' => 'STI03',
                'name' => 'Double Doodle',
            ],
            [
                'id' => 'SM015',
                'category_id' => 'STI03',
                'name' => 'Thinking Cap',
            ],

        ]);
    }
}
