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


Route::get('appointments', 'Api\ApiAppointmentsController@index')->name('api.appointments.index');
Route::post('appointments', 'Api\ApiAppointmentsController@store')->name('api.appointments.store');
Route::get('appointments/create/{appointment}', 'Api\ApiAppointmentsController@create')->name('api.appointments.create');
Route::get('appointments/{appointment}', 'Api\ApiAppointmentsController@show')->name('api.appointments.show');
Route::put('appointments/{appointment}', 'Api\ApiAppointmentsController@update')->name('api.appointments.update');
Route::delete('appointments/{appointment}', 'Api\ApiAppointmentsController@destroy')->name('api.appointments.destroy');
Route::get('appointments/{appointment}/edit', 'Api\ApiAppointmentsController@edit')->name('api.appointments.edit');







