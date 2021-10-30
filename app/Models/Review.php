<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'content', 'rating', 'booking_id'];

    public function bookable()
    {
        return $this->belongsTo(Bookable::class);
    }
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
