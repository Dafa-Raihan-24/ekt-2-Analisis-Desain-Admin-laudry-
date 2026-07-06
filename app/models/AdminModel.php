<?php
/**
 * AdminModel
 *
 * Bertanggung jawab atas semua akses data ke tabel `admin`.
 * Controller (AuthController) tidak boleh menulis query SQL sendiri —
 * semua query lewat class ini. Ini bagian "Model" dari pola MVC.
 */
class AdminModel
{
    private $db;

    public function __construct($db_koneksi)
    {
        $this->db = $db_koneksi;
    }

    /**
     * Cari 1 baris admin berdasarkan username & password (hash) yang cocok persis.
     * Dipakai saat proses login.
     *
     * @param string $username
     * @param string $passwordHash  password yang sudah di-hash (md5), bukan plain text
     * @return object|false  data admin jika cocok, false jika tidak ditemukan
     */
    public function cariByKredensial($username, $passwordHash)
    {
        $query = "SELECT * FROM admin WHERE username = :username AND password = :password";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'username' => $username,
            'password' => $passwordHash,
        ]);

        return $stmt->fetch();
    }
}
