<?php
include "../config.php";
header('Content-Type: application/json; charset=utf-8');

// Parameter
$search   = isset($_GET['search']) ? trim($_GET['search']) : '';
$kategori = isset($_GET['kategori']) ? trim($_GET['kategori']) : '';
$slug     = isset($_GET['slug']) ? trim($_GET['slug']) : '';

// SQL
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

$where = [];
$params = [];

// filter slug (DETAIL)
if ($slug !== '') {
    $where[] = "a.slug = :slug";
    $params[':slug'] = $slug;
}

// filter search
if ($search !== '') {
    $where[] = "(a.judul LIKE :search OR a.isi LIKE :search)";
    $params[':search'] = "%$search%";
}

// filter kategori
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

    // JIKA DETAIL (slug) → KIRIM 1 DATA
    if ($slug !== '') {
        echo json_encode($artikel[0] ?? null, JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode($artikel, JSON_UNESCAPED_UNICODE);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Gagal mengambil artikel"]);
}
