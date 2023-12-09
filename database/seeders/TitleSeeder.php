<?php

namespace Database\Seeders;

use App\Models\Title;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $titles = [
            [
                'name' => 'Mr',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Mrs',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Miss',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Ms',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Dr.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Prof.',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        Title::insert($titles);
    }
}
