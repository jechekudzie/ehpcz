<?php

namespace Database\Seeders;

use App\Models\EmploymentStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmploymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $employmentStatuses = [
            ['name' => 'Employed'],
            ['name' => 'Unemployed'],
        ];

        // Seed each sector
        foreach ($employmentStatuses as $employmentStatus) {
            EmploymentStatus::create($employmentStatus);
        }
    }
}
