<?php

namespace Database\Seeders;


use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users = [
            [
                'name' => 'Nigel Jeche',
                'email' => 'nigel@leadingdigital.africa',
                'password' => 'password@1',
                'role' => 'super-admin',

            ],
             [
                 'name' => 'Simba Mupesa',
                 'email' => 'admin@ehpcz.co.zw',
                 'password' => 'password@1',
                 'role' => 'admin',
             ],
        ];

        foreach ($users as $userData) {

            // Create the user
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),
            ]);

            // Check if the 'super-admin' role already exists for the organisation
            $role = Role::firstOrCreate([
                'name' => $userData['role'],
                'guard_name' => 'web',
            ]);

            // Assign the role to the user
            $user->roles()->attach($role->id, [
                'model_type' => get_class($user),
            ]);


            //Mail::to($user->email)->queue(new AccountCreatedMail($user->id, $organisation->id));
        }
    }
}
