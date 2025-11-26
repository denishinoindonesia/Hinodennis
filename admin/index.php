<?php
// Pastikan config.php sudah di-include untuk koneksi database
include 'config.php';  // Sesuaikan dengan lokasi file config.php kamu

// Ambil jumlah artikel
$artikelQuery = "SELECT COUNT(*) FROM artikel";
$totalArtikel = fetchOnePrepared($pdo, $artikelQuery)['COUNT(*)'];

// Ambil jumlah pesan customer
$pesanQuery = "SELECT COUNT(*) FROM messages";
$totalPesanCustomer = fetchOnePrepared($pdo, $pesanQuery)['COUNT(*)'];
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin</title>

  <!-- Favicon -->
  <link rel="icon" href="../img/favicon.png" type="image/png" />

  <!-- CSS & ICONS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/admin.css?v=2">
</head>

<body>

  <!-- HAMBURGER TOGGLE & OVERLAY -->
  <button class="menu-toggle"><i class="fa-solid fa-bars"></i></button>
  <div class="overlay"></div>

  <!-- SIDEBAR -->
  <div class="sidebar">
    <div class="logo">
      <img src="../img/favicon.png" alt="Logo">
    </div>

    <a href="index.php" class="active"><i class="fa-solid fa-house"></i> Dashboard</a>
    <a href="artikel.php"><i class="fa-solid fa-file-lines"></i> Artikel</a>
    <a href="messages.php"><i class="fa-solid fa-envelope"></i> Pesan</a>
    <a href="ganti_password.php"><i class="fa-solid fa-envelope"></i> Ganti Password</a>

    <a href="logout.php" class="logout-link"><i class="fa-solid fa-right-from-bracket"></i> Log Out</a>
  </div>

  <!-- MAIN CONTENT -->
  <div class="main-content">
    <div class="main-header mb-4">
      <h3>Selamat Datang, <span class="text-primary">Admin 👋</span></h3>
      <p class="text-muted">Panel Admin Hino — Didesain untuk kemudahan & kecepatan kerja.</p>
    </div>

    <div class="row g-4">
      <div class="col-md-4">
        <div class="stat-card">
          <div class="stat-icon icon-artikel"><i class="fa-solid fa-file-lines"></i></div>
          <div class="stat-info">
            <h6>Total Artikel</h6>
            <h3><?php echo $totalArtikel; ?></h3>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="stat-card">
          <div class="stat-icon icon-messages"><i class="fa-solid fa-envelope"></i></div>
          <div class="stat-info">
            <h6>Pesan Customer</h6>
            <h3><?php echo $totalPesanCustomer; ?></h3>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- JS -->
  <script src="js/admin.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
