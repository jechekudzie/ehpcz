<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $roles = [
            ['name' => 'reception'],
            ['name' => 'admin'],
            ['name' => 'accountant'],
            ['name' => 'accounts-clerk'],
            ['name' => 'procurement'],
            ['name' => 'registrar'],
            ['name' => 'practitioner'],
            ['name' => 'super-admin'],

        ];

        foreach ($roles as $role) {
            $role =Role::create([
                'name' => $role['name'],
                'guard_name' => 'web',
            ]);

        }
    }
}
