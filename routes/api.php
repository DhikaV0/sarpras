<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MainApiController;

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

// USER API
Route::post('/register', [MainApiController::class, 'register']);
Route::post('/login', [MainApiController::class, 'login']);
Route::post('/logout', [MainApiController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    // AUTH
    Route::post('/logout', [MainApiController::class, 'logout']);

    // CATEGORY
    Route::get('/categories', [MainApiController::class, 'getCategories']);
    Route::post('/categories', [MainApiController::class, 'createCategory']);
    Route::put('/categories/{id}', [MainApiController::class, 'updateCategory']);
    Route::delete('/categories/{id}', [MainApiController::class, 'deleteCategory']);

    // ITEM
    Route::get('/items', [MainApiController::class, 'getItems']);
    Route::post('/items', [MainApiController::class, 'createItem']);
    Route::put('/items/{id}', [MainApiController::class, 'updateItem']);
    Route::delete('/items/{id}', [MainApiController::class, 'deleteItem']);

    // PEMINJAMAN
    Route::post('/peminjaman', [MainApiController::class, 'store']);

    // Get current user
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
