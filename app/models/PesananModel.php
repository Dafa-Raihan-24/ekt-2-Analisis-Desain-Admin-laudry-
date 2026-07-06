<?php
/**
 * PesananModel
 *
 * Bertanggung jawab atas semua akses data ke tabel `pesanan`.
 * Controller (PesananController) tidak boleh menulis query SQL sendiri —
 * semua query lewat class ini. Ini bagian "Model" dari pola MVC, sekaligus
 * menerapkan Single Responsibility Principle: controller cuma ngatur alur
 * (routing & logic tampilan), model yang urus data.
 */
class PesananModel
{
    private $db;

    public function __construct($db_koneksi)
    {
        $this->db = $db_koneksi;
    }

    /**
     * Ambil id pesanan terakhir (dipakai untuk generate kode pesanan otomatis LDR-xxx).
     *
     * @return object|false
     */
    public function ambilIdTerakhir()
    {
        $query = "SELECT id FROM pesanan ORDER BY id DESC LIMIT 1";
        $stmt = $this->db->query($query);

        return $stmt->fetch();
    }

    /**
     * Simpan pesanan baru ke database.
     *
     * @param array $data  kode, nama, no_hp, layanan, berat, total, estimasi
     * @return bool
     */
    public function simpan(array $data)
    {
        $query = "INSERT INTO pesanan (kode_pesanan, nama_pelanggan, no_hp, layanan, berat, total_harga, estimasi_selesai)
                  VALUES (:kode, :nama, :no_hp, :layanan, :berat, :total, :estimasi)";

        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            'kode'     => $data['kode'],
            'nama'     => $data['nama'],
            'no_hp'    => $data['no_hp'],
            'layanan'  => $data['layanan'],
            'berat'    => $data['berat'],
            'total'    => $data['total'],
            'estimasi' => $data['estimasi'],
        ]);
    }

    /**
     * Ambil semua pesanan, opsional difilter berdasarkan kode pesanan (search).
     * Dipakai di halaman Daftar Pesanan.
     *
     * @param string $search
     * @return array
     */
    public function ambilSemua($search = '')
    {
        if (!empty($search)) {
            $query = "SELECT * FROM pesanan WHERE kode_pesanan LIKE :search ORDER BY id DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['search' => "%" . $search . "%"]);
        } else {
            $query = "SELECT * FROM pesanan ORDER BY id DESC";
            $stmt = $this->db->query($query);
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Ambil 1 pesanan berdasarkan id.
     *
     * @param int $id
     * @return array|false
     */
    public function cariById($id)
    {
        $query = "SELECT * FROM pesanan WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Update status laundry & status pembayaran sekaligus.
     * Dipakai di halaman Update Proses (stepper status cucian).
     *
     * @param int    $id
     * @param string $statusLaundry
     * @param string $statusPembayaran
     * @return bool
     */
    public function updateStatus($id, $statusLaundry, $statusPembayaran)
    {
        $query = "UPDATE pesanan SET status_laundry = :status_l, status_pembayaran = :status_p WHERE id = :id";
        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            'status_l' => $statusLaundry,
            'status_p' => $statusPembayaran,
            'id'       => $id,
        ]);
    }

    /**
     * Ambil daftar pesanan untuk halaman Manage Pembayaran.
     *
     * Tab "diambil"  -> pesanan yang status_pembayaran-nya sudah 'Diambil'.
     * Tab "proses"   -> sisanya (Belum Bayar / Lunas, belum diambil).
     *
     * @param string $tab     'diambil' atau 'proses'
     * @param string $search
     * @return array
     */
    public function ambilUntukManage($tab, $search = '')
    {
        $filterDiambil = ($tab === 'diambil')
            ? "status_pembayaran = 'Diambil'"
            : "(status_pembayaran IS NULL OR status_pembayaran != 'Diambil')";

        if (!empty($search)) {
            $query = "SELECT * FROM pesanan WHERE {$filterDiambil} AND kode_pesanan LIKE :search ORDER BY id DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['search' => "%" . $search . "%"]);
        } else {
            $query = "SELECT * FROM pesanan WHERE {$filterDiambil} ORDER BY id DESC";
            $stmt = $this->db->query($query);
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Tandai pesanan sebagai Lunas + catat waktu bayar.
     *
     * @param int $id
     * @return bool
     */
    public function tandaiLunas($id)
    {
        $waktuBayar = date('Y-m-d H:i:s');
        $query = "UPDATE pesanan SET status_pembayaran = 'Lunas', dibayar_pada = :waktu WHERE id = :id";
        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            'waktu' => $waktuBayar,
            'id'    => $id,
        ]);
    }

    /**
     * Tandai pesanan sebagai sudah Diambil oleh pelanggan.
     *
     * @param int $id
     * @return bool
     */
    public function tandaiDiambil($id)
    {
        $query = "UPDATE pesanan SET status_pembayaran = 'Diambil' WHERE id = :id";
        $stmt = $this->db->prepare($query);

        return $stmt->execute(['id' => $id]);
    }

    /**
     * Kembalikan status pembayaran ke Belum Bayar (reset penuh, termasuk status_laundry).
     *
     * @param int $id
     * @return bool
     */
    public function resetPembayaran($id)
    {
        $query = "UPDATE pesanan SET status_pembayaran = 'Belum Bayar', dibayar_pada = NULL, status_laundry = NULL WHERE id = :id";
        $stmt = $this->db->prepare($query);

        return $stmt->execute(['id' => $id]);
    }
}
