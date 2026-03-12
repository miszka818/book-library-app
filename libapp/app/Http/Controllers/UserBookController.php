<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserBookResource;
use App\Models\UserBook;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserBookController extends Controller
{
     use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $userBooks = $user
            ->userBooks()
            ->with(['book.tags', 'groups'])
            ->get();

        return UserBookResource::collection($userBooks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'status' => 'nullable|string|max:50',
            'rating' => 'nullable|numeric|min:0|max:5',
            'notes' => 'nullable|string',
        ]);

        $user = Auth::user();

        return new UserBookResource(
            $user->userBooks()->create($validated)->load(['book.tags', 'groups'])
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(UserBook $userBook)
    {
        $this->authorize('view', $userBook);

        return new UserBookResource($userBook->load(['book.tags', 'groups']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserBook $userBook)
    {
        $this->authorize('update', $userBook);

        $validated = $request->validate([
            'status' => 'nullable|string|max:50',
            'rating' => 'nullable|numeric|min:0|max:5',
            'notes' => 'nullable|string',
        ]);

        $userBook->update($validated);

        return new UserBookResource($userBook->load('book', 'groups'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserBook $userBook)
    {
        $this->authorize('delete', $userBook);

        $userBook->delete();

        return response()->noContent();
    }
}
