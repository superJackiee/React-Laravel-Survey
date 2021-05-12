<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Auth;

class AuthenticationController extends Controller
{
    /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
        $user = User::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $token = $user->createToken('TutsForWeb')->accessToken;
        return response()->json(['token' => $token], 200);
    }
    /**
    * Handles Login Request
    *
    * @param Request $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        
        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('TutsForWeb')->accessToken;
            return response()->json(['token' => $token, 'auth' => Auth::user()], 200);
        } 
        else {
            return response()->json(['error' => 'UnAuthorised'], 401);
        }
    }
    
    /**
    * Returns Authenticated User Details
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function user_details()
    {
        return response()->json(['user' => auth()->user()], 200);
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        return response()->json(['message' => 'You have been successfully logged out!'], 200);
    }
}
