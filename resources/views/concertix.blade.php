<!DOCTYPE html>
<html>
<head>
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

<body class="bg-white dark:bg-gray-900 dark:text-white transition-all duration-300">

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
    <a href="#event">Event Saya</a>
    <a href="#tambah">Tambah Event</a>
    <a href="#transaksi">Transaksi</a>
    <a href="#profil">Profil</a>
    <a href="{{ url('/tentang') }}">Tentang</a>
    <a href="{{ url('/kontak') }}">Kontak</a>
    <a href="/preferensi">Preferensi</a>
</div>
</nav>

<!-- HEADER -->
<header id="dashboard" class="header">
    <h1>Dashboard</h1>
    <p>Kelola event dan pantau penjualan tiket Anda</p>
</header>

<div class="hero">
    <h2>Selamat Datang, Penyelenggara!</h2>
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
<div class="container" id="cardContainer"></div>

<h3>Event Saya</h3>

<table class="bg-white dark:bg-gray-900 dark:text-white">
<thead>
<tr>
<th>ID</th>
<th>Nama Event</th>
<th>Lokasi</th>
<th>Tanggal</th>
<th>Harga</th>
<th>Stok</th>
<th>Aksi</th>
</tr>
</thead>
<tbody id="dataTable"></tbody>
</table>

</section>

<!-- SECTION TAMBAH -->
<section id="tambah" class="content">

<h3>Tambah / Edit Event</h3>

<input type="text" id="nama" placeholder="Nama Event">
<input type="text" id="lokasi" placeholder="Lokasi">
<input type="date" id="tanggal">
<input type="number" id="stok" placeholder="Jumlah tiket">
<input type="text" id="harga" placeholder="Harga Tiket">

<input type="file" id="gambar">
<small>*Kosongkan jika tidak ingin ganti gambar</small><br><br>

<button id="btnSubmit" onclick="tambahData()">Tambah Event</button>

</section>

<!-- SECTION TRANSAKSI -->
<section id="transaksi" class="content">
<h3>Transaksi</h3>
<p>Belum ada transaksi.</p>
</section>

<!-- SECTION PROFIL -->
<section id="profil" class="content profil-card">
    <h3>Profil Penyelenggara</h3>

    <div class="profil-content">
        <div class="profil-avatar">
    @if(session('foto_profil'))
        <img src="{{ asset('images/profil/' . session('foto_profil')) }}" alt="Foto Profil">
    @else
        P
    @endif
</div>

        <div class="profil-info">
            <h3>Nama Penyelenggara</h3>
            <p>Concertix Organizer</p>

            <h3>Email</h3>
            <p>organizer@concertix.com</p>

            <h3>Status</h3>
            <p>Aktif sebagai penyelenggara event</p>

            <form action="{{ route('profil.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="file" name="foto_profil">

                @error('foto_profil')
                    <small style="color:red">{{ $message }}</small>
                @enderror

                <br><br>

                <button type="submit">Upload Foto Profil</button>
            </form>
        </div>
    </div>
</section>

<!-- SIDEBAR -->
<aside class="sidebar">

<h3>Statistik Penjualan</h3>
<ul id="statistik"></ul>

<br>

<h3>Filter Event</h3>
<input type="checkbox"> Konser <br>
<input type="checkbox"> Festival <br>
<input type="checkbox"> Musik <br>

</aside>

</main>

<!-- FOOTER -->
<footer class="footer">
<div>About</div>
<div>Contact</div>
<div>Social Media</div>
</footer>

<script>

// ================= DATA =================
let dataEvent = JSON.parse(localStorage.getItem("event")) || [
    {
        nama:"Indie Night",
        lokasi:"Bandung",
        tanggal:"2026-07-15",
        stok:400,
        harga:300000,
        gambar:"indie.png"
    },
    {
        nama:"Rock Nation",
        lokasi:"Surabaya",
        tanggal:"2026-07-20",
        stok:350,
        harga:400000,
        gambar:"rocknation.png"
    }
];

let editIndex = -1;

// ================= SIMPAN =================
function simpan(){
    localStorage.setItem("event", JSON.stringify(dataEvent));
}

