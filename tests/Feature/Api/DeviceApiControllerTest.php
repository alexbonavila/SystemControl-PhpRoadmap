<?php

namespace Tests\Feature\Api;

use App\Models\Device;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class DeviceApiControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Passport::actingAs($this->user);
    }

    public function test_it_can_list_devices()
    {
        Device::factory()->count(3)->create();

        $response = $this->getJson('/api/devices');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_it_can_create_a_device()
    {
        $data = [
            'user_id' => $this->user->id,
            'model' => 'Model X',
            'serial_number' => 'SN123456'
        ];

        $response = $this->postJson('/api/devices', $data);

        $response->assertStatus(201)
            ->assertJsonFragment($data);

        $this->assertDatabaseHas('devices', $data);
    }

    public function test_it_can_show_a_device()
    {
        $device = Device::factory()->create();

        $response = $this->getJson("/api/devices/{$device->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $device->id,
                'model' => $device->model
            ]);
    }

    public function test_it_can_update_a_device()
    {
        $user = User::factory()->create();
        $device = Device::factory()->create(['user_id' => $user->id]);

        $data = [
            'user_id' => $user->id,
            'model' => 'Model Y',
            'serial_number' => 'SN654321'
        ];

        $response = $this->putJson("/api/devices/{$device->id}", $data);

        $response->assertStatus(200)
            ->assertJsonFragment($data);

        $this->assertDatabaseHas('devices', $data);
    }


    public function test_it_can_delete_a_device()
    {
        $device = Device::factory()->create();

        $response = $this->deleteJson("/api/devices/{$device->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('devices', ['id' => $device->id]);
    }
}
