<?php
$current_status = isset($_GET['status']) ? $_GET['status'] : 'proses';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Pembayaran - Freshy Laundry</title>
    <link rel="stylesheet" href="css/manage_pembayaran_diambil.css">
</head>
<body>

    <div class="pesanan-header">
        <a href="index.php?page=home" class="back-btn">&#8592;</a>
        <h2>Daftar Pesanan</h2>
    </div>

    <div class="search-container">
        <form action="index.php" method="GET" class="search-box">
            <input type="hidden" name="page" value="manage_pembayaran">
            <input type="hidden" name="status" value="<?= $current_status; ?>">
            <input type="text" name="search" placeholder="Cari berdasarkan Kode Pesanan (Contoh: LDR-001)..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" autocomplete="off">
            <button type="submit">Cari</button>
        </form>
    </div>

    <div class="status-tabs">
        <a href="index.php?page=manage_pembayaran&status=proses" class="tab-item <?= ($current_status == 'proses') ? 'active' : ''; ?>">Proses</a>
        <a href="index.php?page=manage_pembayaran&status=diambil" class="tab-item <?= ($current_status == 'diambil') ? 'active' : ''; ?>">Diambil</a>
    </div>

    <div class="pesanan-container">
        <?php 
        if (!empty($all_pesanan)) {
            foreach ($all_pesanan as $row) { 
                $status_pembayaran = strtolower($row['status_pembayaran']);

                if ($current_status == 'diambil') {
                    // Kalau sudah masuk daftar tab ini, artinya status_pembayaran memang
                    // sudah 'Diambil' (lihat filter query di controller), jadi keterangannya
                    // gak perlu dicek ulang ke 'lunas'.
                    $badge_class = 'status-success';
                    $text_badge = 'Diambil';
                    $text_keterangan = 'Sudah Diambil';
                } else {
                    $badge_class = ($status_pembayaran == 'lunas') ? 'status-success' : 'status-process';
                    $text_badge = ($status_pembayaran == 'lunas') ? 'Lunas' : 'Menunggu';
                    $text_keterangan = ($status_pembayaran == 'lunas') ? 'Siap untuk diambil' : 'Belum Bayar';
                }
                ?>
                
                <div class="card-pesanan">
                    <div class="card-left">
                        <h3><?= htmlspecialchars($row['kode_pesanan']); ?></h3>
                        <p class="nama-pelanggan"><?= htmlspecialchars($row['nama_pelanggan']); ?></p>
                        <p><?= htmlspecialchars($row['berat']); ?>Kg - <?= htmlspecialchars($row['layanan']); ?></p>
                    </div>
                    
                    <div class="card-right">
                        <a href="index.php?page=status_pembayaran&id=<?= $row['id']; ?>" class="badge-status <?= $badge_class; ?>">
                            <?= $text_badge; ?>
                        </a>
                        <p class="keterangan-laundry">
                            <?= $text_keterangan; ?>
                        </p>
                    </div>
                </div>

            <?php 
            } 
        } else {
            echo "<p class='empty-state'>Belum ada data pesanan.</p>";
        } 
        ?>
    </div>

</body>
</html>