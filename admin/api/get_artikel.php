<?php
include "../config.php";
header('Content-Type: application/json; charset=utf-8');

// Ambil parameter pencarian dan filter kategori
$search   = isset($_GET['search']) ? trim($_GET['search']) : null;
$kategori = isset($_GET['kategori']) ? trim($_GET['kategori']) : null;

// Query dasar
$sql = "
    SELECT 
        a.id, 
        a.judul, 
        a.isi, 
        a.gambar, 
        a.tanggal, 
        k.nama_kategori AS kategori
    FROM artikel a
    LEFT JOIN kategori k ON a.kategori_id = k.id
";

// Buat kondisi dinamis
$conditions = [];
$params = [];

if ($search) {
    $conditions[] = "(a.judul LIKE :search OR a.isi LIKE :search)";
    $params[':search'] = "%{$search}%";
}

if ($kategori) {
    $conditions[] = "k.nama_kategori = :kategori";
    $params[':kategori'] = $kategori;
}

// Tambahkan kondisi jika ada
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

// Urutkan artikel terbaru
$sql .= " ORDER BY a.id DESC";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $artikel = $stmt->fetchAll();

    // Ubah path gambar ke URL lengkap
    foreach ($artikel as &$row) {
        if (!empty($row['gambar'])) {
            $row['gambar'] = 'https://official-hino.com/admin/uploads/artikel/' . $row['gambar'];
        }
    }

    echo json_encode($artikel, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} catch (Exception $e) {
    // Error handling
    error_log("Error get_artikel: " . $e->getMessage());
    echo json_encode(['error' => 'Terjadi kesalahan saat mengambil data artikel.']);
}
?>
