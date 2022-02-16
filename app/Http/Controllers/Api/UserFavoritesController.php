<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Bookable;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UserFavoritesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $id)
    {
        $ids = Favorite::where('user_id', $id)->get('bookable_id');
        $bookables = Bookable::whereIn('id', $ids)->orderBy('id', 'DESC')->with(['location', 'thumbnail', 'averageRating', 'user', 'user.profileImage'])->paginate(6);
        return $bookables;
    }
}
