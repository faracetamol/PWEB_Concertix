@php
use Illuminate\Support\Facades\Cookie;
@endphp
<!DOCTYPE html>
<html>
<head>
    <title>Profil Admin</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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

<section class="content profil-card">
    <h2>👤 Profil Penyelenggara</h2>

    <div class="profil-content">

        <div class="profil-avatar">
            @if(auth()->user()->foto_profil)
                <img
                    src="{{ asset('images/profil/' . auth()->user()->foto_profil) }}"
                    alt="Foto Profil">
            @else
                P
            @endif
        </div>

        <div class="profil-info">
            <h3>Nama Penyelenggara</h3>
            <p>{{ auth()->user()->name }}</p>

            <h3>Email</h3>
            <p>{{ auth()->user()->email }}</p>

            <h3>Status</h3>
            <p>Aktif sebagai penyelenggara event</p>

            <form action="{{ route('profil.upload') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <input type="file" name="foto_profil">

                @error('foto_profil')
                    <small style="color:red">
                        {{ $message }}
                    </small>
                @enderror

                <br><br>

                <button type="submit">
                    Upload Foto Profil
                </button>
            </form>
        </div>
    </div>
</section>

</body>
</html>
