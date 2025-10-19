<?php
session_start();
if (!isset($_SESSION['admin'])) { 
    header("Location: login.php"); 
    exit; 
}
include 'config.php';

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM artikel WHERE id=$id");
$article = $result->fetch_assoc();

if (!$article) {
    $_SESSION['message'] = ['type'=>'danger','text'=>'Artikel tidak ditemukan.'];
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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
:root { --primary: #0d6efd; --accent: #f4f6fb; --text-dark: #2e2e2e; --card-bg: #fff; }
body { font-family:'Poppins',sans-serif; background: var(--accent); color: var(--text-dark); margin:0; overflow-x:hidden; }
.sidebar { position: fixed; left:0; top:0; width:250px; height:100vh; background:#fff; box-shadow:3px 0 15px rgba(0,0,0,0.05); padding:30px 20px; display:flex; flex-direction:column; }
.sidebar .logo { text-align:center; margin-bottom:40px; }
.sidebar .logo img { width:140px; height:auto; }
.sidebar a { display:flex; align-items:center; gap:12px; padding:12px 18px; color:#555; border-radius:10px; font-size:15px; text-decoration:none; margin-bottom:8px; transition:all 0.3s; }
.sidebar a i { font-size:17px; }
.sidebar a:hover, .sidebar a.active { background:var(--primary); color:white; box-shadow:0 4px 10px rgba(13,110,253,0.2); }
.logout-link { margin-top:auto; color:#dc3545; font-weight:500; }
.logout-link:hover { color:#b02a37; }
.main-content { margin-left:270px; padding:40px 50px; }
.main-header { margin-bottom:40px; }
.main-header h3 { font-weight:700; color: var(--primary);}
.card-detail { background: var(--card-bg); border-radius:16px; padding:30px; box-shadow:0 4px 14px rgba(0,0,0,0.06); }
img.article-image { width: 100%; max-width: 400px; border-radius: 10px; margin-bottom: 20px; }
.btn-primary { background-color: var(--primary); border-radius:10px; border:none; }
</style>
</head>
<body>

<div class="sidebar">
  <div class="logo"><img src="../img/logo.png" alt="Logo"></div>
  <a href="index.php"><i class="fa-solid fa-house"></i> Dashboard</a>
  <a href="produk.php"><i class="fa-solid fa-box"></i> Produk</a>
  <a href="artikel.php" class="active"><i class="fa-solid fa-file-alt"></i> Artikel</a>
  <a href="messages.php"><i class="fa-solid fa-envelope"></i> Pesan</a>
  <a href="logout.php" class="logout-link"><i class="fa-solid fa-right-from-bracket"></i> Log Out</a>
</div>

<div class="main-content">
  <div class="main-header">
    <h3>Detail Artikel</h3>
    <p class="text-muted">Informasi lengkap artikel.</p>
  </div>

  <div class="card-detail">
    <h4><?= htmlspecialchars($article['title']) ?></h4>
    <p class="text-muted">Tanggal Dibuat: <?= date("d M Y", strtotime($article['created_at'])) ?></p>
    
    <?php if(!empty($article['image'])): ?>
        <img src="uploads/artikel/<?= $article['image'] ?>" class="article-image" alt="<?= htmlspecialchars($article['title']) ?>">
    <?php else: ?>
        <img src="https://via.placeholder.com/400x250?text=No+Image" class="article-image" alt="No Image">
    <?php endif; ?>

    <p><?= nl2br(htmlspecialchars($article['description'])) ?></p>

    <a href="artikel.php" class="btn btn-primary"><i class="fa fa-arrow-left me-1"></i> Kembali</a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
