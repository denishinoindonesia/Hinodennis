<?php
// Ambil data artikel dan kategori dari API
$kategoriData = json_decode(file_get_contents("https://official-hino.com/admin/api/get_kategori.php"), true);
$search = $_GET['search'] ?? '';
$selectedKategori = $_GET['kategori'] ?? '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 6;

// Bangun URL API dengan filter jika ada
$apiUrl = "https://official-hino.com/admin/api/get_artikel.php";
$params = [];
if ($search !== '') {
  $params[] = "search=" . urlencode($search);
}
if ($selectedKategori !== '') {
  $params[] = "kategori=" . urlencode($selectedKategori);
}
if (!empty($params)) {
  $apiUrl .= '?' . implode('&', $params);
}

$artikelData = json_decode(file_get_contents($apiUrl), true);
$totalArtikel = is_array($artikelData) ? count($artikelData) : 0;
$totalPages = ceil($totalArtikel / $perPage);
$offset = ($page - 1) * $perPage;
$artikel = array_slice($artikelData, $offset, $perPage);
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Info dan Promo Truk Hino Terbaru | Hino Official</title>
    <meta name="description" content="Hino Official - Dealer Truck Hino Tangerang. Hubungi : 0812 1905 5571 Untuk mendapatkan informasi produk Hino. Layanan Terbaik dan Jaminan Mutu." />
    <link rel="icon" type="image/png" href="/img/favicon.png" />
    <!-- Meta Keywords -->
    <meta name="keywords" content="sales Hino, sales Hino Jakarta, sales Hino Jabodetabek, sales Hino Tangerang, sales Hino Bekasi, sales Hino Depok, sales Hino Bogor, sales truck Hino, dealer Hino, dealer Hino Jabodetabek, dealer Hino Tangerang, dealer Hino Bekasi, dealer Hino Depok, dealer Hino Bogor, dealer truck Hino, dealer Hino resmi, dealer Hino Jakarta, dealer Hino Indonesia, jual truk Hino, kredit truk Hino, cicilan truk Hino, promo truk Hino, harga truk Hino terbaru, diskon truk Hino, truk Hino Dutro, truk Hino 300, truk Hino 500, Hino Dutro 136 HD, Hino Dutro 4x4, Hino Dutro box, Hino Dutro engkel, spesifikasi Hino Dutro, modifikasi truk Hino, gambar truk Hino, keunggulan truk Hino, truk Hino untuk bisnis, truk Hino untuk logistik, perbandingan truk Hino dan Isuzu Elf, dealer truk Hino termurah, dealer truk hino tangerang, dealer hino cikupa, hino cikupa, dealer hino tangerang murah" />
      <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-8BPF492E6Z"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-8BPF492E6Z');
    </script>

    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/navbar.css" />
    <link rel="stylesheet" href="css/home_css/header.css" />
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="css/home_css/blogcard.css" />
    <link rel="stylesheet" href="css/blog.css" />
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
      .blog-filter {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: center;
      }
      .blog-filter input, .blog-filter select {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 16px;
      }
      .blog-filter button {
        padding: 10px 20px;
        background-color: #007e33;
        color: #fff;
        border: none;
        border-radius: 8px;
        cursor: pointer;
      }
      .pagination {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 30px;
      }
      .pagination a {
        padding: 8px 16px;
        background: #eee;
        text-decoration: none;
        border-radius: 6px;
        color: #333;
      }
      .pagination a.active {
        background-color: #007e33;
        color: #fff;
      }
    </style>

    <!-- Scripts -->
    <script src="js/script.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>

  </head>
  <body>
    <!-- Header -->
    <header>
      <div class="container header-content navbar">
    <!-- Logo -->
    <div class="header-title">
      <a href="https://official-hino.com">
        <img src="img/logo3.png" alt="Logo Hino" style="height: 60px" />
      </a>
    </div>

        <div class="hamburger-menu">&#9776;</div>
        <nav class="nav links">
          <a href="index.php">Home</a>
          <a href="hino300.php">Hino 300 Series</a>
          <a href="hino500.php">Hino 500 Series</a>
          <a href="hinobus.php">Hino Bus Series</a>
          <a href="artikel.php">Blog & Artikel</a>
          <a href="contact.php">Contact</a>
        </nav>
      </div>
    </header>

    <!-- Hero Banner -->
    <section class="hero-banner" style="position: relative; overflow: hidden;">
      <img src="img/Euro 4 Hino 300.jpeg" alt="Banner Artikel Hino" style="width: 100%; height: auto; max-height: 400px; object-fit: cover;">
      <div style="
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.7));
        display: flex;
        justify-content: center;
        align-items: center;
      ">
        <h1 style="color: white; font-size: 36px; font-weight: bold;">Blog & Artikel Hino Indonesia</h1>
      </div>
    </section>


    <!-- Blog Filter -->
    <section class="content-section">
      <div class="container">

        <form method="get" class="blog-filter" style="margin-bottom: 20px;">
          <input 
            type="text" 
            name="search" 
            placeholder="Cari artikel..." 
            value="<?= htmlspecialchars($search) ?>" 
          />
          <select name="kategori" onchange="this.form.submit()">
            <option value="">Semua Kategori</option>
            <option value="">Berita Dealer</option>
            <option value="">Promo Hino</option>
            <?php if (is_array($kategoriData)): ?>
              <?php foreach ($kategoriData as $kat): ?>
                <option value="<?= htmlspecialchars($kat['nama_kategori']) ?>" <?= $selectedKategori === $kat['nama_kategori'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($kat['nama_kategori']) ?>
                </option>
              <?php endforeach; ?>
            <?php endif; ?>
          </select>
          <button type="submit">Filter</button>
        </form>


        <div class="blog-grid">
          <?php if (is_array($artikel) && count($artikel) > 0): ?>
            <?php foreach ($artikel as $row): ?>
              <div class="blog-post">
                <img src="<?= htmlspecialchars($row['gambar']) ?>" alt="<?= htmlspecialchars($row['judul']) ?>">
                <h2>
                  <a href="detail_artikel.php?id=<?= urlencode($row['id']) ?>">
                    <?= htmlspecialchars($row['judul']) ?>
                  </a>
                </h2>
                <p><?= substr(strip_tags($row['isi']), 0, 100) ?>...</p>
                <div class="card-footer">
                  <a href="detail_artikel.php?id=<?= urlencode($row['id']) ?>">Baca Selengkapnya</a>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p>Tidak ada artikel yang ditemukan.</p>
          <?php endif; ?>
        </div>

        <!-- Pagination -->
        <div class="pagination">
          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a class="<?= $i === $page ? 'active' : '' ?>" href="?search=<?= urlencode($search) ?>&kategori=<?= urlencode($selectedKategori) ?>&page=<?= $i ?>">
              <?= $i ?>
            </a>
          <?php endfor; ?>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

<!-- Elfsight WhatsApp Chat | Untitled WhatsApp Chat -->
<script src="https://static.elfsight.com/platform/platform.js" async></script>
<div class="elfsight-app-1c150e27-6597-4113-becd-79df393b9756" data-elfsight-app-lazy></div>

    <script>feather.replace();</script>
  </body>
</html>
