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
            ["name" => "Registration fees", "created_at" => now(), "updated_at" => now()],
            ["name" => "Annual fees", "created_at" => now(), "updated_at" => now()],
            ["name" => "Application for foreign registrants", "created_at" => now(), "updated_at" => now()],
            ["name" => "Registration of Extra Qualification", "created_at" => now(), "updated_at" => now()],
            ["name" => "Miscellaneous fees", "created_at" => now(), "updated_at" => now()],
        ];

        PaymentCategory::insert($paymentCategories);
    }
}
