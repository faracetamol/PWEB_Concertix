let dataEvent = JSON.parse(localStorage.getItem("event")) || [
    {
        nama:"Indie Night",
        lokasi:"Bandung",
        tanggal:"2026-07-15",
        stok:400,
        harga:300000,
        gambar:"images/indie.png"
    }
];

let editIndex = -1;

function simpan(){
    localStorage.setItem("event", JSON.stringify(dataEvent));
}

function render(list = dataEvent){
    let table = document.getElementById("dataTable");
    let card = document.getElementById("cardContainer");

    table.innerHTML = "";
    card.innerHTML = "";

    list.forEach((e,i)=>{

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

        card.innerHTML += `
        <div class="card">
            <img src="${e.gambar}">
            <h4>${e.nama}</h4>
            <p>${e.lokasi}</p>
        </div>`;
    });

    statistik();
}

function tambahData(){
    let nama = document.getElementById("nama").value;
    let lokasi = document.getElementById("lokasi").value;
    let tanggal = document.getElementById("tanggal").value;
    let stok = document.getElementById("stok").value;
    let harga = document.getElementById("harga").value;
    let file = document.getElementById("gambar").files[0];

    if(editIndex !== -1){
        dataEvent[editIndex].nama = nama;
        editIndex = -1;
    }else{
        dataEvent.push({
            nama, lokasi, tanggal, stok, harga,
            gambar:"images/indie.png"
        });
    }

    simpan();
    render();
}

function edit(i){
    let e = dataEvent[i];

    document.getElementById("nama").value = e.nama;
    document.getElementById("lokasi").value = e.lokasi;
    document.getElementById("tanggal").value = e.tanggal;
    document.getElementById("stok").value = e.stok;
    document.getElementById("harga").value = e.harga;

    editIndex = i;
}

function hapus(i){
    dataEvent.splice(i,1);
    simpan();
    render();
}

function searchData(){
    let key = document.getElementById("search").value.toLowerCase();
    let hasil = dataEvent.filter(e => e.nama.toLowerCase().includes(key));
    render(hasil);
}

function filterTerdekat(){
    let today = new Date();

    let filtered = dataEvent
        .filter(e => new Date(e.tanggal) >= today)
        .sort((a,b)=> new Date(a.tanggal) - new Date(b.tanggal));

    render(filtered);
}

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

render();
