@php
use Illuminate\Support\Facades\Cookie;
@endphp
<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran Tiket</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body{
            background:#0f172a;
            font-family:Arial, sans-serif;
            color:white;
        }

        .payment-container{
            max-width:600px;
            margin:50px auto;
            background:white;
            color:black;
            padding:30px;
            border-radius:15px;
            text-align:center;
            box-shadow:0 10px 30px rgba(0,0,0,.2);
        }

        .payment-container h2{
            color:#0000aa;
            margin-bottom:20px;
        }

        .event-info{
            background:#f3f4f6;
            padding:15px;
            border-radius:10px;
            margin-bottom:20px;
        }

        .qris-img{
            width:300px;
            border-radius:10px;
            margin:20px 0;
            border:1px solid #ddd;
        }

        .btn-bayar{
            background:#0000aa;
            color:white;
            border:none;
            padding:12px 25px;
            border-radius:8px;
            cursor:pointer;
            font-size:16px;
        }

        .btn-bayar:hover{
            background:#000080;
        }

        .status{
            color:red;
            font-weight:bold;
        }
    </style>
</head>

<body class="{{ Cookie::get('tema') == 'dark' ? 'dark-mode' : '' }}">

<div class="payment-container">
    <h2>💳 Pembayaran Tiket</h2>

    <div class="event-info">
        <h3>{{ $ticket->event->nama }}</h3>
        <p>
            🎫 {{ $ticket->jumlah_tiket }} Tiket
        </p>

        <p>
            💰 Rp {{ number_format($ticket->total_harga) }}
        </p>

        <p class="status">
            Status: Belum Lunas
        </p>
    </div>

    <h4>Scan QRIS Berikut</h4>
    <img
        src="{{ asset('images/qris.jpeg') }}"
        class="qris-img">

    <p>
        Setelah melakukan pembayaran,
        klik tombol di bawah ini.
    </p>

    <form action="{{ route('pembayaran.selesai', $ticket->id) }}"
          method="POST">
        @csrf

        <button type="submit" class="btn-bayar">
            ✅ Saya Sudah Bayar
        </button>
    </form>

    <br>

    <a href="/pelanggan">
        Kembali ke Dashboard
    </a>
</div>

</body>
</html>
