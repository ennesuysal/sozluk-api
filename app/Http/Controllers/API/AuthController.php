<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Suser;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'nick' => 'required|max:55|unique:susers',
            'email' => 'email|required|unique:susers',
            'password' => 'required',
        ], [
            'nick.required' => 'nickname is required.',
            'nick.max' => 'nickname may be max 55 characters.',
            'nick.unique' => 'this nick is used by another suser.',
            'email.email' => 'you must enter a valid e-mail.',
            'email.required' => 'e-mail is required.',
            'email.unique' => 'this e-mail is used by another suser.',
            'password.required' => 'password is required.',
        ]);

        if($validatedData->fails()){
            return response(["Errors" => $validatedData->errors()]);
        }

        $validatedData = $validatedData->validated();

        $validatedData['password'] = bcrypt($request->password);

        $user = Suser::create($validatedData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response([ 'user' => $user, 'access_token' => $accessToken]);
    }

    public function login(Request $request)
    {
        $loginData = Validator::make($request->all(), [
            'nick' => 'required',
            'password' => 'required'
        ], [
            'nick.required' => 'nick is required.',
            'password.required' => 'password is required.'
        ]);

        if($loginData->fails()){
            return response(["Errors" => $loginData->errors()]);
        }

        $loginData = $loginData->validated();

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid Credentials']);
        }
        if(auth()->user()->role == 0) {
            $accessToken = auth()->user()->createToken('authToken', ['suser'])->accessToken;
        }
        else if(auth()->user()->role == 1) {
            $accessToken = auth()->user()->createToken('authToken', ['moderator'])->accessToken;
        }
        else if(auth()->user()->role == 2) {
            $accessToken = auth()->user()->createToken('authToken', ['admin'])->accessToken;
        }

        return response(['user' => auth()->user(), 'access_token' => $accessToken]);
    }
}
