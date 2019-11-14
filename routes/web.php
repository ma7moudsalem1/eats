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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function(){
    Route::get('/home', 'HomeController@index')->name('home');

    Route::group(['namespace' => 'Api', 'prefix' => 'api'], function(){
        Route::resource('/users', 'UserController');
        Route::resource('/resturants', 'ResturantController');
        Route::get('/get-resturants', 'ResturantController@getResturants');
        Route::resource('/items', 'ItemController');
        Route::resource('/items-sizes', 'SizeController');
    });

    Route::get('{path}',"HomeController@index")->where( 'path', '([A-z\d-\/_.]+)?' );
});


Auth::routes();


