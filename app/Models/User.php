<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    public const STATUS_PENDING = 0;
    public const STATUS_ACTIVE = 1;
    public const STATUS_SUSPENDED = 2;
    public const STATUS_BANNED = 3;


    protected $fillable = [
        'username',
        'email',
        'password',
        'name',
        'nickname',
        'gender',
        'studied_at',
        'address',
        'profession',
        'job',
        'marital_status',
        'phone',
        'date_of_birth',
        'about',
        'photo',
        'cover_photo',
        'timezone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function socialAccounts(): HasMany
    {
        return $this->hasMany(UserSocialAccount::class);
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }
}
