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
    return redirect()->route('messages');
});

Auth::routes();
//Controller
Route::get('/home', function () {
    return redirect()->route('messages');
});
Route::post('/messages/{user}', 'MessagesController@sendMessage');
Route::get('/messages', 'MessagesController@index')->name('messages');
//Route::get('/messages/{user}', 'MessagesController@show')->name('messages.show');
Route::get('/messages/{user}', 'MessagesController@index');
//Route::post('/messages/{user}', 'MessagesController@sendMessage');

//Profile utilisateur
Route::get('/profile', 'UserController@index')->name('user.profile');
Route::post('/profile', 'UserController@uploadPhoto');
