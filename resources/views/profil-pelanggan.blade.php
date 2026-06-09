@php
use Illuminate\Support\Facades\Cookie;
@endphp
<!DOCTYPE html>
<html>
<head>
    <title>Profil Pelanggan</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="{{ Cookie::get('tema') == 'dark' ? 'dark-mode' : '' }}">

<nav class="navbar">
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" width="120">
    </div>

    <div class="menu">
        <a href="/pelanggan">Kembali ke Dashboard</a>
    </div>
</nav>

<section class="content profil-card">
    <h2>Profil Pelanggan</h2>

    <div class="profil-content">

        <div class="profil-avatar">
            @if(auth()->user()->foto_profil)
    <img
        src="{{ asset('images/profil/' . auth()->user()->foto_profil) }}"
        alt="Foto Profil"
        width="120">
@else
    P
@endif
        </div>

        <div class="profil-info">
       <form action="{{ route('pelanggan.profile.update') }}"
      method="POST">
    @csrf
    @method('PATCH')
                <h4>Nama</h4>
                <input type="text"
                       name="name"
                       value="{{ auth()->user()->name }}">

                <br><br>

                <h4>Email</h4>
                <input type="email"
                       name="email"
                       value="{{ auth()->user()->email }}">

                <br><br>

                <button type="submit">
                    Update Profil
                </button>
            </form>

            <br><br>

            <form action="{{ route('profil.upload') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <input type="file" name="foto_profil">

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
