<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index(Request $request)
{
    // SESSION KUNJUNGAN
    $jumlah = session('jumlah_kunjungan', 0);
    $jumlah++;

    if (!session()->has('kunjungan_pertama')) {
        session([
            'kunjungan_pertama' => now()->format('d M Y H:i:s')
        ]);
    }

    session([
        'jumlah_kunjungan' => $jumlah,
        'kunjungan_terakhir' => now()->format('d M Y H:i:s')
    ]);

    // QUERY EVENT
    $query = Event::query();

    if ($request->filter == 'terdekat') {
        $query->orderBy('tanggal', 'asc');
    }

    $events = $query->get();

    // TRANSAKSI
    $transaksi = Ticket::with(['user', 'event'])->get();

    // STATISTIK
    $totalEvent = Event::count();
    $totalTiket = Ticket::sum('jumlah_tiket');
    $totalNilai = Ticket::sum('total_harga');

    return view('concertix', compact(
        'events',
        'transaksi',
        'totalEvent',
        'totalTiket',
        'totalNilai'
    ));
}

   public function uploadProfil(Request $request)
{
    $request->validate([
        'foto_profil' => 'required|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $file = $request->file('foto_profil');

    $namaFile = time() . '.' . $file->getClientOriginalExtension();

    $file->move(public_path('images/profil'), $namaFile);

    auth()->user()->update([
        'foto_profil' => $namaFile
    ]);

    return back()->with(
        'success',
        'Foto profil berhasil diupload!'
    );
}

    // TAMBAH
    public function store(Request $request){

        $namaFile = null;

        if($request->hasFile('gambar')){
            $file = $request->file('gambar');
            $namaFile = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('images'), $namaFile);
        }

        Event::create([
            'nama' => $request->nama,
            'lokasi' => $request->lokasi,
            'tanggal' => $request->tanggal,
            'stok' => $request->stok,
            'harga' => $request->harga,
            'gambar' => $namaFile
        ]);
        return redirect()->back()->with('success', 'Event berhasil ditambahkan!');
    }

    // UPDATE 
    public function update(Request $request, $id){
        $event = Event::find($id);

        if($request->hasFile('gambar')){
            $file = $request->file('gambar');
            $namaFile = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('images'), $namaFile);

            $event->gambar = $namaFile;
        }

        $event->nama = $request->nama;
        $event->lokasi = $request->lokasi;
        $event->tanggal = $request->tanggal;
        $event->stok = $request->stok;
        $event->harga = $request->harga;

        $event->save();

        return redirect()->back();
    }

    // HAPUS
    public function delete($id){
        Event::find($id)->delete();
        return redirect()->back();
    }
}
