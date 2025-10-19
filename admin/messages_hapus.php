<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include 'config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Hapus pesan berdasarkan ID
    $stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = ['type'=>'success','text'=>'Pesan berhasil dihapus!'];
    } else {
        $_SESSION['message'] = ['type'=>'danger','text'=>'Gagal menghapus pesan.'];
    }
} else {
    $_SESSION['message'] = ['type'=>'danger','text'=>'ID pesan tidak ditemukan.'];
}

// Kembali ke halaman pesan
header("Location: messages.php");
exit;
?>
