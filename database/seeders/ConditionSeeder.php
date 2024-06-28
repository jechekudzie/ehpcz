<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $conditions = [
            'TO WORK UNDER SUPERVISION FOR ONE YEAR WITH A REPORT FROM THE PROVINCIAL ENVIRONMENTAL HEALTH OFFICER OR HEAD OF ENVIRONMENTAL HEALTH DEPARTMENT OF A LOCAL AUTHORITY.',
            'TO WORK UNDER SUPERVISION FOR ONE YEAR WITH A REPORT FROM THE PROVINCIAL CHIEF FOOD INSPECTOR AFTER EVERY FOUR MONTHS.',
            'TO WORK UNDER SUPERVISION FOR TWO YEARS WITH A REPORT FROM THE PROVINCIAL ENVIRONMENTAL HEALTH OFFICER OR HEAD OF ENVIRONMENTAL HEALTH DEPARTMENT OF A LOCAL AUTHORITY.',
            'TO WORK UNDER SUPERVISION FOR TWO YEARS WITH A REPORT FROM THE PROVINCIAL CHIEF FOOD INSPECTOR AFTER EVERY FOUR MONTHS.',
        ];

        foreach ($conditions as $condition) {
            DB::table('conditions')->insert([
                'condition' => $condition,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
