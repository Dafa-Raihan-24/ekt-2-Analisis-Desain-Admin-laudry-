<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Proses Pesanan</title>
    <link rel="stylesheet" href="../public/css/update_proses.css">
</head>

<body>

    <div class="header-nav">
        <a href="index.php?page=pesanan" class="back-btn">⬅️</a>
        <h2>Detail Pesanan</h2>
    </div>

    <div class="container">
        <form action="index.php?page=simpan_update" method="POST">
            <input type="hidden" name="id" value="<?php echo $detail['id']; ?>">
            <input type="hidden" name="status_laundry" id="inputStatus" value="<?php echo $detail['status_laundry'] ?? 'Diterima'; ?>">

            <div class="info-grid">
            <div class="input-group">
                <label>Kode Pesanan</label>
                <input type="text" value="<?php echo htmlspecialchars($detail['kode_pesanan']); ?>" readonly>
            </div>
            <div class="input-group">
                <label>Nama Pelanggan</label>
                <input type="text" value="<?php echo htmlspecialchars($detail['nama_pelanggan']); ?>" readonly>
            </div>
            <div class="input-group">
                <label>Status Laundry Saat Ini</label>
                <input type="text" id="statusDisplay" class="status-badge" value="<?php echo htmlspecialchars($detail['status_laundry'] ?? 'Diterima'); ?>" readonly>
            </div>
            
            <div class="input-group">
                <label>Status Pembayaran</label>
                <select name="status_pembayaran" class="select-pembayaran">
                    <option value="Belum Bayar" <?php echo ($detail['status_pembayaran'] == 'Belum Bayar') ? 'selected' : ''; ?>>🔴 Belum Bayar</option>
                    <option value="Lunas" <?php echo ($detail['status_pembayaran'] == 'Lunas') ? 'selected' : ''; ?>>🟢 Lunas</option>
                </select>
            </div>
        </div>

            <div class="stepper-wrapper">
                <div class="progress-line" id="progressLine"></div>
                
                <?php 
                $list_status = ['Diterima', 'Dicuci', 'Dikeringkan', 'Disetrika', 'Packing', 'Bisa Diambil'];
                $icons = ['✅', '🧺', '💨', '👔', '📦', '🛒'];
                foreach ($list_status as $index => $status): 
                ?>
                    <div class="step-item" onclick="setStep('<?php echo $status; ?>', <?php echo $index; ?>)">
                        <div class="step-circle" id="circle-<?php echo $index; ?>"><?php echo $icons[$index]; ?></div>
                        <p class="step-label" id="label-<?php echo $index; ?>"><?php echo $status; ?></p>
                        <span class="step-subtext" id="sub-<?php echo $index; ?>">Menunggu</span>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="action-footer">
                <button type="button" class="btn-cancel" onclick="window.history.back()">Batal Pesanan</button>
                <button type="button"class="btn-submit"onclick="kirimNotif()">Simpan</button>
            </div>
        </form>
    </div>

    <script>
        const statusOrder = ['Diterima', 'Dicuci', 'Dikeringkan', 'Disetrika', 'Packing', 'Bisa Diambil'];
        const currentStatusFromDB = "<?php echo $detail['status_laundry'] ?? 'Diterima'; ?>";
        
        function setStep(statusName, indexTarget) {
            // Ubah value input hidden & text box display
            document.getElementById('inputStatus').value = statusName;
            document.getElementById('statusDisplay').value = statusName;

            // Refresh semua warna visual stepper
            statusOrder.forEach((status, idx) => {
                const circle = document.getElementById(`circle-${idx}`);
                const label = document.getElementById(`label-${idx}`);
                const sub = document.getElementById(`sub-${idx}`);

                if (idx <= indexTarget) {
                    // Tahapan yang sudah dilewati / sedang aktif diberi warna biru menyala
                    circle.classList.add('active');
                    label.classList.add('active-text');
                    sub.innerText = (idx === indexTarget) ? "Sedang Diproses" : "Selesai";
                    sub.style.color = "#28a745";
                } else {
                    // Tahapan di depannya tetap abu-abu bawaan figma
                    circle.classList.remove('active');
                    label.classList.remove('active-text');
                    sub.innerText = "Menunggu";
                    sub.style.color = "#a0aec0";
                }
            });

            // Atur panjang garis biru di belakang lingkaran stepper
            const progressPct = (indexTarget / (statusOrder.length - 1)) * 100;
            document.getElementById('progressLine').style.width = progressPct + '%';
        }

        // Jalankan otomatis saat halaman dimuat agar membaca kondisi terakhir dari database
        document.addEventListener("DOMContentLoaded", function() {
            const initialIndex = statusOrder.indexOf(currentStatusFromDB);
            setStep(currentStatusFromDB, initialIndex >= 0 ? initialIndex : 0);
        });
        function closeNotif(){
            document.getElementById("waModal").style.display="none";
            document.querySelector("form").submit();
        }
        function kirimNotif(){
        let status=document.getElementById("inputStatus").value;
        if(status=="Bisa Diambil"){
            document.getElementById("waModal").style.display="flex";
        }
        else{
            document.querySelector("form").submit();
        }
        }
        </script>
    <!-- Modal Notifikasi WA -->

<div id="waModal" class="wa-modal">
    <div class="wa-box">
        <div class="wa-icon">
            📱
        </div>
        <h2>Notifikasi WhatsApp</h2>
        <p class="success">
            ✅ Berhasil Dikirim
        </p>
        <div class="wa-content">
            <p>
                <strong>Pelanggan :</strong>
                <?php echo htmlspecialchars($detail['nama_pelanggan']); ?>
            </p>
            <p>
                <strong>No HP :</strong>
                <?php echo htmlspecialchars($detail['no_hp']); ?>
            </p>
            <hr>
            <p>
                Halo <b><?php echo htmlspecialchars($detail['nama_pelanggan']); ?></b> 👋
            </p>
            <p>
                Laundry Anda telah selesai
                dan siap diambil.
            </p>
            <p>
                <strong>Kode :</strong>
                <?php echo htmlspecialchars($detail['kode_pesanan']); ?>
            </p>
            <p>
                Terima kasih telah menggunakan
                Freshy Laundry.
            </p>
        </div>
        <button onclick="closeNotif()">
            OK
        </button>
    </div>
</div>
</body>
</html>