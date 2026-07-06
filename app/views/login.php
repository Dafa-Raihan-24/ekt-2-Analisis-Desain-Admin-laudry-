<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Freshy Laundry</title>
    <link rel="stylesheet" href="../public/css/login.css">
</head>
<body class="login-body">

    <div class="login-card">
        <img src="../public/img/Logo_Fresty_laundry.png" alt="Logo Freshy Laundry" class="login-logo" onerror="this.src='https://placehold.co/100x100?text=Logo+Freshy'">
        
        <p>Silakan masuk ke akun admin Anda</p>

        <?php if (isset($error)): ?>
            <div style="background:#fdecea; color:#b3261e; border:1px solid #f5c2c0; border-radius:8px; padding:10px 14px; margin-bottom:14px; font-size:14px;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="index.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username admin" required autocomplete="off">
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>
            </div>
            
            <button type="submit" class="btn-login">Masuk</button>
        </form>
    </div>

</body>
</html>