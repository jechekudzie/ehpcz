<?php

namespace Database\Seeders;

use App\Models\Qualification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QualificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $qualifications = [
            ["name" => "National Certificate In Meat Inspection", "profession_id" => 4],
            ["name" => "National Diploma In Meat Inspection", "profession_id" => 3],
            ["name" => "Higher National Diploma In Meat Inspection", "profession_id" => 3],
            ["name" => "National Certificate In Environmental Health", "profession_id" => 2],
            ["name" => "National Diploma In Environmental Health", "profession_id" => 2],
            ["name" => "Higher National Diploma In Environmental Health", "profession_id" => 2],
            ["name" => "Bachelor of Technology In Environmental Health", "profession_id" => 1],
            ["name" => "Bachelor of Science Environmental Health", "profession_id" => 1],
            ["name" => "Bachelor of Science Honours Degree In Environmental Health", "profession_id" => 1],
            ["name" => "Bachelor of Science Honours Degree In Environmental Science and Health", "profession_id" => 1],
            ["name" => "Bachelor of Environmental Science Honours Degree In Public Health", "profession_id" => 1],
            ["name" => "Bachelor of Science In Occupational and Environmental Health", "profession_id" => 1],
            ["name" => "Masters Degree In Public Health", "profession_id" => 1],
            ["name" => "Masters Degree In Environmental Health", "profession_id" => 1],
        ];

        foreach ($qualifications as $qualification) {
            Qualification::create($qualification);
        }
    }
}
