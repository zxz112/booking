<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Bookable;

class PriceForBookable extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $id)
    {
        $bookable = Bookable::findOrFail($id);
        $request->validate([
            'to' => ['required', 'date_format:Y-m-d'],
            'from' => ['required', 'date_format:Y-m-d'],
        ]);

        return response()->json([
           'data' => $bookable->priceFor($request->from, $request->to)
        ]);
    }
}
