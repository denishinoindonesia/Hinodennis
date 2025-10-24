<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'admin/config.php';

// Ambil 3 artikel terbaru dari database
$sql = "SELECT a.id, a.judul, a.isi, a.gambar, a.tanggal, k.nama_kategori AS kategori
        FROM artikel a
        LEFT JOIN kategori k ON a.kategori_id = k.id
        ORDER BY a.tanggal DESC
        LIMIT 3";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $artikelData = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Gagal mengambil data artikel: " . $e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dealer Hino Tangerang | Info Pemesanan Hubungi 0812-1905-5571</title>

    <meta name="description" content="Hino Official - Dealer Truck Hino Tangerang. Hubungi : 0812 1905 5571 Untuk mendapatkan informasi produk Hino. Layanan Terbaik dan Jaminan Mutu." />
    <meta name="keywords" content="sales Hino, sales Hino Jakarta, sales Hino Jabodetabek, sales Hino Tangerang, sales Hino Bekasi, sales Hino Depok, sales Hino Bogor, sales truck Hino, dealer Hino, dealer Hino Jabodetabek, dealer Hino Tangerang, dealer Hino Bekasi, dealer Hino Depok, dealer Hino Bogor, dealer truck Hino, dealer Hino resmi, dealer Hino Jakarta, dealer Hino Indonesia, jual truk Hino, kredit truk Hino, cicilan truk Hino, promo truk Hino, harga truk Hino terbaru, diskon truk Hino, truk Hino Dutro, truk Hino 300, truk Hino 500, Hino Dutro 136 HD, Hino Dutro 4x4, Hino Dutro box, Hino Dutro engkel, spesifikasi Hino Dutro, modifikasi truk Hino, gambar truk Hino, keunggulan truk Hino, truk Hino untuk bisnis, truk Hino untuk logistik, perbandingan truk Hino dan Isuzu Elf, dealer truk Hino termurah, dealer truk hino tangerang, dealer hino cikupa, hino cikupa, dealer hino tangerang murah" />

    <link rel="canonical" href="https://official-hino.com/" />

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-8BPF492E6Z"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-8BPF492E6Z');
    </script>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/img/favicon.png" />
    <link rel="apple-touch-icon" href="images/favicon.png" />

    <!-- Font & CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/navbar.css" />
    <link rel="stylesheet" href="css/home_css/header.css" />
    <link rel="stylesheet" href="css/home_css/promoutama.css" />
    <link rel="stylesheet" href="css/home_css/layanan.css" />
    <link rel="stylesheet" href="css/home_css/produk.css" />
    <link rel="stylesheet" href="css/home_css/keunggulankami.css" />
    <link rel="stylesheet" href="css/home_css/contact.css" />
    <link rel="stylesheet" href="css/home_css/blogcard.css" />

    <script src="js/script.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
  </head>

  <body>
    <!-- Header -->
    <header>
      <div class="container header-content navbar">
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

    <!-- Hero -->
    <section class="hero">
      <div class="slider">
        <img src="img/Euro 4 Hino 300.jpeg" class="slide active" alt="Banner 1" />
        <img src="img/Euro 4 Hino 500.jpeg" class="slide" alt="Banner 2" />
        <img src="img/Euro 4 Hino Bus.jpeg" class="slide" alt="Banner 3" />
      </div>
    </section>

    <!-- Section: Promo Utama -->
    <section id="promo-utama" class="promo-section fade-element">
      <div class="promo-text">
        <h2>Dapatkan Harga dan Penawaran Terbaik Langsung dari Dealer Resmi Hino Indonesia</h2>
        <ul>
          <li>Ingin harga terbaik untuk semua jenis truk Hino?</li>
          <li>Bingung memilih kendaraan yang tepat untuk bisnis Anda?</li>
          <li>Butuh pelayanan cepat, ramah, dan profesional?</li>
          <li>Hubungi Dennis sekarang juga dan dapatkan solusi terbaik!</li>
        </ul>
        <p>
          Denis Hino siap membantu Anda mendapatkan truk Hino baru dengan harga kompetitif untuk seluruh Indonesia,
          <strong>terutama di Tangerang</strong>. Pelayanan cepat, terpercaya, dan tanpa ribet menanti Anda!
        </p>
        <div class="promo-buttons">
          <a href="https://wa.me/6281219055571" class="btn-primary" target="_blank" rel="noopener noreferrer">Konsultasi Pembelian</a>
        </div>
      </div>
      <img src="img/hino.png" alt="Truk Hino Hijau" loading="lazy" class="promo-main-image" />
    </section>

    <!-- BAGIAN PRODUK & LAYANAN -->
    <section class="hino-section-produk fade-element">
      <div class="hino-container">
        <div class="hino-heading">
          <h5>PRODUK & LAYANAN</h5>
          <h2>HINO TANGERANG</h2>
          <p>Kami melayani jasa penyediaan unit Truk & Bus, layanan service dan penjualan spare part merk Hino.</p>
        </div>

        <div class="hino-cards">
          <div class="hino-card">
            <img src="img/bannerpenjualan.jpg" alt="Penjualan Truk & Bis" />
            <h3>PENJUALAN TRUK & BUS</h3>
            <a href="#products-section" class="hino-btn">SELENGKAPNYA</a>
          </div>

          <div class="hino-card">
            <img src="img/bannerservice.jpg" alt="Layanan Service" />
            <h3>LAYANAN SERVICE</h3>
            <a href="contact.php" class="hino-btn">SELENGKAPNYA</a>
          </div>

          <div class="hino-card">
            <img src="img/bannersparepart.jpg" alt="Spare Part" />
            <h3>SPARE PART</h3>
            <a href="contact.php" class="hino-btn">SELENGKAPNYA</a>
          </div>
        </div>
      </div>
    </section>

    <!-- Produk -->
    <section id="products-section" class="products-section fade-element">
      <h2 class="section-title">Produk Truk Hino Unggulan</h2>
      <div class="products">
        <div class="product">
          <img src="img/hino300produk.png" alt="Hino 300 Dutro" loading="lazy" />
          <h3>
            <a href="https://official-hino.com/hino300.php" target="_blank" rel="noopener noreferrer">Hino 300 Series (Dutro)</a>
          </h3>
          <p>Truk ringan dan tangguh, cocok untuk usaha kecil dan menengah.</p>
        </div>

        <div class="product">
          <img src="img/hino500produk.png" alt="Hino 500 Ranger" loading="lazy" />
          <h3>
            <a href="https://official-hino.com/hino500.php" target="_blank" rel="noopener noreferrer">Hino 500 Series (Ranger)</a>
          </h3>
          <p>Performa handal untuk pengangkutan berat dan jarak jauh.</p>
        </div>

        <div class="product">
          <img src="img/hinobusproduk.png" alt="Hino Bus Series" loading="lazy" />
          <h3>
            <a href="https://official-hino.com/hinobus.php" target="_blank" rel="noopener noreferrer">Hino Bus Series</a>
          </h3>
          <p>Solusi transportasi penumpang dengan kenyamanan terbaik.</p>
        </div>
      </div>
    </section>

    <!-- Keunggulan Kami -->
    <section class="advantages fade-element">
      <div class="advantages-container">
        <div class="advantages-image">
          <img src="img/worker.png" alt="Worker Image" />
        </div>

        <div class="advantages-content">
          <h2>Program Purna Jual</h2>

          <div class="advantage-item">
            <svg xmlns="https://w3.org/2000/svg" class="icon" fill="none" viewBox="0 0 24 24" stroke="#0a1950" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            <div>
              <h4>Program Service</h4>
              <p>
                Nikmati layanan gratis biaya jasa service berkala untuk setiap pembelian unit Hino tertentu. Pemeriksaan dilakukan oleh teknisi bersertifikat menggunakan suku cadang asli Hino.
                Hemat biaya, kendaraan lebih terawat, performa maksimal.
              </p>
            </div>
          </div>

          <div class="advantage-item">
            <svg xmlns="https://w3.org/2000/svg" class="icon" fill="none" viewBox="0 0 24 24" stroke="#0a1950" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6 5.87v-2a4 4 0 00-3-3.87M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <div>
              <h4>Program Suku Cadang</h4>
              <p>
                Dapatkan jaminan kualitas dan ketahanan terbaik untuk truk Anda dengan menggunakan suku cadang asli Hino. Kami menyediakan layanan lengkap untuk memastikan setiap komponen kendaraan Anda bekerja secara optimal dan tahan lama.
              </p>
            </div>
          </div>

          <div class="advantage-item">
            <svg xmlns="https://w3.org/2000/svg" class="icon" fill="none" viewBox="0 0 24 24" stroke="#0a1950" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c1.657 0 3-1.343 3-3S13.657 2 12 2 9 3.343 9 5s1.343 3 3 3zm0 0v13m-3.5-3.5L12 21l3.5-3.5" />
            </svg>
            <div>
              <h4>Program On Site Service</h4>
              <p>
                Kini, perawatan dan perbaikan truk Hino menjadi lebih praktis dengan layanan On Site Service. Teknisi Hino yang profesional akan datang langsung ke lokasi operasional Anda — menghemat waktu, tenaga, dan biaya operasional.
              </p>
            </div>
          </div>

          <div class="advantage-item">
            <svg xmlns="https://w3.org/2000/svg" class="icon" fill="none" viewBox="0 0 24 24" stroke="#0a1950" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 17H4a1 1 0 01-1-1V6a1 1 0 011-1h11a1 1 0 011 1v10a1 1 0 01-1 1h-1m5 0a2 2 0 100-4h-1m-4 4h6m-1 0a2 2 0 110 4 2 2 0 010-4zM6 17a2 2 0 100 4 2 2 0 000-4z" />
            </svg>
            <div>
              <h4>Pelatihan & Konsultasi</h4>
              <p>
                Hino tidak hanya menjual truk, tapi juga memastikan setiap pengguna memahami cara terbaik untuk mengoperasikan dan merawatnya. Melalui program Pelatihan & Konsultasi, kami membekali operator dan manajemen Anda dengan pengetahuan teknis, keselamatan, efisiensi pengoperasian, serta perawatan kendaraan.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Section -->
    <div class="contact-container fade-element">
      <div class="contact-tabs">
        <div class="tab active">Hubungi Kami</div>
      </div>

      <div class="contact-info">
        <div class="contact-item">
          <img src="img/cssupport.png" alt="WhatsApp" />
          <div>
            <strong>Whatsapp</strong><br />
            +62 812-1905-5571
          </div>
        </div>

        <div class="divider"></div>

        <div class="contact-item">
          <img src="https://img.icons8.com/ios-filled/50/000000/phone.png" alt="Phone" />
          <div>
            <strong>Phone Call</strong><br />
            +62 812-1905-5571
          </div>
        </div>

        <div class="divider"></div>

        <div class="contact-item">
          <img src="https://img.icons8.com/ios-filled/50/000000/new-post.png" alt="Email" />
          <div>
            <strong>Email</strong><br />
            denishinoindonesia@gmail.com
          </div>
        </div>
      </div>
    </div>

    <!-- Blog Section -->
    <section class="blog-section fade-element">
      <div class="container">
        <h2>Blog & Artikel</h2>
        <p>Dapatkan informasi terbaru seputar Truk Hino, perawatan, dan promo terbaik.</p>

        <div class="blog-grid">
          <?php if (!empty($artikelData)): ?>
            <?php foreach ($artikelData as $artikel): ?>
              <div class="blog-card">
                <img 
                  src="https://official-hino.com/admin/uploads/artikel/<?= htmlspecialchars($artikel['gambar']) ?>"
                  alt="<?= htmlspecialchars($artikel['judul']) ?>" 
                  loading="lazy"
                />
                <div class="blog-card-content">
                  <h3>
                    <a href="detail_artikel.php?id=<?= urlencode($artikel['id']) ?>">
                      <?= htmlspecialchars($artikel['judul']) ?>
                    </a>
                  </h3>

                  <p><?= htmlspecialchars(mb_strimwidth(strip_tags($artikel['isi']), 0, 100, '...')) ?></p>

                  <a href="detail_artikel.php?id=<?= urlencode($artikel['id']) ?>" class="read-more">
                    Baca Selengkapnya
                  </a>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p>Tidak ada artikel ditemukan.</p>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <!-- WhatsApp Chat -->
    <script src="https://static.elfsight.com/platform/platform.js" async></script>
    <div class="elfsight-app-1c150e27-6597-4113-becd-79df393b9756" data-elfsight-app-lazy></div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <script>feather.replace();</script>
  </body>
</html>
