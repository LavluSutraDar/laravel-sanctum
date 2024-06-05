<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(RegisterController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::get('index',[ProductController::class, 'index']);
Route::post('store', [ProductController::class, 'store']);
Route::get('show/{id}', [ProductController::class, 'show']);
Route::post('update/{id}',[ProductController::class, 'update']);

//Route::get('index', [CategoryController::class, 'index']);
Route::post('cat/store', [CategoryController::class, 'store']);
Route::get('cat/show/{category}', [CategoryController::class, 'show']);
Route::post('cat/update/{category}', [CategoryController::class, 'update']);
