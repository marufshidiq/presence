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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'middleware' => 'is_admin'], function(){
    Route::get('/room', 'AdminController@showRoom')->name('room.show');
    Route::post('/room/add', 'AdminController@addRoom')->name('room.add');
    Route::post('/room/delete', 'AdminController@deleteRoom')->name('room.delete');
});