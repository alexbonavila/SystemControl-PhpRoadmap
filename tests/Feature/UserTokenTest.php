<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Client;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Illuminate\Support\Facades\Hash;

class UserTokenTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    private function createUser(): User
    {
        return User::factory()->create([
            'password' => Hash::make('password123')
        ]);
    }

    private function createClient(): Client
    {
        return Client::factory()->create([
            'user_id' => null,
            'name' => 'Test Client',
            'redirect' => 'http://localhost',
            'personal_access_client' => false,
            'password_client' => true,
            'revoked' => false,
        ]);
    }

    private function getTokenForUser(User $user, Client $client): string
    {
        $response = $this->postJson('/oauth/token', [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->plainSecret,
            'username' => $user->email,
            'password' => 'password123',
            'scope' => '',
        ]);

        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJsonStructure([
            'token_type',
            'expires_in',
            'access_token',
            'refresh_token',
        ]);

        return $response['access_token'];
    }

    #[Test]
    public function user_can_create_token(): void
    {
        $user = $this->createUser();
        $client = $this->createClient();
        $token = $this->getTokenForUser($user, $client);

        $this->assertNotEmpty($token);
    }

    #[Test]
    public function authenticated_user_can_get_info(): void
    {
        $user = $this->createUser();
        $client = $this->createClient();
        $token = $this->getTokenForUser($user, $client);

        $response = $this->getJson('/api/user', [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson([
            'id' => $user->id,
        ]);
    }
}
