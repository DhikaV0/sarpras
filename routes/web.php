<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthCrudController;

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

Route::get('/home', function () {
    return view('home/home');
})->name('home');

Route::get('/crud', function () {
    return view('Crud.crud');
})->name('crud');

// REGISTER ROUTES
Route::get('/register', [AuthCrudController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthCrudController::class, 'register'])->name('register.submit');

// LOGIN ROUTES
Route::get('/login', [AuthCrudController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthCrudController::class, 'login'])->name('login.submit');

// CATEGORY CRUD ROUTES
Route::get('/category', [AuthCrudController::class, 'showCategoryCrud'])->name('category');
Route::post('/category', [AuthCrudController::class, 'storeCategory'])->name('category.store');
Route::put('/category/{id}', [AuthCrudController::class, 'updateCategory'])->name('category.update');
Route::delete('/category/{id}', [AuthCrudController::class, 'deleteCategory'])->name('category.delete');

// LOGOUT ROUTE
Route::post('/logout', [AuthCrudController::class, 'logout'])->name('logout');

