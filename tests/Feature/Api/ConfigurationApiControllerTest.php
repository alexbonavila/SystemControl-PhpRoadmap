<?php

namespace Tests\Feature\Api;

use App\Models\Configuration;
use App\Models\Device;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ConfigurationApiControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Passport::actingAs($this->user);
    }

    #[Test]
    public function it_can_list_configurations()
    {
        for ($i = 0; $i < 3; $i++) {
            $device = Device::factory()->create();
            Configuration::factory()->create(['device_id' => $device->id]);
        }

        $response = $this->getJson(route('configurations.index'));

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    #[Test]
    public function it_can_create_a_configuration()
    {
        $device = Device::factory()->create();
        $data = [
            'device_id' => $device->id,
            'cpu' => 'Intel i7',
            'ram' => '16GB',
            'storage' => '512GB SSD'
        ];

        $response = $this->postJson(route('configurations.store'), $data);

        $response->assertStatus(201)
            ->assertJsonFragment($data);

        $this->assertDatabaseHas('configurations', $data);
    }

    #[Test]
    public function it_can_show_a_configuration()
    {
        $device = Device::factory()->create();
        $configuration = Configuration::factory()->create(['device_id' => $device->id]);

        $response = $this->getJson(route('configurations.show', $configuration->id));

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $configuration->id,
                'device_id' => $device->id
            ]);
    }

    #[Test]
    public function it_can_update_a_configuration()
    {
        $device = Device::factory()->create();
        $configuration = Configuration::factory()->create(['device_id' => $device->id]);

        $data = [
            'device_id' => $device->id,
            'cpu' => 'Intel i9',
            'ram' => '32GB',
            'storage' => '1TB SSD'
        ];

        $response = $this->putJson(route('configurations.update', $configuration->id), $data);

        $response->assertStatus(200)
            ->assertJsonFragment($data);

        $this->assertDatabaseHas('configurations', $data);
    }

    #[Test]
    public function it_can_delete_a_configuration()
    {
        $device = Device::factory()->create();
        $configuration = Configuration::factory()->create(['device_id' => $device->id]);

        $response = $this->deleteJson(route('configurations.destroy', $configuration->id));

        $response->assertStatus(204);

        $this->assertDatabaseMissing('configurations', ['id' => $configuration->id]);
    }
}
