<?php

namespace Database\Seeders;

use App\Models\Report;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportTableSeeder extends Seeder
{
    private int $reportsNumber = 10;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Report::factory($this->reportsNumber)->create();
    }
}
