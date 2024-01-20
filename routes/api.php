<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

use App\Http\Controllers\ProductController;

use App\Http\Controllers\UserActivityLogController;

use App\Http\Controllers\LoginController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// User routes
Route::get('/users', [UserController::class, 'index']);
Route::post('/register', [UserController::class, 'register']);



Route::post('/products', [ProductController::class, 'create']);


// User Activity Log routes
Route::get('/user-activity-logs/{user_id}', [UserActivityLogController::class, 'index']);

Route::group(['middleware' => 'log.user.activity'], function () {
    Route::post('/login', [LoginController::class, 'login'])->name('login');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/products_index', [ProductController::class, 'index'])->name('products_index');

    Route::post('/products_purchase/{productId}', [ProductController::class, 'purchase'])->name('products_purchase');

});

