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
    Route::post('files/remove', 'FilesController@remove');

    Route::get('sales', 'SalesController@index');
    Route::get('overdue-customers', 'OverdueCustomersController@index');
    Route::get('overdue-customers/test', 'OverdueCustomersController@test');

    // <editor-fold defaultstate="collapsed" desc="Master Files">
    Route::get('users/datatable', 'UsersController@datatable');
    Route::resource('users', 'UsersController');

    Route::get('clients/{clientId}/activate', 'ClientsController@activate');
    Route::get('clients/{clientId}/deactivate', 'ClientsController@deactivate');
    Route::get('clients/{clientId}/reset-password', 'ClientsController@resetPassword');
    Route::get('clients/datatable', 'ClientsController@datatable');
    Route::resource('clients', 'ClientsController');

    Route::get('suppliers/datatable', 'SuppliersController@datatable');
    Route::resource('suppliers', 'SuppliersController');

    Route::get('fuel-types/datatable', 'FuelTypesController@datatable');
    Route::resource('fuel-types', 'FuelTypesController');

    Route::get('categories/datatable', 'CategoriesController@datatable');
    Route::resource('categories', 'CategoriesController');

    Route::get('items/{itemId}/files', 'ItemsController@itemFiles');
    Route::get('items/datatable', 'ItemsController@datatable');
    Route::get('items/status/{status}/datatable', 'ItemsController@datatableByStatus');
    Route::resource('items', 'ItemsController');
    Route::get('items/status/{status}', 'ItemsController@viewlistByStatus');

    Route::resource('bank-accounts', 'BankAccountsController');

    // </editor-fold>
    // 
    // <editor-fold defaultstate="collapsed" desc="Modules">

    Route::get('sales-invoices/datatable', 'SalesInvoicesController@datatable');
    Route::get('sales-invoices/{id}/print', 'SalesInvoicesController@printDocument');
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
