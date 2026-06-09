@php
use Illuminate\Support\Facades\Cookie;
@endphp
<!DOCTYPE html>
<html>
<head>
    <title>Preferensi</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="{{ Cookie::get('tema') == 'dark' ? 'dark-mode' : '' }}">

@include('partials.navbar')

<div class="back-wrapper">
    <a href="{{ url('/') }}" class="btn-kembali">
        ← Kembali ke Dashboard
    </a>
</div>

<section class="content">
    <div class="preferensi-card">
        <h2>⚙️ Pengaturan Preferensi</h2>

        <form action="{{ route('preferensi.simpan') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Tema</label>
                <select name="tema">
                    <option value="light"
                        {{ session('tema') == 'light' ? 'selected' : '' }}>
                        Light
                    </option>

                    <option value="dark"
                        {{ session('tema') == 'dark' ? 'selected' : '' }}>
                        Dark
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label>Ukuran Font</label>

                <select name="font">
                    <option value="small">Small</option>
                    <option value="medium">Medium</option>
                    <option value="large">Large</option>
                </select>
            </div>

            <button type="submit" class="btn-simpan">
                💾 Simpan Preferensi
            </button>
        </form>
    </div>
</section>

</body>
</html>
