<?php
include '../helpers/isAccessAllowedHelper.php';

// cek apakah user yang mengakses adalah sekretaris_desa?
if (!isAccessAllowed('sekretaris_desa')) :
  session_destroy();
  echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
else :
  include_once '../config/connection.php';
?>


  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php include '_partials/head.php' ?>

    <meta name="description" content="Data Profil" />
    <meta name="author" content="" />
    <title>Profil - <?= SITE_NAME ?></title>
  </head>

  <body class="nav-fixed">
    <!--============================= TOPNAV =============================-->
    <?php include '_partials/topnav.php' ?>
    <!--//END TOPNAV -->
    <div id="layoutSidenav">
      <div id="layoutSidenav_nav">
        <!--============================= SIDEBAR =============================-->
        <?php include '_partials/sidebar.php' ?>
        <!--//END SIDEBAR -->
      </div>
      <div id="layoutSidenav_content">

        <?php
        $id_pegawai = $_SESSION['id_pegawai'];
      
        if ($id_pegawai) {
          $stmt_pegawai = mysqli_stmt_init($connection);
          $query_pegawai = 
            "SELECT
                a.id AS id_pegawai, a.nip, a.nama_pegawai, a.jk, a.alamat, a.tmp_lahir, a.tgl_lahir, a.tahun_ijazah, a.foto_profil,
                b.id AS id_jabatan, b.nama_jabatan, 
                c.id AS id_pangkat_golongan, c.nama_pangkat_golongan, c.tipe AS tipe_pangkat_golongan,
                d.id AS id_pendidikan, d.nama_pendidikan,
                e.id AS id_jurusan_pendidikan, e.nama_jurusan AS nama_jurusan_pendidikan,
                f.id AS id_pengguna, f.username, f.hak_akses
            FROM tbl_pegawai AS a
            LEFT JOIN tbl_jabatan AS b
                ON a.id_jabatan = b.id
            LEFT JOIN tbl_pangkat_golongan AS c
                ON a.id_pangkat_golongan = c.id
            LEFT JOIN tbl_pendidikan AS d
                ON a.id_pendidikan = d.id
            LEFT JOIN tbl_jurusan_pendidikan AS e
                ON a.id_jurusan_pendidikan = e.id
            LEFT JOIN tbl_pengguna AS f
                ON a.id_pengguna = f.id
            WHERE a.id=?";
          
          mysqli_stmt_prepare($stmt_pegawai, $query_pegawai);
          mysqli_stmt_bind_param($stmt_pegawai, 'i', $id_pegawai);
          mysqli_stmt_execute($stmt_pegawai);
      
          $result = mysqli_stmt_get_result($stmt_pegawai);
          $pegawai = mysqli_fetch_assoc($result);
      
          $hak_akses = $pegawai['hak_akses'] ? ucwords(str_replace('_', ' ', $pegawai['hak_akses'])) : null;
          $tgl_lahir = date('d M Y', strtotime($pegawai['tgl_lahir']));
          $path_foto_profil = $pegawai['foto_profil']
            ? base_url_return("assets/uploads/foto_profil/{$pegawai['foto_profil']}")
            : base_url_return('assets/img/illustrations/profiles/profile-1.png');
        }
        ?>

        <main>
          <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
            <div class="container-xl px-4">
              <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                  <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                      <div class="page-header-icon"><i data-feather="user"></i></div>
                      Pengaturan Akun - Password
                    </h1>
                  </div>
                </div>
              </div>
            </div>
          </header>
          <!-- Main page content-->
          <div class="container-xl px-4 mt-4">
            <!-- Account page navigation-->
            <nav class="nav nav-borders">
              <a class="nav-link ms-0" href="profil.php?go=profil">Profil</a>
              <a class="nav-link active" href="profil_password.php?go=profil">Password</a>
            </nav>
            <hr class="mt-0 mb-4">
            <div class="row">
              <div class="col-xl-4">
                <!-- Foto Profil card-->
                <div class="card mb-4 mb-xl-0">
                  <div class="card-header">Foto Profil</div>
                  <div class="card-body text-center">
                    <form action="profil_foto_profil_ubah.php" method="post" enctype="multipart/form-data">
                      <!-- Foto Profil image-->
                      <img class="img-account-profile rounded-circle mb-2" src="<?= $path_foto_profil ?>" alt="">
                      <!-- Foto Profil help block-->
                      <div class="small font-italic text-muted mb-4">JPG atau PNG tidak lebih dari 500 KB</div>
                      <!-- Foto Profil upload button-->
                      <button class="btn btn-primary" type="button" onclick="document.getElementById('xfoto_profil').click()">Unggah foto profil baru</button>
                      <input class="form-control d-none" id="xfoto_profil" type="file" name="xfoto_profil" accept=".jpg,.png" required>
                    </form>
                    <hr>
                    <div class="mt-4 text-start">
                      <!-- Ubah Password (Nama Pegawai) -->
                      <div class="small mt-1">
                        <i data-feather="user" class="me-3"></i>
                        <?= $pegawai['nama_pegawai'] ?? '<small class="text-muted">Tidak ada</small>' ?>
                      </div>
                      <!-- Ubah Password (Nama Jabatan) -->
                      <div class="small mt-1">
                        <i data-feather="briefcase" class="me-3"></i>
                        <?= $pegawai['nama_jabatan'] ?? '<small class="text-muted">Tidak ada</small>' ?>
                      </div>
                      <!-- Ubah Password (Hak Akses) -->
                      <div class="small mt-1">
                        <i data-feather="key" class="me-3"></i>
                        <?= $hak_akses ?? '<small class="text-muted">Tidak ada</small>' ?>
                      </div>
                      <!-- Ubah Password (Alamat) -->
                      <div class="small mt-1">
                        <i data-feather="home" class="me-3"></i>
                        <?= $pegawai['alamat'] ?? '<small class="text-muted">Tidak ada</small>' ?>
                      </div>
                      <!-- Ubah Password (Tempat, Tanggal Lahir) -->
                      <div class="small mt-1">
                        <i data-feather="gift" class="me-3"></i>
                        <?= $pegawai['tmp_lahir'] ? "{$pegawai['tmp_lahir']}, " : '<small class="text-muted">Tidak ada, </small>' ?>
                        <?= $tgl_lahir ?? '<small class="text-muted">xx xx xxxx</small>' ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-8" id="detail_akun">
                <!-- Ubah Password card-->
                <div class="card mb-4">
                  <div class="card-header">Ubah Password</div>
                  <div class="card-body">
                    <form action="profil_password_ubah.php" method="post">
          
                      <!-- Form Group (Password Saat Ini)-->
                      <div class="mb-3">
                        <label class="small mb-1" for="xpassword_saat_ini">Password Saat Ini <span class="text-danger fw-bold">*</span></label>
                        <div class="input-group input-group-joined mb-1">
                          <input class="form-control mb-1" id="xpassword_saat_ini" type="password" name="xpassword_saat_ini" placeholder="Enter password saat ini" autocomplete="current-password" required>
                          <button class="input-group-text" id="xpassword_saat_ini_toggle" type="button"><i class="fa-regular fa-eye"></i></button>
                        </div>
                        <small class="text-danger fade-in-up d-none xpassword_saat_ini_help" id="xpassword_saat_ini_help">Password salah!</small>
                      </div>
                        
                      <!-- Form Group (Password Baru)-->
                      <div class="mb-3">
                        <label class="small mb-1" for="xpassword_baru">Password Baru <span class="text-danger fw-bold">*</span></label>
                        <div class="input-group input-group-joined mb-1">
                          <input class="form-control mb-1" id="xpassword_baru" type="password" name="xpassword_baru" placeholder="Enter password baru" autocomplete="new-password" required>
                          <button class="input-group-text" id="xpassword_baru_toggle" type="button"><i class="fa-regular fa-eye"></i></button>
                        </div>
                        <small class="text-danger fade-in-up d-none xpassword_baru_help" id="xpassword_baru_help">Password tidak sama!</small>
                      </div>
          
                      <!-- Form Group (Konfirmasi Password Baru)-->
                      <div class="mb-3">
                        <label class="small mb-1" for="xpassword_konfirmasi">Konfirmasi Password Baru <span class="text-danger fw-bold">*</span></label>
                        <div class="input-group input-group-joined mb-1">
                          <input class="form-control mb-1" id="xpassword_konfirmasi" type="password" name="xpassword_konfirmasi" placeholder="Enter konfirmasi password baru" autocomplete="new-password" required>
                          <button class="input-group-text" id="xpassword_konfirmasi_toggle" type="button"><i class="fa-regular fa-eye"></i></button>
                        </div>
                        <small class="text-danger fade-in-up d-none xpassword_konfirmasi_help" id="xpassword_konfirmasi_help">Password tidak sama!</small>
                      </div>
          
                      <!-- Simpan button-->
                      <button class="btn btn-primary toggle_swal_submit" type="button">Simpan</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </main>
        
        <!--============================= FOOTER =============================-->
        <?php include '_partials/footer.php' ?>
        <!--//END FOOTER -->

      </div>
    </div>
    
    <?php include '_partials/script.php' ?>
    <?php include '../helpers/sweetalert2_notify.php' ?>

    <!-- PAGE SCRIPT -->
    <script>
        let passwordSaatIni = document.getElementById('xpassword_saat_ini');
        let passwordSaatIniToggle = document.getElementById('xpassword_saat_ini_toggle');
        let passwordSaatIniHelp = document.getElementById('xpassword_saat_ini_help');
        
        let passwordBaru = document.getElementById('xpassword_baru');
        let passwordBaruToggle = document.getElementById('xpassword_baru_toggle');
        let passwordBaruHelp = document.getElementById('xpassword_baru_help');
        
        let passwordKonfirmasi = document.getElementById('xpassword_konfirmasi');
        let passwordKonfirmasiToggle = document.getElementById('xpassword_konfirmasi_toggle');
        let passwordKonfirmasiHelp = document.getElementById('xpassword_konfirmasi_help');
        
        passwordSaatIniToggle.addEventListener('click', function() {
          initTogglePassword(passwordSaatIni, passwordSaatIniToggle);
        });
        
        passwordBaruToggle.addEventListener('click', function() {
          initTogglePassword(passwordBaru, passwordBaruToggle);
        });
        
        passwordKonfirmasiToggle.addEventListener('click', function() {
          initTogglePassword(passwordKonfirmasi, passwordKonfirmasiToggle);
        });

        passwordBaru.addEventListener('keyup', function() {
          initIsPasswordSame(passwordBaru, passwordKonfirmasi, passwordBaruHelp, passwordKonfirmasiHelp);
        });

        passwordKonfirmasi.addEventListener('keyup', function() {
          initIsPasswordSame(passwordBaru, passwordKonfirmasi, passwordBaruHelp, passwordKonfirmasiHelp);
        });
    </script>

    <script>
      $(document).ready(function() {
        const formSubmitBtn = $('.toggle_swal_submit');
        const eventName = 'click';
        const form = $('#detail_akun form');
        
        toggleSwalSubmit(formSubmitBtn, eventName, form);

        
        $('#xfoto_profil').on('input', function() {
          const form = $(this).parents('form');
          
          form.submit();
        });
        

        let passwordSaatIni = $('#xpassword_saat_ini');
        let passwordSaatIniHelp = $('#xpassword_saat_ini_help');
        
        passwordSaatIni.on('keyup', function() {
          const id_pengguna = `<?= $_SESSION['id_pengguna'] ?>`;
          const password = $(this).val();
        
          setTimeout(() => {
            $.ajax({
              url: 'get_is_password_correct.php',
              method: 'POST',
              dataType: 'JSON',
              data: {
                'id_pengguna' : id_pengguna,
                'password' : password,
              },
              success: function(isCorrect) {
                console.log(isCorrect)
                !isCorrect
                  ? passwordSaatIniHelp.removeClass('d-none')
                  : passwordSaatIniHelp.addClass('d-none');
              },
              error: function(request, status, error) {
                // console.log("ajax call went wrong:" + request.responseText);
                console.log("ajax call went wrong:" + error);
              }
            });
          }, 1000);
        });
        
      });
    </script>

  </body>

  </html>

<?php endif ?>