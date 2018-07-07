<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/admin', function () {
    return view('admin');
})->middleware('admin');

Route::get('/user', function () {
    return view('user');
})->middleware('user');

Route::get('/adminDash', function () {
    return view('adminDash');
})->middleware('admin');

Route::get('/userDash', function () {
    return view('userDash');
})->middleware('user');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/pb/?{name}', function(){
    return redirect('phonebook');
})->where('name', '[A-Za-z]+');

Route::resource('phonebook','PhonebookController');
Route::post('getData','PhonebookController@getData');
Route::get('phonebooj','PhonebookController@check');