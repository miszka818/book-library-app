<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_tag()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/tags', [
                'name' => 'Biography'
            ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('tags', [
            'name' => 'Biography'
        ]);
    }
}