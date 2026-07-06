<?php
if (!isset($detail)) {
    die("Data pesanan tidak ditemukan.");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Struk Pengambilan</title>
<link rel="stylesheet" href="../public/css/struk_pengambilan.css">
</head>
<body>
<div class="receipt">
    <div class="receipt-header">
        <img src="../public/img/Logo_Fresty_laundry.png" class="logo">
        <h2>Freshy Laundry</h2>
        <p>Digital Laundry System</p>
        <h3>STRUK PENGAMBILAN</h3> 
    </div>
    <hr>
    <table class="info-table">
        <tr>
            <td>Tanggal</td>
            <td><?= date("d-m-Y H:i"); ?></td>
        </tr>
        <tr>
            <td>Nama Pelanggan</td>
            <td><?= htmlspecialchars($detail['nama_pelanggan']); ?></td>
        </tr>
        <tr>
            <td>No HP</td>
            <td><?= htmlspecialchars($detail['no_hp']); ?></td>
        </tr>
        <tr>
            <td>Kode Pesanan</td>
            <td><?= htmlspecialchars($detail['kode_pesanan']); ?></td>
        </tr>
        <tr>
            <td>Status</td>
            <td><?= htmlspecialchars($detail['status_laundry']); ?></td>
        </tr>
    </table>
    <hr>
    <table class="detail-table">
        <thead>
            <tr>
                <th>Layanan</th>
                <th>Berat</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= htmlspecialchars($detail['layanan']); ?></td>
                <td><?= htmlspecialchars($detail['berat']); ?> Kg</td>
                <td>Rp <?= number_format($detail['total_harga'],0,',','.'); ?></td>
            </tr>
        </tbody>
    </table>
        <hr>
    <div class="total-section">
        <table>
            <tr>
                <td>Subtotal</td>
                <td>
                    Rp <?= number_format($detail['total_harga'],0,',','.'); ?>
                </td>
            </tr>
            <tr class="grand-total">
                <td><strong>TOTAL</strong></td>
                <td>
                    <strong>
                        Rp <?= number_format($detail['total_harga'],0,',','.'); ?>
                    </strong>
                </td>
            </tr>
        </table>
    </div>
    <hr>
    <div class="pickup-info">
        <p>
            <strong>Tanggal Diambil :</strong>
            <?= date("d-m-Y H:i"); ?>
        </p>
        <p>
            <strong>Status Pembayaran :</strong>
            <?= htmlspecialchars($detail['status_pembayaran']); ?>
        </p>
    </div>
    <hr>
    <div class="footer">
        <p>
            Terima kasih telah menggunakan
            <strong>Freshy Laundry</strong>
        </p>
        <p>
            Cucian yang telah diambil dianggap selesai.
        </p>
        <div class="barcode">
            ||||| || |||| ||||| || ||
        </div>
    </div>
    <div class="button-area">
        <button onclick="window.print()">
            🖨️ Cetak Sekarang
        </button>
        <a href="index.php?page=pesanan">
            Kembali
        </a>
    </div>
</div>
<script src="../public/js/struk_pengambilan.js"></script>
</body>
</html>