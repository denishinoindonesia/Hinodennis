<?php
// buat_admin.php — jalankan sekali untuk membuat admin
require_once 'config.php';

$username = 'admin';
$passwordPlain = 'D3n15h1no35!';

// Cek apakah user sudah ada
$existing = fetchOnePrepared($pdo, "SELECT id FROM users WHERE username = :u", [':u' => $username]);
if ($existing) {
    echo "User '$username' sudah ada (id: " . $existing['id'] . ").\n";
    exit;
}

// Hash password dengan password_hash (bcrypt)
$hash = password_hash($passwordPlain, PASSWORD_DEFAULT);

// Insert user
$stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (:u, :p, :r)");
$stmt->execute([
    ':u' => $username,
    ':p' => $hash,
    ':r' => 'admin'
]);

echo "Admin '$username' berhasil dibuat.\n";
