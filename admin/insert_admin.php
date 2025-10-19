<?php
// Contoh: insert_admin.php
$pdo = new PDO('mysql:host=localhost;dbname=app_db;charset=utf8mb4', 'db_user', 'db_pass', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$username = 'admin';
$passwordPlain = 'D3n15h1no35!';

// Hash password menggunakan bcrypt (default di password_hash)
$hash = password_hash($passwordPlain, PASSWORD_DEFAULT);

// Prepared statement untuk insert
$stmt = $pdo->prepare('INSERT INTO admins (username, password_hash) VALUES (:username, :hash)');
$stmt->execute([':username' => $username, ':hash' => $hash]);

echo "Admin dibuat.\n";
