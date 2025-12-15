<?php
error_reporting(0);
ini_set('display_errors', 0);

include "../config.php";
header('Content-Type: application/json; charset=utf-8');

$search   = isset($_GET['search']) ? trim($_GET['search']) : null;
$kategori = isset($_GET['kategori']) ? trim($_GET['kategori']) : null;

$sql = "
    SELECT 
        a.id, 
        a.judul, 
        a.slug, 
        a.isi, 
        a.gambar, 
        a.tanggal, 
        k.nama_kategori AS kategori
    FROM artikel a
    LEFT JOIN kategori k ON a.kategori_id = k.id
";

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

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$sql .= " ORDER BY a.id DESC";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $artikel = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($artikel as &$row) {
        $row['judul']    = $row['judul'] ?? '';
        $row['slug']     = $row['slug'] ?? '';
        $row['isi']      = $row['isi'] ?? '';
        $row['kategori'] = $row['kategori'] ?? '';

        if (!empty($row['gambar'])) {
            $row['gambar'] = 'https://official-hino.com/admin/uploads/artikel/' . $row['gambar'];
        } else {
            $row['gambar'] = '';
        }
    }

    echo json_encode($artikel, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch (Exception $e) {
    echo json_encode(['error' => 'Terjadi kesalahan saat mengambil data artikel.']);
}
