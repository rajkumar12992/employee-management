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

Route::post('register', 'App\Http\Controllers\API\RegisterController@register');
Route::post('login', 'App\Http\Controllers\API\RegisterController@login');

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('candidates', 'App\Http\Controllers\API\CandidateController@index');
Route::post('filerCandidates', 'App\Http\Controllers\API\CandidateController@filerCandidates');

Route::middleware('auth:api')->group( function () {
    Route::post('candidates', 'App\Http\Controllers\API\CandidateController@store');
    Route::put('candidates/{id}', 'App\Http\Controllers\API\CandidateController@update');
    Route::delete('candidates/{id}', 'App\Http\Controllers\API\CandidateController@destroy');
    Route::get('candidates/{id}', 'App\Http\Controllers\API\CandidateController@show');
});