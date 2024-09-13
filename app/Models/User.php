<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'address',
        'phone_number',
        'sim_number',
        'password',
    ];

    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }
    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
