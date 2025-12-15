<?php
include "../config.php";
header('Content-Type: application/json; charset=utf-8');

try {
    $stmt = $pdo->query("
        SELECT id, nama_kategori
        FROM kategori
        ORDER BY nama_kategori ASC
    ");

    echo json_encode(
        $stmt->fetchAll(PDO::FETCH_ASSOC),
        JSON_UNESCAPED_UNICODE
    );
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Gagal mengambil kategori"]);
}
