<?php
$kategoriData = json_decode(
    file_get_contents("https://official-hino.com/admin/api/get_kategori.php"),
    true
);

$search = $_GET['search'] ?? '';
$selectedKategori = $_GET['kategori'] ?? '';
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 6;

// Bangun URL API
$apiUrl = "https://official-hino.com/admin/api/get_artikel.php";
$params = [];

if ($search !== '') {
    $params[] = "search=" . urlencode($search);
}
if ($selectedKategori !== '') {
    $params[] = "kategori=" . urlencode($selectedKategori);
}

if ($params) {
    $apiUrl .= '?' . implode('&', $params);
}

// Ambil data artikel
$artikelData = json_decode(file_get_contents($apiUrl), true);
if (!is_array($artikelData)) {
    $artikelData = [];
}

// Pagination manual
$totalArtikel = count($artikelData);
$totalPages   = ceil($totalArtikel / $perPage);
$offset       = ($page - 1) * $perPage;
$artikel      = array_slice($artikelData, $offset, $perPage);
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- ✅ SEO Title (Artikel / Blog) -->
    <title>Artikel & Promo Truk Hino Terbaru | Dealer Hino Tangerang</title>

    <!-- ✅ Meta Description (Informatif + CTA Halus) -->
    <meta name="description" content="Artikel terbaru seputar truk Hino: harga, promo, spesifikasi Hino Dutro, Hino 300 & 500 Series. Update resmi dari Dealer Hino Tangerang Jabodetabek." />

    <!-- ✅ Meta Keywords (khusus artikel, tidak spam) -->
    <meta name="keywords" content="artikel hino, berita hino, promo truk hino, harga truk hino terbaru, spesifikasi hino dutro, hino 300, hino 500, dealer hino tangerang, hino dutro, hino ranger, dealer hino cikupa, dealer resmi hino tangerang, hino tangerang" />

    <!-- ✅ Canonical -->
    <link rel="canonical" href="https://official-hino.com/artikel" />

    <!-- ✅ Favicon -->
    <link rel="icon" type="image/png" href="/favicon_512.png" />

    <!-- ✅ Open Graph (Share Sosial Media) -->
    <meta property="og:site_name" content="Dealer Hino Tangerang" />
    <meta property="og:title" content="Artikel & Promo Truk Hino Terbaru" />
    <meta property="og:description" content="Update artikel Hino terbaru: harga, promo, dan spesifikasi truk Hino resmi dari Dealer Hino Tangerang." />
    <meta property="og:url" content="https://official-hino.com/artikel" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="https://official-hino.com/img/hino300produk.png" />

    <!-- ✅ Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Artikel & Promo Truk Hino Terbaru" />
    <meta name="twitter:description" content="Artikel lengkap truk Hino: harga, promo & spesifikasi resmi Dealer Hino Tangerang." />
    <meta name="twitter:image" content="https://official-hino.com/img/hino300produk.png" />

    <!-- JSON Schema -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Article",
      "@id": "https://official-hino.com/artikel",
      "headline": "Artikel & Promo Truk Hino Terbaru",
      "description": "Artikel terbaru seputar truk Hino meliputi harga, promo, spesifikasi Hino Dutro, Hino 300 dan Hino 500 dari Dealer Hino Tangerang resmi.",
      "image": "https://official-hino.com/img/hino300produk.png",
      "author": {
        "@type": "Organization",
        "name": "Dealer Hino Tangerang",
        "url": "https://official-hino.com"
      },
      "publisher": {
        "@type": "Organization",
        "name": "Dealer Hino Tangerang",
        "logo": {
          "@type": "ImageObject",
          "url": "https://official-hino.com/favicon_512.png"
        }
      },
      "datePublished": "2025-01-01",
      "dateModified": "2025-01-01",
      "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "https://official-hino.com/artikel"
      }
    }
    </script>

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BreadcrumbList",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "Beranda",
          "item": "https://official-hino.com"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "Artikel",
          "item": "https://official-hino.com/artikel"
        }
      ]
    }
    </script>



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
          <a href="/">Home</a>
          <a href="/hino300">Hino 300 Series</a>
          <a href="/hino500">Hino 500 Series</a>
          <a href="/hinobus">Hino Bus Series</a>
          <a href="/artikel">Blog & Artikel</a>
          <a href="/contact">Contact</a>
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
                  <a href="/artikel/<?= htmlspecialchars($row['slug']) ?>">
                    <?= htmlspecialchars($row['judul']) ?>
                  </a>
                </h2>
                <p><?= substr(strip_tags($row['isi']), 0, 100) ?>...</p>
                <div class="card-footer">
                  <a href="/artikel/<?= htmlspecialchars($row['slug']) ?>">Baca Selengkapnya</a>
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
    <script src="https://elfsightcdn.com/platform.js" async></script>
    <div class="elfsight-app-b334841b-ad07-411c-889b-4364272215a1" data-elfsight-app-lazy></div>

    <script>feather.replace();</script>
  </body>
</html>
