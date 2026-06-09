@php
use Illuminate\Support\Facades\Auth;
@endphp

<nav class="navbar">
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="logo" height="120">
    </div>

    <div class="menu">
    <a href="{{ url('/') }}">Dashboard</a>
    <a href="{{ route('admin.events') }}">Event Saya</a>
    <a href="{{ route('events.create') }}">Tambah Event</a>
    <a href="{{ route('admin.transaksi') }}">Transaksi</a>
    <a href="{{ route('admin.profil') }}">Profil</a>
    <a href="/tentang">Tentang</a>

    @auth
        <span class="user-name">
            {{ Auth::user()->name }}
        </span>
    @endauth
</div>
</nav>
