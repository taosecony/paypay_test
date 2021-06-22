<?php


Route::get('/','PaymentController@index')->name('index');
Route::post('/sendRequest','PaymentController@sendRequest')->name('sendRequest');
Route::any('/carrier_success','PaymentController@carrier_success')->name('carrier_success');
Route::any('/carrier_error','PaymentController@carrier_error')->name('carrier_error');
Route::any('/carrier_request','PaymentController@carrier_request')->name('carrier_request');
