<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class UserRouteTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function unauthenticated_users_cannot_access_user_route()
    {
        $response = $this->get('api/user', ["Accept" => "application/json"]);

        $response->assertStatus(ResponseAlias::HTTP_UNAUTHORIZED);
    }

    #[Test]
    public function authenticated_users_can_access_user_route()
    {
        $user = User::factory()->create();

        Passport::actingAs($user);

        $response = $this->get('api/user', ["Accept" => "application/json"]);

        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson(['id' => $user->id]);
    }
}
