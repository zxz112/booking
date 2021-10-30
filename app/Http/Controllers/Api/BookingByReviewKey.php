<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Http\Resources\BookingByReviewShowResource;

class BookingByReviewKey extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $key)
    {
        $data = Booking::bookingByReviewKey($key);
        return $data ? new BookingByReviewShowResource($data) : abort(404);
    }
}
