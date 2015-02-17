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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['middleware' => 'cors'], function () {
    Route::get('items', 'ItemsController@getAllJSON');
    Route::get('bank-accounts', 'BankAccountsController@getAllJSON');
    Route::get('reservations/{username}', 'ReservationsController@getByUserJSON');
    Route::get('loans/{username}', 'AmortizationLoansController@getByUserJSON');

    Route::post('clients', 'ClientsController@store');
    Route::post('login', 'UsersController@apiLogin');
    Route::post('reservations', 'ReservationsController@store');
    Route::put('reservations', 'ReservationsController@update');
    Route::post('reservations/{reservationId}/updateImage', 'ReservationsController@updateImage');
    Route::post('reservations/{reservationId}/cancel', 'ReservationsController@cancel');
});

//  For easier explanation to client later, use this link: https://gistlog.co/JacobBennett/090369fbab0b31130b51

Route::group(['middleware' => 'auth:api'], function () {
    
});
