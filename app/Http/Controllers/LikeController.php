<?php

namespace App\Http\Controllers;

use App\Models\Likes;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LikeController extends Controller
{
    public function store(Request $request){
        $validatedData = Validator::make($request->all(), [
            'entry_id' => 'required',
            'like' => 'required'

        ], [
            'entry_id.required' => 'entry_id is required.',
            'like.required' => 'like is required'
        ]);

        if($validatedData->fails()){
            return response(["Errors" => $validatedData->errors()]);
        }

        $l = intval(request('like'));
        if($l > 1 || $l < 0)
            return Response(["Error" => "Please post 0 or 1 for like."]);

        $entry_id = request('entry_id');
        $user =  auth()->guard('api')->user()->nick;

        $check = Likes::where([['entry_id', $entry_id], ['suser_id', $user]]);

        if($check->first() === null) {
            $like = new Likes();
            $like->suser_id = $user;
            $like->entry_id = $entry_id;
            $like->like = $l;

            $like->save();
        } else {
            $check->update(['like' => $l]);
        }

        return response(["Status" => "Success!"]);
    }

    function destroy($entry_id) {
        $like = Likes::where([['entry_id', $entry_id], ['suser_id', auth()->guard('api')->user()->nick]]);
        if($like->first() !== null) {
            $like->delete();
            return Response(["Status" => "Success!"]);
        }
        else
            return Response(["Status" => "Like not found!"]);
    }
}
