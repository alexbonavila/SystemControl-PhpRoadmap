<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class PassportAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_users_cannot_access_user_route()
    {
        $response = $this->getJson('api/user');

        $response->assertStatus(ResponseAlias::HTTP_UNAUTHORIZED);
    }

    public function test_unauthenticated_users_cannot_access_configuration_route()
    {
        $response = $this->getJson('api/configurations');

        $response->assertStatus(ResponseAlias::HTTP_UNAUTHORIZED);
    }

    public function test_unauthenticated_users_cannot_access_device_route()
    {
        $response = $this->getJson('api/devices');

        $response->assertStatus(ResponseAlias::HTTP_UNAUTHORIZED);
    }

    public function test_unauthenticated_users_cannot_access_project_route()
    {
        $response = $this->getJson('api/projects');

        $response->assertStatus(ResponseAlias::HTTP_UNAUTHORIZED);
    }

    public function test_unauthenticated_users_cannot_access_report_route()
    {
        $response = $this->getJson('api/reports');

        $response->assertStatus(ResponseAlias::HTTP_UNAUTHORIZED);
    }

    private function passport_auth_simulation(): void
    {
        $user = User::factory()->create();

        Passport::actingAs($user);
    }

    public function test_authenticated_users_can_access_user_route()
    {
        $this->passport_auth_simulation();

        $response = $this->getJson('api/user');

        $response->assertStatus(ResponseAlias::HTTP_OK);
    }

    public function test_authenticated_users_can_access_configuration_route()
    {
        $this->passport_auth_simulation();

        $response = $this->getJson('api/configurations');

        $response->assertStatus(ResponseAlias::HTTP_OK);
    }

    public function test_authenticated_users_can_access_device_route()
    {
        $this->passport_auth_simulation();

        $response = $this->getJson('api/devices');

        $response->assertStatus(ResponseAlias::HTTP_OK);
    }

    public function test_authenticated_users_can_access_project_route()
    {
        $this->passport_auth_simulation();

        $response = $this->getJson('api/projects');

        $response->assertStatus(ResponseAlias::HTTP_OK);
    }

    public function test_authenticated_users_can_access_report_route()
    {
        $this->passport_auth_simulation();

        $response = $this->getJson('api/reports');

        $response->assertStatus(ResponseAlias::HTTP_OK);
    }
}
