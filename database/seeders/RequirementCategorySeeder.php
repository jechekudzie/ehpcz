<?php

namespace Database\Seeders;

use App\Models\RequirementsCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RequirementCategorySeeder extends Seeder
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
            ["name" => "Identification", "created_at" => now(), "updated_at" => now()],
            ["name" => "Educational", "created_at" => now(), "updated_at" => now()],
            ["name" => "Foreigners", "created_at" => now(), "updated_at" => now()],
        ];

        RequirementsCategory::insert($categories);
    }
}
