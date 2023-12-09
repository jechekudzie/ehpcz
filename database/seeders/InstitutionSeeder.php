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
            ["name" => "Chinhoyi University", "created_at" => now(), "updated_at" => now()],
            ["name" => "Solusi University", "created_at" => now(), "updated_at" => now()],
            ["name" => "National University of Science and Technology", "created_at" => now(), "updated_at" => now()],
            ["name" => "Bulawayo Polytechnic", "created_at" => now(), "updated_at" => now()],
            ["name" => "Kwekwe Polytechnic", "created_at" => now(), "updated_at" => now()],
            ["name" => "Gweru Polytechnic", "created_at" => now(), "updated_at" => now()],
            ["name" => "Mutare Polytechnic", "created_at" => now(), "updated_at" => now()],
            ["name" => "Joshua Mqabuko Nkomo Polytechnic", "created_at" => now(), "updated_at" => now()],
            ["name" => "Kushinga Phikelela Polytechnic", "created_at" => now(), "updated_at" => now()],
            ["name" => "Masvingo Polytechnic", "created_at" => now(), "updated_at" => now()],
            ["name" => "Kwekwe Polytechnic College", "created_at" => now(), "updated_at" => now()],
        ];

        Institution::insert($institutions);
    }
}
