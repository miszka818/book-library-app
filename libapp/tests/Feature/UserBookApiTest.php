<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserBookApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_add_book_to_library()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/user-books', [
                'book_id' => $book->id,
                'status' => 'Reading'
            ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('user_books', [
            'book_id' => $book->id
        ]);
    }
}