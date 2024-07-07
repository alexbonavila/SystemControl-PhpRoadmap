<?php

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use App\Models\Device;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeviceApiControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user, 'api');
    }

    #[Test]
    public function it_can_list_devices()
    {
        Device::factory()->count(3)->create();

        $response = $this->getJson(route('devices.index'));

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    #[Test]
    public function it_can_create_a_device()
    {
        $data = [
            'user_id' => $this->user->id,
            'model' => 'Model X',
            'serial_number' => 'SN123456'
        ];

        $response = $this->postJson(route('devices.store'), $data);

        $response->assertStatus(201)
            ->assertJsonFragment($data);

        $this->assertDatabaseHas('devices', $data);
    }

    #[Test]
    public function it_can_show_a_device()
    {
        $device = Device::factory()->create();

        $response = $this->getJson(route('devices.show', $device->id));

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $device->id,
                'model' => $device->model
            ]);
    }

    #[Test]
    public function it_can_update_a_device()
    {
        $device = Device::factory()->create();

        $data = [
            'model' => 'Model Y',
            'serial_number' => 'SN654321'
        ];

        $response = $this->putJson(route('devices.update', $device->id), $data);

        $response->assertStatus(200)
            ->assertJsonFragment($data);

        $this->assertDatabaseHas('devices', $data);
    }

    #[Test]
    public function it_can_delete_a_device()
    {
        $device = Device::factory()->create();

        $response = $this->deleteJson(route('devices.destroy', $device->id));

        $response->assertStatus(204);

        $this->assertDatabaseMissing('devices', ['id' => $device->id]);
    }
}
