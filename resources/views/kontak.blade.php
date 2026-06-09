@php
use Illuminate\Support\Facades\Cookie;
@endphp
<!DOCTYPE html>
<html>
<head>
    <title>Kontak Concertix</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="{{ Cookie::get('tema') == 'dark' ? 'dark-mode' : '' }}">

@include('partials.navbar')

<div class="back-wrapper">
    <a href="{{ url('/') }}" class="btn-kembali">← Kembali ke Dashboard</a>
</div>

<section class="content">
    <h1>Kontak</h1>
    <p>Email: concertix@gmail.com</p>
    <p>Instagram: @concertix</p>
    <p>Telepon: 08123456789</p>
</section>

<footer class="footer">
    <div>About</div>
    <div>Contact</div>
    <div>Social Media</div>
</footer>

</body>
</html>
