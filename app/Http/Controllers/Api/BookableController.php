<?php

namespace App\Http\Controllers\Api;

use App\Models\Bookable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class BookableController extends Controller
{
    public function index()
    {
        $bookables = Bookable::orderBy('id', 'DESC')->with(['location', 'thumbnail', 'averageRating', 'user', 'user.profileImage'])->paginate(12);
        return $bookables;
    }

    public function show($id)
    {
        $bookable = Bookable::where('id', $id)->with(['location', 'photos', 'averageRating', 'extraodinaryEquipments', 'favoriteEquipments', 'securityEquipments', 'user', 'user.profileImage'])->first();

        return $bookable;
    }
}
