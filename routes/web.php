<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddOnController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\VideosController;
use App\Http\Controllers\CouponsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\WatchesController;

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
Route::view('test', 'dashboard');

Route::get('/', 'OrdersController@index')->name('home');
Route::post('/order', 'OrdersController@store')->name('order.store');
Route::resource('invoice', 'InvoiceController', ['only' => ['create', 'store']]);

Route::group(['middleware' => 'auth'], function () {
    Route::resource('dashboard', 'DashboardController', ['only' => ['index']]);
    Route::resource('videos', 'VideosController', ['only' => ['show']]);

    Route::get('users/edit', 'UsersController@edit')->name('user.edit');
    Route::put('users', 'UsersController@update');

    Route::resource('add-ons', 'AddOnController')->only('index', 'store')->middleware('add-ons');
    Route::resource('watches', 'WatchesController')->only('store')->middleware('can:upgrade');
});

Route::get('promotions/{code}', 'CouponsController@show');

Auth::routes();
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
