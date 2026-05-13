@extends('layouts.app')

@section('content')

<h1>Tambah Event</h1>

<form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="text" name="nama" placeholder="Nama Event" value="{{ old('nama') }}"><br>
    @error('nama') <small>{{ $message }}</small><br> @enderror

    <input type="text" name="lokasi" placeholder="Lokasi" value="{{ old('lokasi') }}"><br>
    @error('lokasi') <small>{{ $message }}</small><br> @enderror

    <input type="date" name="tanggal" value="{{ old('tanggal') }}"><br>
    @error('tanggal') <small>{{ $message }}</small><br> @enderror

    <input type="number" name="stok" placeholder="Stok" value="{{ old('stok') }}"><br>
    @error('stok') <small>{{ $message }}</small><br> @enderror

    <input type="number" name="harga" placeholder="Harga" value="{{ old('harga') }}"><br>
    @error('harga') <small>{{ $message }}</small><br> @enderror

    <input type="file" name="gambar"><br>
    @error('gambar') <small>{{ $message }}</small><br> @enderror

    <button type="submit">Simpan</button>
</form>

@endsection
