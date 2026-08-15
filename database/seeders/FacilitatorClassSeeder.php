<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacilitatorClassSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('facilitator_class')->insert([
            [
                'id' => 'FCL000001',
                'facilitator_id' => 'FAS000001',
                'class_id' => 'CLS000001',
            ],
        ]);
    }
}
