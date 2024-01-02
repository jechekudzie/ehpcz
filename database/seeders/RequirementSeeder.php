<?php

namespace Database\Seeders;

use App\Models\Requirement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RequirementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $requirements = [
            ["name" => "National ID Card or Passport", "requirements_category_id" => 1],
            ["name" => "Birth Certificate", "requirements_category_id" => 1],
            ["name" => "Passport Sized Photos", "requirements_category_id" => 1],
            ["name" => "Ordinary Level certificates", "requirements_category_id" => 2],
            ["name" => "Advanced Level certificates", "requirements_category_id" => 2],
            ["name" => "National or Diploma or Degree Certificate", "requirements_category_id" => 2],
            ["name" => "National or Diploma or Degree transcript", "requirements_category_id" => 2],
            ["name" => "Certificate of knowledge of English/Affirmation", "requirements_category_id" => 3],
            ["name" => "Certificate of completion of Internship", "requirements_category_id" => 3],
        ];

        foreach ($requirements as $requirement) {
            Requirement::create($requirement);
        }
    }
}
