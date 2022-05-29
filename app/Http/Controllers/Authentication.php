<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class Authentication extends Controller
{
    public function registration(Request $request) {
        // dd($request->all());
        $validation = Validator::make($request->all(),[
            'name'             => 'required',
            'email'            => 'required|email|unique:users',
            'password'         => 'required|min:8',
            'confirm_password' => 'required|required_with:password|same:password'
        ]);

        if(!$validation->fails()) {
            $create_user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password)
            ]);
            if($create_user) {
                return response()->json('success',200);
            }
        }else{
           return response()->json(['error' => $validation->errors()],401);
        }
    }

    public function login(Request $request) {
        if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json([
        'message' => 'Invalid login details'
                ], 401);
            }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request) {
        if(Auth::logout()) {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Logout Successful'],200);
        }else{
            return response()->json(['message' => 'Something Went Wrong'],401);
        }
        
    }
}
