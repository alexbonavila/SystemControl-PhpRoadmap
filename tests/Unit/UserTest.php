<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_user()
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas('users', [
            'id' => $user->id
        ]);
    }

    public function test_update_user()
    {
        $user = User::factory()->create();
        $user->update(['name' => 'new_user_name']);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'new_user_name'
        ]);
    }

    public function test_delete_user()
    {
        $user = User::factory()->create();
        $user->delete();

        $this->assertDatabaseMissing('users', [
            'id' => $user->id
        ]);
    }
}
