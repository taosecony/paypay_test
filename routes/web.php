<?php


Route::get('/','PaymentController@index')->name('index');
Route::post('/sendRequest','PaymentController@sendRequest')->name('sendRequest');
Route::match(['get','post'],'/carrier_success','PaymentController@carrier_success')->name('carrier_success');
Route::match(['get','post'],'/carrier_error','PaymentController@carrier_error')->name('carrier_error');
