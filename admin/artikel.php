<?php
session_start();
require 'config.php'; // pastikan sudah ada koneksi $pdo

// Cek login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil data artikel + kategori
try {
    $sql = "SELECT a.*, k.nama_kategori AS kategori_nama 
            FROM artikel a 
            LEFT JOIN kategori k ON a.kategori_id = k.id 
            ORDER BY a.id DESC";
    $stmt = $pdo->query($sql);
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

  <!-- NOTIFIKASI -->
  <?php if (isset($_SESSION['message'])): ?>
  <div class="alert alert-<?= $_SESSION['message']['type'] ?> alert-dismissible fade show" role="alert" style="margin-left: 260px; margin-top: 20px;">
    <?= htmlspecialchars($_SESSION['message']['text']) ?>
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
      <div class="table-responsive">
        <table class="table table-bordered align-middle">
          <thead>
            <tr class="text-center">
              <th width="5%">No</th>
              <th>Gambar</th>
              <th>Judul</th>
              <th>Kategori</th>
              <th>Deskripsi</th>
              <th>Tanggal Dibuat</th>
              <th width="20%">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (count($articles) > 0):
                $no = 1;
                foreach ($articles as $row):
            ?>
            <tr>
              <td class="text-center"><?= $no++; ?></td>
              <td class="text-center">
                <?php if (!empty($row['gambar'])): ?>
                  <img src="uploads/artikel/<?= htmlspecialchars($row['gambar']) ?>" alt="<?= htmlspecialchars($row['judul']) ?>">
                <?php else: ?>
                  <img src="https://via.placeholder.com/60?text=No+Image" alt="no image">
                <?php endif; ?>
              </td>
              <td><?= htmlspecialchars($row['judul']) ?></td>
              <td class="text-center"><?= htmlspecialchars($row['kategori_nama'] ?? '-') ?></td>
              <td><?= htmlspecialchars(substr(strip_tags($row['isi']), 0, 70)) ?>...</td>
              <td><?= date("d M Y", strtotime($row['tanggal'])) ?></td>
              <td class="text-center">
                <a href="artikel_detail.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                <a href="artikel_edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                <a href="artikel_hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus artikel ini?')"><i class="fa fa-trash"></i></a>
              </td>
            </tr>
            <?php
                endforeach;
            else:
            ?>
            <tr><td colspan="7" class="text-center text-muted">Belum ada artikel.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

<script src="js/admin.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
