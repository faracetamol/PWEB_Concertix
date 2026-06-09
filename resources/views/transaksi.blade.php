@php
use Illuminate\Support\Facades\Cookie;
@endphp
<!DOCTYPE html>
<html>
<head>
    <title>Transaksi</title>
    <link rel="stylesheet"
          href="{{ asset('css/style.css') }}">
</head>

<body class="{{ Cookie::get('tema') == 'dark' ? 'dark-mode' : '' }}">

<nav class="navbar">
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}"
             width="120">
    </div>

    <div class="menu">
        <a href="/">Kembali ke Dashboard</a>
    </div>
</nav>

<section class="content">
    <h2>📊 Data Transaksi</h2>
    <table class="ticket-table">
        <thead>
            <tr>
                <th>Pembeli</th>
                <th>Event</th>
                <th>Jumlah Tiket</th>
                <th>Total Harga</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>

            @foreach($tickets as $ticket)

            <tr>
                <td>{{ $ticket->user->name }}</td>
                <td>{{ $ticket->event->nama }}</td>
                <td>{{ $ticket->jumlah_tiket }}</td>
                <td>
                    Rp {{ number_format($ticket->total_harga) }}
                </td>

                <td>
                    @if($ticket->status_pembayaran == 'Lunas')
                        <span style="color:green;font-weight:bold;">
                            ✅ Lunas
                        </span>
                    @else

                        <span style="color:red;font-weight:bold;">
                            ❌ Belum Lunas
                        </span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</section>
</body>
</html>
