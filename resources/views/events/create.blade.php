@php
use Illuminate\Support\Facades\Cookie;
@endphp
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Event</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body{
            background:#f4f6f9;
        }

        .create-container{
            max-width:800px;
            margin:50px auto;
            padding:20px;
        }

        .create-card{
            background:white;
            padding:30px;
            border-radius:15px;
            box-shadow:0 5px 20px rgba(0,0,0,.1);
        }

        .dark-mode .create-card{
        background:#1f2937 !important;
        color:white !important;
        }

        .dark-mode .create-card h2{
        color:white !important;
        }

        .dark-mode .create-card label{
        color:white !important;
        }

        .create-card h2{
            text-align:center;
            color:#0000aa;
            margin-bottom:25px;
        }

        .form-group{
            margin-bottom:20px;
        }

        .form-group label{
            display:block;
            margin-bottom:8px;
            font-weight:bold;
        }

        .form-group input{
            width:100%;
            padding:12px;
            border:1px solid #ddd;
            border-radius:8px;
        }

        .btn-submit{
            width:100%;
            padding:14px;
            background:#0000aa;
            color:white;
            border:none;
            border-radius:8px;
            font-size:16px;
            cursor:pointer;
        }

        .btn-submit:hover{
            background:#000080;
        }

        .back-btn{
            display:inline-block;
            margin-bottom:20px;
            text-decoration:none;
            color:#0000aa;
            font-weight:bold;
        }
    </style>
</head>

<body class="{{ Cookie::get('tema') == 'dark' ? 'dark-mode' : '' }}">

<div class="create-container">
    <a href="/" class="back-btn">
        ← Kembali ke Dashboard
    </a>

    <div class="create-card">
        <h2>🎵 Tambah Event Baru</h2>
        <form action="{{ route('events.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="form-group">
                <label>Nama Event</label>
                <input type="text" name="nama" required>
            </div>

            <div class="form-group">
                <label>Lokasi</label>
                <input type="text" name="lokasi" required>
            </div>

            <div class="form-group">
                <label>Tanggal Event</label>
                <input type="date" name="tanggal" required>
            </div>

            <div class="form-group">
                <label>Harga Tiket</label>
                <input type="number" name="harga" required>
            </div>

            <div class="form-group">
                <label>Stok Tiket</label>
                <input type="number" name="stok" required>
            </div>

            <div class="form-group">
                <label>Poster Event</label>
                <input type="file" name="gambar">
            </div>

            <button type="submit" class="btn-submit">
                🚀 Simpan Event
            </button>
        </form>
    </div>
</div>

</body>
</html>
