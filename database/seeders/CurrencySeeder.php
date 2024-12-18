<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $currencies = [
            ['name' => 'USD', 'symbol' => '$USD'],
            ['name' => 'ZIG', 'symbol' => '$ZIG'],
        ];

        foreach ($currencies as $currency) {
            \App\Models\Currency::create($currency);
        }
    }
}
