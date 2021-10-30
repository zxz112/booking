<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookable extends Model
{
    use HasFactory;
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function checkDate($from, $to)
    {
        $res = $this->bookings()->betweenDates($from, $to);
        return count($res) > 0;
    }
    public function priceFor($from, $to)
    {
        $from = new Carbon($from);
        $diffDays = $from->diffInDays(new Carbon(($to)));
        $price = $diffDays * $this->price;

        return [
            'total' => $price,
            'breakdown' => [
                $this->price => $diffDays
            ]
        ];
    }
}
