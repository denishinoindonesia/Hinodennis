<?php
include "../config.php";
header('Content-Type: application/json; charset=utf-8');

try {
    $stmt = $pdo->query("SELECT id, nama_kategori FROM kategori ORDER BY nama_kategori ASC");
    $kategori = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($kategori, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} catch (Exception $e) {
    error_log("Error get_kategori: " . $e->getMessage());
    echo json_encode(["error" => "Terjadi kesalahan saat mengambil kategori."]);
}

// Cek koneksi
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Koneksi gagal: " . $conn->connect_error]);
    exit;
}

// Ambil data kategori
$sql = "SELECT id, nama_kategori FROM kategori ORDER BY nama_kategori ASC";
$result = $conn->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(["error" => "Query gagal: " . $conn->error]);
    exit;
}

$kategori = [];

while ($row = $result->fetch_assoc()) {
    // Buat format output: id dan nama (pakai alias agar frontend tetap bisa akses 'nama')
    $kategori[] = [
    "id" => $row["id"],
    "nama_kategori" => $row["nama_kategori"]
    ];
}

// Output dalam format JSON
echo json_encode($kategori);
?>
