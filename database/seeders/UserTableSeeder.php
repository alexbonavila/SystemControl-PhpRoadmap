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
                'name' => 'Test User',
                'email' => 'test@test.com',
                'password' => bcrypt('12345678'),
                'role' => 'basic-user'
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@test.com',
                'password' => bcrypt('12345678'),
                'role' => 'admin'
            ],
            [
                'name' => 'Mantainer User',
                'email' => 'mantainer@test.com',
                'password' => bcrypt('12345678'),
                'role' => 'maintainer'
            ],
            [
                'name' => 'Regular User',
                'email' => 'user@test.com',
                'password' => bcrypt('12345678'),
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

        // Create additional users
        User::factory($this->usersNumber)->withPersonalTeam()->create()->each(function ($user) {
            $user->assignRole('basic-user');
        });
    }
}
