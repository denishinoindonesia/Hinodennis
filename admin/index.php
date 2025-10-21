<?php
// Setting session (bisa di sini supaya lebih aman)
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
// ini_set('session.cookie_secure', 1); // aktifkan kalau pakai HTTPS

session_start();

require 'config.php'; // file config.php dengan PDO $pdo di atas

// Cek session login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil data total artikel dan pesan
$total_artikel = 0;
$total_messages = 0;

try {
    $row = fetchOnePrepared($pdo, "SELECT COUNT(*) AS total FROM artikel");
    if ($row) $total_artikel = $row['total'];

    $row = fetchOnePrepared($pdo, "SELECT COUNT(*) AS total FROM messages");
    if ($row) $total_messages = $row['total'];
} catch (Exception $e) {
    echo "⚠️ Error: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin</title>

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
    <div class="logo">
      <img src="../img/favicon.png" alt="Logo">
    </div>

    <a href="index.php" class="active"><i class="fa-solid fa-house"></i> Dashboard</a>
    <a href="artikel.php"><i class="fa-solid fa-file-lines"></i> Artikel</a>
    <a href="messages.php"><i class="fa-solid fa-envelope"></i> Pesan</a>

    <a href="logout.php" class="logout-link"><i class="fa-solid fa-right-from-bracket"></i> Log Out</a>
  </div>

  <!-- MAIN CONTENT -->
  <div class="main-content">
    <div class="main-header">
      <h3>Selamat Datang, <?php echo $_SESSION['admin_username']; ?> 👋</h3>
      <p class="text-muted">Panel Admin Hino — Didesain untuk kemudahan & kecepatan kerja.</p>
    </div>

      <div class="col-md-4">
        <div class="stat-card">
          <div class="stat-icon icon-artikel"><i class="fa-solid fa-file-lines"></i></div>
          <div class="stat-info">
            <h6>Total Artikel</h6>
            <h3><?php echo $total_artikel; ?></h3>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="stat-card">
          <div class="stat-icon icon-messages"><i class="fa-solid fa-envelope"></i></div>
          <div class="stat-info">
            <h6>Pesan Customer</h6>
            <h3><?php echo $total_messages; ?></h3>
          </div>
        </div>
      </div>
    </div>
  </div>

<script src="js/admin.js"></script>

</body>
</html>
