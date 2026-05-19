<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <section class="content" id="cuaca">
    <h3>Cuaca Hari Ini</h3>

    <button onclick="ambilCuaca()">Muat Cuaca Surabaya</button>

    <p id="loadingCuaca" style="display:none;">Sedang mengambil data cuaca...</p>

    <div id="hasilCuaca">
        <p>Belum ada data cuaca.</p>
    </div>
</section>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

    <script>
async function ambilCuaca() {
    const loading = document.getElementById("loadingCuaca");
    const hasil = document.getElementById("hasilCuaca");

    loading.style.display = "block";
    hasil.innerHTML = "";

    try {
        const response = await fetch("https://wttr.in/Surabaya?format=j1");

        if (!response.ok) {
            throw new Error("Gagal mengambil data cuaca");
        }

        const data = await response.json();

        const kota = data.nearest_area[0].areaName[0].value;
        const suhu = data.current_condition[0].temp_C;
        const deskripsi = data.current_condition[0].weatherDesc[0].value;

        hasil.innerHTML = `
            <div class="bg-white p-4 rounded shadow mt-3">
                <h4>${kota}</h4>
                <p>Suhu: ${suhu}°C</p>
                <p>Cuaca: ${deskripsi}</p>
            </div>
        `;
    } catch (error) {
        hasil.innerHTML = `
            <p style="color:red;">${error.message}</p>
        `;
    } finally {
        loading.style.display = "none";
    }
}
</script>
</x-app-layout>
