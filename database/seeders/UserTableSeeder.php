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
        User::factory()->withPersonalTeam()->create([
            'email' => 'test@test.com',
            'password' => bcrypt('12345678'),
        ]);

        User::factory($this->usersNumber)->withPersonalTeam()->create();
    }
}
