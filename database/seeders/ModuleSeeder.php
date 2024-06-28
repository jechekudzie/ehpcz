<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $modules = [
            'Practitioner',
            'Contact',
            'Employment',
            'Profession',
            'CPD',
            'Disciplinary',
            'Renewal',
            'Registration',
            'Qualification',
            'Payment',
            'Fee Category',
            'Fee Item',
            'Registration Rule',
            'Exchange Rate',
            'Penalty Setting',
            'Certificate',
            'Report',
        ];

        foreach ($modules as $module) {
            Module::create(['name' => ucfirst($module)]);
        }
    }
}
