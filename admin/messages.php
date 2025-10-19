<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include 'config.php';

// Ambil semua pesan, urut dari terbaru
$result = $conn->query("SELECT * FROM messages ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pesan Masuk</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
body { background: #f8f9fb; font-family: 'Poppins', sans-serif; }

.sidebar {
    position: fixed;
    left: 0;
    top: 0;
    width: 250px;
    height: 100vh;
    background: #fff;
    box-shadow: 3px 0 15px rgba(0,0,0,0.05);
    padding: 30px 20px;
    display: flex;
    flex-direction: column;
}

.sidebar .logo { text-align: center; margin-bottom: 40px; }
.sidebar .logo img { width: 140px; height: auto; }

.sidebar a { display:flex; align-items:center; gap:12px; padding:12px 18px; color:#555; border-radius:10px; font-size:15px; text-decoration:none; margin-bottom:8px; transition:0.3s; }
.sidebar a i { font-size:17px; }
.sidebar a:hover, .sidebar a.active { background:#0d6efd; color:white; }

.logout-link { margin-top:auto; color:#dc3545; font-weight:500; }
.logout-link:hover { color:#b02a37; }

.main-content { margin-left: 260px; padding: 30px; }

.card { border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
.table th { background-color: #0d6efd; color: white; }
.btn-primary, .btn-info, .btn-danger { border-radius: 8px; font-weight: 500; }
.btn-primary { background-color: #0d6efd; border: none; }
.btn-primary:hover { background-color: #005ce6; }
.btn-info { background-color: #17a2b8; border: none; color:white; }
.btn-info:hover { background-color: #138496; }
.btn-danger { background-color: #dc3545; border: none; color:white; }
.btn-danger:hover { background-color: #b02a37; }
</style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="logo text-center">
        <img src="../img/logo.png" alt="Logo">
    </div>
    <a href="index.php"><i class="fa-solid fa-home"></i> Dashboard</a>
    <a href="produk.php"><i class="fa-solid fa-box"></i> Produk</a>
    <a href="artikel.php"><i class="fa-solid fa-file-alt"></i> Artikel</a>
    <a href="messages.php" class="active"><i class="fa-solid fa-envelope"></i> Pesan</a>
    <div class="mt-auto pt-3">
        <a href="logout.php" style="color:#dc3545;"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-semibold text-primary"><i class="fa-solid fa-envelope me-2"></i> Pesan Masuk</h3>
    </div>

    <div class="card p-3">
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
                <?php
                $no = 1;
                while($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <td class="text-center"><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['phone']) ?></td>
                    <td><?= htmlspecialchars(substr($row['message'],0,70)) ?>...</td>
                    <td><?= date("d M Y H:i", strtotime($row['created_at'])) ?></td>
                    <td class="text-center">
                        <a href="messages_detail.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm" title="Lihat"><i class="fa fa-eye"></i></a>
                        <a href="messages_hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin menghapus pesan ini?')"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
