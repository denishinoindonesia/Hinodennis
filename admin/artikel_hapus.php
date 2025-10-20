<?php
session_start();

require 'config.php'; // pastikan ini path yang benar dan $pdo sudah didefinisikan

// Cek session login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Ambil info artikel untuk mendapatkan nama file gambar
    $article = fetchOnePrepared($pdo, "SELECT image FROM artikel WHERE id = ?", [$id]);

    if ($article) {
        $imageFile = $article['image'] ?? null;

        // Hapus file gambar jika ada
        if (!empty($imageFile)) {
            $filePath = "uploads/artikel/" . $imageFile;
            if (is_file($filePath)) {
                unlink($filePath);
            }
        }

        // Hapus artikel dari database
        $deleted = execPrepared($pdo, "DELETE FROM artikel WHERE id = ?", [$id]);

        if ($deleted > 0) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Artikel berhasil dihapus!'];
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'Gagal menghapus artikel.'];
        }
    } else {
        $_SESSION['message'] = ['type' => 'warning', 'text' => 'Artikel tidak ditemukan.'];
    }
} else {
    $_SESSION['message'] = ['type' => 'danger', 'text' => 'Permintaan tidak valid.'];
}

header("Location: artikel.php");
exit;
?>
