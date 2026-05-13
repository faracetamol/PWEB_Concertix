@extends('layouts.app')

@section('content')

<h1>Daftar Event</h1>

<a href="{{ route('events.create') }}">Tambah Event</a>

<br><br>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Event</th>
            <th>Lokasi</th>
            <th>Tanggal</th>
            <th>Stok</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @forelse($events as $event)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $event->nama }}</td>
                <td>{{ $event->lokasi }}</td>
                <td>{{ $event->tanggal }}</td>
                <td>{{ $event->stok }}</td>
                <td>Rp {{ number_format($event->harga, 0, ',', '.') }}</td>
                <td>
                    <a href="{{ route('events.edit', $event->id) }}">Edit</a>

                    <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus event ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">Belum ada event.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<br>

{{ $events->links() }}

@endsection
