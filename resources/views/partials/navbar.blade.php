@php
use Illuminate\Support\Facades\Auth;
@endphp

<nav class="navbar">
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="logo" height="120">
    </div>

    <div class="menu">
    <a href="#dashboard">Dashboard</a>
    <a href="#event">Event Saya</a>
    <a href="#tambah">Tambah Event</a>
    <a href="#transaksi">Transaksi</a>
    <a href="#profil">Profil</a>
    <a href="/tentang">Tentang</a>

    @auth
        <span class="user-name">
            {{ Auth::user()->name }}
        </span>
    @endauth
</div>
</nav>
