<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freshy Laundry - Home Admin</title>
    <link rel="stylesheet" href="../public/css/home.css">
</head>
<body>

    <?php if (isset($_SESSION['login_sukses'])): ?>
        <div style="background-color: #2ecc71; color: white; text-align: center; padding: 10px; font-weight: bold; font-size: 14px; width: 100%;">
            <?php 
                echo $_SESSION['login_sukses']; 
                unset($_SESSION['login_sukses']); 
            ?>
        </div>
    <?php endif; ?>

    <header>
        <h1>Halo, Admin!</h1>
        <div class="logo-text">Freshy Laundry</div>
    </header>

    <div class="main-container">
        <div class="menu-grid">
            
            <a href="index.php?page=buat_pesanan" style="text-decoration: none; color: inherit;">
                <div class="menu-card">Buat Pesanan Baru</div>
            </a>

            <a href="index.php?page=manage_pembayaran" style="text-decoration: none; color: inherit;">
                <div class="menu-card">Manage Pembayaran</div>
            </a>

            <a href="index.php?page=pesanan" style="text-decoration: none; color: inherit;">
                <div class="menu-card">Pesanan</div>
            </a>

            <a href="index.php?page=logout" style="text-decoration: none; color: inherit;">
                <div class="menu-card logout">Log Out</div>
            </a>

        </div>
    </div>

</body>
</html>