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

Route::get('/home', function () {
    return view('pages.home');
})->name('home');

Route::get('/crud', function () {
    return view('pages.crud');
})->name('crud');

Route::get('/user', function () {
    return view('pages.users');
})->name('users');

// REGISTER ROUTES
Route::get('/register', [MainController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [MainController::class, 'register'])->name('register.submit');

// LOGIN ROUTES
Route::get('/login', [MainController::class, 'showLoginForm'])->name('login');
Route::post('/login', [MainController::class, 'login'])->name('login.submit');

// USERS
Route::get('/users', [MainController::class, 'showUsers'])->name('users');

// CRUD
Route::get('/crud', [MainController::class,'showCrudPage'])->name('crud');

// CRUD CATEGORY
Route::post('/category', [MainController::class,'storeCategory'])->name('category.store');
Route::put('/category/{id}', [MainController::class,'updateCategory'])->name('category.update');
Route::delete('/category/{id}',[MainController::class,'deleteCategory'])->name('category.delete');

// CRUD ITEM
Route::post('/item', [MainController::class,'storeItem'])->name('item.store');
Route::put('/item/{id}', [MainController::class,'updateItem'])->name('item.update');
Route::delete('/item/{id}',[MainController::class,'deleteItem'])->name('item.delete');

// LOGOUT ROUTE
Route::post('/logout', [MainController::class, 'logout'])->name('logout');

