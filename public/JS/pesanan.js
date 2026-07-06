// public/js/pesanan.js

function switchTab(statusTarget) {
    // 1. Ubah visual tombol tab aktif
    const tombolTabs = document.querySelectorAll('.tab-btn');
    tombolTabs.forEach(btn => {
        if (btn.innerText.trim() === statusTarget) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });

    // 2. Filter kartu pesanan yang tampil di layar
    const semuaKartu = document.querySelectorAll('.pesanan-card');
    semuaKartu.forEach(card => {
        const statusKartu = card.getAttribute('data-status');
        if (statusKartu === statusTarget) {
            card.style.display = 'flex';
        } else {
            card.style.display = 'none';
        }
    });
}

// Jalankan otomatis saat halaman pertama kali dibuka agar tab "Baru" langsung terfilter
document.addEventListener("DOMContentLoaded", function() {
    switchTab('Baru');
});