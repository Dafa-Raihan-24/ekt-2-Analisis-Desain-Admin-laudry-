<?php
$status_bayar = strtolower($pesanan['status_pembayaran']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pembayaran - Freshy Laundry</title>
    <link rel="stylesheet" href="../public/css/status_pembayaran.css">
</head>
<body>
    <div class="status-header">
        <a href="index.php?page=manage_pembayaran&status=proses" class="back-btn">&#8592;</a>
        <h2>Status Pembayaran</h2>
    </div>
    <div class="status-container">
        <div class="info-row">
            <span class="info-label">Nama</span>
            <span class="info-value"><?= htmlspecialchars($pesanan['nama_pelanggan']); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Kode Pesanan</span>
            <span class="info-value"><?= htmlspecialchars($pesanan['kode_pesanan']); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">No Hp</span>
            <span class="info-value"><?= htmlspecialchars($pesanan['no_hp']); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Layanan</span>
            <span class="info-value"><?= htmlspecialchars($pesanan['layanan']); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Berat</span>
            <span class="info-value"><?= htmlspecialchars($pesanan['berat']); ?> Kg</span>
        </div>
        <div class="info-row">
            <span class="info-label">Total Pembayaran</span>
            <span class="info-value">Rp. <?= number_format($pesanan['total_harga'], 0, ',', '.'); ?>.00</span>
        </div>
        <div class="info-row">
            <span class="info-label">Metode Pembayaran</span>
            <span class="info-value">Cash/Tunai</span>
        </div>
        <div class="info-row">
            <span class="info-label">Status Pembayaran</span>
            <span class="info-value">
                <form action="index.php" method="GET">
                    <input type="hidden" name="page" value="toggle_bayar">
                    <input type="hidden" name="id" value="<?= $pesanan['id']; ?>">
                    <select name="status" class="dropdown-status" onchange="this.form.submit()">
                        <option value="belum" <?= ($status_bayar != 'lunas' && $status_bayar != 'diambil') ? 'selected' : ''; ?>>Belum Bayar</option>
                        <option value="lunas" <?= ($status_bayar == 'lunas') ? 'selected' : ''; ?>>Lunas</option>
                        <option value="diambil" <?= ($status_bayar == 'diambil') ? 'selected' : ''; ?>>Diambil</option>
                    </select>
                </form>
            </span>
        </div>
        <?php if ($status_bayar == 'lunas' && !empty($pesanan['dibayar_pada'])): ?>
        <div class="info-row">
            <span class="info-label">Dibayar Pada</span>
            <span class="info-value"><?= date('d M Y, H:i', strtotime($pesanan['dibayar_pada'])); ?></span>
        </div>
        <?php endif; ?>
        <div class="info-row">
            <span class="info-label">Estimasi</span>
            <span class="info-value"><?= htmlspecialchars($pesanan['estimasi_selesai']); ?></span>
        </div>
        <div class="action-buttons">
            <?php if ($status_bayar == 'lunas'): ?>
                <a href="index.php?page=struk_pengambilan&id=<?= $pesanan['id']; ?>" class="btn-cetak">🖨️ Cetak Struk</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>