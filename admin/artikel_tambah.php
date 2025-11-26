<?php
session_start();
require 'config.php'; // pastikan koneksi PDO ($pdo) sudah benar

// Cek session login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// =============================
//  Ambil daftar kategori
// =============================
try {
    $stmt = $pdo->query("SELECT id, nama_kategori FROM kategori ORDER BY nama_kategori ASC");
    $kategoriList = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    exit("Gagal mengambil data kategori: " . $e->getMessage());
}

// =============================
//  Proses Simpan Artikel Baru
// =============================
if (isset($_POST['submit'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $kategori_id = $_POST['kategori_id'] ?? null;
    $image = '';

    // Upload gambar (jika ada)
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/artikel/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);

        $fileName = time() . '_' . basename($_FILES['image']['name']);
        $targetFilePath = $targetDir . $fileName;

        // Validasi ekstensi file
        $allowedTypes = ['jpg', 'jpeg', 'png', 'webp'];
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                $image = $fileName;
            }
        }
    }

    // Simpan data artikel
    try {
        $sql = "INSERT INTO artikel (judul, isi, gambar, tanggal, kategori_id) 
                VALUES (:judul, :isi, :gambar, NOW(), :kategori_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':judul' => $title,
            ':isi' => $description,
            ':gambar' => $image,
            ':kategori_id' => $kategori_id
        ]);

        $_SESSION['message'] = ['type' => 'success', 'text' => 'Artikel berhasil ditambahkan!'];
    } catch (Exception $e) {
        error_log("Gagal menambahkan artikel: " . $e->getMessage());
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Gagal menambahkan artikel.'];
    }

    header("Location: artikel.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tambah Artikel</title>

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
  <a href="index.php"><i class="fa-solid fa-house"></i> Dashboard</a>
  <a href="artikel.php" class="active"><i class="fa-solid fa-file-alt"></i> Artikel</a>
  <a href="messages.php"><i class="fa-solid fa-envelope"></i> Pesan</a>
  <a href="ganti_password.php"><i class="fa-solid fa-envelope"></i> Ganti Password</a>
  <a href="logout.php" class="logout-link"><i class="fa-solid fa-right-from-bracket"></i> Log Out</a>
</div>

<div class="main-content">
  <div class="main-header">
    <h3>Tambah Artikel Baru</h3>
    <p class="text-muted">Isi form berikut untuk menambahkan artikel baru.</p>
  </div>

  <div class="card-form">
    <form method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label class="form-label">Judul</label>
        <input type="text" name="title" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Deskripsi</label>
        <textarea name="description" class="form-control" rows="5" required></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Kategori</label>
        <select name="kategori_id" class="form-select" required>
          <option value="">-- Pilih Kategori --</option>
          <?php foreach ($kategoriList as $kategori): ?>
            <option value="<?= htmlspecialchars($kategori['id']) ?>">
              <?= htmlspecialchars($kategori['nama_kategori']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Gambar (opsional)</label>
        <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png,.webp">
      </div>

      <div class="text-end">
        <a href="artikel.php" class="btn btn-secondary">Batal</a>
        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<script src="js/admin.js"></script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
