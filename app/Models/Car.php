<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Car extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['owner_id', 'name', 'engine', 'brand', 'localization', 'vin', 'gearbox', 'condition', 'mileage', 'hp', 'price', 'production_date', 'first_registration', 'description', 'color', 'country_of_origin', 'drive', 'body', 'capacity', 'image', 'status'];

    public $timestamps = false;

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}

