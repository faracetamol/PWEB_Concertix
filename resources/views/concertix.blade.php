@php
use Illuminate\Support\Facades\Cookie;
@endphp
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concertix - Dashboard Penjual</title>
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
<script>

const toggle = document.querySelector('.menu-toggle');
const menu = document.querySelector('.menu');

toggle.addEventListener('click', () => {
    menu.classList.toggle('active');
});

</script>
<body class="
{{ Cookie::get('tema') == 'dark' ? 'dark-mode' : '' }}
bg-white transition-all duration-300
">

<!-- NAVBAR -->
<nav class="navbar">
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" width="120">
    </div>

    <button class="menu-toggle">
        ☰
    </button>

    <div class="menu">
    <button onclick="toggleDarkMode()" class="btn-dark">
    Dark Mode
    </button>
    <a href="#dashboard">Dashboard</a>
    <a href="{{ route('admin.events') }}">Event Saya</a>
    <a href="{{ route('events.create') }}">Tambah Event</a>
    <a href="{{ route('admin.transaksi') }}">Transaksi</a>
    <a href="{{ route('admin.profil') }}">Profil</a>
    <a href="{{ url('/tentang') }}">Tentang</a>
    <a href="{{ url('/kontak') }}">Kontak</a>
    <a href="/preferensi">Preferensi</a>
    <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" style="background:white; border:none; color:blue; cursor:pointer;">
        Logout
    </button>
</form>
</div>
</nav>

<!-- HEADER -->
<header id="dashboard" class="header">
    <h1>Dashboard</h1>
    <p>Kelola event dan pantau penjualan tiket Anda</p>
</header>

<div class="hero">
    <h2>Selamat Datang, Admin!</h2>
    <p>Kelola event dan pantau penjualan tiket Anda di Concertix.</p>
</div>

<section class="content" id="cuaca">
    <h3>Cuaca Hari Ini</h3>
    <button onclick="ambilCuaca()">Muat Cuaca Surabaya</button>
    <p id="loadingCuaca" style="display:none;">
        Sedang mengambil data cuaca...
    </p>

    <div id="hasilCuaca">
        <p>Belum ada data cuaca.</p>
    </div>
</section>

<section class="content">

    <h2>Statistik Kunjungan</h2>
    <div class="event-card">
        <p>
            Jumlah Kunjungan:
            <strong>{{ session('jumlah_kunjungan') }}</strong>
        </p>

        <p>
            Kunjungan Pertama:
            <strong>{{ session('kunjungan_pertama') }}</strong>
        </p>

        <p>
            Kunjungan Terakhir:
            <strong>{{ session('kunjungan_terakhir') }}</strong>
        </p>

        <br>

        <form action="/reset-kunjungan" method="POST">
            @csrf

            <button type="submit">
                Reset Hitungan
            </button>
        </form>
    </div>
</section>

<!-- MAIN -->
<main class="main">

<!-- SECTION EVENT -->
<section id="event" class="content">

    <div class="main-layout">

        <!-- KIRI -->
        <div class="event-section">
            <section class="content bg-white dark:bg-gray-800 dark:text-white">
                <h2>Cari Event</h2>
                <input type="text"
                       id="searchInput"
                       placeholder="Cari event..."
                       onkeyup="searchEvent()">
                <div id="hasilSearch"></div>
            </section>

            <br><br>

            <h3>Preview Event</h3>
            <div class="container">
                @foreach($events as $event)

                <div class="card">
                    @if($event->gambar)
                        <img src="{{ asset('images/' . $event->gambar) }}"
                             class="card-img">
                    @endif

                    <div class="card-body">
                        <h4>{{ $event->nama }}</h4>
                        <p>{{ $event->tanggal }}</p>
                        <p>{{ $event->lokasi }}</p>
                        <p>
                            Rp {{ number_format($event->harga) }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- KANAN -->
        <aside class="sidebar">
            <div class="sidebar-card">
                <h3>📊 Statistik Penjualan</h3>

                <ul>
                    <li>Total Event : {{ $totalEvent }}</li>
                    <li>Total Tiket : {{ $totalTiket }}</li>
                    <li>Total Nilai : Rp {{ number_format($totalNilai) }}</li>
                </ul>

            </div>
        </aside>
    </div>

</section>
</main>

<!-- FOOTER -->
<footer class="footer">
<div>About</div>
<div>Contact</div>
<div>Social Media</div>
</footer>

<script>
async function ambilCuaca() {
    const loading = document.getElementById("loadingCuaca");
    const hasil = document.getElementById("hasilCuaca");

    loading.style.display = "block";
    hasil.innerHTML = "";

    try {
        const response = await fetch("https://wttr.in/Surabaya?format=j1");

        if (!response.ok) {
            throw new Error("Gagal mengambil data cuaca");
        }

        const data = await response.json();
        const kota = data.nearest_area[0].areaName[0].value;
        const suhu = data.current_condition[0].temp_C;
        const deskripsi = data.current_condition[0].weatherDesc[0].value;

        hasil.innerHTML = `
            <div class="cuaca-card">
                <h4>${kota}</h4>
                <p>Suhu: ${suhu}°C</p>
                <p>Cuaca: ${deskripsi}</p>
            </div>
        `;
    } catch (error) {
        hasil.innerHTML = `
            <p style="color:red;">${error.message}</p>
        `;
    } finally {
        loading.style.display = "none";
    }
}
</script>

<script>
async function searchEvent() {

    const keyword = document.getElementById('searchInput').value;
    const hasil = document.getElementById('hasilSearch');

    try {
        const response = await fetch(`/search-event?keyword=${keyword}`);
        const data = await response.json();

        hasil.innerHTML = "";

        if(data.length === 0) {
            hasil.innerHTML = "<p>Event tidak ditemukan</p>";
            return;
        }
       data.forEach(event => {

    const tanggal = new Date(event.tanggal).toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'long',
        year: 'numeric'
    });

    hasil.innerHTML += `
       <div class="event-card bg-white dark:bg-gray-900 dark:text-white">
            <h3>${event.nama}</h3>
            <p>${event.lokasi}</p>
            <p>${tanggal}</p>
        </div>
    `;

});

    } catch(error) {
        hasil.innerHTML = `
            <p style="color:red;">
                Gagal mengambil data
            </p>
        `;
    }
}
</script>

<script>
function setCookie(name, value, days) {
    const expires = new Date();
    expires.setTime(expires.getTime() + days * 24 * 60 * 60 * 1000);
    document.cookie = `${name}=${value};expires=${expires.toUTCString()};path=/`;
}

function getCookie(name) {
    const cookies = document.cookie.split('; ');
    for (let cookie of cookies) {
        let [key, value] = cookie.split('=');
        if (key === name) return value;
    }
    return null;
}

function deleteCookie(name) {
    document.cookie =
        `${name}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
}

function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');

    if (document.body.classList.contains('dark-mode')) {
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
