<?php

namespace App\Http\Controllers\Api;

use App\Rules\Name;
use App\Models\User;
use App\Rules\Username;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function updateInfos(Request $request){
        $user_id = Auth::user()->id;

        $request->validate([
            'name' => ['required', new Name()],
            'username' => ['required', 'max:255', new Username(), "unique:users,username,{$user_id}"],
            'email' => "required | email | unique:users,email,{$user_id}"
        ]);

        $user = User::find($user_id);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->save();

        return $user;
    }

    public function updatePassword(Request $request){
        
        $request->validate([
            'current' => 'required',
            'new' => 'required|same:confirm|min:8',
            'confirm' => 'required'
        ],
    );

        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $user_pwd = $user->password;
        
        if (!Hash::check($request->current, $user_pwd)) {
            return back()->withErrors(['current'=>'Wrong password']);
        }

        $user->password = Hash::make($request->new);

        $user->save();

        return 'password has been changed';
    }
}
