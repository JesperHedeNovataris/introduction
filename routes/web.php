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

use Illuminate\Support\Facades\Route;

Route::get('/', 'CustomerController@index');

Route::group(['prefix' => 'customer'], function () {
    Route::get('/{id}', 'CustomerController@show');
    Route::get('/invoice/{id}', 'CustomerController@invoice');
    Route::post('/changetype/{id}', 'CustomerController@changetype');
});

Route::get('/invoices', 'InvoiceController@index');
