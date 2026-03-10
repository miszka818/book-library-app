<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Resources\TagResource;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::all();
        return TagResource::collection($tags);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:tags,name']
        ]);
        $tag = Tag::create($data);
        return new TagResource($tag);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        return new TagResource($tag);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:tags,name,' . $tag->id]
        ]);
        $tag->update($data);
        return new TagResource($tag);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return response()->noContent();
    }
}
