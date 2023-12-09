<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $genders = [
            [
                'name' => 'Male',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Female',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        Gender::insert($genders);
    }
}
