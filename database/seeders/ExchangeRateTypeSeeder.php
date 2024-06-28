<?php

namespace Database\Seeders;


use App\Models\ExchangeRateType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExchangeRateTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $exchangeRateTypes = [
            ["name" => "INTERBANK RATE"],
            ["name" => "ALLOWANCE RATE"],
            ["name" => "BLACKMARKET RATE"],
        ];

        foreach ($exchangeRateTypes as $exchangeRateType) {
            ExchangeRateType::create($exchangeRateType);
        }
    }
}
