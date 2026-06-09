@php
use Illuminate\Support\Facades\Cookie;
@endphp
<!DOCTYPE html>
<html>
<head>
    <title>Tiket Saya</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .ticket-table{
            width:100%;
            border-collapse:collapse;
            margin-top:20px;
            background:white;
            border-radius:10px;
            overflow:hidden;
        }

        .ticket-table th{
            background:#0000aa;
            color:white;
            padding:15px;
            text-align:center;
        }

        .ticket-table td{
            padding:15px;
            border-bottom:1px solid #ddd;
            text-align:center;
        }

        .ticket-table tr:hover{
            background:#f5f5f5;
        }

        .status-lunas{
            color:#16a34a;
            font-weight:bold;
        }

        .status-belum{
            color:#dc2626;
            font-weight:bold;
        }

        .btn-bayar{
    background:#0000aa;
    color:white;
    padding:8px 15px;
    border-radius:5px;
    text-decoration:none;
}

.btn-bayar:hover{
    background:#000080;
}

        .content{
            padding:30px;
        }

        h2{
            margin-bottom:20px;
        }
    </style>
</head>

<body class="{{ Cookie::get('tema') == 'dark' ? 'dark-mode' : '' }}">

<nav class="navbar">
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" width="120">
    </div>

    <div class="menu">
        <a href="{{ url('/pelanggan') }}">
            Kembali ke Dashboard
        </a>
    </div>
</nav>

<section class="content">

    <h2>🎫 Tiket Saya</h2>
    @if($tickets->count())
        <table class="ticket-table">
            <thead>
                <tr>
                    <th>Event</th>
                    <th>Jumlah Tiket</th>
                    <th>Total Harga</th>
                    <th>Status Pembayaran</th>
                </tr>
            </thead>
            <tbody>

                @foreach($tickets as $ticket)

                    <tr>
                        <td>
                            {{ $ticket->event->nama }}
                        </td>

                        <td>
                            {{ $ticket->jumlah_tiket }}
                        </td>

                        <td>
                            Rp {{ number_format($ticket->total_harga) }}
                        </td>

                        <td>
                            @if($ticket->status_pembayaran == 'Lunas')
    <span class="status-lunas">
        ✅ Lunas
    </span>

@else
    <span class="status-belum">
        ❌ Belum Lunas
    </span>

    <br><br>

    <a href="{{ url('/pembayaran/'.$ticket->id) }}"
       class="btn-bayar">
        Bayar Sekarang
    </a>
@endif

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @else
        <p>Belum ada tiket yang dipesan.</p>
    @endif
</section>
</body>
</html>
