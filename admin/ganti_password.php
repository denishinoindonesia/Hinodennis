<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password_lama = $_POST['password_lama'] ?? '';
    $password_baru = $_POST['password_baru'] ?? '';
    $konfirmasi_password = $_POST['konfirmasi_password'] ?? '';

    $admin = fetchOnePrepared($pdo, "SELECT password FROM users WHERE id = :id LIMIT 1", [':id' => $admin_id]);

    if (!$admin) {
        $error = "Akun tidak ditemukan!";
    } elseif (!password_verify($password_lama, $admin['password'])) {
        $error = "Password lama salah!";
    } elseif ($password_baru !== $konfirmasi_password) {
        $error = "Konfirmasi password tidak cocok!";
    } else {
        $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);
        execPrepared($pdo, "UPDATE users SET password = :p WHERE id = :id", [':p'=>$password_hash, ':id'=>$admin_id]);
        $success = "Password berhasil diubah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ganti Password Admin</title>

<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(135deg, #0d6efd, #5a9bfd, #a2c8ff);
    background-size: 300% 300%;
    animation: gradientShift 10s ease infinite;
    font-family: 'Poppins', sans-serif;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}
@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
.card {
    background: rgba(255,255,255,0.95);
    border-radius: 18px;
    padding: 40px;
    width: 100%;
    max-width: 450px;
    box-shadow: 0 12px 35px rgba(13,110,253,0.3);
}
.card h2 {
    text-align: center;
    color: #0d6efd;
    margin-bottom: 25px;
}
.btn-primary {
    background: linear-gradient(135deg, #0d6efd, #5a9bfd);
    border: none;
}
.btn-primary:hover {
    background: linear-gradient(135deg, #005ce6, #3b82f6);
}
</style>

</head>
<body>

<div class="card shadow">
    <h2>Ganti Password</h2>

    <?php if($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Password Lama</label>
            <input type="password" name="password_lama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password Baru</label>
            <input type="password" name="password_baru" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Konfirmasi Password Baru</label>
            <input type="password" name="konfirmasi_password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Ganti Password</button>
    </form>

    <div class="text-center mt-3">
        <a href="index.php" class="text-decoration-none">&larr; Kembali ke Dashboard</a>
    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
