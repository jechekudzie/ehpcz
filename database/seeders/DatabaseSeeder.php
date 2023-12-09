<?php

namespace Database\Seeders;

use App\Models\EmploymentLocation;
use App\Models\Profession;
use App\Models\Requirement;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            ProvinceSeeder::class,
            CitySeeder::class,
            TitleSeeder::class,
            GenderSeeder::class,
            ProfessionSeeder::class,
            QualificationSeeder::class,
            InstitutionSeeder::class,
            RequirementCategorySeeder::class,
            RequirementSeeder::class,
            RegisterSeeder::class,
            PaymentCategorySeeder::class,
            AddressTypeSeeder::class,
            ContactTypeSeeder::class,
            CountriesSeeder::class

        ]);
    }
}
