@extends('layouts.app')

@section('content')

<h1>Edit Event</h1>

<form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <input type="text" name="nama" placeholder="Nama Event" value="{{ old('nama', $event->nama) }}"><br>
    @error('nama') <small>{{ $message }}</small><br> @enderror

    <input type="text" name="lokasi" placeholder="Lokasi" value="{{ old('lokasi', $event->lokasi) }}"><br>
    @error('lokasi') <small>{{ $message }}</small><br> @enderror

    <input type="date" name="tanggal" value="{{ old('tanggal', $event->tanggal->format('Y-m-d')) }}"><br>
    @error('tanggal') <small>{{ $message }}</small><br> @enderror

    <input type="number" name="stok" placeholder="Stok" value="{{ old('stok', $event->stok) }}"><br>
    @error('stok') <small>{{ $message }}</small><br> @enderror

    <input type="number" name="harga" placeholder="Harga" value="{{ old('harga', $event->harga) }}"><br>
    @error('harga') <small>{{ $message }}</small><br> @enderror

    @if($event->gambar)
        <img src="{{ asset('images/' . $event->gambar) }}" width="120"><br>
    @endif

    <input type="file" name="gambar"><br>
    @error('gambar') <small>{{ $message }}</small><br> @enderror

    <button type="submit">Update</button>
</form>

@endsection
