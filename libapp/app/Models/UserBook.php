<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBook extends Model
{
    protected $table = 'user_books';

    protected $fillable = [
        'user_id',
        'book_id',
        'status',
        'rating',
        'notes'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_user_books');
    }
}