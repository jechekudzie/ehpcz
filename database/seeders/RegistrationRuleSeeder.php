<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegistrationRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('registration_rules')->insert([
            ['id' => 1, 'register_id' => 1, 'is_zimbabwean' => 1, 'qualification_category_id' => 1, 'fee_item_id' => 1, 'created_at' => '2024-04-18 11:37:22', 'updated_at' => '2024-04-18 11:37:22'],
            ['id' => 2, 'register_id' => 1, 'is_zimbabwean' => 1, 'qualification_category_id' => 1, 'fee_item_id' => 2, 'created_at' => '2024-04-18 11:37:32', 'updated_at' => '2024-04-18 11:37:32'],
            ['id' => 3, 'register_id' => 1, 'is_zimbabwean' => 1, 'qualification_category_id' => 1, 'fee_item_id' => 3, 'created_at' => '2024-04-18 11:37:46', 'updated_at' => '2024-04-18 11:37:46'],
            ['id' => 4, 'register_id' => 1, 'is_zimbabwean' => 1, 'qualification_category_id' => 1, 'fee_item_id' => 4, 'created_at' => '2024-04-18 11:37:54', 'updated_at' => '2024-04-18 11:37:54'],
            ['id' => 5, 'register_id' => 2, 'is_zimbabwean' => 0, 'qualification_category_id' => 2, 'fee_item_id' => 5, 'created_at' => '2024-04-18 11:38:20', 'updated_at' => '2024-04-18 11:38:20'],
            ['id' => 6, 'register_id' => 3, 'is_zimbabwean' => 1, 'qualification_category_id' => 2, 'fee_item_id' => 6, 'created_at' => '2024-04-18 11:38:30', 'updated_at' => '2024-04-18 11:38:30'],
            ['id' => 7, 'register_id' => 5, 'is_zimbabwean' => 1, 'qualification_category_id' => 1, 'fee_item_id' => 29, 'created_at' => '2024-04-18 11:38:49', 'updated_at' => '2024-04-18 11:38:49'],
        ]);
    }
}
