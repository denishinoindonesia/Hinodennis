<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

include "../config.php";
header('Content-Type: application/json; charset=utf-8');

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
        "nama" => $row["nama_kategori"]
    ];
}

// Output dalam format JSON
echo json_encode($kategori);
?>
