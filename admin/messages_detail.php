<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include 'config.php';

$id = intval($_GET['id']); // pastikan aman
$result = $conn->query("SELECT * FROM messages WHERE id=$id");
$message = $result->fetch_assoc();

if (!$message) {
    $_SESSION['message'] = ['type'=>'danger','text'=>'Pesan tidak ditemukan.'];
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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
body { background: #f8f9fb; font-family: 'Poppins', sans-serif; }

.sidebar {
    position: fixed;
    left: 0;
    top: 0;
    width: 250px;
    height: 100vh;
    background: #fff;
    box-shadow: 3px 0 15px rgba(0,0,0,0.05);
    padding: 30px 20px;
    display: flex;
    flex-direction: column;
}

.sidebar .logo { text-align: center; margin-bottom: 40px; }
.sidebar .logo img { width: 140px; height: auto; }

.sidebar a { display:flex; align-items:center; gap:12px; padding:12px 18px; color:#555; border-radius:10px; font-size:15px; text-decoration:none; margin-bottom:8px; transition:0.3s; }
.sidebar a i { font-size:17px; }
.sidebar a:hover, .sidebar a.active { background:#0d6efd; color:white; }

.logout-link { margin-top:auto; color:#dc3545; font-weight:500; }
.logout-link:hover { color:#b02a37; }

.main-content { margin-left: 260px; padding: 30px; }

.card { border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
.btn-primary { background-color: #0d6efd; border: none; border-radius: 10px; font-weight: 500; }
.btn-primary:hover { background-color: #005ce6; }
</style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="logo text-center">
        <img src="../img/logo.png" alt="Logo">
    </div>
    <a href="index.php"><i class="fa-solid fa-home"></i> Dashboard</a>
    <a href="produk.php"><i class="fa-solid fa-box"></i> Produk</a>
    <a href="artikel.php"><i class="fa-solid fa-file-alt"></i> Artikel</a>
    <a href="messages.php" class="active"><i class="fa-solid fa-envelope"></i> Pesan</a>
    <div class="mt-auto pt-3">
        <a href="logout.php" style="color:#dc3545;"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">
    <h3 class="fw-semibold text-primary mb-4"><i class="fa-solid fa-envelope-open-text me-2"></i> Detail Pesan</h3>

    <div class="card p-4">
        <div class="mb-3">
            <label class="fw-semibold">Nama Pengirim:</label>
            <p><?= htmlspecialchars($message['name']) ?></p>
        </div>
        <div class="mb-3">
            <label class="fw-semibold">Nomor Pengirim:</label>
            <p><?= htmlspecialchars($message['phone']) ?></p>
        </div>
        <div class="mb-3">
            <label class="fw-semibold">Pesan:</label>
            <p><?= nl2br(htmlspecialchars($message['message'])) ?></p>
        </div>
        <div class="mb-3">
            <label class="fw-semibold">Tanggal Diterima:</label>
            <p><?= date("d M Y H:i", strtotime($message['created_at'])) ?></p>
        </div>
        <a href="messages.php" class="btn btn-primary"><i class="fa fa-arrow-left me-1"></i> Kembali ke Pesan</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
