<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GroupApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_group()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/groups', [
                'name' => 'Sci-Fi',
                'description' => 'Science fiction books'
            ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('groups', [
            'name' => 'Sci-Fi'
        ]);
    }
}