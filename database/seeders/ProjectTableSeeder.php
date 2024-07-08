<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ProjectTableSeeder extends Seeder
{
    private int $projectsNumber = 10;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::factory($this->projectsNumber)->create();
    }
}
