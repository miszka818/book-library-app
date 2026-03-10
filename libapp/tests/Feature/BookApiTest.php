<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_get_books_list()
    {
        $user = User::factory()->create();

        Book::factory()->count(5)->create();

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/books');

        $response->assertStatus(200);
    }

    public function test_user_can_create_book_and_userbook()
    {
        $user = User::factory()->create();

        $data = [
            'title' => 'Test Book',
            'author' => 'Test Author',
            'status' => 'To Read',
            'rating' => 5,
            'tags' => ['Fantasy']
        ];

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/books', $data);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'title' => 'Test Book'
            ]);

        $this->assertDatabaseHas('books', [
            'title' => 'Test Book'
        ]);

        $this->assertDatabaseHas('user_books', [
            'status' => 'To Read'
        ]);
    }
}