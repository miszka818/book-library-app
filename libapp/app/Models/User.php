<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\UserBook;
/**
 * @property-read \Illuminate\Database\Eloquent\Collection|UserBook[] $userBooks
 */

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
        ];
    }
    public function books()
    {
        return $this->belongsToMany(Book::class)
            ->withPivot(['status', 'rating', 'notes'])
            ->withTimestamps();
    }

    public function userBooks()
    {
        return $this->hasMany(UserBook::class);
    }
    
    public function groups()
    {
        return $this->hasMany(Group::class);
    }
    protected static function booted()
    {
        static::created(function ($user) {

            $defaultGroups = [
                'Favorites',
                'To Read',
                'Currently Reading',
                'Finished'
            ];

            foreach ($defaultGroups as $groupName) {
                Group::create([
                    'user_id' => $user->id,
                    'name' => $groupName,
                    'is_default' => true
                ]);
            }
        });
    }
}
