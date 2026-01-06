<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'admin/config.php';

// Ambil 3 artikel terbaru (SEO READY)
$sql = "
    SELECT 
        a.id,
        a.judul,
        a.slug,
        a.isi,
        a.gambar,
        a.tanggal,
        k.nama_kategori AS kategori
    FROM artikel a
    LEFT JOIN kategori k ON a.kategori_id = k.id
    ORDER BY a.tanggal DESC
    LIMIT 3
";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $artikelData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Samakan format gambar seperti API
    foreach ($artikelData as &$row) {
        if (!empty($row['gambar'])) {
            $row['gambar'] = "https://official-hino.com/admin/uploads/artikel/" . $row['gambar'];
        }
    }
    unset($row);

} catch (PDOException $e) {
    die("Gagal mengambil data artikel: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- ✅ Judul utama -->
    <title>Dealer Hino Tangerang | Info Pemesanan Hubungi 0812-1905-5571</title>

    <!-- ✅ Deskripsi SEO -->
    <meta name="description" content="Dealer Hino Tangerang — Hubungi 0812-1905-5571 untuk info harga, promo, dan pembelian truk Hino di wilayah Tangerang dan sekitarnya. Layanan cepat dan terpercaya.">
    <meta name="keywords" content="dealer hino, dealer hino jakarta, dealer hino jabodetabek, dealer hino jakarta barat, dealer hino jakarta timur, dealer hino jakarta utara, dealer hino jakarta selatan, dealer hino tangerang, dealer hino bekasi, dealer hino depok, dealer hino bogor, dealer hino bandung, dealer resmi hino indonesia, sales hino, promo hino, harga truk hino, jual truk hino, kredit truk hino, cicilan truk hino, hino ready stock, stok unit hino terbaru, harga hino terbaru 2025, promo kredit hino, dealer hino tangerang, hino tangerang, sales hino tangerang, harga truk hino tangerang, promo hino tangerang, kredit truk hino tangerang, dealer hino resmi tangerang, dealer hino cikupa, dealer hino cikupa tangerang">
    <meta name="author" content="Dealer Hino Tangerang">

    <!-- ✅ Canonical URL -->
    <link rel="canonical" href="https://official-hino.com/" />

    <!-- ✅ Tambahkan ini agar judul 'Dealer Hino Tangerang' muncul di atas domain (seperti di Indomobil Hino) -->
    <meta name="application-name" content="Dealer Hino Tangerang">
    <meta name="apple-mobile-web-app-title" content="Dealer Hino Tangerang">

    <!-- ✅ Open Graph untuk tampilan di Google / Facebook / WhatsApp -->
    <meta property="og:site_name" content="Dealer Hino Tangerang">
    <meta property="og:title" content="Dealer Hino Tangerang | Info Pemesanan Hubungi 0812-1905-5571">
    <meta property="og:description" content="Dealer Hino Tangerang. Hubungi 0812-1905-5571 untuk promo dan harga truk Hino terbaru.">
    <meta property="og:url" content="https://official-hino.com/">
    <meta property="og:type" content="website">
    <meta property="og:image" content="https://official-hino.com/img/hino.png">

    <!-- Favicon untuk semua browser modern -->
    <link rel="icon" type="image/png" sizes="512x512" href="/favicon_512.png">
    
    <!-- Favicon untuk browser lama -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    
    <!-- Apple Touch Icon (iPhone/iPad) -->
    <link rel="apple-touch-icon" href="/favicon_512.png">

    <!-- ✅ Fonts & CSS -->
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

    <!-- JSON -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebSite",
      "name": "Dealer Hino Tangerang",
      "alternateName": "Official Hino",
      "url": "https://official-hino.com"
    }
    </script>
    
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "Dealer Hino Tangerang",
      "url": "https://official-hino.com",
      "logo": "https://official-hino.com/favicon_512.png"
    }
    </script>
    
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "AutoDealer",
      "@id": "https://official-hino.com/#dealer",
      "name": "Dealer Hino Tangerang",
      "alternateName": "Dealer Hino Tangerang",
      "url": "https://official-hino.com/",
      "image": "https://official-hino.com/img/hino300produk.png",
      "logo": "https://official-hino.com/img/hino300produk.png",
      "description": "Dealer Resmi Hino Tangerang - Menyediakan berbagai jenis truk dan bus Hino dengan layanan terbaik. Dapatkan promo menarik dan layanan kredit untuk wilayah Tangerang dan sekitarnya.",
      "telephone": "+62-812-1905-5571",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Jl. Raya Serang No.Km.18,8, Sukanagara, Kec. Cikupa",
        "addressLocality": "Kabupaten Tangerang",
        "addressRegion": "Banten",
        "postalCode": "15710",
        "addressCountry": "ID"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": -6.2500,
        "longitude": 106.5000
      },
      "openingHoursSpecification": [
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": [
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday"
          ],
          "opens": "08:00",
          "closes": "17:00"
        }
      ],
      "sameAs": [
        "https://www.facebook.com/official-hino",
        "https://www.instagram.com/official_hino.id",
        "https://www.tiktok.com/@official_hino"
      ]
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
          "name": "Dealer Hino Tangerang"
        }
      ]
    }
    </script>



    <!-- ✅ Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-8BPF492E6Z"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-8BPF492E6Z');
    </script>

    <!-- ✅ Script -->
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
          <a href="/">Home</a>
          <a href="/hino300">Hino 300 Series</a>
          <a href="/hino500">Hino 500 Series</a>
          <a href="/hinobus">Hino Bus Series</a>
          <a href="/artikel">Blog & Artikel</a>
          <a href="/contact">Contact</a>
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
        <h2>Dapatkan Harga dan Penawaran Terbaik Langsung dari Dealer Resmi Hino Tangerang</h2>
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
            <a href="/contact" class="hino-btn">SELENGKAPNYA</a>
          </div>

          <div class="hino-card">
            <img src="img/bannersparepart.jpg" alt="Spare Part" />
            <h3>SPARE PART</h3>
            <a href="/contact" class="hino-btn">SELENGKAPNYA</a>
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
            <a href="https://official-hino.com/hino300" target="_blank" rel="noopener noreferrer">Hino 300 Series (Dutro)</a>
          </h3>
          <p>Truk ringan dan tangguh, cocok untuk usaha kecil dan menengah.</p>
        </div>

        <div class="product">
          <img src="img/hino500produk.png" alt="Hino 500 Ranger" loading="lazy" />
          <h3>
            <a href="https://official-hino.com/hino500" target="_blank" rel="noopener noreferrer">Hino 500 Series (Ranger)</a>
          </h3>
          <p>Performa handal untuk pengangkutan berat dan jarak jauh.</p>
        </div>

        <div class="product">
          <img src="img/hinobusproduk.png" alt="Hino Bus Series" loading="lazy" />
          <h3>
            <a href="https://official-hino.com/hinobus" target="_blank" rel="noopener noreferrer">Hino Bus Series</a>
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
                  src="<?= htmlspecialchars($artikel['gambar']) ?>"
                  alt="<?= htmlspecialchars($artikel['judul']) ?>" 
                  loading="lazy"
                />
                <div class="blog-card-content">
                  <h3>
                    <a href="/artikel/<?= htmlspecialchars($artikel['slug']) ?>">
                      <?= htmlspecialchars($artikel['judul']) ?>
                    </a>
                  </h3>

                  <p><?= htmlspecialchars(mb_strimwidth(strip_tags($artikel['isi']), 0, 100, '...')) ?></p>

                  <a href="/artikel/<?= htmlspecialchars($artikel['slug']) ?>" class="read-more">
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

    <!-- Elfsight WhatsApp Chat | Untitled WhatsApp Chat -->
    <script src="https://elfsightcdn.com/platform.js" async></script>
    <div class="elfsight-app-b334841b-ad07-411c-889b-4364272215a1" data-elfsight-app-lazy></div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <script>feather.replace();</script>
  </body>
</html>
