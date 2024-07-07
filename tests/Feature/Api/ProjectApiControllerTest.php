<?php

namespace Tests\Feature\Api;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ProjectApiControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Passport::actingAs($this->user);
    }

    public function test_it_can_list_projects()
    {
        Project::factory()->count(3)->create();

        $response = $this->getJson(route('projects.index'));

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_it_can_create_a_project()
    {
        $data = [
            'name' => 'Project A',
            'description' => 'Description of Project A'
        ];

        $response = $this->postJson(route('projects.store'), $data);

        $response->assertStatus(201)
            ->assertJsonFragment($data);

        $this->assertDatabaseHas('projects', $data);
    }

    public function test_it_can_show_a_project()
    {
        $project = Project::factory()->create();

        $response = $this->getJson(route('projects.show', $project->id));

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $project->id,
                'name' => $project->name
            ]);
    }

    public function test_it_can_update_a_project()
    {
        $project = Project::factory()->create();

        $data = [
            'name' => 'Updated Project',
            'description' => 'Updated Description'
        ];

        $response = $this->putJson(route('projects.update', $project->id), $data);

        $response->assertStatus(200)
            ->assertJsonFragment($data);

        $this->assertDatabaseHas('projects', $data);
    }

    public function test_it_can_delete_a_project()
    {
        $project = Project::factory()->create();

        $response = $this->deleteJson(route('projects.destroy', $project->id));

        $response->assertStatus(204);

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    public function test_it_can_attach_a_user_to_a_project()
    {
        $project = Project::factory()->create();
        $user = User::factory()->create();

        $response = $this->postJson("/api/projects/{$project->id}/attach-user", ['user_id' => $user->id]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $user->id
            ]);

        $this->assertDatabaseHas('users_projects', [
            'project_id' => $project->id,
            'user_id' => $user->id
        ]);
    }

    public function test_it_can_detach_a_user_from_a_project()
    {
        $project = Project::factory()->create();
        $user = User::factory()->create();
        $project->users()->attach($user->id);

        $response = $this->postJson("/api/projects/{$project->id}/detach-user", ['user_id' => $user->id]);

        $response->assertStatus(200)
            ->assertJsonMissing([
                'id' => $user->id
            ]);

        $this->assertDatabaseMissing('users_projects', [
            'project_id' => $project->id,
            'user_id' => $user->id
        ]);
    }
}
