<?php

namespace Database\Seeders;

use App\Models\EmploymentSector;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmploymentSectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // Define the sectors to be seeded
        $sectors = [
            ['name' => 'Public'],
            ['name' => 'Private'],
        ];

        // Seed each sector
        foreach ($sectors as $sector) {
            EmploymentSector::create($sector);
        }
    }
}
