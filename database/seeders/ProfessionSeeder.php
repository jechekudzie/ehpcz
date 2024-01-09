<?php

namespace Database\Seeders;

use App\Models\Profession;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $professions = [
            ["name" => "Environmental Health Officer", "expiry_month" => "09", "prefix" => "EH0", "plural" => "Environmental Health Officers"],
            ["name" => "Environmental Health Technician", "expiry_month" => "06", "prefix" => "EHT", "plural" => "Environmental Health Technicians"],
            ["name" => "Meat Inspector", "expiry_month" => "09", "prefix" => "MI", "plural" => "Meat Inspectors"],
            ["name" => "Meat Examiner", "expiry_month" => "09", "prefix" => "ME", "plural" => "Meat Examiners"],
        ];

        foreach ($professions as $profession) {
            Profession::create($profession);
        }
    }
}
