<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\ProjectRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class ProjectRequestTest extends TestCase
{
    public function test_project_request_validation_rules()
    {
        $request = new ProjectRequest();

        $rules = $request->rules();

        $validator = Validator::make([
            'name' => 'Project Name',
            'description' => 'Project Description'
        ], $rules);

        $this->assertTrue($validator->passes());
    }

    public function test_project_request_validation_fails()
    {
        $request = new ProjectRequest();

        $rules = $request->rules();

        $validator = Validator::make([
            'name' => '',
            'description' => ''
        ], $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('name', $validator->errors()->messages());
        $this->assertArrayHasKey('description', $validator->errors()->messages());
    }
}
