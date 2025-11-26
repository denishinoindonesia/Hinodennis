<?php
session_start();
require 'config.php';

// Cek login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil ID
$id = intval($_GET['id'] ?? 0);

// Ambil data artikel
$stmt = $pdo->prepare("SELECT * FROM artikel WHERE id = ?");
$stmt->execute([$id]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$article) {
    $_SESSION['message'] = ['type' => 'danger', 'text' => 'Artikel tidak ditemukan.'];
    header("Location: artikel.php");
    exit;
}

// Ambil kategori
$kategoriStmt = $pdo->query("SELECT id, nama_kategori FROM kategori ORDER BY nama_kategori ASC");
$kategoriList = $kategoriStmt->fetchAll(PDO::FETCH_ASSOC);

// Update data
if (isset($_POST['update'])) {
    $judul = trim($_POST['judul']);
    $isi = trim($_POST['isi']);
    $kategori_id = intval($_POST['kategori_id']);
    $gambar = $article['gambar']; // gunakan gambar lama jika tidak upload baru

    // Upload gambar baru
    if (!empty($_FILES['gambar']['name'])) {
        $targetDir = "uploads/artikel/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);

        $fileName = time() . '_' . basename($_FILES['gambar']['name']);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFilePath)) {
            $gambar = $fileName;
        }
    }

    try {
        $sql = "UPDATE artikel 
                SET judul = ?, isi = ?, gambar = ?, kategori_id = ? 
                WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$judul, $isi, $gambar, $kategori_id, $id]);

        $_SESSION['message'] = ['type' => 'success', 'text' => 'Artikel berhasil diperbarui!'];
    } catch (Exception $e) {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Gagal memperbarui artikel: ' . $e->getMessage()];
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
<title>Edit Artikel</title>
<link rel="icon" href="../img/favicon.png" type="image/png" />
<link rel="stylesheet" href="css/admin.css">
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
  <h3 class="mb-3 text-primary">Edit Artikel</h3>

  <div class="card-form">
    <form method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label class="form-label">Judul</label>
        <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($article['judul']) ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Isi Artikel</label>
        <textarea name="isi" class="form-control" rows="6" required><?= htmlspecialchars($article['isi']) ?></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Kategori</label>
        <select name="kategori_id" class="form-control" required>
          <option value="">-- Pilih Kategori --</option>
          <?php foreach ($kategoriList as $kat): ?>
            <option value="<?= $kat['id'] ?>" <?= ($article['kategori_id'] == $kat['id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($kat['nama_kategori']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Gambar Saat Ini</label><br>
        <?php if (!empty($article['gambar'])): ?>
          <img src="uploads/artikel/<?= htmlspecialchars($article['gambar']) ?>" style="width:120px;border-radius:8px;">
        <?php else: ?>
          <img src="https://via.placeholder.com/120?text=No+Image" style="width:120px;border-radius:8px;">
        <?php endif; ?>
        <input type="file" name="gambar" class="form-control mt-2">
      </div>

      <div class="text-end">
        <a href="artikel.php" class="btn btn-secondary">Batal</a>
        <button type="submit" name="update" class="btn btn-primary">Update</button>
      </div>
    </form>
  </div>
</div>


<script src="js/admin.js"></script>

</body>
</html>
