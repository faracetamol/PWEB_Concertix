<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/tentang', function () {
    return view('tentang');
});

Route::get('/kontak', function () {
    return view('kontak');
});

Route::get('/hitung/{a}/{b}', function ($a, $b) {
    return $a + $b;
});

Route::post('/tambah', [DashboardController::class, 'store']);
Route::post('/update/{id}', [DashboardController::class, 'update']);
Route::get('/hapus/{id}', [DashboardController::class, 'delete']);
