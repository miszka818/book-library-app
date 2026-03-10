<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'author',
        'description',
        'release_year',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot(['status', 'rating', 'notes'])
            ->withTimestamps();
    }

    public function userBooks()
    {
        return $this->hasMany(UserBook::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}