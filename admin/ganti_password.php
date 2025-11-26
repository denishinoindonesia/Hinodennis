<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'config.php';


// Debug sementara — hapus setelah selesai
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

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

    // Ambil password lama
    $admin = fetchOnePrepared($pdo, 
        "SELECT password FROM users WHERE id = :id LIMIT 1",
        [':id' => $admin_id]
    );

    if (!$admin) {
        $error = "Akun tidak ditemukan!";
    } elseif (!password_verify($password_lama, $admin['password'])) {
        $error = "Password lama salah!";
    } elseif ($password_baru !== $konfirmasi_password) {
        $error = "Konfirmasi password tidak cocok!";
    } else {

        // Hash password baru
        $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);

        // Update
        execPrepared($pdo, 
            "UPDATE users SET password = :p WHERE id = :id",
            [
                ':p' => $password_hash,
                ':id' => $admin_id
            ]
        );

        $success = "Password berhasil diubah.";
    }
}
?>
