<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CertificateTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $certificateTypes = [
            [
                'name' => 'Registration Certificate',
                'description' => 'This certificate signifies that the holder is officially registered.'
            ],
            [
                'name' => 'Practicing Certificate',
                'description' => 'This certificate permits the holder to practice their profession.'
            ],
            [
                'name' => 'Certificate of Good Standing',
                'description' => 'This certificate confirms that the holder is in good standing with the issuing authority.'
            ]
        ];

        foreach ($certificateTypes as $type) {
            DB::table('certificate_types')->insert([
                'name' => $type['name'],
                'description' => $type['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
