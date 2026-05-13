<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class DashboardController extends Controller
{
    public function index(Request $request)
{
    $query = Event::query();

    if ($request->filter == 'terdekat') {
        $query->orderBy('tanggal', 'asc');
    }

    $events = $query->get();

    return view('dashboard', compact('events'));
}

   public function uploadProfil(Request $request)
{
    $request->validate([
        'foto_profil' => 'required|image|mimes:jpg,png|max:2048'
    ]);

    $file = $request->file('foto_profil');
    $namaFile = time() . '.' . $file->getClientOriginalExtension();

    $file->move(public_path('images/profil'), $namaFile);

    session(['foto_profil' => $namaFile]);

    return redirect()->back()->with('success', 'Foto profil berhasil diupload!');
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

    // UPDATE (INI YANG FIX BUG EDIT)
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
