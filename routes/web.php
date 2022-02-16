<?php

use App\Models\CoverImage;
use App\Models\Favorite;
use App\Models\ProfileImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::middleware('auth:sanctum')->get('/user', [function (Request $request) {
    /* return response()
    ->json(['name' => 'Abigail', 'state' => 'CA', $request->user()]); */
    $user = $request->user();
    $user->profile = ProfileImage::select('original', 'cropped')->where('user_id', $user->id)->first();
    $user->cover = CoverImage::select('original', 'cropped')->where('user_id', $user->id)->first();
    $user->favorites = Favorite::where('user_id', $user->id)->get('bookable_id')->toArray();
    return $user;
}]);

Route::get('/{any?}', function () {
    return view('welcome');
})->where('any', '^(?!api\/)[\/\w\.\,-]*'); //when route doesn't start with api/ return the welcome view
