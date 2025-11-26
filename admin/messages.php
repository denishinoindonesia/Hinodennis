<?php
session_start();

require 'config.php'; // pastikan $pdo sudah didefinisikan dengan benar

// Cek session login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

try {
    // Ambil semua pesan dari database, urut dari terbaru
    $stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC");
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['message'] = ['type' => 'danger', 'text' => 'Gagal mengambil data pesan: ' . $e->getMessage()];
    $messages = [];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Pesan Masuk</title>

<!-- Favicon -->
<link rel="icon" href="../img/favicon.png" type="image/png" />

<link rel="stylesheet" href="css/admin.css">


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
<link rel="stylesheet" href="css/admin.css?v=2">

</head>
<body>

<button class="menu-toggle"><i class="fa-solid fa-bars"></i></button>
<div class="overlay"></div>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="logo text-center">
        <img src="../img/favicon.png" alt="Logo" />
    </div>
    <a href="index.php" class="active"><i class="fa-solid fa-house"></i> Dashboard</a>
    <a href="artikel.php"><i class="fa-solid fa-file-lines"></i> Artikel</a>
    <a href="messages.php"><i class="fa-solid fa-envelope"></i> Pesan</a>
    <a href="ganti_password.php"><i class="fa-solid fa-line"></i> Ganti Password</a>
    <div class="mt-auto pt-3">
        <a href="logout.php" class="logout-link"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
</div>

<!-- ALERT / NOTIF -->
<?php if (isset($_SESSION['message'])): ?>
<div class="alert alert-<?= $_SESSION['message']['type'] ?> alert-dismissible fade show"
     role="alert" style="margin-left:260px; margin-top:20px;">
  <?= htmlspecialchars($_SESSION['message']['text']) ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php unset($_SESSION['message']); endif; ?>

<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-semibold text-primary">
            <i class="fa-solid fa-envelope me-2"></i> Pesan Masuk
        </h3>
    </div>

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr class="text-center">
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>Nomor Pengirim</th>
                        <th>Pesan</th>
                        <th>Tanggal</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($messages) === 0): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">Belum ada pesan masuk.</td>
                    </tr>
                    <?php else: ?>
                    <?php $no = 1; foreach ($messages as $row): ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td><?= htmlspecialchars($row['name']); ?></td>
                        <td><?= htmlspecialchars($row['phone']); ?></td>
                        <td><?= htmlspecialchars(mb_strimwidth($row['message'], 0, 70, '...')); ?></td>
                        <td><?= date("d M Y H:i", strtotime($row['created_at'])); ?></td>
                        <td class="text-center">
                            <a href="messages_detail.php?id=<?= $row['id']; ?>" class="btn btn-info btn-sm" title="Lihat">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="messages_hapus.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" title="Hapus"
                            onclick="return confirm('Yakin ingin menghapus pesan ini?')">
                            <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
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
