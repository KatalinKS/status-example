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

Route::group(['prefix/{modelName:slug}' => 'status'], function() {
    Route::post('set', [\App\Http\Controllers\StatusController::class, 'setStatus']);
    Route::post('unset', [\App\Http\Controllers\StatusController::class, 'unsetStatus']);
});
