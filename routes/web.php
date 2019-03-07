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
Route::post('appointments', 'AppointmentsController@store')->name('appointments.store');
Route::post('appointments/create', 'AppointmentsController@create')->name('appointments.create');
Route::post('appointments/{appointment}', 'AppointmentsController@show')->name('appointments.show');
Route::put('appointments/{appointment}', 'AppointmentsController@update')->name('appointments.update');
Route::delete('appointments/{appointment}', 'AppointmentsController@destroy')->name('appointments.destroy');
Route::post('appointments/{appointment}/edit', 'AppointmentsController@edit')->name('appointments.edit');


