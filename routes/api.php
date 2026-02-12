<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\StockOpnameController;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/books/{isbn}', [StockOpnameController::class, 'searchBook']);
    Route::post('/stock-opname', [StockOpnameController::class, 'store']);
});
