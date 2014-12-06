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

Route::get('home', function () {
    return redirect('/');
});

Route::get('/', 'HomeController@index');

Route::get('/logout', 'Auth\LoginController@logout');
Route::auth();

Route::group(['middleware' => 'auth'], function () {

    Route::post('files/upload', 'FilesController@upload');

    // <editor-fold defaultstate="collapsed" desc="Master Files">
    Route::get('users/datatable', 'UsersController@datatable');
    Route::resource('users', 'UsersController');

    Route::get('clients/datatable', 'ClientsController@datatable');
    Route::resource('clients', 'ClientsController');

    Route::get('items/datatable', 'ItemsController@datatable');
    Route::resource('items', 'ItemsController');

    Route::resource('bank-accounts', 'BankAccountsController');

    // </editor-fold>
    // 
    // <editor-fold defaultstate="collapsed" desc="Modules">

    Route::get('sales-invoices/datatable', 'SalesInvoicesController@datatable');
    Route::resource('sales-invoices', 'SalesInvoicesController');
    Route::delete('sales-invoice-details/{id}', 'SalesInvoicesController@destroyDetail');

    Route::get('reservations/datatable', 'ReservationsController@datatable');
    Route::resource('reservations', 'ReservationsController');
    Route::get('reservations/{id}/convert', 'ReservationsController@convert');

    Route::get('amortization-loans/datatable', 'AmortizationLoansController@datatable');
    Route::resource('amortization-loans', 'AmortizationLoansController');

    Route::get('request-payments/datatable', 'RequestPaymentsController@datatable');
    Route::resource('request-payments', 'RequestPaymentsController');
    Route::delete('request-payment-details/{id}', 'RequestPaymentsController@destroyDetail');

    Route::post('request-payments/post', 'RequestPaymentsController@postAndSave');
    Route::post('request-payments/post/{docNo}', 'RequestPaymentsController@post');

    // </editor-fold>
});
