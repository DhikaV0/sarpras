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
    return redirect()->route('login');
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
    Route::get('/web/home', [MainController::class, 'showHome'])->name('home');
    Route::get('/mobile/home', [MainController::class, 'showHome'])->name('mobile.home');
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
    Route::delete('/peminjaman/{id}', [MainController::class, 'destroy'])->name('peminjaman.delete');
    Route::post('/peminjaman/{id}/approve', [MainController::class, 'approve'])->name('peminjaman.approve');
    Route::post('/peminjaman/{id}/reject', [MainController::class, 'reject'])->name('peminjaman.reject');

    // Pengembalian
    Route::get('/pengembalian', [MainController::class, 'showPengembalian'])->name('pengembalian');
    Route::put('/pengembalian/{id}/approve', [MainController::class, 'approvePengembalian'])->name('pengembalian.approve');
    Route::put('/pengembalian/{id}/reject', [MainController::class, 'rejectPengembalian'])->name('pengembalian.reject');

    // Laporan
    Route::get('/laporan', [MainController::class, 'showLaporan'])->name('laporan');
    Route::get('/laporan/pdf', [MainController::class, 'downloadLaporanPDF'])->name('laporan.pdf');

    // Logout
    Route::post('/logout', [MainController::class, 'logout'])->name('logout');
});
