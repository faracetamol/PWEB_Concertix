// ================= DATA =================
let dataEvent = JSON.parse(localStorage.getItem("event")) || [
    {
        nama:"Indie Night",
        lokasi:"Bandung",
        tanggal:"2026-07-15",
        stok:400,
        harga:300000,
        gambar:"indie.png"
    },
    {
        nama:"Rock Nation",
        lokasi:"Surabaya",
        tanggal:"2026-07-20",
        stok:350,
        harga:400000,
        gambar:"rocknation.png"
    }
];

let editIndex = -1;

// ================= SIMPAN =================
function simpan(){
    localStorage.setItem("event", JSON.stringify(dataEvent));
}

// ================= RENDER =================
function render(list = dataEvent){
    let table = document.getElementById("dataTable");
    let card = document.getElementById("cardContainer");

    table.innerHTML = "";
    card.innerHTML = "";

    list.forEach((e,i)=>{

        // TABLE
        table.innerHTML += `
        <tr>
            <td>${i+1}</td>
            <td>${e.nama}</td>
            <td>${e.lokasi}</td>
            <td>${e.tanggal}</td>
            <td>Rp ${Number(e.harga).toLocaleString()}</td>
            <td>${e.stok}</td>
            <td>
                <button onclick="edit(${i})">Edit</button>
                <button onclick="hapus(${i})">Hapus</button>
            </td>
        </tr>`;

        // CARD
        card.innerHTML += `
        <div class="card">
            <img src="${e.gambar}" class="card-img">
            <div class="card-body">
                <h4>${e.nama}</h4>
                <p>${e.tanggal}</p>
                <p>${e.lokasi}</p>
                <p>Rp ${Number(e.harga).toLocaleString()}</p>
            </div>
        </div>`;
    });

    statistik();
}

// ================= TAMBAH / EDIT =================
function tambahData(){
    let nama = document.getElementById("nama").value;
    let lokasi = document.getElementById("lokasi").value;
    let tanggal = document.getElementById("tanggal").value;
    let stok = document.getElementById("stok").value;
    let harga = document.getElementById("harga").value.replace(/[^0-9]/g,"");
    let file = document.getElementById("gambar").files[0];

    if(!nama || !lokasi || !tanggal || !stok || !harga){
        alert("Isi semua kolom!");
        return;
    }

    // 🔥 RESET FUNCTION
    function resetForm(){
        document.getElementById("nama").value = "";
        document.getElementById("lokasi").value = "";
        document.getElementById("tanggal").value = "";
        document.getElementById("stok").value = "";
        document.getElementById("harga").value = "";
        document.getElementById("gambar").value = "";

        document.getElementById("btnSubmit").innerText = "Tambah Event";
        editIndex = -1;
    }

    // ================= EDIT =================
    if (editIndex !== -1) {

        if (file) {
            let reader = new FileReader();

            reader.onload = function(e){
                dataEvent[editIndex] = {
                    nama,
                    lokasi,
                    tanggal,
                    stok,
                    harga,
                    gambar: e.target.result
                };

                simpan();
                render();
                alert("Event berhasil diupdate!");
                resetForm();
            };

            reader.readAsDataURL(file);

        } else {
            dataEvent[editIndex] = {
                nama,
                lokasi,
                tanggal,
                stok,
                harga,
                gambar: dataEvent[editIndex].gambar
            };

            simpan();
            render();
            alert("Event berhasil diupdate!");
            resetForm();
        }

        return;
    }

    // ================= TAMBAH =================
    if (file) {
        let reader = new FileReader();

        reader.onload = function(e){
            dataEvent.push({
                nama,
                lokasi,
                tanggal,
                stok,
                harga,
                gambar: e.target.result
            });

            simpan();
            render();
            alert("Event berhasil ditambahkan!");
            resetForm();
        };

        reader.readAsDataURL(file);

    } else {
        dataEvent.push({
            nama,
            lokasi,
            tanggal,
            stok,
            harga,
            gambar:"indie.png"
        });

        simpan();
        render();
        alert("Event berhasil ditambahkan!");
        resetForm();
    }
}

// ================= EDIT =================
function edit(i){
    let e = dataEvent[i];

    document.getElementById("nama").value = e.nama;
    document.getElementById("lokasi").value = e.lokasi;
    document.getElementById("tanggal").value = e.tanggal;
    document.getElementById("stok").value = e.stok;
    document.getElementById("harga").value = e.harga;

    editIndex = i;

    document.getElementById("btnSubmit").innerText = "Update Event";
}

// ================= HAPUS =================
function hapus(i){
    if(confirm("Yakin hapus?")){
        dataEvent.splice(i,1);
        simpan();
        render();
    }
}

// ================= SEARCH =================
function searchData(){
    let keyword = document.getElementById("search").value.toLowerCase();

    let hasil = dataEvent.filter(e =>
        e.nama.toLowerCase().includes(keyword)
    );

    render(hasil);
}

// ================= STATISTIK =================
function statistik(){
    let total = dataEvent.length;
    let tiket = dataEvent.reduce((a,b)=>a + Number(b.stok),0);
    let totalHarga = dataEvent.reduce((a,b)=>a + (b.harga * b.stok),0);

    document.getElementById("statistik").innerHTML = `
        <li>Total Event : ${total}</li>
        <li>Total Tiket : ${tiket}</li>
        <li>Total Nilai : Rp ${totalHarga.toLocaleString()}</li>
    `;
}

// ================= FORMAT RUPIAH =================
const inputHarga = document.getElementById("harga");

inputHarga.addEventListener("keyup", function() {
    let value = this.value.replace(/[^,\d]/g, "").toString();
    let split = value.split(",");
    let sisa = split[0].length % 3;
    let rupiah = split[0].substr(0, sisa);
    let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        let separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    this.value = value ? "Rp " + rupiah : "";
});

// ================= INIT =================
render();