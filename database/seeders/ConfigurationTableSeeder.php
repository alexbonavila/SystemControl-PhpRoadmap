<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigurationTableSeeder extends Seeder
{
    private int $configurationsNumber = 10; // Same as $deviceNumber in DeviceTableSeeder

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Configuration::factory($this->configurationsNumber)->create();
    }
}
