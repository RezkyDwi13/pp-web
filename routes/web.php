<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
})->name('home');

// Halaman login
Route::get('/login', function () {
    return view('login');
})->name('login');

// Halaman register
Route::get('/register', function () {
    return view('register');
})->name('register');

// Halaman index
Route::get('/index', function () {
    return view('index');
})->name('index');

// Halaman tambah (add)
Route::get('/add', function () {
    return view('add');
})->name('add');

// Halaman edit
Route::get('/edit', function () {
    return view('edit');
})->name('edit');

// Classification Routes
Route::post('/classify', [App\Http\Controllers\ClassificationController::class, 'store']);
Route::get('/history', [App\Http\Controllers\ClassificationController::class, 'index']);