<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserBookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'book' => new BookResource($this->whenLoaded('book')),
            'status' => $this->status,
            'rating' => $this->rating,
            'notes' => $this->notes,
            'groups' => $this->groups->pluck('name'),
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}