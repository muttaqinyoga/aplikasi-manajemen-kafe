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

Auth::routes();
Route::group(['middleware' => 'auth'], function(){
	Route::get('/', 'HomeController@index');
	Route::group(['prefix' =>'/admin', 'middleware'=>'checkRole'], function(){
		// Users
		Route::get('/users', 'UserController@user');
		Route::get('/users/data', 'UserController@getUsers');
		Route::post('/users/save', 'UserController@save');
		Route::delete('/users/destroy','UserController@delete');
		Route::put('/users/update', 'UserController@update');
		// End Users
		// Menus
		Route::get('/menu', 'MenuController@menu');
		Route::get('/menu/data', 'MenuController@getMenu');
		Route::post('/menu/save', 'MenuController@save');
		Route::delete('/menu/destroy', 'MenuController@delete');
		Route::put('/menu/update', 'MenuController@update');
		// End Menus
		// Tables
		Route::get('/table', 'TableController@table');
		Route::get('/table/data', 'TableController@getTable');
		Route::post('/table/save', 'TableController@save');
		Route::delete('/table/destroy', 'TableController@delete');
		Route::put('/table/update', 'TableController@update');
		// End Tables
		// Payments
		Route::get('/payment/{orderID}/create', 'PaymentController@save');
		Route::post('/payment/save', 'PaymentController@store');
		Route::get('/pembayaran', 'PaymentController@payments');
		Route::get('/payments/data', 'PaymentController@getData');
		// End Payments
	});
	Route::get('/pesanan', 'OrderController@orders');
	// Orders
	Route::group(['prefix'=>'order'], function(){
		Route::get('/tables/get', 'OrderController@getTables');
		Route::get('/data', 'OrderController@getData');
		Route::post('/save', 'OrderController@save');
		Route::delete('/destroy', 'OrderController@delete');
		Route::get('/{id}/details', 'OrderController@details');
		Route::put('/table/update', 'OrderController@updateTable');
		Route::put('/add/{id}', 'OrderController@addNewOrder');
		Route::put('/update/{id}/{oid}', 'OrderController@updateMenuOrder');
		Route::delete('/destroy/{id}/{oid}', 'OrderController@deleteMenuOrder');
	});
	// End Orders
	Route::get('/invoice/{id}', 'PaymentController@details');
});
