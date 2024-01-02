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
            ["name" => "Student", "description" => "Students in training institution"],
            ["name" => "Intern", "description" => "Internship"],
            ["name" => "Provisional", "description" => "Foreign applications"],
            ["name" => "Provisional", "description" => "Foreign trained Zimbabweans"],
            ["name" => "Main", "description" => "Permanent Register"],
        ];

        foreach ($registers as $register) {
            Register::create($register);
        }
    }
}
