<?php

namespace Database\Seeders;

use App\Models\RegistrationStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegistrationStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $registrationStatuses = [
            [
                'name' => 'Pending',
                'description' => 'Pending registration',
            ],
            [
                'name' => 'Approved',
                'description' => 'Approved registration',
            ],
            [
                'name' => 'Rejected',
                'description' => 'Rejected registration',
            ],
            [
                'name' => 'Cancelled',
                'description' => 'Cancelled registration',
            ],
        ];

        foreach ($registrationStatuses as $registrationStatus) {
            RegistrationStatus::create($registrationStatus);
        }
    }
}
