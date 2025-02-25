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
// Rutas para el controlador de canciones
Route::resource('song', CancionController::class)->except(['create', 'edit']);

// Rutas de autenticación

