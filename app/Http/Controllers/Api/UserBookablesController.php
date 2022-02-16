<?php

namespace App\Http\Controllers\Api;

use App\Models\Bookable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookableIndexResource;
use Illuminate\Support\Facades\Auth;

class UserBookablesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $id)
    {
        return Bookable::where('user_id', $id)->with(['location', 'thumbnail', 'averageRating', 'user', 'user.profileImage'])->paginate(6);
    }
}
