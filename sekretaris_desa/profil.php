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
                      Pengaturan Akun - Profil
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
              <a class="nav-link active ms-0" href="profil.php?go=profil">Profil</a>
              <a class="nav-link" href="profil_password.php?go=profil">Password</a>
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
                      <!-- Form Group (Halaman Saat ini)-->
                      <input class="form-control d-none" id="xhalaman_saat_ini" type="text" name="xhalaman_saat_ini" value="profil">
                    </form>
                    <hr>
                    <div class="mt-4 text-start">
                      <!-- Detail Akun (Nama Pegawai) -->
                      <div class="small mt-1">
                        <i data-feather="user" class="me-3"></i>
                        <?= $pegawai['nama_pegawai'] ?? '<small class="text-muted">Tidak ada</small>' ?>
                      </div>
                      <!-- Detail Akun (Nama Jabatan) -->
                      <div class="small mt-1">
                        <i data-feather="briefcase" class="me-3"></i>
                        <?= $pegawai['nama_jabatan'] ?? '<small class="text-muted">Tidak ada</small>' ?>
                      </div>
                      <!-- Detail Akun (Hak Akses) -->
                      <div class="small mt-1">
                        <i data-feather="key" class="me-3"></i>
                        <?= $hak_akses ?? '<small class="text-muted">Tidak ada</small>' ?>
                      </div>
                      <!-- Detail Akun (Alamat) -->
                      <div class="small mt-1">
                        <i data-feather="home" class="me-3"></i>
                        <?= $pegawai['alamat'] ?? '<small class="text-muted">Tidak ada</small>' ?>
                      </div>
                      <!-- Detail Akun (Tempat, Tanggal Lahir) -->
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
                <!-- Detail Akun card-->
                <div class="card mb-4">
                  <div class="card-header">Detail Akun</div>
                  <div class="card-body">
                    <form action="profil_ubah.php" method="post">
          
                      <!-- Form Group (Alamat)-->
                      <div class="mb-3">
                        <label class="small mb-1" for="xalamat">Alamat <span class="text-danger fw-bold">*</span></label>
                        <input class="form-control" id="xalamat" type="text" name="xalamat" value="<?= $pegawai['alamat'] ?? '' ?>" placeholder="Enter alamat" required>
                      </div>
          
                      <!-- Form Row-->
                      <div class="row gx-3 mb-3">
                        <!-- Form Group (Tempat Lahir)-->
                        <div class="col-md-6">
                          <label class="small mb-1" for="xtmp_lahir">Tempat Lahir <span class="text-danger fw-bold">*</span></label>
                          <input class="form-control" id="xtmp_lahir" type="text" name="xtmp_lahir" value="<?= $pegawai['tmp_lahir'] ?? '' ?>" placeholder="Enter tempat lahir" required>
                        </div>
                        <!-- Form Group (Tanggal Lahir)-->
                        <div class="col-md-6">
                          <label class="small mb-1" for="xtgl_lahir">Tanggal Lahir <span class="text-danger fw-bold">*</span></label>
                          <input class="form-control" id="xtgl_lahir" type="date" name="xtgl_lahir" value="<?= $pegawai['tgl_lahir'] ?? '' ?>" required>
                        </div>
                      </div>
          
                      <!-- Form Group (Jabatan)-->
                      <div class="mb-3">
                        <label class="small mb-1" for="xid_pangkat_golongan">Jabatan <span class="text-danger fw-bold">*</span></label>
                        <select name="xid_jabatan" class="form-control select2" id="xid_jabatan" required>
                          <option value="">-- Pilih --</option>
                          <?php
                          $query_jabatan = mysqli_query($connection, "SELECT * FROM tbl_jabatan");

                          while ($jabatan = mysqli_fetch_assoc($query_jabatan)) :
                            $is_selected = $jabatan['id'] == $pegawai['id_jabatan'] ? 'selected' : '';
                          ?>
            
                            <option value="<?= $jabatan['id'] ?>" <?= $is_selected ?>><?= $jabatan['nama_jabatan'] ?></option>
            
                          <?php endwhile ?>
                        </select>
                      </div>
          
                      <!-- Form Group (Pangkat/Golongan)-->
                      <div class="mb-3">
                        <label class="small mb-1" for="xid_pangkat_golongan">Pangkat/Golongan <span class="text-danger fw-bold">*</span></label>
                        <select name="xid_pangkat_golongan" class="form-control select2" id="xid_pangkat_golongan" required>
                          <option value="">-- Pilih --</option>
                          <?php
                          $query_pangkat_golongan = mysqli_query($connection, "SELECT * FROM tbl_pangkat_golongan");
                          
                          while ($pangkat_golongan = mysqli_fetch_assoc($query_pangkat_golongan)) :
                            $is_selected = $pangkat_golongan['id'] == $pegawai['id_pangkat_golongan'] ? 'selected' : '';
                          ?>
            
                            <option value="<?= $pangkat_golongan['id'] ?>" <?= $is_selected ?>><?= $pangkat_golongan['nama_pangkat_golongan'] ?></option>
            
                          <?php endwhile ?>
                        </select>
                      </div>
          
                      <!-- Form Row-->
                      <div class="row gx-3 mb-3">
                        <!-- Form Group (Pendidikan)-->
                        <div class="col-md-4">
                          <label class="small mb-1" for="xid_pendidikan">Pendidikan <span class="text-danger fw-bold">*</span></label>
                          <select name="xid_pendidikan" class="form-control select2" id="xid_pendidikan" required>
                            <option value="">-- Pilih --</option>
                            <?php
                            $query_pendidikan = mysqli_query($connection, "SELECT * FROM tbl_pendidikan WHERE nama_pendidikan NOT IN ('SD', 'SMP', 'sd', 'smp', 'tidak_sekolah')");
                            
                            while ($pendidikan = mysqli_fetch_assoc($query_pendidikan)) :
                              $is_selected = $pendidikan['id'] == $pegawai['id_pendidikan'] ? 'selected' : '';
                            ?>
          
                              <option value="<?= $pendidikan['id'] ?>" <?= $is_selected ?>><?= $pendidikan['nama_pendidikan'] ?></option>
          
                            <?php endwhile ?>
                          </select>
                        </div>
                        <!-- Form Group (birthday)-->
                        <div class="col-md-8">
                          <label class="small mb-1" for="xid_jurusan">Jurusan <span class="text-danger fw-bold">*</span></label>
                          <span class="form-control text-danger xid_jurusan">Pilih pendidikan terlebih dahulu!</span>
                        </div>
                      </div>
          
                      <!-- Form Group (Tahun Ijzah)-->
                      <div class="mb-3">
                        <label class="small mb-1" for="xtahun_ijazah">Tahun Ijazah <span class="text-danger fw-bold">*</span></label>
                        <input class="form-control" id="xtahun_ijazah" type="text" name="xtahun_ijazah" value="<?= $pegawai['tahun_ijazah'] ?>" placeholder="Enter tahun ijazah" required>
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
      $(document).ready(function() {
        
        const selectDetailAkun = $('#detail_akun .select2');
        initSelect2(selectDetailAkun, {
          width: '100%',
          dropdownParent: "#detail_akun"
        });
        

        const formSubmitBtn = $('.toggle_swal_submit');
        const eventName = 'click';
        const form = $('#detail_akun form');
        
        toggleSwalSubmit(formSubmitBtn, eventName, form);


        $('#xfoto_profil').on('input', function() {
          const form = $(this).parents('form');
          
          form.submit();
        });
        
        
        $('#xid_pendidikan').on('change', function() {
          const id_pendidikan = $(this).val();
          const nama_pendidikan = $(this).find('option:selected').text();
        
          $.ajax({
            url: 'get_jurusan_pendidikan.php',
            method: 'POST',
            dataType: 'JSON',
            data: {
              'id_pendidikan' : id_pendidikan,
            },
            success: function(data) {
              if (!id_pendidikan) {
                $('#detail_akun span.xid_jurusan').html('Pilih pendidikan terlebih dahulu!');
                $('#detail_akun span.xid_jurusan').removeClass('form-control'); // to make sure there's no form-control before adding new one
                $('#detail_akun span.xid_jurusan').addClass('form-control');
                return;
              }
        
              if (['tidak_sekolah', 'sd', 'smp', 'sltp'].includes(nama_pendidikan.toLowerCase())) {
                $('#detail_akun span.xid_jurusan').html('Tidak perlu diisi.');
                $('#detail_akun span.xid_jurusan').removeClass('form-control'); // to make sure there's no form-control before adding new one
                $('#detail_akun span.xid_jurusan').addClass('form-control');
                return;
              }
        
              // set select html for select2 initialization
              const jurusan_select2_html = `<select name="xid_jurusan" class="form-control form-control-sm select2 xid_jurusan" id="xid_jurusan" required style="width: 100%"></select>`;
              
              // Clear text and specific style for span id jurusan
              $('#detail_akun span.xid_jurusan').html(jurusan_select2_html);
              $('#detail_akun span.xid_jurusan').removeClass('form-control');
        
              // Transform the data to the format that Select2 expects
              var transformedData = data.map(item => ({
                id: item.id_jurusan,
                text: item.nama_jurusan
              }));
              
              const jurusanSelect = $('select#xid_jurusan');
              jurusanSelect.select2({ 'width': '100%' });
              
              // Clear the select element
              jurusanSelect.html(null);
              
              // Set the transformed data to the select element using select2 method
              initSelect2(jurusanSelect, {
                width: '100%',
                dropdownParent: "#detail_akun",
                data: transformedData
              });
              
            },
            error: function(request, status, error) {
              // console.log("ajax call went wrong:" + request.responseText);
              console.log("ajax call went wrong:" + error);
            }
          })
        });

        $('#xid_pendidikan').trigger('change');
        
      });
    </script>

  </body>

  </html>

<?php endif ?>