@php
use Illuminate\Support\Facades\Cookie;
@endphp
<!DOCTYPE html>
<html>
<head>
    <title>Tentang Concertix</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="{{ Cookie::get('tema') == 'dark' ? 'dark-mode' : '' }}">

@include('partials.navbar')

<section class="content">
    <a href="{{ url('/') }}" class="btn-kembali">← Kembali ke Dashboard</a>
    <h1>Tentang Kami</h1>
    <p>Concertix adalah platform untuk membantu penyelenggara mengelola event dan tiket.</p>
</section>

<footer class="footer">
    <div>About</div>
    <div>Contact</div>
    <div>Social Media</div>
</footer>

</body>
</html>
