<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotspotController;

Route::get('/', function () {
    return redirect('/login');
});

// Alias untuk MikroTik external UAM (biasa pakai /wifi-login)
Route::get('/wifi-login', [HotspotController::class, 'index']);
Route::post('/wifi-login', [HotspotController::class, 'authenticate']);

Route::get('/login', [HotspotController::class, 'index'])->name('login');
Route::post('/login', [HotspotController::class, 'authenticate'])->name('login.submit');

Route::get('/status', [HotspotController::class, 'status'])->name('status');

// Untuk testing cepat kita pakai GET logout — di production sebaiknya POST + CSRF
Route::get('/logout', [HotspotController::class, 'logout'])->name('logout');

Route::get('/error', [HotspotController::class, 'error'])->name('error');
