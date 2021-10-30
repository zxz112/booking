<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bookable;

class BookingAvailableController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id, Request $request)
    {
        $request->validate([
            'to' => ['required', 'date_format:Y-m-d'],
            'from' => ['required', 'date_format:Y-m-d'],
        ]);
        $bookable = Bookable::findOrFail($id);
        return $bookable->checkDate($request->from, $request->to)
            ? response()->json([])
            : response()->json([], 404);
    }
}
