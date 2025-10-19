<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
include 'config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Ambil info artikel untuk mendapatkan nama file gambar
    $query = $conn->query("SELECT image FROM artikel WHERE id=$id");
    if ($query && $query->num_rows > 0) {
        $row = $query->fetch_assoc();
        $imageFile = $row['image'];

        // Hapus file gambar jika ada
        if (!empty($imageFile)) {
            $filePath = "uploads/artikel/" . $imageFile;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // Hapus artikel dari database
        $result = $conn->query("DELETE FROM artikel WHERE id=$id");

        if ($result) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Artikel berhasil dihapus!'];
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'Gagal menghapus artikel.'];
        }
    } else {
        $_SESSION['message'] = ['type' => 'warning', 'text' => 'Artikel tidak ditemukan.'];
    }
}

header("Location: artikel.php");
exit;
?>
