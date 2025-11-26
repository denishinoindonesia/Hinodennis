<?php
session_start();
require_once 'config.php';

// Cek login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password_lama = $_POST['password_lama'] ?? '';
    $password_baru = $_POST['password_baru'] ?? '';
    $konfirmasi_password = $_POST['konfirmasi_password'] ?? '';

    // Ambil data admin
    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $admin_id]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$admin) {
        $error = "Akun tidak ditemukan!";
    } elseif (!password_verify($password_lama, $admin['password'])) {
        $error = "Password lama salah!";
    } elseif ($password_baru !== $konfirmasi_password) {
        $error = "Konfirmasi password tidak cocok!";
    } else {
        // Update password baru
        $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);
        $update = $pdo->prepare("UPDATE users SET password = :p WHERE id = :id");
        $update->execute([':p' => $password_hash, ':id' => $admin_id]);

        $success = "Password berhasil diubah.";
    }
}
?>
