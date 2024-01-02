<?php

namespace Database\Seeders;

use App\Models\MaritalStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaritalStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $statuses = [
            ['name' => 'Single'],
            ['name' => 'Married'],
            ['name' => 'Widowed'],
            ['name' => 'Divorced'],
        ];

        foreach ($statuses as $status) {
            MaritalStatus::create($status);
        }
    }
}
