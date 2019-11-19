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
    Route::get('api/auth', 'HomeController@auth')->name('auth');
    Route::get('logout', 'HomeController@logout')->name('logout');
    Route::get('/home', 'HomeController@index')->name('home');

    Route::group(['namespace' => 'Api', 'prefix' => 'api'], function(){
        Route::resource('/users', 'UserController');
        Route::resource('/resturants', 'ResturantController');
        Route::get('/get-resturants', 'ResturantController@getResturants');
        Route::resource('/items', 'ItemController');
        Route::resource('/items-sizes', 'SizeController');

        Route::resource('/suggestions', 'SuggestionController');
        Route::get('my-suggestions', 'SuggestionController@getTodaySuggestion')->name('my-suggestions');
        Route::post('suggestions/add/{suggestion}', 'SuggestionController@plusOne')->name('plusOne');

        Route::resource('/orders', 'OrderController');
        Route::resource('/order-items', 'OrderItemController');

        Route::get('/order-items-group', 'OrderItemGroupController@index');

        Route::get('/order-items/get/items', 'OrderItemController@getItems');
        Route::get('/order-items/get/total', 'OrderItemController@getTotal');


        Route::get('decisions', 'DecisionController@index')->name('decisions.index');
        Route::post('decisions', 'DecisionController@makeDecision')->name('decisions.make');
        Route::get('decisions/check/made', 'DecisionController@isDecisionMade')->name('decisions.isMade');
        Route::post('decisions/make/order', 'DecisionController@makeOrder')->name('decisions.makeOrder');
        Route::delete('decisions/{decisions}', 'DecisionController@destroy')->name('decisions.destroy');
    });

    Route::get('{path}','HomeController@index')->where( 'path', '([A-z]+)?' );
});


