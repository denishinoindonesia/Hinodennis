<?php
include "../config.php";
header('Content-Type: application/json; charset=utf-8');

// Parameter
$search   = isset($_GET['search']) ? trim($_GET['search']) : '';
$kategori = isset($_GET['kategori']) ? trim($_GET['kategori']) : '';

// SQL
$sql = "
    SELECT 
        a.id,
        a.judul,
        a.slug,
        a.isi,
        a.gambar,
        a.tanggal,
        k.nama_kategori
    FROM artikel a
    LEFT JOIN kategori k ON a.kategori_id = k.id
";

$where = [];
$params = [];

if ($search !== '') {
    $where[] = "(a.judul LIKE :search OR a.isi LIKE :search)";
    $params[':search'] = "%$search%";
}

if ($kategori !== '') {
    $where[] = "k.nama_kategori = :kategori";
    $params[':kategori'] = $kategori;
}

if ($where) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " ORDER BY a.tanggal DESC";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $artikel = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($artikel as &$row) {
        if (!empty($row['gambar'])) {
            $row['gambar'] = "https://official-hino.com/admin/uploads/artikel/" . $row['gambar'];
        }
    }

    echo json_encode($artikel, JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Gagal mengambil artikel"]);
}
