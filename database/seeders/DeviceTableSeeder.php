<?php

namespace Database\Seeders;

use App\Models\Device;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeviceTableSeeder extends Seeder
{
    private int $devicesNumber = 10;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Device::factory($this->devicesNumber)->create();
    }
}
