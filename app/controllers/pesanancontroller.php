<?php
require_once __DIR__ . '/../models/PesananModel.php';

class PesananController {
    private $pesananModel;

    public function __construct($db_koneksi) {
        $this->pesananModel = new PesananModel($db_koneksi);
    }

    /**
     * Tampilkan form Buat Pesanan Baru + proses simpan saat form di-submit.
     */
    public function tambah() {
        $kode_pesanan = $this->generateKodePesanan();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $layanan = $_POST['layanan'];
            $berat = $_POST['berat'];

            // Guard clause: validasi ulang di server, jangan cuma andalkan atribut
            // min="0.1" di HTML — itu gampang di-bypass (lewat DevTools, curl, dll).
            if (!is_numeric($berat) || $berat < 0.1) {
                $error = "Berat pesanan tidak valid. Minimal 0.1 Kg.";
                include '../app/views/buat_pesanan.php';
                exit();
            }

            $total_harga = $this->hitungTotalHarga($layanan, $berat);

            $berhasilSimpan = $this->pesananModel->simpan([
                'kode'     => $kode_pesanan,
                'nama'     => $_POST['nama_pelanggan'],
                'no_hp'    => $_POST['no_hp'],
                'layanan'  => $layanan,
                'berat'    => $berat,
                'total'    => $total_harga,
                'estimasi' => $_POST['estimasi_selesai'],
            ]);

            if (!$berhasilSimpan) {
                echo "Gagal menyimpan pesanan, silakan coba lagi.";
                exit();
            }

            $_SESSION['login_sukses'] = "Pesanan <strong>$kode_pesanan</strong> berhasil disimpan!";
            header("Location: index.php?page=home");
            exit();
        }

        // Lempar variabel $kode_pesanan ke halaman view agar bisa tampil di kotak biru
        include '../app/views/buat_pesanan.php';
    }

    /**
     * Bikin kode pesanan otomatis berformat LDR-001, LDR-002, dst,
     * berdasarkan id pesanan terakhir di database.
     */
    private function generateKodePesanan() {
        $last_row = $this->pesananModel->ambilIdTerakhir();
        $next_id = $last_row ? $last_row->id + 1 : 1;

        return "LDR-" . str_pad($next_id, 3, "0", STR_PAD_LEFT);
    }

    /**
     * Hitung total harga berdasarkan jenis layanan & berat (kg).
     */
    private function hitungTotalHarga($layanan, $berat) {
        $harga_per_kg = 7000; // Default: Cuci Setrika
        if ($layanan == "Cuci Express") $harga_per_kg = 10000;
        if ($layanan == "Setrika") $harga_per_kg = 5000;

        return $harga_per_kg * $berat;
    }

    /**
     * Tampilkan Daftar Pesanan (dengan pencarian kode pesanan opsional).
     */
    public function index() {
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $all_pesanan = $this->pesananModel->ambilSemua($search);

        include '../app/views/pesanan.php';
    }

    /**
     * Tampilkan halaman detail Update Proses untuk 1 pesanan.
     * Guard clause: langsung tolak & keluar di awal kalau id tidak ada / data tidak ditemukan,
     * baru logika utama (tampilkan view) dijalankan di baris paling luar.
     */
    public function updateProses() {
        if (!isset($_GET['id'])) {
            header("Location: index.php?page=pesanan");
            exit();
        }

        $detail = $this->pesananModel->cariById($_GET['id']);

        if (!$detail) {
            echo "Pesanan tidak ditemukan!";
            exit();
        }

        include '../app/views/update_proses.php';
    }

    /**
     * Simpan perubahan status laundry & status pembayaran dari halaman Update Proses.
     */
    public function simpanUpdate() {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return;
        }

        $id = $_POST['id'];
        $status_laundry = $_POST['status_laundry'];
        $status_pembayaran = $_POST['status_pembayaran'];

        // Otomatis mengunci jadi 'Lunas' begitu menyentuh tahap Bisa Diambil / Selesai
        if ($status_laundry == 'Bisa Diambil' || $status_laundry == 'Selesai') {
            $status_pembayaran = 'Lunas';
        }

        $berhasilUpdate = $this->pesananModel->updateStatus($id, $status_laundry, $status_pembayaran);

        if (!$berhasilUpdate) {
            return;
        }

        header("Location: index.php?page=pesanan");
        exit();
    }

    /**
     * Tampilkan struk pengambilan untuk 1 pesanan.
     */
    public function strukPengambilan() {
        if (!isset($_GET['id'])) {
            header("Location: index.php?page=pesanan");
            exit();
        }

        $detail = $this->pesananModel->cariById($_GET['id']);

        if (!$detail) {
            echo "Pesanan tidak ditemukan!";
            exit();
        }

        include '../app/views/struk_pengambilan.php';
    }

    /**
     * Tampilkan halaman Manage Pembayaran, tab "proses" atau "diambil".
     *
     * Tab "diambil" -> pesanan yang status_pembayaran-nya sudah 'Diambil'.
     * Tab "proses"  -> sisanya (Belum Bayar / Lunas, belum diambil).
     */
    public function manage() {
        $status = isset($_GET['status']) ? $_GET['status'] : 'proses';
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

        $all_pesanan = $this->pesananModel->ambilUntukManage($status, $search);

        if ($status == 'diambil') {
            include '../app/views/manage_pembayaran_diambil.php';
        } else {
            include '../app/views/manage_pembayaran_proses.php';
        }
    }

    /**
     * Tampilkan detail Status Pembayaran untuk 1 pesanan.
     */
    public function statusPembayaran() {
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $pesanan = $this->pesananModel->cariById($id);

        if (!$pesanan) {
            header("Location: index.php?page=manage_pembayaran");
            exit();
        }

        include '../app/views/status_pembayaran.php';
    }

    /**
     * Ubah status pembayaran: lunas, diambil, atau reset ke belum bayar.
     */
    public function toggleBayar() {
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $status = isset($_GET['status']) ? $_GET['status'] : 'lunas';

        if ($status == 'lunas') {
            $this->pesananModel->tandaiLunas($id);
            header("Location: index.php?page=status_pembayaran&id=" . $id);
        } elseif ($status == 'diambil') {
            $this->pesananModel->tandaiDiambil($id);
            header("Location: index.php?page=manage_pembayaran&status=diambil");
        } else {
            $this->pesananModel->resetPembayaran($id);
            header("Location: index.php?page=manage_pembayaran&status=proses");
        }
        exit();
    }

    /**
     * Tandai pesanan sebagai sudah diambil pelanggan (route belum terpakai di view manapun,
     * disiapkan untuk pemakaian ke depan).
     */
    public function tandaiDiambil() {
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $this->pesananModel->tandaiDiambil($id);

        header("Location: index.php?page=manage_pembayaran&status=diambil");
        exit();
    }
}