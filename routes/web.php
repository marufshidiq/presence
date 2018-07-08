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

    Route::get('/course', 'AdminController@listCourse')->name('course.list');
    Route::get('/course/add', 'AdminController@formAddCourse')->name('course.add.form');
    Route::get('/course/{id}/edit', 'AdminController@formEditCourse')->name('course.edit.form');
    Route::post('/course/add', 'AdminController@addCourse')->name('course.add');
    Route::post('/course/edit', 'AdminController@editCourse')->name('course.edit');
    Route::post('/course/delete', 'AdminController@deleteCourse')->name('course.delete');

    Route::get('/curriculum', 'AdminController@listCurriculum')->name('curriculum.list');
    Route::post('/curriculum/add', 'AdminController@addCurriculum')->name('curriculum.add');
    Route::post('/curriculum/edit', 'AdminController@editCurriculum')->name('curriculum.edit');
    Route::post('/curriculum/delete', 'AdminController@deleteCurriculum')->name('curriculum.delete');
    Route::post('/curriculum/default', 'AdminController@defaultCurriculum')->name('curriculum.default');
    Route::post('/curriculum/course', 'AdminController@showCourseCurriculum')->name('curriculum.showcourse');
});