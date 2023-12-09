<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $provinces = [
            ["name" => "Bulawayo", "created_at" => now(), "updated_at" => now()],
            ["name" => "Harare", "created_at" => now(), "updated_at" => now()],
            ["name" => "Manicaland", "created_at" => now(), "updated_at" => now()],
            ["name" => "Mashonaland Central", "created_at" => now(), "updated_at" => now()],
            ["name" => "Mashonaland East", "created_at" => now(), "updated_at" => now()],
            ["name" => "Mashonaland West", "created_at" => now(), "updated_at" => now()],
            ["name" => "Masvingo", "created_at" => now(), "updated_at" => now()],
            ["name" => "Matebeleland North", "created_at" => now(), "updated_at" => now()],
            ["name" => "Matebeleland South", "created_at" => now(), "updated_at" => now()],
            ["name" => "Midlands", "created_at" => now(), "updated_at" => now()],
        ];

        Province::insert($provinces);
    }
}
