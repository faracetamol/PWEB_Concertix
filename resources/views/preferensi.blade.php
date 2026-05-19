<!DOCTYPE html>
<html>
<head>
    <title>Preferensi</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
<script>
if (document.cookie.includes('tema=dark')) {
    document.body.classList.add('dark-mode');
}
</script>
<div class="content">

    <h2>Pengaturan Preferensi</h2>

    <form id="formPreferensi">

        <label>Tema:</label>
        <select name="tema" id="tema">
            <option value="light">Light</option>
            <option value="dark">Dark</option>
            <option value="system">System</option>
        </select>

        <br><br>

        <label>Ukuran Font:</label>
        <select name="font" id="font">
            <option value="small">Small</option>
            <option value="medium">Medium</option>
            <option value="large">Large</option>
        </select>

        <br><br>

        <button type="button" onclick="simpanPreferensi()">
            Simpan
        </button>

    </form>

    <div id="status"></div>

</div>
<script>
async function simpanPreferensi() {

    const tema = document.getElementById('tema').value;
    const font = document.getElementById('font').value;

    try {

        const response = await fetch('/simpan-preferensi', {

            method: 'POST',

            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },

            body: JSON.stringify({
                tema: tema,
                font: font
            })

        });

        const data = await response.json();

document.getElementById('status').innerHTML = data.message;

if (tema === 'dark') {
    document.body.classList.add('dark-mode');
} else {
    document.body.classList.remove('dark-mode');
}

    } catch(error) {

        document.getElementById('status').innerHTML =
            'Gagal menyimpan preferensi';

        console.log(error);
    }
}
</script>
</body>
</html>
