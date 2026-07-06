document.addEventListener("DOMContentLoaded", function() {
    // ================= 1. LOGIC HITUNG HARGA OTOMATIS =================
    const layanan = document.getElementById('layanan');
    const berat = document.getElementById('berat');
    const totalDisplay = document.getElementById('total_display');

    function hitung() {
        let harga = 7000;
        if (layanan.value === "Cuci Express") harga = 10000;
        if (layanan.value === "Setrika") harga = 5000;
        
        const total = harga * (parseFloat(berat.value) || 0);
        totalDisplay.value = "RP. " + total.toLocaleString('id-ID') + ".00";
    }
    
    if (layanan && berat) {
        layanan.addEventListener('change', hitung);
        berat.addEventListener('input', hitung);
    }

    // ================= 2. LOGIC MODAL POP-UP STRUK =================
    const formPesanan = document.getElementById('formPesanan');
    const modalStruk = document.getElementById('modalStruk');

    if (formPesanan) {
        formPesanan.addEventListener('submit', function(e) {
            e.preventDefault(); // Tahan submit form asli agar modal muncul dulu

            // Oper data dari form input kasir ke dalam elemen template struk
            document.getElementById('st_kode').innerText = document.getElementById('kode_laundry').innerText;
            document.getElementById('st_nama').innerText = document.getElementById('input_nama').value;
            document.getElementById('st_layanan').innerText = layanan.value;
            document.getElementById('st_berat').innerText = berat.value + " Kg";
            document.getElementById('st_total').innerText = totalDisplay.value;
            document.getElementById('st_estimasi').innerText = document.getElementById('input_estimasi').value;

            // Tampilkan modal struk di layar
            modalStruk.style.display = 'flex';
        });
    }

    // ================= 3. TRIGER PRINT WINDOWS PROMPT =================
    const btnCetakFisik = document.getElementById('btnCetakFisik');
    if (btnCetakFisik) {
        btnCetakFisik.addEventListener('click', function() {
            window.print(); // Membuka menu print browser bawaan
        });
    }

    // ================= 4. SUBMIT DATA ASLI KE MYSQL VIA PHP =================
    const btnTutupStruk = document.getElementById('btnTutupStruk');
    if (btnTutupStruk) {
        btnTutupStruk.addEventListener('click', function() {
            modalStruk.style.display = 'none';
            formPesanan.submit(); // Lanjutkan proses pengiriman data asli form ke database
        });
    }
});