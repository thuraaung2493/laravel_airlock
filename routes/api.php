<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Api'], function () {
    Route::post('/signup', 'RegisterController@store');
    Route::post('/login', 'LoginController@login');

    Route::middleware('auth:airlock')->group(function () {
        Route::get('/users/{user}', 'UserController@show');
        Route::delete('/users/{user}', 'UserController@destroy');
        Route::patch('/users/{user}', 'UserController@update');
    });
});
