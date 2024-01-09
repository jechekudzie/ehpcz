<?php

namespace Database\Seeders;

use App\Models\RenewalStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RenewalStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $renewalStatuses = [
            ['name' => 'Renewed'],
            ['name' => 'Inactive'],
            ['name' => 'Expired'],
            ['name' => 'Suspended'],
        ];

        // Seed each sector
        foreach ($renewalStatuses as $renewalStatus) {
            RenewalStatus::create($renewalStatus);
        }
    }
}
