<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bookable;
use Illuminate\Http\Request;

class BookableAvailabilityController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $id)
    {
        $booking = $request->validate([
            "from" => "required | date | after_or_equal:today",
            "to" => "required | date | after:from",
        ]);

        $bookable = Bookable::findOrFail($id);

        return $bookable->availableFor($booking['from'], $booking['to'])
            ? response()->json([])
            : response()->json(["message" => "The property is not available for this date"], 404) ;
    }
}
