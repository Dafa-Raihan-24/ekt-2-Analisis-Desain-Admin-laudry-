<?php
// Mulai session untuk membaca status login & notifikasi sukses
session_start();

// 1. Panggil file koneksi database
require_once '../app/config/koneksi.php';

// 2. Panggil semua file Controller yang kita butuhkan
require_once '../app/controllers/AuthController.php';
require_once '../app/controllers/PesananController.php';

// 3. Inisialisasi object Controller dari class-nya
$auth = new AuthController($koneksi);
$pesanan = new PesananController($koneksi);

// 4. Tangkap parameter halaman dari URL (index.php?page=...)
$page = isset($_GET['page']) ? $_GET['page'] : 'login';

// 5. Alur Navigasi (Routing) Aplikasi
if ($page == 'login') {
    $auth->login();
} elseif ($page == 'home') {
    // Proteksi: Jika belum login, tendang balik ke halaman login
    if (!isset($_SESSION['admin'])) {
        header("Location: index.php");
        exit();
    }
    include '../app/views/home.php';
} elseif ($page == 'buat_pesanan') {
    // Proteksi: Jika belum login, tidak bisa tembus ke form input pesanan
    if (!isset($_SESSION['admin'])) {
        header("Location: index.php");
        exit();
    }
    // Jalankan fungsi tambah() di PesananController untuk memproses form & database
    $pesanan->tambah();
} elseif ($page == 'pesanan') { 
    // Proteksi: Biar orang luar gak bisa langsung nembak URL list pesanan
    if (!isset($_SESSION['admin'])) {
        header("Location: index.php");
        exit();
    }
    $pesanan->index();
} elseif ($page == 'logout') {
    $auth->logout();
} elseif ($page == 'update_proses') { // 📥 RUTE BARU TAMPIL HALAMAN
    if (!isset($_SESSION['admin'])) { header("Location: index.php"); exit(); }
    $pesanan->updateProses();

} elseif ($page == 'simpan_update') {  // 📥 RUTE BARU PROSES SQL UPDATE
    if (!isset($_SESSION['admin'])) { header("Location: index.php"); exit(); }
    $pesanan->simpanUpdate();
} elseif ($page == 'struk_pengambilan') {

    if (!isset($_SESSION['admin'])) {
        header("Location: index.php");
        exit();
    }

    $pesanan->strukPengambilan();

} elseif ($page == 'manage_pembayaran') {

    if (!isset($_SESSION['admin'])) {
        header("Location: index.php");
        exit();
    }

    $pesanan->manage();

} elseif ($page == 'status_pembayaran') {

    if (!isset($_SESSION['admin'])) {
        header("Location: index.php");
        exit();
    }

    $pesanan->statusPembayaran();

} elseif ($page == 'toggle_bayar') {

    if (!isset($_SESSION['admin'])) {
        header("Location: index.php");
        exit();
    }

    $pesanan->toggleBayar();

} elseif ($page == 'tandai_diambil') {

    if (!isset($_SESSION['admin'])) {
        header("Location: index.php");
        exit();
    }

    $pesanan->tandaiDiambil();

}
// ... rute lama ...
