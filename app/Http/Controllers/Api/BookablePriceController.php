<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bookable;
use Illuminate\Http\Request;

class BookablePriceController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $bookable = Bookable::findOrFail($id);

        $booking = $request->validate([
            "from" => "required | date | after_or_equal:today",
            "to" => "required | date | after:from",
        ]);

        return response()->json([
            'data' => $bookable->priceFor($booking['from'], $booking['to'])
        ]);
    }
}
