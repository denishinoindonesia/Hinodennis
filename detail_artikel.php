<?php
$slug = $_GET['slug'] ?? null;
if (!$slug) {
    http_response_code(404);
    exit('Artikel tidak ditemukan');
}

// Ambil artikel by slug
$artikel = json_decode(
    file_get_contents("https://official-hino.com/admin/api/get_artikel.php?slug=" . urlencode($slug)),
    true
);

if (!$artikel || !isset($artikel['slug'])) {
    http_response_code(404);
    exit('Artikel tidak ditemukan');
}

// Ambil artikel lain untuk sidebar
$allArtikel = json_decode(
    file_get_contents("https://official-hino.com/admin/api/get_artikel.php"),
    true
) ?: [];
?>

    <!DOCTYPE html>
    <html lang="id">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($artikel['judul']) ?> | Official Hino</title>
    <meta name="description" content="<?= htmlspecialchars(mb_strimwidth(strip_tags($artikel['isi']),0,160,'...')) ?>">

    <!-- SEO -->
    <meta property="og:title" content="<?= htmlspecialchars($artikel['judul']) ?>">
    <meta property="og:description" content="<?= htmlspecialchars(mb_strimwidth(strip_tags($artikel['isi']),0,160,'...')) ?>">
    <meta property="og:image" content="<?= htmlspecialchars($artikel['gambar']) ?>">
    <meta property="og:url" content="https://official-hino.com/artikel/<?= htmlspecialchars($artikel['slug']) ?>">
    <meta property="og:type" content="article">
    <link rel="icon" type="image/png" href="/favicon_512.png">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;700&display=swap" rel="stylesheet" />
    
    <!-- CSS -->
    <link rel="stylesheet" href="/css/style.css" />
    <link rel="stylesheet" href="/css/navbar.css" />
    <link rel="stylesheet" href="/css/home_css/header.css" />
    <link rel="stylesheet" href="/css/footer.css" />
    <link rel="stylesheet" href="/css/artikel.css">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-8BPF492E6Z"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-8BPF492E6Z');
    </script>

    <!-- JS -->
    <script src="/js/script.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- Tambahan Perbaikan Ukuran Navbar & Footer -->
  </head>
  <body>

    <!-- Header -->
    <header>
      <div class="container header-content navbar">
    <!-- Logo -->
    <div class="header-title">
      <a href="https://official-hino.com">
        <img src="/img/logo3.png" alt="Logo Hino" style="height: 60px" />
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

    <!-- Konten Artikel -->
    <section class="detail-artikel">
      <div class="container">
        <div class="artikel-wrapper" style="display: flex; flex-wrap: wrap; gap: 30px;">
          <div class="artikel-main" style="flex: 1 1 65%;">
            <?php if($artikel): ?>
              <h1><?= htmlspecialchars($artikel['judul']) ?></h1>
              <p style="color: #888; font-size: 14px; margin-bottom: 15px;">
                Diposting oleh <strong><?= htmlspecialchars($artikel['author'] ?? 'Dennis Hino') ?></strong> pada <?= date('d M Y', strtotime($artikel['tanggal'] ?? 'now')) ?>
              </p>
              <img src="<?= htmlspecialchars($artikel['gambar']) ?>" alt="<?= htmlspecialchars($artikel['judul']) ?>" class="featured-image" style="width: 100%; height: auto; margin-bottom: 20px;">
              <div class="isi-artikel">
                <?= nl2br($artikel['isi']) ?>
              </div>
              <a href="/artikel" class="btn-kembali" style="display:inline-block; margin-top:20px;">Kembali ke Daftar Artikel</a>
            <?php else: ?>
              <p>Artikel tidak ditemukan.</p>
            <?php endif; ?>
          </div>

          <!-- Sidebar -->
          <aside class="artikel-sidebar" style="flex: 1 1 30%;">
            <div class="sidebar-section">
              <h3>Recent Posts</h3>
              <div class="recent-posts-list">
                <?php
                foreach (array_slice($allArtikel, 0, 5) as $recent) {
                  if ($recent['slug'] !== $artikel['slug']) {
                    echo '<div class="recent-post-item" style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">';
                    echo '<a href="/artikel/' . htmlspecialchars($recent['slug']) . '" style="flex-shrink: 0;">';
                    echo '<img src="' . htmlspecialchars($recent['gambar']) . '" alt="' . htmlspecialchars($recent['judul']) . '" style="width: 80px; height: 60px; object-fit: cover; border-radius: 6px;">';
                    echo '</a>';
                    echo '<div style="flex: 1;">';
                    echo '<a href="/artikel/' . htmlspecialchars($recent['slug']) . '" style="font-weight: 600; text-decoration: none; color: #333; line-height: 1.3; display: block;">' . htmlspecialchars($recent['judul']) . '</a>';
                    echo '</div>';
                    echo '</div>';
                  }
                }
                ?>
              </div>
            </div>

            <div class="sidebar-section">
              <h3>Kategori</h3>
              <ul style="list-style: none; padding-left: 0;">
                <?php
                $kategori = array_unique(array_column($allArtikel, 'kategori'));
                foreach ($kategori as $kat) {
                  if (!empty($kat)) {
                    echo '<li style="margin-bottom: 8px;">';
                    echo '<a href="artikel.php?kategori=' . urlencode($kat) . '" style="text-decoration: none; color: #333; font-weight: 500;">• ' . htmlspecialchars($kat) . '</a>';
                    echo '</li>';
                  }
                }
                ?>
              </ul>
            </div>
          </aside>
        </div>

        <!-- Related Posts -->
        <?php if ($artikel): ?>
        <div class="related-posts" style="margin-top: 60px;">
          <h2 style="margin-bottom: 25px; font-size: 26px; font-weight: 700;">Related Posts</h2>
          <div class="related-list" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px;">
            <?php
            $related_count = 0;
            foreach ($allArtikel as $rel) {
              if ($rel['slug'] !== $artikel['slug'] && isset($rel['kategori'], $artikel['kategori']) && $rel['kategori'] === $artikel['kategori']) {
                echo '<div class="related-item" style="background: #fff; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">';
                echo '<a href="/artikel/' . htmlspecialchars($rel['slug']) . '" style="text-decoration: none; color: #333;">';
                echo '<img src="' . htmlspecialchars($rel['gambar']) . '" alt="' . htmlspecialchars($rel['judul']) . '" style="width: 100%; height: 160px; object-fit: cover;">';
                echo '<div style="padding: 15px;">';
                echo '<h4 style="font-size: 16px; font-weight: 600; margin: 0 0 10px 0;">' . htmlspecialchars($rel['judul']) . '</h4>';
                echo '<p style="font-size: 14px; color: #666;">' . substr(strip_tags($rel['isi']), 0, 100) . '...</p>';
                echo '</div></a></div>';
                $related_count++;
                if ($related_count >= 3) break;
              }
            }
            if ($related_count === 0) {
              echo "<p>Tidak ada artikel terkait.</p>";
            }
            ?>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </section>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <!-- Elfsight WhatsApp Chat | Untitled WhatsApp Chat -->
    <script src="https://elfsightcdn.com/platform.js" async></script>
    <div class="elfsight-app-b334841b-ad07-411c-889b-4364272215a1" data-elfsight-app-lazy></div>


    <script>
      feather.replace();
    </script>
  </body>
</html>
