<?php

namespace Tests\Unit\DataModel;

use App\Models\Report;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_report()
    {
        $report = Report::factory()->create();

        $this->assertDatabaseHas('reports', [
            'id' => $report->id
        ]);
    }

    public function test_update_report()
    {
        $report = Report::factory()->create();

        $report->update(['content' => 'new_report_content']);

        $this->assertDatabaseHas('reports', [
            'id' => $report->id,
            'content' => 'new_report_content'
        ]);
    }

    public function test_delete_report()
    {
        $report = Report::factory()->create();
        $report->delete();

        $this->assertDatabaseMissing('reports', [
            'id' => $report->id
        ]);
    }
}
