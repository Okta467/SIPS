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

      <div class="sidenav-menu-heading">Profil</div>
      
      <a class="nav-link <?php if ($current_page === 'profil') echo 'active' ?>" href="profil.php?go=profil">
        <div class="nav-link-icon"><i data-feather="user"></i></div>
        Profil
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