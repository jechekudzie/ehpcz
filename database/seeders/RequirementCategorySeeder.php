<?php

namespace Database\Seeders;

use App\Models\RequirementCategory;
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
            ["name" => "Registration"],
            ["name" => "Renewal"],
        ];

        foreach ($categories as $category) {
            RequirementCategory::create($category);
        }
    }
}
