<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TaskController;
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
Route::middleware('throttle:10,1')->group(function () {
    Route::get('login', [RegisterController::class, 'relogin'])->name('login');
    Route::post('login', [RegisterController::class, 'login']);
    Route::middleware('auth:api')->group(function () {
        Route::get('categories', [CategoryController::class, 'invoke']);
        Route::get('tasks', [TaskController::class, 'index']);
        Route::post('searchTask', [TaskController::class, 'searchTask']);
        Route::post('attachTaskCategory', [TaskController::class,'attachTaskCategory']);
    });
});



