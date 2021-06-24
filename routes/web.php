<?php


Route::get('/','PaymentController@index')->name('index');
Route::post('/sendRequest','PaymentController@sendRequest')->name('sendRequest');
Route::any('/carrier_success','PaymentController@carrier_success')->name('carrier_success');
Route::any('/carrier_error','PaymentController@carrier_error')->name('carrier_error');
Route::any('/carrier_request','PaymentController@carrier_request')->name('carrier_request');

Route::get('/index2','PaymentControllerApi@index')->name('indexApi');
Route::post('/sendRequestApi','PaymentControllerApi@sendRequest')->name('sendRequestApi');
Route::any('/carrier_successApi','PaymentControllerApi@carrier_success')->name('carrier_successApi');
Route::any('/carrier_errorApi','PaymentControllerApi@carrier_error')->name('carrier_errorApi');
Route::any('/carrier_requestApi','PaymentControllerApi@carrier_request')->name('carrier_requestApi');


