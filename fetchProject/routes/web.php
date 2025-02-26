<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CancionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisterController;

Auth::routes(['verify' => true]);

Route::get('/', [CancionController::class, 'main']);

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Rutas para el controlador de canciones
Route::resource('song', CancionController::class)->except(['create', 'edit']);


