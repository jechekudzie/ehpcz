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
            ["name" => "Student", "description" => "Students in training institution", "created_at" => now(), "updated_at" => now()],
            ["name" => "Intern", "description" => "Internship", "created_at" => now(), "updated_at" => now()],
            ["name" => "Provisional", "description" => "Foreign applications", "created_at" => now(), "updated_at" => now()],
            ["name" => "Provisional", "description" => "Foreign trained Zimbabweans", "created_at" => now(), "updated_at" => now()],
            ["name" => "Main", "description" => "Permanent Register", "created_at" => now(), "updated_at" => now()],
        ];

        Register::insert($registers);
    }
}
