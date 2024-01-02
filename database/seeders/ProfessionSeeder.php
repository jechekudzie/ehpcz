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
            ["name" => "Environmental Health Officer"],
            ["name" => "Environmental Health Technician"],
            ["name" => "Meat Inspector"],
            ["name" => "Meat Examiners"],
        ];

        foreach ($professions as $profession) {
            Profession::create($profession);
        }
    }
}
