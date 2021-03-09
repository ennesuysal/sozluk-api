<?php

namespace App\Http\Controllers;

use App\Models\Suser;
use App\Models\Title;
use Illuminate\Http\Request;
use App\Models\Entry;
use Illuminate\Support\Facades\Validator;

class EntryController extends Controller
{
    public function index(){
        $entrys = Entry::latest()->get();
        return $entrys;
    }

    public function show($id){
        $entry = Entry::findOrFail($id);
        $dict = [];
        $dict["entry"] = $entry;
        $dict["suser"] = $entry->suser;

        return $dict;
    }

    public function store(Request $request){
        $validatedData = Validator::make($request->all(), [
            'title_id' => 'required',
            'entry' => 'required'
        ], [
            'title_id.required' => "Title ID is required!",
            'entry.required' => "Entry is required"
        ]);

        if($validatedData->fails()){
            return response(["Errors" => $validatedData->errors()]);
        }

        $title = request('title_id');
        $user =  auth()->guard('api')->user()->id;
        $entry = request('entry');

        $entry_ = new Entry();
        $entry_->title_id = $title;
        $entry_->user_id = $user;
        $entry_->entry = $entry;

        $entry_->save();

        return response(["Status" => "Success!"]);
    }

    public function update($id){
        $user =  auth()->guard('api')->user();
        if($user->nick == $this->show($id)['suser']['nick']) {
            $new_entry = request('entry');
            $entry = Entry::where('ID', $id);
            $entry->update(['entry' => $new_entry]);
            return response(["Status" => "Success!"]);
        }
        return response(["Status" => "Forbidden!"]);
    }

    public function destroy($id){
        $user =  auth()->guard('api')->user();
        if($user->tokenCan('moderator') || $user->nick == $this->show($id)['suser']['nick']) {
            $entry = Entry::where('ID', $id);
            $entry->delete();
            return Response(['Status' => 'Success']);
        }
        return Response(['Status' => 'Forbidden!']);
    }
}
