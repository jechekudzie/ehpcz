<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenaltySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('penalties')->insert([
            'id' => 1,
            'percentage' => 20.00,
            'threshold' => 6,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
