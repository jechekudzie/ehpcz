<?php

namespace Database\Seeders;

use App\Models\FeeCategory;
use App\Models\PaymentCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeesCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $paymentCategories = [
            ["name" => "REGISTRATION FEES"],
            ["name" => "ANNUAL FEES"],
            ["name" => "TRANSFER FEES"],
            ["name" => "REGISTRATION OF EXTRA QUALIFICATION FEES"],
            ["name" => "MISCELLANEOUS FEES"],
            ["name" => "RESTORATION FEES"],
            ["name" => "PENALTY FEES"],
        ];

        foreach ($paymentCategories as $category) {
            FeeCategory::create($category);
        }
    }
}
