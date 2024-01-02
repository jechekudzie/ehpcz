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
            ["name" => "Chinhoyi University"],
            ["name" => "Solusi University"],
            ["name" => "National University of Science and Technology"],
            ["name" => "Bulawayo Polytechnic"],
            ["name" => "Kwekwe Polytechnic"],
            ["name" => "Gweru Polytechnic"],
            ["name" => "Mutare Polytechnic"],
            ["name" => "Joshua Mqabuko Nkomo Polytechnic"],
            ["name" => "Kushinga Phikelela Polytechnic"],
            ["name" => "Masvingo Polytechnic"],
            ["name" => "Kwekwe Polytechnic College"],
        ];

        foreach ($institutions as $institution) {
            Institution::create($institution);
        }
    }
}
