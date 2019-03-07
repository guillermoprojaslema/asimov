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


Route::get('appointments', 'AppointmentsController@index')->name('appointments.index');
Route::post('appointments/create', 'AppointmentsController@create')->name('appointments.create');
Route::post('appointments/{appointment}', 'AppointmentsController@show')->name('appointments.show');
Route::post('appointments/{appointment}/edit', 'AppointmentsController@edit')->name('appointments.edit');


