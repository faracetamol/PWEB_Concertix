@php
use Illuminate\Support\Facades\Cookie;
@endphp
<!DOCTYPE html>
<html>
<head>
    <title>Concertix - Dashboard Pelanggan</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <script>
    (function() {
        const tema = document.cookie
            .split('; ')
            .find(row => row.startsWith('tema='))
            ?.split('=')[1];

        if (tema === 'dark') {
            document.documentElement.classList.add('dark');
        }
    })();
    </script>
</head>

<body class="
{{ Cookie::get('tema') == 'dark' ? 'dark-mode' : '' }}
bg-white transition-all duration-300
">

<!-- NAVBAR -->
<nav class="navbar">
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" width="120">
    </div>

   <div class="menu">
    <button onclick="toggleDarkMode()" class="btn-dark">
        Dark Mode
    </button>

    <a href="#dashboard">Dashboard</a>
    <a href="#event">Daftar Event</a>
    <a href="{{ route('tiket.saya') }}">Tiket Saya</a>
    <a href="{{ route('profil.pelanggan') }}">Profil</a>
    <a href="{{ url('/tentang') }}">Tentang</a>
    <a href="{{ url('/kontak') }}">Kontak</a>
    <a href="{{ url('/preferensi') }}">Preferensi</a>

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="submit" class="btn-logout">
            Logout
        </button>
    </form>
</div>
</nav>

<!-- HEADER -->
<header id="dashboard" class="header">
    <h1>Dashboard Pelanggan</h1>
    <p>
        Temukan event favoritmu di Concertix
    </p>
</header>

<!-- HERO -->
<div class="hero">
    <h2>
        Selamat Datang, {{ auth()->user()->name }} 👋
    </h2>

    <p>
        Cari event terbaik dan pesan tiket dengan mudah.
    </p>
</div>

<!-- CUACA -->
<section class="content" id="cuaca">
    <h3>Cuaca Hari Ini</h3>
    <button onclick="ambilCuaca()">
        Muat Cuaca Surabaya
    </button>

    <p id="loadingCuaca" style="display:none;">
        Sedang mengambil data cuaca...
    </p>

    <div id="hasilCuaca">
        <p>Belum ada data cuaca.</p>
    </div>
</section>

<!-- SEARCH -->
<section class="content">
    <h2>Cari Event</h2>
    <input
        type="text"
        id="searchInput"
        placeholder="Cari event..."
        onkeyup="searchEvent()">

    <div id="hasilSearch"></div>
</section>

<!-- MAIN -->
<main class="main">

<form method="GET">

    <select name="filter">
        <option value="">Semua Event</option>
        <option value="terdekat">Event Terdekat</option>
        <option value="termurah">Harga Termurah</option>
    </select>

    <button type="submit">
        Filter
    </button>
</form>

<!-- DAFTAR EVENT -->
<section id="event" class="content">
    <h2>Daftar Event Tersedia</h2>

    <div class="container">
        @forelse($events as $event)
            <div class="card">
                @if($event->gambar)
                    <img
                        src="{{ asset('images/' . $event->gambar) }}"
                        class="card-img"
                        alt="{{ $event->nama }}">
                @else
                    <img
                        src="{{ asset('images/logo.png') }}"
                        class="card-img">
                @endif

                <div class="card-body">
                    <h4>{{ $event->nama }}</h4>
                    <p>📍 {{ $event->lokasi }}</p>
                    <p>
                        📅
                        {{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }}
                    </p>
                    <p>
                        🎫 Stok: {{ $event->stok }}
                    </p>
                    <p>
                        💰 Rp {{ number_format($event->harga) }}
                    </p>
                    <form method="POST"
                          action="{{ route('tickets.store') }}">

                        @csrf

        <input type="hidden"
           name="event_id"
           value="{{ $event->id }}">

    <label>Jumlah Tiket</label>

    <input type="number"
           name="jumlah_tiket"
           min="1"
           max="{{ $event->stok }}"
           value="1"
           required>

           <br><br>

                        <button type="submit"
                            style="
                            width:100%;
                            background:#0000aa;
                            color:white;
                            border:none;
                            padding:10px;
                            border-radius:5px;
                            cursor:pointer;">
                            Pesan Tiket
                        </button>
                    </form>
                </div>
            </div>

        @empty
            <p>Belum ada event tersedia.</p>
        @endforelse

    </div>
</section>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <h3>Informasi Akun</h3>
        <ul>
            <li>Role : Pelanggan</li>
            <li>Status : Aktif</li>
        </ul>
    </aside>
</main>

<!-- FOOTER -->
<footer class="footer">
    <div>About</div>
    <div>Contact</div>
    <div>Social Media</div>
</footer>

<!-- CUACA -->
<script>
async function ambilCuaca() {

    const loading = document.getElementById("loadingCuaca");
    const hasil = document.getElementById("hasilCuaca");

    loading.style.display = "block";
    hasil.innerHTML = "";

    try {

        const response = await fetch(
            "https://wttr.in/Surabaya?format=j1"
        );
        const data = await response.json();
        const kota =
            data.nearest_area[0].areaName[0].value;
        const suhu =
            data.current_condition[0].temp_C;

        const deskripsi =
            data.current_condition[0]
            .weatherDesc[0].value;

        hasil.innerHTML = `
            <div class="cuaca-card">
                <h4>${kota}</h4>
                <p>Suhu: ${suhu}°C</p>
                <p>Cuaca: ${deskripsi}</p>
            </div>
        `;

    } catch (error) {
        hasil.innerHTML =
            "<p style='color:red'>Gagal mengambil cuaca</p>";
    } finally {
        loading.style.display = "none";
    }
}
</script>

<!-- SEARCH EVENT -->
<script>
async function searchEvent() {

    const keyword =
        document.getElementById('searchInput').value;
    const hasil =
        document.getElementById('hasilSearch');
    try {

        const response =
            await fetch(`/search-event?keyword=${keyword}`);
        const data = await response.json();

        hasil.innerHTML = "";

        if(data.length === 0) {

            hasil.innerHTML =
                "<p>Event tidak ditemukan</p>";
            return;
        }

        data.forEach(event => {

            hasil.innerHTML += `
                <div class="event-card">
                    <h3>${event.nama}</h3>
                    <p>${event.lokasi}</p>
                </div>
            `;
        });

    } catch(error) {
        hasil.innerHTML =
            "<p style='color:red'>Gagal mengambil data</p>";
    }
}
</script>

<!-- DARK MODE -->
<script>

function setCookie(name, value, days) {
    const expires = new Date();

    expires.setTime(
        expires.getTime() +
        days * 24 * 60 * 60 * 1000
    );

    document.cookie =
        `${name}=${value};expires=${expires.toUTCString()};path=/`;
}

function getCookie(name) {
    const cookies =
        document.cookie.split('; ');

    for (let cookie of cookies) {

        let [key, value] =
            cookie.split('=');

        if (key === name)
            return value;
    }
    return null;
}

function toggleDarkMode() {

    document.body.classList.toggle('dark-mode');

    if (
        document.body.classList.contains('dark-mode')
    ) {
        setCookie('tema', 'dark', 30);
    } else {
        setCookie('tema', 'light', 30);
    }
}

window.addEventListener('DOMContentLoaded', function () {

    if (getCookie('tema') === 'dark') {
        document.body.classList.add('dark-mode');
    }
});
</script>

</body>
</html>
