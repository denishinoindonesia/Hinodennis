<?php
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_name = getenv('DB_NAME') ?: 'u142136422_officialhino';
$db_user = getenv('DB_USER') ?: 'u142136422_officialhino';
$db_pass = getenv('DB_PASS') ?: 'D3n15h1no35!';

$dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // exception saat error
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false, // pakai native prepares bila tersedia
];

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
} catch (PDOException $e) {
    // Jangan tampilkan detail error di production — log saja.
    error_log("Database connection failed: " . $e->getMessage());
    // Tampilkan pesan umum
    exit('Koneksi ke database gagal. Silakan coba lagi nanti.');
}

/* -------------------------
   Session hardening (recommended)
   ------------------------- */

/* -------------------------
   Helper functions
   ------------------------- */

/**
 * fetchAllPrepared
 * Jalankan statement prepared (SELECT) dan kembalikan semua baris.
 * - $sql: query with placeholders
 * - $params: array of params (positional or named)
 */
function fetchAllPrepared(PDO $pdo, string $sql, array $params = []): array {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

/**
 * fetchOnePrepared
 * Ambil satu baris (atau null)
 */
function fetchOnePrepared(PDO $pdo, string $sql, array $params = []): ?array {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $row = $stmt->fetch();
    return $row === false ? null : $row;
}

/**
 * execPrepared
 * Untuk INSERT/UPDATE/DELETE. Mengembalikan rowCount() (jumlah baris yang terpengaruh)
 */
function execPrepared(PDO $pdo, string $sql, array $params = []): int {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->rowCount();
}
