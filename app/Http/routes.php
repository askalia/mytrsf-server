<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('index');
});

Route::group(['middleware' => 'cors'], function()
{
    Route::resource('authenticate','AuthenticateController', ['only' => ['index']]);
    Route::post('authenticate', 'AuthenticateController@authenticate');
    Route::get('authenticate/user', 'AuthenticateController@getAuthenticatedUser');
    Route::post('signup', 'AuthenticateController@signupUser');


    //Route::resource('user', 'UserController');
    // @override : allow update user without passing ID : resolved from JWT-token
    Route::put('user', 'UserController@update');
    Route::post('user/inventory', 'InventoryController@store');
    Route::get('user/inventory', 'UserController@getInventory');

    Route::get('product/search', 'AmazonController@search');



});

