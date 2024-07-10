<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    private int $usersNumber = 10;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => env('BASIC_NAME','Basic User'),
                'email' => env('BASIC_EMAIL','basic@example.com'),
                'password' => env('BASIC_PASSWORD', bcrypt('12345678')),
                'role' => 'basic-user'
            ],
            [
                'name' => env('ADMIN_NAME','Admin User'),
                'email' => env('ADMIN_EMAIL','admin@example.com'),
                'password' => env('ADMIN_PASSWORD', bcrypt('12345678')),
                'role' => 'admin'
            ],
            [
                'name' => env('MAINTAINER_NAME','Maintainer User'),
                'email' => env('MAINTAINER_EMAIL','maintainer@example.com'),
                'password' => env('MAINTAINER_PASSWORD', bcrypt('12345678')),
                'role' => 'maintainer'
            ],
            [
                'name' => env('FULL_NAME','Regular User'),
                'email' => env('FULL_EMAIL','user@example.com'),
                'password' => env('FULL_PASSWORD', bcrypt('12345678')),
                'role' => 'full-user'
            ]
        ];

        foreach ($users as $userData) {
            $user = User::factory()->withPersonalTeam()->create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => $userData['password']
            ]);

            // Assign role to user
            $user->assignRole($userData['role']);
        }

        if (env('APP_ENV') !== 'production') {
            // Create additional users
            User::factory($this->usersNumber)->withPersonalTeam()->create()->each(function ($user) {
                $user->assignRole('basic-user');
            });
        }
    }
}
