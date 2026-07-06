<?php
require_once __DIR__ . '/../models/AdminModel.php';

class AuthController {
    private $adminModel;

    public function __construct($db_koneksi) {
        $this->adminModel = new AdminModel($db_koneksi);
    }

    public function login() {
        // Jika ada data kiriman POST dari form login
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = md5($_POST['password']); // Samakan dengan enkripsi database

            // Controller cuma manggil Model, gak nulis query SQL sendiri lagi
            $admin = $this->adminModel->cariByKredensial($username, $password);

            if ($admin) {
                // Jika benar, simpan di session data suksesnya
                $_SESSION['admin'] = $admin->nama_lengkap;
                $_SESSION['login_sukses'] = "Login Sukses! Selamat Datang, " . $admin->nama_lengkap;
                
                // Alihkan ke halaman utama
                header("Location: index.php?page=home");
                exit();
            } else {
                // Jika salah, kirim pesan error kembali ke halaman login
                $error = "Username atau Password salah!";
                include '../app/views/login.php';
                exit();
            }
        }

        // Tampilan default kalau belum mencet tombol masuk
        include '../app/views/login.php';
    }

    public function logout() {
        session_destroy();
        header("Location: index.php");
        exit();
    }
}