<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware(['guest'])->group(function(){
    Route::get('/', 'General\PublicController@index')->name('guestbook-homepage');
    Route::put('/', 'General\PublicController@add_submit')->name('guestbook-submit');
});

Route::get('/dashboard', 'DashboardController@index')->middleware(['auth'])->name('dashboard');
Route::post('/get-city-data', 'General\PublicController@get_city_data')->name('get-city');

require __DIR__.'/auth.php';
