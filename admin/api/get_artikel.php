<?php
// ==================================================
// GET ARTIKEL API - OFFICIAL HINO (STABLE)
// ==================================================

error_reporting(0);
ini_set('display_errors', 0);

include "../config.php";
header('Content-Type: application/json; charset=utf-8');

// Parameter
$search   = isset($_GET['search']) && $_GET['search'] !== '' ? trim($_GET['search']) : null;
$kategori = isset($_GET['kategori']) && $_GET['kategori'] !== '' ? trim($_GET['kategori']) : null;

// Query dasar
$sql = "
    SELECT 
        a.id,
        a.judul,
        a.slug,
        a.isi,
        a.gambar,
        a.tanggal,
        COALESCE(k.nama_kategori, '') AS kategori
    FROM artikel a
    LEFT JOIN kategori k ON a.kategori_id = k.id
";

// Kondisi dinamis
$conditions = [];
$params = [];

if ($search !== null) {
    $conditions[] = "(a.judul LIKE :search OR a.isi LIKE :search)";
    $params[':search'] = '%' . $search . '%';
}

if ($kategori !== null) {
    $conditions[] = "k.nama_kategori = :kategori";
    $params[':kategori'] = $kategori;
}

if ($conditions) {
    $sql .= ' WHERE ' . implode(' AND ', $conditions);
}

$sql .= " ORDER BY a.id DESC";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $artikel = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($artikel as &$row) {
        // Pastikan tidak ada NULL (PHP 8 safe)
        $row['id']       = (int) ($row['id'] ?? 0);
        $row['judul']    = $row['judul'] ?? '';
        $row['slug']     = $row['slug'] ?? '';
        $row['isi']      = $row['isi'] ?? '';
        $row['tanggal']  = $row['tanggal'] ?? '';
        $row['kategori'] = $row['kategori'] ?? '';

        // Full URL gambar
        if (!empty($row['gambar'])) {
            $row['gambar'] = 'https://official-hino.com/admin/uploads/artikel/' . $row['gambar'];
        } else {
            $row['gambar'] = '';
        }
    }

    echo json_encode($artikel, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Gagal mengambil data artikel'
    ]);
}
