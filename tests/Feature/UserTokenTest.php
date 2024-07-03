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

    public function setUp(): void
    {
        parent::setUp();
        // Configurar el entorno de pruebas
    }

    #[Test]
    public function user_can_create_token(): array
    {
        // Crear un usuario
        $user = User::factory()->create([
            'password' => Hash::make('password123')
        ]);

        // Crear un cliente de Passport
        $client = Client::factory()->create([
            'user_id' => null,
            'name' => 'Test Client',
            'redirect' => 'http://localhost',
            'personal_access_client' => false,
            'password_client' => true,
            'revoked' => false,
        ]);

        // Realizar la petición para obtener un token
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

        return ['access_token'=>$response["access_token"], 'user_id'=>$user->id];
    }

    public function authenticated_user_get_info_route(): void
    {
        $params = $this->user_can_create_token();

        $access_token = $params['access_token'];
        $user_id = $params['user_id'];


        // Make authorized request with true token to /api/user
        $response = $this->getJson('/api/user', [
            'Authorization' => 'Bearer ' . $access_token,
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson([
            'id' => $user_id,
        ]);
    }
}
