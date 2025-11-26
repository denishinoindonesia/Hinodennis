<?php
session_start();

require 'config.php'; // pastikan path ini benar dan $pdo tersedia

// Cek session login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? null;

if (!$id || !ctype_digit($id)) {
    $_SESSION['message'] = ['type' => 'danger', 'text' => 'Permintaan tidak valid.'];
    header("Location: messages.php");
    exit;
}

$id = (int) $id;

// Ambil pesan dari database
$message = fetchOnePrepared($pdo, "SELECT * FROM messages WHERE id = ?", [$id]);

if (!$message) {
    $_SESSION['message'] = ['type' => 'danger', 'text' => 'Pesan tidak ditemukan.'];
    header("Location: messages.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detail Pesan</title>

<!-- Favicon -->
<link rel="icon" href="../img/favicon.png" type="image/png" />


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/admin.css?v=2">
</head>
<body>

<button class="menu-toggle"><i class="fa-solid fa-bars"></i></button>
<div class="overlay"></div>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="logo text-center">
        <img src="../img/favicon.png" alt="Logo">
    </div>
    <a href="index.php" class="active"><i class="fa-solid fa-house"></i> Dashboard</a>
    <a href="artikel.php"><i class="fa-solid fa-file-lines"></i> Artikel</a>
    <a href="messages.php"><i class="fa-solid fa-envelope"></i> Pesan</a>
    <a href="ganti_password.php"><i class="fa-solid fa-envelope"></i> Ganti Password</a>
    <div class="mt-auto pt-3">
        <a href="logout.php" class="logout-link"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">
    <h3 class="fw-semibold text-primary mb-4">
        <i class="fa-solid fa-envelope-open-text me-2"></i> Detail Pesan
    </h3>

    <div class="card p-4">
        <div class="mb-3">
            <label class="fw-semibold">Nama Pengirim:</label>
            <p><?= htmlspecialchars($message['name'] ?? '-') ?></p>
        </div>
        <div class="mb-3">
            <label class="fw-semibold">Nomor Pengirim:</label>
            <p><?= htmlspecialchars($message['phone'] ?? '-') ?></p>
        </div>
        <div class="mb-3">
            <label class="fw-semibold">Pesan:</label>
            <p><?= nl2br(htmlspecialchars($message['message'] ?? '-')) ?></p>
        </div>
        <div class="mb-3">
            <label class="fw-semibold">Tanggal Diterima:</label>
            <p><?= !empty($message['created_at']) ? date("d M Y H:i", strtotime($message['created_at'])) : '-' ?></p>
        </div>
        <a href="messages.php" class="btn btn-primary">
            <i class="fa fa-arrow-left me-1"></i> Kembali ke Pesan
        </a>
    </div>
</div>

<script src="js/admin.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
