<?php
session_start();
require 'config.php'; // pastikan $pdo sudah aktif (gunakan PDO)

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $id = (int) $_GET['id'];

    try {
        // Ambil data artikel untuk cek file gambar
        $stmt = $pdo->prepare("SELECT gambar FROM artikel WHERE id = ?");
        $stmt->execute([$id]);
        $article = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($article) {
            $imageFile = $article['gambar'] ?? null;

            // Hapus file gambar jika ada dan valid
            if (!empty($imageFile)) {
                $filePath = __DIR__ . "/uploads/artikel/" . basename($imageFile);
                if (file_exists($filePath) && is_file($filePath)) {
                    unlink($filePath);
                }
            }

            // Hapus artikel dari database
            $stmt = $pdo->prepare("DELETE FROM artikel WHERE id = ?");
            $stmt->execute([$id]);

            if ($stmt->rowCount() > 0) {
                $_SESSION['message'] = ['type' => 'success', 'text' => 'Artikel berhasil dihapus!'];
            } else {
                $_SESSION['message'] = ['type' => 'danger', 'text' => 'Gagal menghapus artikel dari database.'];
            }
        } else {
            $_SESSION['message'] = ['type' => 'warning', 'text' => 'Artikel tidak ditemukan.'];
        }
    } catch (PDOException $e) {
        // Log error ke server
        error_log("Error hapus artikel: " . $e->getMessage());
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Terjadi kesalahan sistem.'];
    }
} else {
    $_SESSION['message'] = ['type' => 'danger', 'text' => 'Permintaan tidak valid.'];
}

// Kembali ke daftar artikel
header("Location: artikel.php");
exit;
?>
