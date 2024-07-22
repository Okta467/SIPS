<?php
$current_page = $_GET['go'] ?? '';
$user_logged_in = $_SESSION['nama_pegawai'] ?? $_SESSION['nama_guest'] ?? $_SESSION['username'];
?>

<nav class="sidenav shadow-right sidenav-light">
  <div class="sidenav-menu">
    <div class="nav accordion" id="accordionSidenav">
      <!-- Sidenav Menu Heading (Core)-->
      <div class="sidenav-menu-heading">Core</div>
      
      <a class="nav-link <?php if ($current_page === 'dashboard') echo 'active' ?>" href="index.php?go=dashboard">
        <div class="nav-link-icon"><i data-feather="activity"></i></div>
        Dashboard
      </a>

      <div class="sidenav-menu-heading">Pengguna</div>
      
      <a class="nav-link <?php if ($current_page === 'pengguna') echo 'active' ?>" href="pengguna.php?go=pengguna">
        <div class="nav-link-icon"><i data-feather="users"></i></div>
        Pengguna
      </a>
      
      <div class="sidenav-menu-heading">Surat</div>
      
      <a class="nav-link <?php if ($current_page === 'surat_masuk') echo 'active' ?>" href="surat_masuk.php?go=surat_masuk">
        <div class="nav-link-icon"><i data-feather="inbox"></i></div>
        Surat Masuk
      </a>
      
      <a class="nav-link <?php if ($current_page === 'surat_keluar') echo 'active' ?>" href="surat_keluar.php?go=surat_keluar">
        <div class="nav-link-icon"><i data-feather="send"></i></div>
        Surat Keluar
      </a>
      
      <div class="sidenav-menu-heading">Tools Surat</div>
      
      <a class="nav-link <?php if ($current_page === 'kode_surat') echo 'active' ?>" href="kode_surat.php?go=kode_surat">
        <div class="nav-link-icon"><i data-feather="hash"></i></div>
        Kode Surat
      </a>
      
      <a class="nav-link <?php if ($current_page === 'disposisi_surat_masuk') echo 'active' ?>" href="disposisi_surat_masuk.php?go=disposisi_surat_masuk">
        <div class="nav-link-icon"><i data-feather="tag"></i></div>
        Disposisi Surat Masuk
      </a>
      
      <div class="sidenav-menu-heading">Agenda</div>
      
      <a class="nav-link <?php if ($current_page === 'agenda') echo 'active' ?>" href="agenda.php?go=agenda">
        <div class="nav-link-icon"><i data-feather="calendar"></i></div>
        Agenda
      </a>
      
      <div class="sidenav-menu-heading">Pegawai</div>
      
      <a class="nav-link <?php if ($current_page === 'pegawai') echo 'active' ?>" href="pegawai.php?go=pegawai">
        <div class="nav-link-icon"><i data-feather="user"></i></div>
        Pegawai
      </a>
      
      <a class="nav-link <?php if ($current_page === 'jabatan') echo 'active' ?>" href="jabatan.php?go=jabatan">
        <div class="nav-link-icon"><i data-feather="briefcase"></i></div>
        Jabatan
      </a>
      
      <?php
      if (in_array($current_page, ['pangkat_golongan', 'pendidikan', 'jurusan_pendidikan'])) {
        $active_nav_container_detail_kepala_desa = 'active';
        $show_nav_menu_detail_kepala_desa = 'show';
      }
      ?>
      
      <a class="nav-link collapsed <?= $active_nav_container_detail_kepala_desa ?? '' ?>" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseDetailKepalaDesa" aria-expanded="false" aria-controls="collapseDetailKepalaDesa">
        <div class="nav-link-icon"><i data-feather="list"></i></div>
        Lainnya
        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
      </a>
      <div class="collapse <?= $show_nav_menu_detail_kepala_desa ?? '' ?>" id="collapseDetailKepalaDesa" data-bs-parent="#accordionSidenav">
        <nav class="sidenav-menu-nested nav">
          <a class="nav-link <?php if ($current_page === 'pangkat_golongan') echo 'active' ?>" href="pangkat_golongan.php?go=pangkat_golongan">
            Pangkat / Golongan
          </a>
          <a class="nav-link <?php if ($current_page === 'pendidikan') echo 'active' ?>" href="pendidikan.php?go=pendidikan">
            Pendidikan
          </a>
          <a class="nav-link <?php if ($current_page === 'jurusan_pendidikan') echo 'active' ?>" href="jurusan_pendidikan.php?go=jurusan_pendidikan">
            Jurusan
          </a>
        </nav>
      </div>
      
      <div class="sidenav-menu-heading">Lainnya</div>
      
      <a class="nav-link" href="<?= base_url('logout.php') ?>">
        <div class="nav-link-icon"><i data-feather="log-out"></i></div>
        Keluar
      </a>

    </div>
  </div>
  <!-- Sidenav Footer-->
  <div class="sidenav-footer">
    <div class="sidenav-footer-content">
      <div class="sidenav-footer-subtitle">Anda masuk sebagai:</div>
      <div class="sidenav-footer-title"><?= ucwords($user_logged_in) ?></div>
    </div>
  </div>
</nav>