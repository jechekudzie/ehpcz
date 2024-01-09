<?php

namespace Database\Seeders;

use App\Models\Institution;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $institutions = [
            ["name" => "Army Health Services Training School"],
            ["name" => "Bulawayo Polytechnic"],
            ["name" => "Chinhoyi University of Technology"],
            ["name" => "Gwanda Multidisciplinary School"],
            ["name" => "Gweru Multidisciplinary School"],
            ["name" => "Joshua Mqabuko Polytechnic"],
            ["name" => "Kushinga Phikelela Training School"],
            ["name" => "Kwekwe Polytechnic"],
            ["name" => "Masvingo Polytechnic"],
            ["name" => "Mutare Polytechnic"],
            ["name" => "National University of Science and Technology"],
            ["name" => "Solusi University"],
            ["name" => "University of Zimbabwe"],
        ];


        foreach ($institutions as $institution) {
            Institution::create($institution);
        }
    }
}
