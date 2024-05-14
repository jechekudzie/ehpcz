<?php

namespace Database\Seeders;

use App\Models\EmploymentLocation;
use App\Models\EmploymentStatus;
use App\Models\Profession;
use App\Models\QualificationCategory;
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
            QualificationLevelSeeder::class,
            QualificationSeeder::class,
            QualificationCategorySeeder::class,
            RequirementCategorySeeder::class,
            RequirementSeeder::class,
            RegisterSeeder::class,
            FeesCategorySeeder::class,
            AddressTypeSeeder::class,
            ContactTypeSeeder::class,
            CountriesSeeder::class,
            IdentificationTypeSeeder::class,
            EmploymentSectorSeeder::class,
            EmploymentStatusSeeder::class,
            MaritalStatusSeeder::class,
            InstitutionSeeder::class,
            PaymentMethodSeeder::class,
            RenewalStatusSeeder::class,
            RegistrationStatusSeeder::class,
            OperationalStatusSeeder::class,
            FeeItemsTableSeeder::class,
            CurrencySeeder::class,
            RegistrationRuleSeeder::class,
            ExchangeRateTypeSeeder::class,
            RolesSeeder::class,
            UserSeeder::class

        ]);
    }
}
