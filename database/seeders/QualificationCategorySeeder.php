<?php

namespace Database\Seeders;

use App\Models\QualificationCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QualificationCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $categories = [
            ["name" => "Local", "description" => "Locally trained", "created_at" => now(), "updated_at" => now()],
            ["name" => "Foreign", "description" => "Foreign trained", "created_at" => now(), "updated_at" => now()],
        ];

        QualificationCategory::insert($categories);
    }
}
