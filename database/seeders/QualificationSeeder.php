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
            ["name" => "Bsc Hns Degree in Environmental Health", "profession_id" => 1, "created_at" => now(), "updated_at" => now()],
            ["name" => "BSc Hns Degree in Public Health", "profession_id" => 1, "created_at" => now(), "updated_at" => now()],
            ["name" => "BSc Hns Degree in Environmental Science and Health", "profession_id" => 1, "created_at" => now(), "updated_at" => now()],
            ["name" => "Bachelor of Technology Honours Degree in Environmental Health", "profession_id" => 1, "created_at" => now(), "updated_at" => now()],
            ["name" => "National Diploma in Environmental Health", "profession_id" => 2, "created_at" => now(), "updated_at" => now()],
            ["name" => "National Diploma in Meat Inspection", "profession_id" => 3, "created_at" => now(), "updated_at" => now()],
            ["name" => "National Certificate in Meat Inspection", "profession_id" => 4, "created_at" => now(), "updated_at" => now()],
        ];

        Qualification::insert($qualifications);
    }
}
