<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $paymentMethods = [
            ['name' => 'CASH - USD'],
            ['name' => 'Ecocash - ZWL'],
            ['name' => 'Transfer - USD'],
            ['name' => 'Swipe - ZWL'],
            ['name' => 'Transfer - ZWL'],
            ['name' => 'Ecocash - USD'],
            ['name' => 'Ecocash Biller'],
            ['name' => 'Paynow Online'],
        ];

        foreach ($paymentMethods as $paymentMethod) {
            PaymentMethod::create($paymentMethod);

        }

    }
}
