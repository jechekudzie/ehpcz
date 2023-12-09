<?php

namespace Database\Seeders;

use App\Models\Profession;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $professions = [
            ["name" => "Environmental Health Officers", "created_at" => now(), "updated_at" => now()],
            ["name" => "Environmental Health Technicians", "created_at" => now(), "updated_at" => now()],
            ["name" => "Meat Inspectors", "created_at" => now(), "updated_at" => now()],
            ["name" => "Meat Examiners", "created_at" => now(), "updated_at" => now()],
        ];

        Profession::insert($professions);
    }
}
