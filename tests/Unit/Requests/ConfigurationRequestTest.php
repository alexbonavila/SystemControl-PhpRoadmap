<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\ConfigurationRequest;
use App\Models\Device;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class ConfigurationRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_configuration_request_validation_rules()
    {
        $device = Device::factory()->create();
        $request = new ConfigurationRequest();

        $rules = $request->rules();

        $validator = Validator::make([
            'device_id' => $device->id,
            'cpu' => 'Intel i7',
            'ram' => '16GB',
            'storage' => '512GB SSD'
        ], $rules);

        $this->assertTrue($validator->passes());
    }

    public function test_configuration_request_validation_fails_repeated_device()
    {
        $device = Device::factory()->create();
        $request = new ConfigurationRequest();

        $rules = $request->rules();

        $validator = Validator::make([
            'device_id' => $device->id,
            'cpu' => 'Intel i7',
            'ram' => '16GB',
            'storage' => '512GB SSD'
        ], $rules);

        $this->assertTrue($validator->passes());

        $validator = Validator::make([
            'device_id' => $device->id,
            'cpu' => 'Intel i9',
            'ram' => '32GB',
            'storage' => '256GB SSD'
        ], $rules);

        $this->assertTrue($validator->passes());
    }

    public function test_configuration_request_validation_fails_device_no_exist()
    {
        $request = new ConfigurationRequest();

        $rules = $request->rules();

        $validator = Validator::make([
            'device_id' => 1,
            'cpu' => 'Intel i7',
            'ram' => '16GB',
            'storage' => '512GB SSD'
        ], $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('device_id', $validator->errors()->messages());
    }

    public function test_configuration_request_validation_fails()
    {
        $request = new ConfigurationRequest();

        $rules = $request->rules();

        $validator = Validator::make([
            'device_id' => null,
            'cpu' => '',
            'ram' => '',
            'storage' => ''
        ], $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('device_id', $validator->errors()->messages());
        $this->assertArrayHasKey('cpu', $validator->errors()->messages());
        $this->assertArrayHasKey('ram', $validator->errors()->messages());
        $this->assertArrayHasKey('storage', $validator->errors()->messages());
    }
}
