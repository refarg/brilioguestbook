<?php

use Illuminate\Support\Facades\Route;

Route::prefix('guestbook')->as('guestbook.')->group(function(){
    Route::get('/', 'GuestbookController@index')->name('index');
    Route::get('/index-data', 'GuestbookController@index_data')->name('get_index_data');
    Route::get('/add', 'GuestbookController@add_new')->name('add');
    Route::put('/add/submit', 'GuestbookController@add_submit')->name('submit_new');
    Route::get('/edit/{id}', 'GuestbookController@view_edit')->name('view_edit');
    Route::post('/edit/{id}', 'GuestbookController@edit_submit')->name('submit_edit');
    Route::get('/view/{id}', 'GuestbookController@view')->name('view');
    Route::post('/delete/{id}', 'GuestbookController@delete_entry')->name('submit_delete');
    // Route::get('/get-expiration-time', 'GuestbookController@get_exp_time')->name('get_invite_expiration_time');
    // Route::post('/set-expiration-time', 'GuestbookController@set_exp_time')->name('set_invite_expiration_time');
});