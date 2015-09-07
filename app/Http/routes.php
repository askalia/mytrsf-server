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

Route::group(['prefix' => 'api', 'middleware' => 'cors'], function()
{
    Route::resource('authenticate','AuthenticateController', ['only' => ['index']]);
    Route::post('authenticate', 'AuthenticateController@authenticate');
    //Route::get('users', 'AuthenticateController@index');
    Route::get('authenticate/user', 'AuthenticateController@getAuthenticatedUser');

    Route::post('signup', 'AuthenticateController@signupUser');

    Route::resource('users', 'UserController');

    Route::get('product/search', 'AmazonController@search');
});

