<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Device;

class DeviceTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_device()
    {
        $device = Device::factory()->create();

        $this->assertDatabaseHas('devices', [
            'id' => $device->id
        ]);
    }

    public function test_update_device()
    {
        $device = Device::factory()->create();

        $device->model = 'new_device_model';
        $device->save();

        $this->assertDatabaseHas('devices', [
            'id' => $device->id,
            'model' => 'new_device_model'
        ]);
    }

    public function test_delete_device()
    {
        $device = Device::factory()->create();

        $device->delete();

        $this->assertDatabaseMissing('devices', [
            'id' => $device->id
        ]);
    }
}