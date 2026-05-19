<?php

use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    // jumlah kunjungan
    $jumlah = session('jumlah_kunjungan', 0);
    $jumlah++;

    // kunjungan pertama
    if (!session()->has('kunjungan_pertama')) {

        session([
            'kunjungan_pertama' => now()->format('d M Y H:i:s')
        ]);
    }

    // update session
    session([
        'jumlah_kunjungan' => $jumlah,
        'kunjungan_terakhir' => now()->format('d M Y H:i:s')
    ]);

    return view('concertix');

})->name('home');

Route::post('/reset-kunjungan', function () {

    session()->forget([
        'jumlah_kunjungan',
        'kunjungan_pertama',
        'kunjungan_terakhir'
    ]);

    return redirect('/');

});

Route::get('/dashboard', function () {
    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/search-event', [EventController::class, 'search']);

Route::get('/tentang', function () {
    return view('tentang');
});

Route::get('/kontak', function () {
    return view('kontak');
});

Route::get('/preferensi', function () {
    return view('preferensi');
});

Route::post('/simpan-preferensi', function (Request $request) {

    Cookie::queue('tema', $request->tema, 60 * 24 * 30);

    Cookie::queue('font', $request->font, 60 * 24 * 30);

    return response()->json([
        'message' => 'Preferensi berhasil disimpan!'
    ]);

});

Route::middleware(['auth', 'admin'])->group(function () {

    Route::resource('events', EventController::class);

    Route::post('/profil/upload', [DashboardController::class, 'uploadProfil'])
    ->name('profil.upload');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
