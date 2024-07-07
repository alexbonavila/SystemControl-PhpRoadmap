<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use App\Models\Report;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportApiControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user, 'api');
    }

    #[Test]
    public function it_can_list_reports()
    {
        Report::factory()->count(3)->create();

        $response = $this->getJson(route('reports.index'));

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    #[Test]
    public function it_can_create_a_report()
    {
        $data = [
            'reportable_id' => 1,
            'reportable_type' => 'App\\Models\\SomeModel',
            'format' => 'PDF',
            'content' => 'Report content'
        ];

        $response = $this->postJson(route('reports.store'), $data);

        $response->assertStatus(201)
            ->assertJsonFragment($data);

        $this->assertDatabaseHas('reports', $data);
    }

    #[Test]
    public function it_can_show_a_report()
    {
        $report = Report::factory()->create();

        $response = $this->getJson(route('reports.show', $report->id));

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $report->id,
                'content' => $report->content
            ]);
    }

    #[Test]
    public function it_can_update_a_report()
    {
        $report = Report::factory()->create();

        $data = [
            'content' => 'Updated content'
        ];

        $response = $this->putJson(route('reports.update', $report->id), $data);

        $response->assertStatus(200)
            ->assertJsonFragment($data);

        $this->assertDatabaseHas('reports', $data);
    }

    #[Test]
    public function it_can_delete_a_report()
    {
        $report = Report::factory()->create();

        $response = $this->deleteJson(route('reports.destroy', $report->id));

        $response->assertStatus(204);

        $this->assertDatabaseMissing('reports', ['id' => $report->id]);
    }
}
