<?php

namespace App\Http\Controllers;

use App\Models\Title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TitleController extends Controller
{
    public function index(){
        $titles = Title::latest()->get();
        return $titles;
    }

    public function showEntries($id){
        $title = Title::findOrFail($id);
        return response($title->entries);
    }

    public function store(Request $request){
        $validatedData = Validator::make($request->all(), [
            'title' => 'required|max:150',
        ], [
            'title.required' => 'title is required.',
            'title.max' => 'title may be max 150 characters.'
        ]);

        if($validatedData->fails()){
            return response(["Errors" => $validatedData->errors()]);
        }

        Title::create($validatedData->validated());
        return response(["Status" => "Success!"]);
    }

    public function update($id){
        $new_title = request('title');
        $title = Title::where('ID', $id);
        $title->update(['title' => $new_title]);
        return response(["Status" => "Success!"]);
    }

    public function destroy($id){
        $title = Title::where('ID', $id);
        $title->delete();
        return response(['Status' => 'Success!']);
    }
}
