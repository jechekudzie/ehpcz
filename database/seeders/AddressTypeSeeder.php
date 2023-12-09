<?php

namespace Database\Seeders;

use App\Models\AddressType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $addressTypes = [
            ["name" => "Physical", "created_at" => now(), "updated_at" => now()],
            ["name" => "Residential", "created_at" => now(), "updated_at" => now()],
            ["name" => "Business", "created_at" => now(), "updated_at" => now()],
        ];

        AddressType::insert($addressTypes);
    }
}
