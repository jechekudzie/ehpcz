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
            ["name" => "Certificate", "created_at" => now(), "updated_at" => now()],
            ["name" => "Diploma", "created_at" => now(), "updated_at" => now()],
            ["name" => "Degree", "created_at" => now(), "updated_at" => now()],
            ["name" => "Masters", "created_at" => now(), "updated_at" => now()],
            ["name" => "Doctorate", "created_at" => now(), "updated_at" => now()],
        ];

        QualificationLevel::insert($levels);
    }
}
