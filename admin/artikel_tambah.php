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
<link rel="stylesheet" href="css/admin.css">
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
.card-form { background: var(--card-bg); border-radius:16px; padding:30px; box-shadow:0 4px 14px rgba(0,0,0,0.06); }
.card-form h4 { margin-bottom:25px; color:var(--primary); font-weight:700; }
.btn-primary { background-color: var(--primary); border-radius:10px; border:none; }
.btn-secondary { border-radius:10px; }
</style>
</head>

<body>

<button class="menu-toggle"><i class="fa-solid fa-bars"></i></button>
<div class="overlay"></div>
<div class="sidebar">
  <div class="logo"><img src="../img/favicon.png" alt="Logo"></div>
  <a href="index.php"><i class="fa-solid fa-house"></i> Dashboard</a>
  <a href="artikel.php" class="active"><i class="fa-solid fa-file-alt"></i> Artikel</a>
  <a href="messages.php"><i class="fa-solid fa-envelope"></i> Pesan</a>
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
