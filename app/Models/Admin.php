<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    public const STATUS_DISABLED = 0;
    public const STATUS_ACTIVE = 1;


    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }
}
