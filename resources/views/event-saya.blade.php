@php
use Illuminate\Support\Facades\Cookie;
@endphp
<!DOCTYPE html>
<html>
<head>
    <title>Event Saya</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .content{
            padding:30px;
        }

        .event-table{
            width:100%;
            border-collapse:collapse;
            background:white;
            border-radius:10px;
            overflow:hidden;
        }

        .event-table th{
            background:#0000aa;
            color:white;
            padding:15px;
        }

        .event-table td{
            padding:15px;
            border-bottom:1px solid #ddd;
            text-align:center;
        }

        .btn-edit{
            background:#16a34a;
            color:white;
            padding:8px 12px;
            text-decoration:none;
            border-radius:5px;
        }

        .btn-delete{
            background:#dc2626;
            color:white;
            border:none;
            padding:8px 12px;
            border-radius:5px;
            cursor:pointer;
        }

        .aksi{
            display:flex;
            justify-content:center;
            gap:10px;
        }

    </style>
</head>

<body class="{{ Cookie::get('tema') == 'dark' ? 'dark-mode' : '' }}">

<nav class="navbar">
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" width="120">
    </div>

    <div class="menu">
        <a href="/">Kembali ke Dashboard</a>
    </div>
</nav>

<section class="content">
    <h2>🎵 Event Saya</h2>
    <table class="event-table">
        <thead>
            <tr>
                <th>Gambar</th>
                <th>Nama Event</th>
                <th>Lokasi</th>
                <th>Tanggal</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>

        @forelse($events as $event)

            <tr>
                <td>
                    @if($event->gambar)
                        <img
                            src="{{ asset('images/' . $event->gambar) }}"
                            width="80">
                    @endif
                </td>

                <td>{{ $event->nama }}</td>
                <td>{{ $event->lokasi }}</td>
                <td>{{ $event->tanggal }}</td>
                <td>Rp {{ number_format($event->harga) }}</td>
                <td>{{ $event->stok }}</td>

                <td>
                    <div class="aksi">
                        <a href="{{ route('events.edit',$event->id) }}"
                           class="btn-edit">
                            Edit
                        </a>

                        <form action="{{ route('events.destroy',$event->id) }}"
                              method="POST">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn-delete"
                                onclick="return confirm('Yakin hapus event?')">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>

        @empty

            <tr>
                <td colspan="7">
                    Belum ada event.
                </td>
            </tr>

        @endforelse

        </tbody>
    </table>
</section>
</body>
</html>
