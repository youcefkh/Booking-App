<?php

namespace App\Http\Controllers\Api;

use App\Models\Review;
use App\Models\Bookable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookableReviewResource;

class BookableReviewController extends Controller
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
        /* $reviews = DB::table('users')
                    ->join('reviews', 'users.id', '=', 'reviews.user_id')
                    ->where('reviews.bookable_id', '=', $id)
                    ->select('reviews.*', 'users.name', 'users.username')
                    ->paginate(6); */
        $reviews = Review::where('bookable_id', $id)->orderBy('id', 'desc')->with(['user', 'user.profileImage'])->paginate(6);

        return $reviews;
    }
}
