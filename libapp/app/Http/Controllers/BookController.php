<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;

class BookController extends Controller
{
    /**
     * Display a listing of the resource, with optional filtering.
     */
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->has('tags')) {
            $tags = explode(',', $request->input('tags'));
            $query->whereHas('tags', function ($q) use ($tags) {
                $q->whereIn('name', $tags);
            });
        }

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        if ($request->has('sort_by')) {
            $sortField = $request->input('sort_by');
            $sortOrder = $request->input('sort_order', 'asc');

            if (in_array($sortField, ['release_year', 'rating'])) {
                $query->orderBy($sortField, $sortOrder);
            }
        }

        $books = $query->with('tags')->get();

        return BookResource::collection($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'release_year' => 'nullable|integer',
            'status' => 'nullable|string|max:50',
            'rating' => 'nullable|numeric|min:0|max:5',
            'notes' => 'nullable|string',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
        ]);

        $book = Book::firstOrCreate(
            ['title' => $validated['title'], 'author' => $validated['author'] ?? null],
            [
                'description' => $validated['description'] ?? null,
                'release_year' => $validated['release_year'] ?? null
            ]
        );

        if (!empty($validated['tags'])) {
            $tagIds = [];
            foreach ($validated['tags'] as $tagName) {
                $tag = \App\Models\Tag::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }
            $book->tags()->sync($tagIds);
        }

        $userBook = Auth::user()->userBooks()->firstOrCreate(
            ['book_id' => $book->id],
            [
                'status' => $validated['status'] ?? null,
                'rating' => $validated['rating'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]
        );

        return new \App\Http\Resources\UserBookResource($userBook->load('book', 'groups'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return new BookResource($book->load('tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'author' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);
        $book->update($validated);
        return new BookResource($book);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->noContent();
    }
}
