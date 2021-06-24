<?php

namespace App\Http\Controllers;

use App\Models\Suser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SuserController extends Controller
{
    public function index(){
        $suser = Suser::latest()->get();
        return $suser;
    }

    public function show($id){
        $suser = Suser::find($id);
        return $suser;
    }

    public function store(Request $request){
        $validatedData = Validator::make($request->all(),[
            'nick' => 'required|max:55|unique:susers',
            'email' => 'email|required|unique:susers',
            'password' => 'required',
            'role' => 'required'
        ], [
            'nick.required' => 'nick is required.',
            'nick.max' => 'nick may be max 55 characters.',
            'nick.unique' => 'this nick is used by another suser.',
            'email.email' => 'you must enter a valid e-mail.',
            'email.required' => 'e-mail is required.',
            'email.unique' => 'this e-mail is used by another suser.',
            'password.required' => 'password is required.',
            'role.required' => 'role is required.'
        ]);

        if($validatedData->fails()){
            return response(["Errors" => $validatedData->errors()]);
        }

        $validatedData = $validatedData->validated();
        $validatedData['password'] = bcrypt(request()->password);
        Suser::create($validatedData);

        return response(["Status" => "Success!"]);
    }

    public function destroy($id){
        $user =  auth()->guard('api')->user();
        $suser = Suser::findOrFail($id);
        if($suser->id == $user->id || $suser->role <= 0 && $user->tokenCan('moderator') || $user->tokenCan('admin')) {
            $suser = Suser::where('id', $id);
            $suser->delete();
            return response(["Status" => "Success!"]);
        }
        return response(["Status" => "Forbidden!"]);
    }

    public function show_entries($user_id){
        $suser = Suser::findOrFail($user_id);
        return $suser->entries;
    }
}
