<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id', 'current_bid_id', 'queue', 'current_price'//,'end_time'  | zmiana po wyslaniu dokumentacji
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function currentBid()
    {
        return $this->belongsTo(Bid::class, 'current_bid_id');
    }
    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    // public function end()
    // {
        
    // }
}

