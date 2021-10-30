<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['from', 'to', 'price'];
    public function bookable()
    {
        return $this->belongsTo(Bookable::class);
    }
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    static function bookingByReviewKey($key) {
        return self::where('review_key', $key)->with('bookable')->get()->first();
    }

    static function scopeBetweenDates(Builder $query, $from, $to) {
        return $query->where('from', '>=', $from)->where('to', '<=', $to)->get();
    }
    protected static function booted()
    {
        static::creating(function ($booking) {
            $booking->review_key = \Illuminate\Support\Str::uuid();
        });
    }
}
