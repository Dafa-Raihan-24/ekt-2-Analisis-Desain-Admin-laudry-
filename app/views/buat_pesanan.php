<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pesanan Baru</title>
    <link rel="stylesheet" href="../public/css/buat_pesanan.css">
</head>
<body>

    <header>
        <h1>Halo, Admin!</h1>
        <div class="logo-text" style="font-weight: bold;">Freshy Laundry</div>
    </header>

    <div class="main-container">
        <div class="form-box">
            <div class="form-header">
                <a href="index.php?page=home">⬅️</a>
                <span>Buat Pesanan Baru</span>
            </div>

            <?php if (isset($error)): ?>
                <div style="background:#fdecea; color:#b3261e; border:1px solid #f5c2c0; border-radius:8px; padding:10px 14px; margin:0 20px 14px; font-size:14px;">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form id="formPesanan" action="index.php?page=buat_pesanan" method="POST" class="form-content">
                <div class="form-left">
                    <div class="section-title">Data Pelanggan</div>
                    <input type="text" id="input_nama" name="nama_pelanggan" placeholder="Nama Pelanggan" required autocomplete="off">
                    <input type="text" id="input_hp" name="no_hp" placeholder="Nomor HP" required>
                    
                    <hr style="border: 0; border-top: 2px solid #f0f8ff; margin: 20px 0;">
                    
                    <div class="section-title">Detail Cucian</div>
                    <select name="layanan" id="layanan" required>
                        <option value="Cuci Setrika">Cuci Setrika (Rp 7.000 / Kg)</option>
                        <option value="Cuci Express">Cuci Express (Rp 10.000 / Kg)</option>
                        <option value="Setrika">Setrika (Rp 5.000 / Kg)</option>
                    </select>
                    <input type="number" name="berat" id="berat" step="0.1" min="0.1" placeholder="Berat (Kg)" required>
                    <input type="text" id="total_display" placeholder="Total Harga" readonly style="background-color: #fafafa; font-weight: bold; color: #5ca7f2;">
                    <input type="text" id="input_estimasi" name="estimasi_selesai" placeholder="Estimasi Selesai (Contoh: 3 Hari)" required>
                </div>

                <div class="form-right">
                    <span style="font-size: 13px; color: #666; font-weight: 600;">Kode Pesanan</span>
                    <div class="kode-display" id="kode_laundry"><?php echo $kode_pesanan; ?></div>
                    <button type="button" style="background: white; border: 1px solid #5ca7f2; padding: 5px 12px; border-radius: 15px; color: #5ca7f2; cursor: pointer; font-size: 12px;">📋 Salin Kode</button>
                </div>

                <div class="form-footer">
                    <a href="index.php?page=home" class="btn btn-batal">Keluar / Batal</a>
                    <button type="submit" class="btn btn-simpan">Simpan / Cetak Struk</button>
                </div>
            </form>
        </div>
    </div>

    <?php include 'struk_modal.php'; ?>

    <script src="../public/js/buat_pesanan.js"></script>

</body>
</html>