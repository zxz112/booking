<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Validation\Rule;
use App\Models\Booking;


class ReviewController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        return Review::findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|unique:reviews|uuid',
            'rating' => ['required', Rule::in(['1', '2', '3', '4', '5'])],
            'content' => 'required|min:2',
        ]);
        $booking =  Booking::bookingByReviewKey($data['id']);
        if ($booking == null) {
            return abort(404);
        }
        $booking->review_key = '';
        $booking->save();
        $review = Review::make($data);
        $review->booking_id = $booking->id;
        $review->bookable_id = $booking->bookable->id;
        $review->save();
        return $review;
    }
}
