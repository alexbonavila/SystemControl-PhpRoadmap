<?php


namespace Tests\Unit\Requests;

use App\Http\Requests\DeviceRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class DeviceRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_device_request_validation_rules()
    {
        $user = User::factory()->create();
        $request = new DeviceRequest();

        $rules = $request->rules();

        $validator = Validator::make([
            'user_id' => $user->id,
            'model' => 'Model X',
            'serial_number' => '12345'
        ], $rules);

        $this->assertTrue($validator->passes());
    }

    public function test_device_request_validation_no_exist_user_fails()
    {
        $user = User::factory()->create();
        $request = new DeviceRequest();

        $rules = $request->rules();

        $validator = Validator::make([
            'user_id' => 9999999,
            'model' => 'Model X',
            'serial_number' => '12345'
        ], $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('user_id', $validator->errors()->messages());
    }

    public function test_device_request_validation_fails()
    {
        $request = new DeviceRequest();

        $rules = $request->rules();

        $validator = Validator::make([
            'user_id' => null,
            'model' => '',
            'serial_number' => ''
        ], $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('user_id', $validator->errors()->messages());
        $this->assertArrayHasKey('model', $validator->errors()->messages());
        $this->assertArrayHasKey('serial_number', $validator->errors()->messages());
    }
}
