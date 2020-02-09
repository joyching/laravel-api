<?php

use Illuminate\Http\Request;

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

Route::prefix('v1')->group(function () {
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('login', 'Auth\AuthenticationController@login');

    Route::middleware(['auth:api', 'auth.jwtVerify'])->group(function () {
        Route::get('logout', 'Auth\AuthenticationController@logout');
    });
});
