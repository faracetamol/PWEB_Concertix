<!DOCTYPE html>
<html>
<head>
    <title>Edit Event</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="content">

    <h2>Edit Event</h2>

    <form action="{{ route('events.update', $event->id) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <input
            type="text"
            name="nama"
            value="{{ $event->nama }}"
            placeholder="Nama Event">

        <br><br>

        <input
            type="text"
            name="lokasi"
            value="{{ $event->lokasi }}"
            placeholder="Lokasi">

        <br><br>

        <input
            type="date"
            name="tanggal"
            value="{{ $event->tanggal->format('Y-m-d') }}">

        <br><br>

        <input
            type="number"
            name="stok"
            value="{{ $event->stok }}"
            placeholder="Jumlah Tiket">

        <br><br>

        <input
            type="number"
            name="harga"
            value="{{ $event->harga }}"
            placeholder="Harga">

        <br><br>

        <input type="file" name="gambar">

        <br><br>

        <button type="submit">
            Update Event
        </button>

        <a href="/" style="margin-left:10px;">
            Kembali
        </a>

    </form>

</div>

</body>
</html>
