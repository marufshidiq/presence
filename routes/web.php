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
    return redirect()->route('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'middleware' => 'is_admin'], function(){
    Route::get('/card', 'AdminController@listCard')->name('card.list');
    Route::post('/card/add', 'AdminController@addCard')->name('card.add');
    Route::post('/card/delete', 'AdminController@deleteCard')->name('card.delete');
    Route::post('/card/set', 'AdminController@setCard')->name('card.set');
    Route::post('/card/assign', 'AdminController@assignCard')->name('card.assign');

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

    Route::get('/period', 'AdminController@listPeriod')->name('period.list');
    Route::post('/period/add', 'AdminController@addPeriod')->name('period.add');
    Route::post('/period/edit', 'AdminController@editPeriod')->name('period.edit');
    Route::post('/period/delete', 'AdminController@deletePeriod')->name('period.delete');
    Route::post('/period/default', 'AdminController@defaultPeriod')->name('period.default');

    Route::get('/class', 'AdminController@listClass')->name('class.list');
    Route::get('/class/add', 'AdminController@formAddClass')->name('class.add.form');
    Route::get('/class/{id}/edit', 'AdminController@formEditClass')->name('class.edit.form');
    Route::post('/class/add', 'AdminController@addClass')->name('class.add');
    Route::post('/class/edit', 'AdminController@editClass')->name('class.edit');
    Route::post('/class/delete', 'AdminController@deleteClass')->name('class.delete');
    Route::post('/class/student', 'AdminController@showStudent')->name('class.showstudent');
    Route::post('/class/addstudent', 'AdminController@addClassStudent')->name('class.addstudent');
    Route::post('/class/check', 'AdminController@checkClass')->name('class.check');
});