<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'Name' => 'required|max:55',
            'Surname' => 'required|max:55',
            'Mail' => 'email|required|unique:susers',
            'password' => 'required'
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $user = Admin::create($validatedData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response([ 'user' => $user, 'access_token' => $accessToken]);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'Mail' => 'required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid Credentials']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken]);

    }
}
