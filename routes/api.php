<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', 'App\Http\Controllers\Main@index');
Route::post('/login', 'App\Http\Controllers\Authentication@login');
Route::post('/registration', 'App\Http\Controllers\Authentication@registration');
Route::get('/invoice-list', 'App\Http\Controllers\Main@invoiceList');
Route::post('/add-invoice', 'App\Http\Controllers\Main@addInvoice');
Route::get('/single-invoice/{id}', 'App\Http\Controllers\Main@singleInvoice');
Route::post('/update-invoice/{id}', 'App\Http\Controllers\Main@updateInvoice');
Route::post('/delete-invoice/{id}', 'App\Http\Controllers\Main@deleteInvoice');
Route::get('/general-data', 'App\Http\Controllers\Main@addInvoiceView');
Route::get('/product-cost', 'App\Http\Controllers\Main@costCalculator');
Route::get('/search-invoice', 'App\Http\Controllers\Main@searchInvoice');
Route::get('/invoice-products/{id}', 'App\Http\Controllers\Main@invoiceProducts');
