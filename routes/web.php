<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/

Route::get('/', function () {
    return redirect()->route('register');
});

// AUTH ROUTES (GUEST ONLY)
Route::middleware('guest')->group(function () {
    Route::get('/register', [MainController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [MainController::class, 'register'])->name('register.submit');
    Route::get('/login', [MainController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [MainController::class, 'login'])->name('login.submit');
});

// PROTECTED ROUTES (AUTH REQUIRED)
Route::middleware('auth')->group(function () {

    // Home
    Route::get('/home', [MainController::class, 'showHome'])->name('home');

    // Users
    Route::get('/users', [MainController::class, 'showUsers'])->name('users');
    Route::post('/users', [MainController::class, 'storeUser'])->name('users.store');

    // CRUD Main Page
    Route::get('/crud', [MainController::class, 'showCrudPage'])->name('crud');

    // Categories CRUD
    Route::post('/category', [MainController::class, 'storeCategory'])->name('category.store');
    Route::put('/category/{id}', [MainController::class, 'updateCategory'])->name('category.update');
    Route::delete('/category/{id}', [MainController::class, 'deleteCategory'])->name('category.delete');

    // Items CRUD
    Route::post('/item', [MainController::class, 'storeItem'])->name('item.store');
    Route::put('/item/{id}', [MainController::class, 'updateItem'])->name('item.update');
    Route::delete('/item/{id}', [MainController::class, 'deleteItem'])->name('item.delete');

    // Peminjaman
    Route::get('/peminjaman', [MainController::class, 'showPeminjaman'])->name('peminjaman');
    Route::post('/peminjaman', [MainController::class, 'storePeminjaman'])->name('peminjaman.store');
    Route::put('/peminjaman/{id}', [MainController::class, 'updatePeminjaman'])->name('peminjaman.update');
    Route::delete('/peminjaman/{id}', [MainController::class, 'destroy'])->name('peminjaman.delete');

    // Logout
    Route::post('/logout', [MainController::class, 'logout'])->name('logout');
});
