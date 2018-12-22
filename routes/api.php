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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('users/signup', 'UserController@create');

Route::get('/contacts', 'ContactController@index')->middleware('auth:api');
Route::post('contacts', 'ContactController@create')->middleware('auth:api');

Route::post('/chatkit/token', 'ÇhatkitController@getToken')->middleware('auth:api');
