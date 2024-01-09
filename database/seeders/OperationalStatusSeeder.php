<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OperationalStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $operationalStatuses = [
            ['name' => 'Active'],
            ['name' => 'Diseased'],
            ['name' => 'Retired'],
            ['name' => 'Resigned'],
            ['name' => 'Suspended'],
            ['name' => 'Terminated'],
        ];

        foreach ($operationalStatuses as $operationalStatus) {
            \App\Models\OperationalStatus::create($operationalStatus);
        }
    }
}
