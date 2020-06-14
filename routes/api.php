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

Route::group(['namespace' => 'Api\Auth', 'prefix' => 'auth'], function() {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::get('register/activate/{token}', 'AuthController@activate');

    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('user', 'AuthController@currentUser');
        Route::get('logout', 'AuthController@logout');
    });
});

Route::group(['namespace' => 'Api\Auth', 'middleware' => 'api', 'prefix' => 'password'], function() {
    Route::post('request', 'PasswordResetController@request');
    Route::get('find/{token}', 'PasswordResetController@find');
    Route::post('reset', 'PasswordResetController@reset');
});

Route::group(['namespace' => 'Api', 'middleware' => 'auth:api', 'prefix' => 'article'], function() {
    Route::get('/', 'ArticleController@index');
    Route::get('/{slug}', 'ArticleController@show');
});

Route::group(['namespace' => 'Api', 'middleware' => 'auth:api', 'prefix' => 'calculation'], function() {
    Route::post('/ibm', 'CalculationController@calculateIBM');
    Route::post('/day-calory', 'CalculationController@calculateDayCalory');
    Route::post('/food-calory', 'CalculationController@calculateFoodCalory');
});