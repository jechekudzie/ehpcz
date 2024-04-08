<?php

namespace Database\Seeders;

use App\Models\Register;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegisterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $registers = [
            ["name" => "MAIN", "description" => "Permanent Register"],
            ["name" => "PROVISIONAL REGISTRATION FOR FOREIGN APPLICANTS", "description" => "PROVISIONAL REGISTRATION FOR FOREIGN APPLICANTS"],
            ["name" => "PROVISIONAL REGISTRATION FOR FOREIGN TRAINED ZIMBABWEANS", "description" => "PROVISIONAL REGISTRATION FOR FOREIGN TRAINED ZIMBABWEANS"],
            ["name" => "INTERNSHIP", "description" => "Internship"],
            ["name" => "STUDENT", "description" => "Students in training institution"],

        ];

        foreach ($registers as $register) {
            Register::create($register);
        }
    }
}
