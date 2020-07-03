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
Route::get('_healthcheck', 'HealthController@index');

Route::post('login', 'LoginController@index');

Route::group(['prefix' => 'v1', 'middleware' => ['auth:api']], function () {
    //users
    Route::get('/users', 'UsersController@index');
    Route::get('/users/id/{id}', 'UsersController@show');
    Route::post('/users', 'UsersController@store');
    Route::put('/users/id/{id}', 'UsersController@update');
    Route::delete('/users/id/{id}', 'UsersController@destroy');
    //documents
    Route::get('/files', 'FilesController@index');
    Route::get('/files/user-id/{id}', 'FilesController@show');
    Route::post('/files', 'FilesController@store');
    Route::put('/files/id/{id}', 'FilesController@update');
    Route::delete('/files/id/{id}', 'FilesController@destroy');
});




/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
