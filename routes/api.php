<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResources([
        'orders' => OrderController::class,
        'products' => ProductController::class,
        'categories' => CategoryController::class,
    ]);
    Route::post('price-filter', [ProductController::class, 'filerByPrice']);
    Route::get('/users', [AuthController::class, 'index']);
    Route::get('/users/{user}', [AuthController::class, 'show']);
    Route::put('/users/update/{user}', [AuthController::class, 'update']);
    Route::delete('/users/delete/{user}', [AuthController::class, 'delete']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/add-to-cart', [CartController::class, 'store']);
    Route::post('/update', [CartController::class, 'update']);
    Route::post('/delete', [CartController::class, 'delete']);
});

