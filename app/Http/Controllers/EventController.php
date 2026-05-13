<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $events = Event::where('user_id', auth()->id())
                ->latest()
                ->paginate(10);

    return view('events.index', compact('events'));
}

    /**
     * Show the form for creating a new resource.
     */
   public function create()
{
    return view('events.create');
}
    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|min:3',
        'lokasi' => 'required',
        'tanggal' => 'required|date',
        'stok' => 'required|integer',
        'harga' => 'required|integer',
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

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
        'gambar' => $namaFile,
        'user_id' => auth()->id()
    ]);

    return redirect()
        ->route('events.index')
        ->with('success', 'Event berhasil ditambahkan!');
}

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
{
    return view('events.edit', compact('event'));
}

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, Event $event)
{
    $request->validate([
        'nama' => 'required|min:3',
        'lokasi' => 'required',
        'tanggal' => 'required|date',
        'stok' => 'required|integer',
        'harga' => 'required|integer',
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'

    ]);

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

    return redirect()
        ->route('events.index')
        ->with('success', 'Event berhasil diupdate!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
{
    $event->delete();

    return redirect()
        ->route('events.index')
        ->with('success', 'Event berhasil dihapus!');
}

}
