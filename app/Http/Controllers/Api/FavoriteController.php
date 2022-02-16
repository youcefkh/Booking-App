<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function create($bookable_id)
    {
        $user_id = Auth::user()->id;
        return Favorite::create([
            'user_id' => $user_id,
            'bookable_id' => $bookable_id
        ]);
    }

    public function delete($bookable_id)
    {
        $user_id = Auth::user()->id;
        $fav = Favorite::where('user_id', $user_id)->where('bookable_id', $bookable_id)->first();
        $fav->delete();
    }
}
