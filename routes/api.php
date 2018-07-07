<?php

use Illuminate\Http\Request;

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

//List posts
Route::get('posts', 'PostController@index');

//List single posts
Route::get('post/{id}', 'PostController@show');

//Create new posts
Route::post('post', 'PostController@store');

//Update post
Route::put('post', 'PostController@store');

//Delete post
Route::delete('post/{id}', 'PostController@destroy');

Route::get('phonebook','PhonebookController@check');