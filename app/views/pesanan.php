<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pesanan Laundry</title>
    <link rel="stylesheet" href="../public/css/pesanan.css">
</head>
<body>

    <div class="pesanan-header">
        <a href="index.php?page=home">⬅️</a>
        <h2>Daftar Menu Pesanan</h2>
    </div>

    <div class="search-container">
        <form action="index.php" method="GET" class="search-box">
            <input type="hidden" name="page" value="pesanan">
            <input type="text" name="search" placeholder="Cari berdasarkan Kode Pesanan (Contoh: LDR-001)..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" autocomplete="off">
            <button type="submit">Cari</button>
        </form>
    </div>

    <div class="tab-navigation">
        <button class="tab-btn active" onclick="switchTab('Baru')">Baru</button>
        <button class="tab-btn" onclick="switchTab('Update')">Update</button>
        <button class="tab-btn" onclick="switchTab('Selesai')">Selesai</button>
    </div>

    <div class="cards-grid">
        <?php if (empty($all_pesanan)): ?>
            <div style="grid-column: 1/-1; text-align: center; color: #718096; margin-top: 20px; font-weight: bold;">Data pesanan tidak ditemukan atau masih kosong.</div>
        <?php else: ?>
            <?php foreach ($all_pesanan as $pesanan): 
                // 🌟 KLASIFIKASI TAB BERDASARKAN STATUS LAUNDRY (SESUAI FIGMA)
                if ($pesanan['status_laundry'] === 'Diterima') {
                    $tab_class = 'Baru';
                } elseif (in_array($pesanan['status_laundry'], ['Dicuci', 'Dikeringkan', 'Disetrika', 'Packing'])) {
                    $tab_class = 'Update';
                } elseif ($pesanan['status_laundry'] === 'Bisa Diambil' || $pesanan['status_laundry'] === 'Selesai') {
                    $tab_class = 'Selesai';
                }
            ?>
                <div class="pesanan-card" data-status="<?php echo $tab_class; ?>">
                    
                    <div class="card-header-info">
                        <div class="laundry-icon-title">
                            <div class="icon-box">🧺</div>
                            <div class="meta-user">
                                <h4><?php echo htmlspecialchars($pesanan['nama_pelanggan']); ?></h4>
                                <p>📞 <?php echo htmlspecialchars($pesanan['no_hp']); ?></p>
                                
                                <p class="current-status" style="margin-top: 5px; font-size: 13px; color: #3b31df; font-weight: bold; margin-bottom: 0;">
                                    🔄 Status: <span style="background: #e6f2ff; padding: 2px 8px; border-radius: 5px; font-size: 11px;"><?php echo htmlspecialchars($pesanan['status_laundry'] ?? 'Diterima'); ?></span>
                                </p>
                            </div>
                        </div>
                        <div class="kode-tag"><?php echo htmlspecialchars($pesanan['kode_pesanan']); ?></div>
                    </div>

                    <div class="card-detail-row">
                        <div class="detail-item">👔 <strong><?php echo htmlspecialchars($pesanan['layanan']); ?></strong></div>
                        <div class="detail-item">⚖️ <strong><?php echo htmlspecialchars($pesanan['berat']); ?> Kg</strong></div>
                    </div>

                    <div class="card-time-info">
                        <div>💰 <strong>Total Harga:</strong> RP. <?php echo number_format($pesanan['total_harga'], 0, ',', '.'); ?>.00</div>
                        <div>📅 <strong>Estimasi:</strong> <?php echo htmlspecialchars($pesanan['estimasi_selesai']); ?></div>
                    </div>

                    <div class="card-footer">

                    <?php if($tab_class === 'Selesai'): ?>

                    <a href="index.php?page=struk_pengambilan&id=<?php echo $pesanan['id']; ?>" class="btn btn-print">
                    🖨️ Cetak Struk
                    </a>

                    <a href="index.php?page=update_proses&id=<?php echo $pesanan['id']; ?>" class="btn btn-edit">
                    ✏️ Ubah Status
                    </a>

                    <?php else: ?>

                    <a href="index.php?page=update_proses&id=<?php echo $pesanan['id']; ?>" class="btn btn-update">
                    🔄 Update Proses
                    </a>

                    <?php endif; ?>

                    </div>

                </div> <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <script src="../public/js/pesanan.js"></script>
</body>
</html>