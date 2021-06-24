<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'API\AuthController@register');
Route::post('/login', 'API\AuthController@login')->name('login');

Route::get('/entries', 'EntryController@index');
Route::get('/entries/{id}', 'EntryController@show');
Route::get('/entries/{id}/likes', 'EntryController@getLikes');
Route::post('/entries/store', 'EntryController@store')->middleware(['auth:api', 'scope:suser,moderator,admin']);;
Route::put('/entries/update/{id}', 'EntryController@update')->middleware(['auth:api', 'scope:suser,moderator,admin']);
Route::delete('/entries/destroy/{id}', 'EntryController@destroy')->middleware(['auth:api', 'scope:suser,moderator,admin']);

Route::get('/titles', 'TitleController@index');
Route::get('/titles/{id}/entries', 'TitleController@showEntries');
Route::post('/titles/store', 'TitleController@store')->middleware(['auth:api', 'scope:suser,moderator,admin']);
Route::put('/titles/update/{id}', 'TitleController@update')->middleware(['auth:api', 'scope:moderator,admin']);
Route::delete('/titles/destroy/{id}', 'TitleController@destroy')->middleware(['auth:api', 'scope:moderator,admin']);;

Route::get('/susers', 'SuserController@index')->middleware(['auth:api', 'scope:moderator,admin']);
Route::get('/susers/{id}', 'SuserController@show');
Route::get('/susers/{id}/entries', 'SuserController@show_entries');
Route::post('/susers/store', 'SuserController@store')->middleware(['auth:api', 'scope:admin']);
Route::delete('/susers/destroy/{id}', 'SuserController@destroy')->middleware(['auth:api', 'scope:moderator,admin']);

Route::post('/likes/store', 'LikeController@store')->middleware(['auth:api', 'scope:suser,moderator,admin']);
Route::delete('/likes/destroy/{id}', 'LikeController@destroy')->middleware(['auth:api', 'scope:suser,moderator,admin']);;
