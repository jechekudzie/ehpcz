<?php

namespace Database\Seeders;

use App\Models\PaymentCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentCategorySeeder extends Seeder
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
            ["name" => "Registration fees"],
            ["name" => "Annual fees"],
            ["name" => "Application for foreign registrants"],
            ["name" => "Registration of Extra Qualification"],
            ["name" => "Miscellaneous fees"],
        ];

        foreach ($paymentCategories as $category) {
            PaymentCategory::create($category);
        }
    }
}