// ================= RENDER =================
function render(list = dataEvent){
    let table = document.getElementById("dataTable");
    let card = document.getElementById("cardContainer");

    table.innerHTML = "";
    card.innerHTML = "";

    list.forEach((e,i)=>{

        table.innerHTML += `
        <tr>
            <td>${i+1}</td>
            <td>${e.nama}</td>
            <td>${e.lokasi}</td>
            <td>${e.tanggal}</td>
            <td>Rp ${Number(e.harga).toLocaleString()}</td>
            <td>${e.stok}</td>
            <td>
                <button onclick="edit(${i})">Edit</button>
                <button onclick="hapus(${i})">Hapus</button>
            </td>
        </tr>`;

        card.innerHTML += `
        <div class="card">
            <img src="${e.gambar}" class="card-img">
            <div class="card-body">
                <h4>${e.nama}</h4>
                <p>${e.tanggal}</p>
                <p>${e.lokasi}</p>
                <p>Rp ${Number(e.harga).toLocaleString()}</p>
            </div>
        </div>`;
    });

    statistik();
}

// ================= TAMBAH & EDIT =================
function tambahData(){
    let nama = document.getElementById("nama").value;
    let lokasi = document.getElementById("lokasi").value;
    let tanggal = document.getElementById("tanggal").value;
    let stok = document.getElementById("stok").value;
    let harga = document.getElementById("harga").value.replace(/[^0-9]/g,"");
    let file = document.getElementById("gambar").files[0];

    if(!nama || !lokasi || !tanggal || !stok || !harga){
        alert("Isi semua field!");
        return;
    }

    function resetForm(){
        document.getElementById("nama").value = "";
        document.getElementById("lokasi").value = "";
        document.getElementById("tanggal").value = "";
        document.getElementById("stok").value = "";
        document.getElementById("harga").value = "";
        document.getElementById("gambar").value = "";

        document.getElementById("btnSubmit").innerText = "Tambah Event";
        editIndex = -1;
    }

    // EDIT
    if(editIndex !== -1){

        if(file){
            let reader = new FileReader();

            reader.onload = function(e){
                dataEvent[editIndex] = {
                    nama, lokasi, tanggal, stok, harga,
                    gambar: e.target.result
                };

                simpan();
                render();
                alert("Event berhasil diupdate!");
                resetForm();
            };

            reader.readAsDataURL(file);

        }else{
            dataEvent[editIndex] = {
                nama, lokasi, tanggal, stok, harga,
                gambar: dataEvent[editIndex].gambar
            };

            simpan();
            render();
            alert("Event berhasil diupdate!");
            resetForm();
        }

        return;
    }

    // TAMBAH
    if(file){
        let reader = new FileReader();

        reader.onload = function(e){
            dataEvent.push({
                nama, lokasi, tanggal, stok, harga,
                gambar: e.target.result
            });

            simpan();
            render();
            resetForm();
        };

        reader.readAsDataURL(file);

    }else{
        dataEvent.push({
            nama, lokasi, tanggal, stok, harga,
            gambar:"indie.png"
        });

        simpan();
        render();
        resetForm();
    }
}

// ================= EDIT =================
function edit(i){
    let e = dataEvent[i];

    document.getElementById("nama").value = e.nama;
    document.getElementById("lokasi").value = e.lokasi;
    document.getElementById("tanggal").value = e.tanggal;
    document.getElementById("stok").value = e.stok;
    document.getElementById("harga").value = e.harga;

    editIndex = i;
    document.getElementById("btnSubmit").innerText = "Update Event";
}

// ================= HAPUS =================
function hapus(i){
    if(confirm("Yakin hapus?")){
        dataEvent.splice(i,1);
        simpan();
        render();
    }
}

// ================= SEARCH =================
function searchData(){
    let keyword = document.getElementById("search").value.toLowerCase();

    let hasil = dataEvent.filter(e =>
        e.nama.toLowerCase().includes(keyword)
    );

    render(hasil);
}

// ================= STATISTIK =================
function statistik(){
    let total = dataEvent.length;
    let tiket = dataEvent.reduce((a,b)=>a + Number(b.stok),0);
    let totalHarga = dataEvent.reduce((a,b)=>a + (b.harga * b.stok),0);

    document.getElementById("statistik").innerHTML = `
        <li>Total Event : ${total}</li>
        <li>Total Tiket : ${tiket}</li>
        <li>Total Nilai : Rp ${totalHarga.toLocaleString()}</li>
    `;
}

// ================= FORMAT RUPIAH =================
const inputHarga = document.getElementById("harga");

inputHarga.addEventListener("keyup", function() {
    let value = this.value.replace(/[^,\d]/g, "").toString();
    let split = value.split(",");
    let sisa = split[0].length % 3;
    let rupiah = split[0].substr(0, sisa);
    let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        let separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    this.value = value ? "Rp " + rupiah : "";
});

// ================= INIT =================
render();

</script>

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
