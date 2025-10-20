<?php
session_start();

require 'config.php'; // pastikan ini path yang benar dan $pdo sudah didefinisikan

// Cek session login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil data artikel
try {
    $stmt = $pdo->query("SELECT * FROM artikel ORDER BY created_at DESC");
    $articles = $stmt->fetchAll();
} catch (PDOException $e) {
    exit("Gagal mengambil data artikel: " . $e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen Artikel</title>

  <!-- Favicon -->
  <link rel="icon" href="../img/favicon.png" type="image/png" />
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fb;
      font-family: 'Poppins', sans-serif;
    }

    /* === SIDEBAR === */
    :root {
  --primary: #0d6efd; /* biru bootstrap */
}

    .sidebar {
      position: fixed;
      left: 0;
      top: 0;
      width: 250px;
      height: 100vh;
      background: #fff;
      box-shadow: 3px 0 15px rgba(0, 0, 0, 0.05);
      padding: 30px 20px;
      display: flex;
      flex-direction: column;
      transition: 0.3s;
    }

    .sidebar .logo {
      text-align: center;
      margin-bottom: 40px;
    }

    .sidebar .logo img {
      width: 140px;
      height: auto;
      object-fit: contain;
    }

    .sidebar a {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 18px;
      color: #555;
      border-radius: 10px;
      font-size: 15px;
      text-decoration: none;
      margin-bottom: 8px;
      transition: all 0.3s;
    }

    .sidebar a i {
      font-size: 17px;
    }

    .sidebar a:hover, .sidebar a.active {
      background: var(--primary);
      color: white;
      box-shadow: 0 4px 10px rgba(13, 110, 253, 0.2);
    }

    .logout-link {
      margin-top: auto;
      color: #dc3545;
      font-weight: 500;
    }

    .logout-link:hover {
      color: #b02a37;
    }


    .main-content { margin-left: 260px; padding: 30px; }

    .btn-primary {
      background-color: #0d6efd;
      border: none;
      border-radius: 10px;
      font-weight: 500;
    }

    .btn-primary:hover { background-color: #005ce6; }

    .table th { background-color: #0d6efd; color: white; }

    .table img { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; }

    .card { border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
  </style>
</head>
<body>

  <!-- SIDEBAR -->
  <div class="sidebar">
    <div class="logo text-center">
      <img src="../img/favicon.png" alt="Logo">
    </div>
    <a href="index.php"><i class="fa-solid fa-home"></i> Dashboard</a>
    <a href="artikel.php" class="active"><i class="fa-solid fa-file-alt"></i> Artikel</a>
    <a href="messages.php"><i class="fa-solid fa-envelope"></i> Pesan</a>
    <div class="mt-auto pt-3">
      <a href="logout.php" style="color:#dc3545;"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
  </div>

  <!-- NOTIFIKASI -->
  <?php if (isset($_SESSION['message'])): ?>
  <div class="alert alert-<?= $_SESSION['message']['type'] ?> alert-dismissible fade show" role="alert" style="margin-left: 260px; margin-top: 20px;">
    <?= $_SESSION['message']['text'] ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php unset($_SESSION['message']); ?>
  <?php endif; ?>

  <!-- MAIN CONTENT -->
  <div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="fw-semibold text-primary"><i class="fa-solid fa-file-alt me-2"></i> Manajemen Artikel</h3>
      <a href="artikel_tambah.php" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i> Tambah Artikel</a>
    </div>

    <div class="card p-3">
      <table class="table table-bordered align-middle">
        <thead>
          <tr class="text-center">
            <th width="5%">No</th>
            <th>Gambar</th>
            <th>Judul</th>
            <th>Deskripsi</th>
            <th>Tanggal Dibuat</th>
            <th width="20%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          foreach ($articles as $row):
          ?>
          <tr>
            <td class="text-center"><?= $no++; ?></td>
            <td class="text-center">
              <?php if (!empty($row['image'])): ?>
                <img src="uploads/artikel/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
              <?php else: ?>
                <img src="https://via.placeholder.com/60?text=No+Image" alt="no image">
              <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars(substr($row['description'], 0, 70)) ?>...</td>
            <td><?= date("d M Y", strtotime($row['created_at'])) ?></td>
            <td class="text-center">
              <a href="artikel_detail.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
              <a href="artikel_edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
              <a href="artikel_hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus artikel ini?')"><i class="fa fa-trash"></i></a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
