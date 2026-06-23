<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;

use App\Models\Event;
use App\Models\Ticket;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    // Jika admin sudah login, masuk dashboard admin
    if (auth()->check() && trim(auth()->user()->role) == 'admin') {
        return app(DashboardController::class)->index(request());
    }

    // Selain admin (termasuk belum login), tampilkan halaman pelanggan
    return redirect('/pelanggan');
});


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::resource('events', EventController::class);

    Route::get('/event-saya', function () {

        $events = Event::all();

        return view('event-saya', compact('events'));

    })->name('admin.events');

    Route::get('/transaksi', function () {

        $tickets = Ticket::with(['user', 'event'])->get();

        return view('transaksi', compact('tickets'));

    })->name('admin.transaksi');

    Route::view('/profil-admin', 'profil-admin')
        ->name('admin.profil');

});


/*
|--------------------------------------------------------------------------
| AUTH USER
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::post(
        '/profil/upload',
        [DashboardController::class, 'uploadProfil']
    )->name('profil.upload');

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');

    Route::patch(
        '/pelanggan/update-profile',
        [ProfileController::class, 'update']
    )->name('pelanggan.profile.update');

});


/*
|--------------------------------------------------------------------------
| PELANGGAN
|--------------------------------------------------------------------------
*/

// Bisa diakses tanpa login
Route::get('/pelanggan', function () {

    $events = Event::all();

    $tickets = auth()->check()
        ? Ticket::with('event')
            ->where('user_id', auth()->id())
            ->get()
        : collect();

    return view('pelanggan', compact('events', 'tickets'));
});

// Yang di bawah tetap harus login
Route::middleware('auth')->group(function () {

    Route::view(
        '/profil-pelanggan',
        'profil-pelanggan'
    )->name('profil.pelanggan');

    Route::get('/tiket-saya', function () {

        $tickets = Ticket::with('event')
            ->where('user_id', auth()->id())
            ->get();

        return view(
            'tiket-saya',
            compact('tickets')
        );

    })->name('tiket.saya');

});

/*
|--------------------------------------------------------------------------
| PEMBAYARAN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/pembayaran/{id}', function ($id) {

        $ticket = Ticket::findOrFail($id);

        return view(
            'pembayaran',
            compact('ticket')
        );

    });

    Route::post('/pembayaran/{id}', function ($id) {

        $ticket = Ticket::findOrFail($id);

        $ticket->status_pembayaran = 'Lunas';
        $ticket->save();

        return redirect('/tiket-saya');

    })->name('pembayaran.selesai');

});


/*
|--------------------------------------------------------------------------
| TICKET CRUD
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get(
        '/tickets',
        [TicketController::class, 'index']
    )->name('tickets.index');

    Route::post(
        '/tickets',
        [TicketController::class, 'store']
    )->name('tickets.store');

    Route::delete(
        '/tickets/{ticket}',
        [TicketController::class, 'destroy']
    )->name('tickets.destroy');

});


/*
|--------------------------------------------------------------------------
| SESSION
|--------------------------------------------------------------------------
*/

Route::post('/reset-kunjungan', function () {

    session()->forget([
        'jumlah_kunjungan',
        'kunjungan_pertama',
        'kunjungan_terakhir'
    ]);

    return redirect('/');

});


/*
|--------------------------------------------------------------------------
| SEARCH
|--------------------------------------------------------------------------
*/

Route::get(
    '/search-event',
    [EventController::class, 'search']
)->name('search.event');


/*
|--------------------------------------------------------------------------
| PUBLIC PAGES
|--------------------------------------------------------------------------
*/

Route::view('/tentang', 'tentang');
Route::view('/kontak', 'kontak');
Route::view('/preferensi', 'preferensi');


/*
|--------------------------------------------------------------------------
| PREFERENSI
|--------------------------------------------------------------------------
*/

Route::post('/simpan-preferensi', function (Request $request) {

    Cookie::queue(
        'tema',
        $request->tema,
        60 * 24 * 30
    );

    Cookie::queue(
        'font',
        $request->font,
        60 * 24 * 30
    );

    return back()->with(
        'success',
        'Preferensi berhasil disimpan!'
    );

})->name('preferensi.simpan');


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
