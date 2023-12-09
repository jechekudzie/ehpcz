<?php

namespace Database\Seeders;

use App\Models\ContactType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $contactTypes = [
            ["name" => "Mobile", "created_at" => now(), "updated_at" => now()],
            ["name" => "Email", "created_at" => now(), "updated_at" => now()],
            ["name" => "Business", "created_at" => now(), "updated_at" => now()],
        ];

        ContactType::insert($contactTypes);
    }
}
