<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function() {
    Route::post('register', 'Api\Auth\AuthController@register');
    Route::post('login', 'Api\Auth\AuthController@login');
    // Route::get('register/activate/{token}', 'Api/AuthController@activate');

    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('user', 'Api\Auth\AuthController@currentUser');
        Route::get('logout', 'Api\Auth\AuthController@logout');
    });
});

// Route::group(['middleware' => 'api', 'prefix' => 'password'], function() {
//     Route::post('create', 'Api\Auth\PasswordResetController@create');
//     Route::get('find/{token}', 'Api\Auth\PasswordResetController@find');
//     Route::post('reset', 'Api\Auth\PasswordResetController@reset');
// });