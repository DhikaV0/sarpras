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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// USER API
Route::post('/register', [MainApiController::class, 'register']);
Route::post('/login', [MainApiController::class, 'login']);

// CATEGORY API
Route::get('/categories', [MainApiController::class, 'getCategories']);
Route::post('/categories', [MainApiController::class, 'createCategory']);
Route::put('/categories/{id}', [MainApiController::class, 'updateCategory']);
Route::delete('/categories/{id}', [MainApiController::class, 'deleteCategory']);

// ITEM API
Route::get('/items', [MainApiController::class, 'getItems']);
Route::post('/items', [MainApiController::class, 'createItem']);
Route::put('/items/{id}', [MainApiController::class, 'updateItem']);
Route::delete('/items/{id}', [MainApiController::class, 'deleteItem']);
