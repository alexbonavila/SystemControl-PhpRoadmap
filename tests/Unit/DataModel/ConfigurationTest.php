<?php

namespace Tests\Unit\DataModel;

use App\Models\Configuration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConfigurationTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_configuration()
    {
        $configuration = Configuration::factory()->create();

        $this->assertDatabaseHas('configurations', [
            'id' => $configuration->id
        ]);
    }

    public function test_update_configuration()
    {
        $configuration = Configuration::factory()->create();

        $configuration->ram="4GB";
        $configuration->save();

        $this->assertDatabaseHas('configurations', [
            'id' => $configuration->id,
            'ram' => '4GB'
        ]);
    }

    public function test_delete_configuration()
    {
        $configuration = Configuration::factory()->create();

        $configuration->delete();

        $this->assertDatabaseMissing('configurations', [
            'id' => $configuration->id
        ]);
    }
}
