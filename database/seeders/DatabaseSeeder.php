<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Artisan::call('migrate:refresh');

        $this->call([
            UserTableSeeder::class,
            ProjectTableSeeder::class,
            DeviceTableSeeder::class,
            ConfigurationTableSeeder::class,
            ReportTableSeeder::class,
        ]);
    }
}
