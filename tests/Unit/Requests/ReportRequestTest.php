<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\ReportRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class ReportRequestTest extends TestCase
{
    public function test_report_request_validation_rules()
    {
        $request = new ReportRequest();

        $rules = $request->rules();

        $validator = Validator::make([
            'reportable_id' => 1,
            'reportable_type' => 'App\\Models\\SomeModel',
            'format' => 'PDF',
            'content' => 'Report Content'
        ], $rules);

        $this->assertTrue($validator->passes());
    }

    public function test_report_request_validation_fails()
    {
        $request = new ReportRequest();

        $rules = $request->rules();

        $validator = Validator::make([
            'reportable_id' => null,
            'reportable_type' => '',
            'format' => '',
            'content' => ''
        ], $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('reportable_id', $validator->errors()->messages());
        $this->assertArrayHasKey('reportable_type', $validator->errors()->messages());
        $this->assertArrayHasKey('format', $validator->errors()->messages());
        $this->assertArrayHasKey('content', $validator->errors()->messages());
    }
}
