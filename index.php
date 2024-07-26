<!DOCTYPE html>
<html lang="en">

<head>
  <?php session_start() ?>
  <?php include 'config/config.php' ?>
  <?php include 'config/connection.php' ?>
  <?php include 'index_head.php' ?>
  <?php include 'helpers/isAccessAllowedHelper.php' ?>
  <?php include 'helpers/isAlreadyLoginHelper.php' ?>

  <meta name="description" content="" />
  <meta name="author" content="" />
  <title><?= SITE_NAME_LANDING_PAGE ?></title>
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename"><?= SITE_NAME_LANDING_PAGE_SHORT ?></h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#" class="active">Beranda<br></a></li>
          <li><a href="#wisata">Wisata</a></li>
          <li><a href="#peta-lokasi">Lokasi</a></li>
          <li><a href="#kontak">Kontak</a></li>
          <li>
            <a href="login.php" class="btn btn-outline-dark text-xl-white border-3 border-dark-subtle px-3 py-2 mx-3 mx-xl-0">
              Masuk
              <i class="bi bi-box-arrow-right bg-transparent ms-2" style="font-size: 1rem"></i>
            </a>
          </li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

      <img src="<?= base_url('assets/landing_page/img/spot-ntt-outdoor-gasing-water-bay-palembang.jpg') ?>" alt="Spot NTT Outdoor Gasing Water Bay Palembang" data-aos="fade-in">

      <div class="container">
        <div class="row">
          <div class="col-xl-4">
            <h1 data-aos="fade-up"><?= SITE_NAME_LANDING_PAGE ?></h1>
            <blockquote data-aos="fade-up" data-aos-delay="100">
              <p><?= SITE_NAME_LANDING_PAGE_SHORT ?> merupakan bagian dari Kabupaten Banyuasin, Sumatera Selatan.</p>
            </blockquote>
            <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
              <a href="#wisata" class="btn-get-started">Get Started</a>
              <a href="https://www.youtube.com/watch?v=LXb3EKWsInQ" class="glightbox btn-watch-video d-flex align-items-center"><i class="bi bi-play-circle"></i><span>Watch Video</span></a>
            </div>
          </div>
        </div>
      </div>

    </section><!-- /Hero Section -->

    <!-- Wisata Section -->
    <section id="wisata" class="why-us section">

      <div class="container">

        <!-- First Row Swiper -->
        <div class="row g-0">

          <div class="col-xl-5 img-bg" data-aos="fade-up" data-aos-delay="100">
            <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEh7XtA79X94DOlIBvpcX7HXpn0ZmFlAqUmM6d-e0UjmKJq7_n3C_PFPqDqIA4wtg9pmcZbWn_k2wVnOOxFLEXbj0qghiffSJLUZcfRCHnw85z6FOjP5IzVpXOtXLhR3qY6ENK6RTzeFbVs5/s1600/WP_000113.jpg" alt="Outdoor Gasing Water Bay Palembang">
          </div>

          <div class="col-xl-7 slides position-relative" data-aos="fade-up" data-aos-delay="200">

            <div class="swiper init-swiper">
              <script type="application/json" class="swiper-config">
                {
                  "loop": true,
                  "speed": 600,
                  "autoplay": {
                    "delay": 5000
                  },
                  "slidesPerView": "auto",
                  "centeredSlides": true,
                  "pagination": {
                    "el": "#first-swiper.swiper-pagination",
                    "type": "bullets",
                    "clickable": true
                  },
                  "navigation": {
                    "nextEl": "#first-swiper.swiper-button-next",
                    "prevEl": "#first-swiper.swiper-button-prev"
                  }
                }
              </script>
              <div class="swiper-wrapper">

                <div class="swiper-slide">
                  <div class="item">
                    <h3 class="mb-3"><i>Outdoor</i> Gasing Water Bay Palembang</h3>
                    <h4 class="my-4 px-3 py-2 border-start border-info border-2 text-dark fw-bold text-opacity-75">
                      Spot Wisata yang "Instagrammable"
                    </h4>
                    <p>Gasing Water Bay merupakan salah satu destinasi wisata yang Instagramable, yaitu terdapat banyak spot foto yang bagus. Bisa dikatan, Gasing Water Bay ini cocok untuk generasi <i>kekinian</i> yang eksis di media sosial.</p>
                  </div>
                </div><!-- End slide item -->

                <div class="swiper-slide">
                  <div class="item">
                    <h3 class="mb-3"><i>Outdoor</i> Gasing Water Bay Palembang</h3>
                    <h4 class="my-4 px-3 py-2 border-start border-info border-2 text-dark fw-bold text-opacity-75">
                      Spot Wisata Khas Lombok dan Bali
                    </h4>
                    <p>Di sini kita bisa menikmati suasana yang asri karena terdapat spot rumah adat Lombok, Nusa Tengara Barat.</p>
                    <p class="d-none">Spot wisata ini juga dilengkapi dengan rerumputan hijau, pepohonan kelapa dan bunga-bunga indahnya.</p>
                    <p>Selain itu, Gasing Water Bay ini juga terdapat gapura khas Pura di Bali yang di belakangnya menunjukkan pemandangan yang indah.</p>
                  </div>
                </div><!-- End slide item -->

                <div class="swiper-slide">
                  <div class="item">
                    <h3 class="mb-3"><i>Outdoor</i> Gasing Water Bay Palembang</h3>
                    <h4 class="my-4 px-3 py-2 border-start border-info border-2 text-dark fw-bold text-opacity-75">
                      Harga Tiket
                    </h4>
                    <p>Harga tiket masuk wisata ini sebesar <strong>Rp35.000</strong> dan dibuka <strong>setiap hari</strong>.</p>
                  </div>
                </div><!-- End slide item -->

              </div>
              <div class="swiper-pagination" id="first-swiper"></div>
            </div>

            <div class="swiper-button-prev" id="first-swiper"></div>
            <div class="swiper-button-next" id="first-swiper"></div>
          </div>

        </div>
        <!-- /End First Row Swiper -->

        <!-- Second Row Swiper -->
        <div class="row g-0 mt-5">

          <div class="col-xl-7 slides position-relative" data-aos="fade-up" data-aos-delay="200">

            <div class="swiper init-swiper">
              <script type="application/json" class="swiper-config">
                {
                  "loop": false,
                  "speed": 600,
                  "autoplay": {
                    "delay": 5000
                  },
                  "slidesPerView": "auto",
                  "centeredSlides": true,
                  "pagination": {
                    "el": "#second-swiper.swiper-pagination",
                    "type": "bullets",
                    "clickable": true
                  },
                  "navigation": {
                    "nextEl": "#second-swiper.swiper-button-next",
                    "prevEl": "#second-swiper.swiper-button-prev"
                  }
                }
              </script>
              <div class="swiper-wrapper">

                <div class="swiper-slide">
                  <div class="item">
                    <h3 class="mb-3">Lokasi <i>Outdoor</i> Gasing <br> Water Bay Palembang</h3>
                    <h4 class="my-4 px-3 py-2 border-start border-info border-2 text-dark fw-bold text-opacity-75">
                      Alamat
                    </h4>
                    <p>Outdoor Gasing Water Bay Palembang beralamatkan di Jalan Tanjung Api-Api <?= SITE_NAME_LANDING_PAGE_SHORT ?>, Banyuasin (di belakang Cleopatra Karaoke).</p>
                  </div>
                </div><!-- End slide item -->

                <div class="swiper-slide">
                  <div class="item">
                    <h3 class="mb-3">Lokasi <i>Outdoor</i> Gasing <br> Water Bay Palembang</h3>
                    <h4 class="my-4 px-3 py-2 border-start border-info border-2 text-dark fw-bold text-opacity-75">
                      Petunjuk Arah dari Simpang 4 Bandara Baru
                    </h4>
                    <p>Dari simpang 4 bandara baru, 11 kilometer lagi ke arah Pelabuhan Tanjung Api-Api. Setelah 11 KM dari simpang bandara baru, ke kiri jalan ketemu Gerbang KTV Celopatra di samping SPBU, masuk lalu cari gerbang besi berwarna hitam dengan Pos Putih. <a href="<?= base_url('assets/landing_page/img/lokasi-spesifik-outdoor-gasing-water-bay-palembang.jpg') ?>" target="_blank">Lihat Gambar</a></p>
                  </div>
                </div><!-- End slide item -->

              </div>
              <div class="swiper-pagination" id="second-swiper"></div>
            </div>

            <div class="swiper-button-prev" id="second-swiper"></div>
            <div class="swiper-button-next" id="second-swiper"></div>
          </div>

          <div class="col-xl-5 img-bg" data-aos="fade-up" data-aos-delay="100">
            <img src="<?= base_url('assets/landing_page/img/lokasi-outdoor-gasing-water-bay-palembang.jpg') ?>" alt="Lokasi Wisata Outdoor Gasing Water Bay Palembang">
          </div>

        </div>
        <!-- /End Second Row Swiper -->

      </div>

    </section><!-- /Wisata Section -->

    <!-- Peta Lokasi Section -->
    <section id="peta-lokasi" class="peta-lokasi section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up" data-aos-delay="100">
        <h2>Peta Lokasi</h2>
        <p>DI bawah ini merupakan lokasi <?= SITE_NAME_LANDING_PAGE_SHORT ?> yang terletak di Talang Kelapa, Kabupaten Banyuasin, Sumatera Selatan.</p>
      </div><!-- End Section Title -->
    
      <div class="container">
        <div class="row" data-aos="fade-up" data-aos-delay="200">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127523.01654935128!2d104.67370294999999!3d-2.7884401!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e3b6cc686a612af%3A0xfc3756b23ecaa097!2sGasing%2C%20Talang%20Kelapa%2C%20Banyuasin%20Regency%2C%20South%20Sumatra!5e0!3m2!1sen!2sid!4v1721923626646!5m2!1sen!2sid" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>
    
    </section>

    <!-- Kontak Kami Section -->
    <section id="kontak" class="kontak call-to-action section dark-background">

      <img src="<?= base_url('assets/landing_page/img/spot-ntt-outdoor-gasing-water-bay-palembang.jpg') ?>" alt="Spot NTT Outdoor Gasing Water Bay Palembang">

      <div class="container">
        <div class="row justify-content-center" data-aos="zoom-in" data-aos-delay="100">
          <div class="col-xl-10">
            <div class="text-center">
              <h3>Kontak Kami</h3>
              <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
              <a class="cta-btn" href="#">Kontak Kami</a>
            </div>
          </div>
        </div>
      </div>

    </section><!-- /Kontak Kami Section -->

  </main>

  <footer id="footer" class="footer light-background">

    <div class="footer-top">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-5 col-md-12 footer-about">
            <a href="index.html" class="logo d-flex align-items-center">
              <span class="sitename"><?= SITE_NAME_LANDING_PAGE_SHORT ?></span>
            </a>
            <p>Cras fermentum odio eu feugiat lide par naso tierra. Justo eget nada terra videa magna derita valies darta donna mare fermentum iaculis eu non diam phasellus.</p>
            <div class="social-links d-flex mt-4">
              <a href=""><i class="bi bi-twitter-x"></i></a>
              <a href=""><i class="bi bi-facebook"></i></a>
              <a href=""><i class="bi bi-instagram"></i></a>
              <a href=""><i class="bi bi-linkedin"></i></a>
            </div>
          </div>

          <div class="col-lg-2 col-6 footer-links">
            <h4>Tautan</h4>
            <ul>
              <li><a href="#">Beranda</a></li>
              <li><a href="#wisata">Wisata</a></li>
              <li><a href="#peta-lokasi">Lokasi</a></li>
              <li><a href="#kontak">Kontak</a></li>
              <li><a href="login.php">Masuk</a></li>
            </ul>
          </div>

          <div class="col-lg-2 col-6 footer-links">
            <h4>Layanan Kami</h4>
            <ul>
              <li><a href="#">Layanan #1</a></li>
              <li><a href="#">Layanan #2</a></li>
              <li><a href="#">Layanan #3</a></li>
              <li><a href="#">Layanan #4</a></li>
              <li><a href="#">Layanan #5</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
            <h4>Hubungi Kami</h4>
            <p>Kecamatan Talang Kelapa</p>
            <p>Kabupaten Banyuasin</p>
            <p>Provinsi Sumatera Selatan</p>
            <p class="mt-4"><strong>Phone:</strong> <span>+628xx xxxx xxxx</span></p>
            <p><strong>Email:</strong> <span>desa_gasing@example.com</span></p>
          </div>

        </div>
      </div>
    </div>

    <div class="container copyright text-center">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Nova</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <?php include 'index_script.php' ?>

</body>

</html>