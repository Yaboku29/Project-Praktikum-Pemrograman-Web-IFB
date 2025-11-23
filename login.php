<?php
session_start();

if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
// simpan pesan error (jika ada) dan hapus setelah ditampilkan
$error_message = '';
if (isset($_SESSION['error'])) {
    $error_message = $_SESSION['error'];
    unset($_SESSION['error']); // hapus agar tidak muncul terus
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        body {
            min-height: 100vh;
            background: #000000ff;
            background-image:
                radial-gradient(rgba(157, 154, 154, 0.93) 1px, transparent 1px),
                radial-gradient(rgba(255, 255, 255, 0.6) 1px, transparent 1px);
            background-size: 35px 35px, 40px 40px;
            background-position: 0 0, 20px 20px;
        }

        .login-card {
            background: white;
            padding: 40px;
            border-radius: 15px;
            max-width: 420px;
            width: 90%;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        }

        .logo-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: block;
            margin: 0 auto;
        }
    </style>
</head>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pwdInput = document.getElementById('passwordInput');
        const toggleBtn = document.getElementById('togglePasswordBtn');
        const toggleIcon = document.getElementById('toggleIcon');

        toggleBtn.addEventListener('click', function () {
            const isHidden = pwdInput.type === 'password';
            pwdInput.type = isHidden ? 'text' : 'password';

            // update icon & accessibility label
            toggleIcon.classList.toggle('bi-eye', !isHidden);
            toggleIcon.classList.toggle('bi-eye-slash', isHidden);

            toggleBtn.setAttribute('aria-pressed', isHidden ? 'true' : 'false');
            toggleBtn.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');

            // keep focus on input after toggle (UX)
            pwdInput.focus();
        });

        // optional: toggle with keyboard (Space/Enter when button focused handled automatically)
    });
</script>

<body>
    <div class="d-flex justify-content-center align-items-center" style="min-height:100vh;">
        <div class="login-card">
            <img src="asset/bima.png" alt="bima" class="logo-circle "><br>
            <h3 class="text-center">BIMA</h3>
            <h5 class="text-center">Sistem Informasi Akademik</h5>
            <!--  pesan error tampil di sini -->
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger mt-3 text-center">
                    <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>
            <form action="process/login_process.php" method="POST" class="mt-4">
                <div class="mb-3 text-start">
                    <label for="">Username</label><br>
                    <input type="text" name="NIM" required class="w-100">
                </div>
                <div class="mb-3 text-start">
                    <label for="passwordInput">Password</label>
                    <div class="input-group">
                        <input id="passwordInput" type="password" name="password" required class="form-control" autocomplete="current-password" aria-describedby="togglePasswordBtn">
                        <button id="togglePasswordBtn" class="btn btn-outline-secondary" type="button" aria-pressed="false" aria-label="Tampilkan password">
                            <i id="toggleIcon" class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-dark w-100"> Log in </button>
            </form>
        </div>
    </div>
</body>

</html>