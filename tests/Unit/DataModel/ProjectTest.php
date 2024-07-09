<?php

namespace Tests\Unit\DataModel;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_project()
    {
        $project = Project::factory()->create();

        $this->assertDatabaseHas('projects', [
            'id' => $project->id
        ]);
    }

    public function test_update_project()
    {
        $project = Project::factory()->create();

        $project->name = 'updated_project_name';
        $project->save();

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'name' => 'updated_project_name'
        ]);
    }

    public function test_delete_project()
    {
        $project = Project::factory()->create();

        $project->delete();

        $this->assertDatabaseMissing('projects', [
            'id' => $project->id
        ]);
    }
}
