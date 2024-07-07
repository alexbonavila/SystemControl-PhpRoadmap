<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class UserRouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_users_cannot_access_user_route()
    {
        $response = $this->getJson('api/user');

        $response->assertStatus(ResponseAlias::HTTP_UNAUTHORIZED);
    }

    public function test_authenticated_users_can_access_user_route()
    {
        $user = User::factory()->create();

        Passport::actingAs($user);

        $response = $this->getJson('api/user');

        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson(['id' => $user->id]);
    }
}
