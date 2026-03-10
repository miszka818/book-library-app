<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\UserBook;
use App\Http\Resources\GroupResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class GroupController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Auth::user()->groups()->with('userBooks.book')->get();
        return GroupResource::collection($groups);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $group = Group::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);

        return new GroupResource($group->load('userBooks.book'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        if ($group->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return new GroupResource($group->load('userBooks.book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        if ($group->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $group->update($request->only('name', 'description'));

        return new GroupResource($group->load('userBooks.book'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        if ($group->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $group->delete();

        return response()->json(['message' => 'Group deleted successfully']);
    }

    public function addUserBook(Request $request, Group $group)
    {
        $request->validate([
            'user_book_id' => 'required|exists:user_books,id',
        ]);

        $group->userBooks()->syncWithoutDetaching($request->user_book_id);

        return new GroupResource($group->load('userBooks.book'));
    }

    public function removeUserBook(Group $group, UserBook $userBook)
    {   
        $this->authorize('update', $group);

        $group->userBooks()->detach($userBook->id);

        return response()->noContent();
    }
}
