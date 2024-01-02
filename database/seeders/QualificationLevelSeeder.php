<?php

namespace Database\Seeders;

use App\Models\QualificationLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QualificationLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $levels = [
            ["name" => "Certificate"],
            ["name" => "Diploma"],
            ["name" => "Degree"],
            ["name" => "Masters"],
            ["name" => "Doctorate"],
        ];

        foreach ($levels as $level) {
            QualificationLevel::create($level);
        }
    }
}
