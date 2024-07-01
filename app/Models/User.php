<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'surname',
        'username',
        'mail',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->avatar = 'images/default-avatar.jpg';
        });
    }

    public function cars()
    {
        return $this->hasMany(Car::class, 'owner_id');
    }

    public function activeCars()
    {
        return $this->hasMany(Car::class, 'owner_id')->where('status', 'active');
    }

    public function allCars()
    {
        return $this->hasMany(Car::class, 'owner_id')->withTrashed();
    }
}
