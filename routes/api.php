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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::post('/login', [\App\Http\Controllers\Auth\AuthenticateController::class, 'authenticate']);
Route::get('/login', [\App\Http\Controllers\Auth\AuthenticateController::class, 'authenticate']);
Route::post('/login-refresh', [\App\Http\Controllers\Auth\AuthenticateController::class, 'refreshToken']);

Route::group(['middleware'=>'auth:api'], function(){
    Route::resource('/empresa', \App\Http\Controllers\CompanyApiController::class);
    Route::resource('/usuario', \App\Http\Controllers\UserApiController::class);
});


