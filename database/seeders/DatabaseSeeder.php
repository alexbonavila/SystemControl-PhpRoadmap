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
            PermissionTableSeeder::class,
            UserTableSeeder::class,
        ]);

        if (env('APP_ENV') !== 'production') {
            $this->call([
                ProjectTableSeeder::class,
                DeviceTableSeeder::class,
                ConfigurationTableSeeder::class,
                ReportTableSeeder::class,
            ]);
        }
    }
}
