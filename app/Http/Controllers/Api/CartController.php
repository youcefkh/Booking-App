<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $cartItems = DB::table('bookables')
                    ->join('carts', 'bookables.id', '=', 'carts.bookable_id')
                    ->where('carts.user_id', '=', $user_id)
                    ->get();
        return $cartItems;
    }
    public function create(Request $request, $bookable_id)
    {
        $user_id = Auth::user()->id;
        Cart::create([
            'user_id' => $user_id,
            'bookable_id' => $bookable_id,
            'price' => $request->price,
            'from' => $request->from,
            'to' => $request->to
            ]
            );
        
        return DB::table('bookables')
                ->join('carts', 'bookables.id', '=', 'carts.bookable_id')
                ->where('carts.user_id', '=', $user_id)
                ->where('carts.bookable_id', '=', $bookable_id)
                ->first();
    }

    public function delete($bookable_id)
    {
        $user_id = Auth::user()->id;
        $cart = Cart::where('user_id', $user_id)->where('bookable_id', $bookable_id);
        return $cart->delete();
    }
}
