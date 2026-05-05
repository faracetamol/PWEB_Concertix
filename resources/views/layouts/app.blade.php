<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concertix</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <!-- NAVBAR -->
    @include('partials.navbar')

    <!-- CONTENT -->
    <main>
        @if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
    @endif
        @yield('content')
    </main>

    <!-- FOOTER -->
<footer class="footer">
    <div>About</div>
    <div>Contact</div>
    <div>Social Media</div>
</footer>

@stack('scripts')

</body>
</html>
