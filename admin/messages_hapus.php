<?php
session_start();

// Pastikan admin sudah login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

require 'config.php'; // Pastikan file ini sudah men-define $pdo

if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $id = (int) $_GET['id'];

    try {
        // Hapus pesan berdasarkan ID menggunakan prepared statement
        $stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount() > 0) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Pesan berhasil dihapus!'];
        } else {
            $_SESSION['message'] = ['type' => 'warning', 'text' => 'Pesan tidak ditemukan.'];
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Terjadi kesalahan saat menghapus pesan.'];
    }

} else {
    $_SESSION['message'] = ['type' => 'danger', 'text' => 'ID pesan tidak valid.'];
}

// Kembali ke halaman pesan
header("Location: messages.php");
exit;
?>
