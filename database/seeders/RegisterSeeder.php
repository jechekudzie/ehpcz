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
            ["name" => "MAIN REGISTRATION", "description" => "Permanent Register"],
            ["name" => "PROVISIONAL REGISTRATION FOR FOREIGN APPLICANTS", "description" => "Foreign applications, Provisional Registration"],
            ["name" => "PROVISIONAL REGISTRATION FOR FOREIGN TRAINED ZIMBABWEANS", "description" => "Foreign trained Zimbabweans, Provisional Registration"],
            ["name" => "INTERNSHIP", "description" => "Internship"],
            ["name" => "STUDENT", "description" => "Students in training institution"],

        ];

        foreach ($registers as $register) {
            Register::create($register);
        }
    }
}
