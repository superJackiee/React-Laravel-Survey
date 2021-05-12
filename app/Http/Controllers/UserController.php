<?php

namespace App\Http\Controllers;

use app\User;
use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{

    public function create(Request $request)
    {
        $this->validate($request, [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        $user  = User::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return response()->json(['message' => 'Suceess Added Employee'], 200);
    }

    public function update(Request $request)
    {
        $user = Users::findById($request->id);

        
    }

    public function list()
    {
        $users = User::all();
        return response()->json($users);
    }

}
