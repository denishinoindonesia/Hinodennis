<?php
session_start();
require 'config.php'; // pastikan $pdo aktif

// Cek session login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Validasi ID
$id = $_GET['id'] ?? null;
if (!$id || !ctype_digit($id)) {
    $_SESSION['message'] = ['type' => 'danger', 'text' => 'ID artikel tidak valid.'];
    header("Location: artikel.php");
    exit;
}

// Ambil data artikel + kategori
$sql = "SELECT a.*, k.nama_kategori 
        FROM artikel a 
        LEFT JOIN kategori k ON a.kategori_id = k.id 
        WHERE a.id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$article) {
    $_SESSION['message'] = ['type' => 'danger', 'text' => 'Artikel tidak ditemukan.'];
    header("Location: artikel.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detail Artikel</title>

<link rel="icon" href="../img/favicon.png" type="image/png" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/admin.css?v=2">

</head>
<body>

<button class="menu-toggle"><i class="fa-solid fa-bars"></i></button>
<div class="overlay"></div>

<div class="sidebar">
  <div class="logo"><img src="../img/favicon.png" alt="Logo"></div>
    <a href="index.php" class="active"><i class="fa-solid fa-house"></i> Dashboard</a>
    <a href="artikel.php"><i class="fa-solid fa-file-lines"></i> Artikel</a>
    <a href="messages.php"><i class="fa-solid fa-envelope"></i> Pesan</a>
    <a href="ganti_password.php"><i class="fa-solid fa-envelope"></i> Ganti Password</a>
</div>

<div class="main-content">
  <div class="main-header">
    <h3>Detail Artikel</h3>
    <p class="text-muted">Informasi lengkap artikel.</p>
  </div>

  <div class="card-detail">
    <h4><?= htmlspecialchars($article['judul']) ?></h4>

    <?php if (!empty($article['nama_kategori'])): ?>
      <span class="badge-category"><i class="fa-solid fa-tag me-1"></i> <?= htmlspecialchars($article['nama_kategori']) ?></span>
    <?php endif; ?>

    <p class="text-muted">Tanggal Dibuat: <?= date("d M Y", strtotime($article['tanggal'])) ?></p>

    <?php if (!empty($article['gambar'])): ?>
        <img src="uploads/artikel/<?= htmlspecialchars($article['gambar']) ?>" class="article-image" alt="<?= htmlspecialchars($article['judul']) ?>">
    <?php else: ?>
        <img src="https://via.placeholder.com/400x250?text=No+Image" class="article-image" alt="No Image">
    <?php endif; ?>

    <p><?= nl2br(htmlspecialchars($article['isi'])) ?></p>

    <a href="artikel.php" class="btn btn-primary"><i class="fa fa-arrow-left me-1"></i> Kembali</a>
  </div>
</div>

<script src="js/admin.js"></script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
