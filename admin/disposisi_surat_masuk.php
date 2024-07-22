<?php
include '../helpers/isAccessAllowedHelper.php';

// cek apakah user yang mengakses adalah admin?
if (!isAccessAllowed('admin')) :
  session_destroy();
  echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
else :
  include_once '../config/connection.php';
?>


  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php include '_partials/head.php' ?>

    <meta name="description" content="Data Disposisi Surat Masuk" />
    <meta name="author" content="" />
    <title>Disposisi Surat Masuk - <?= SITE_NAME ?></title>
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
        <main>
          <!-- Main page content-->
          <div class="container-xl px-4 mt-5">

            <!-- Custom page header alternative example-->
            <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
              <div class="me-4 mb-3 mb-sm-0">
                <h1 class="mb-0">Disposisi Surat Masuk</h1>
                <div class="small">
                  <span class="fw-500 text-primary"><?= date('D') ?></span>
                  &middot; <?= date('M d, Y') ?> &middot; <?= date('H:i') ?> WIB
                </div>
              </div>

              <!-- Date range picker example-->
              <div class="input-group input-group-joined border-0 shadow w-auto">
                <span class="input-group-text"><i data-feather="calendar"></i></span>
                <input class="form-control ps-0 pointer" id="litepickerRangePlugin" value="Tanggal: <?= date('d M Y') ?>" readonly />
              </div>

            </div>
            
            <!-- Main page content-->
            <div class="card card-header-actions mb-4 mt-5">
              <div class="card-header">
                <div>
                  <i data-feather="briefcase" class="me-2 mt-1"></i>
                  Data Disposisi Surat Masuk
                </div>
                <button class="btn btn-sm btn-primary toggle_modal_tambah" type="button"><i data-feather="plus-circle" class="me-2"></i>Tambah Data</button>
              </div>
              <div class="card-body">
                <table id="datatablesSimple">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Tgl. Penyelesaian</th>
                      <th>Instruksi</th>
                      <th>Diteruskan Ke</th>
                      <th>No Surat</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    $query_disposisi_surat_masuk = mysqli_query($connection,
                      "SELECT
                        a.id AS id_disposisi_surat_masuk, a.instruksi, a.tgl_penyelesaian,
                        b.id AS id_tujuan_disposisi_surat_masuk,
                        GROUP_CONCAT(DISTINCT c.nama_jabatan SEPARATOR ', ') AS diteruskan_ke,
                        GROUP_CONCAT(DISTINCT c.id) AS id_diteruskan_ke,
                        d.id AS id_surat_masuk, d.asal_surat, d.no_surat, d.tgl_surat, d.perihal_indeks, d.isi_surat, d.jml_lampiran, d.file_sm
                      FROM tbl_disposisi_surat_masuk AS a
                      LEFT JOIN tbl_tujuan_disposisi_surat_masuk AS b
                        ON a.id = b.id_disposisi_surat_masuk
                      LEFT JOIN tbl_jabatan AS c
                        ON c.id = b.id_jabatan
                      LEFT JOIN tbl_surat_masuk AS d
                        ON d.id = a.id_surat_masuk
                      GROUP BY a.id
                      ORDER BY a.id DESC");

                    while ($disposisi_surat_masuk = mysqli_fetch_assoc($query_disposisi_surat_masuk)):
                    ?>

                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $disposisi_surat_masuk['tgl_penyelesaian'] ?></td>
                        <td><?= $disposisi_surat_masuk['instruksi'] ?></td>
                        <td>
                          <div class="ellipsis toggle_tooltip" title="<?= $disposisi_surat_masuk['diteruskan_ke'] ?>">
                            <?= $disposisi_surat_masuk['diteruskan_ke'] ?>
                          </div>
                        </td>
                        <td><?= $disposisi_surat_masuk['no_surat'] ?></td>
                        <td>
                          <button class="btn btn-datatable btn-icon btn-transparent-dark me-2 toggle_modal_ubah"
                            data-id_disposisi_surat_masuk="<?= $disposisi_surat_masuk['id_disposisi_surat_masuk'] ?>" 
                            data-id_surat_masuk="<?= $disposisi_surat_masuk['id_surat_masuk'] ?>" 
                            data-tgl_penyelesaian="<?= $disposisi_surat_masuk['tgl_penyelesaian'] ?>" 
                            data-instruksi="<?= $disposisi_surat_masuk['instruksi'] ?>" 
                            data-id_diteruskan_ke="<?= $disposisi_surat_masuk['id_diteruskan_ke'] ?>">
                            <i class="fa fa-pen-to-square"></i>
                          </button>
                          <button class="btn btn-datatable btn-icon btn-transparent-dark me-2 toggle_swal_hapus"
                            data-id_disposisi_surat_masuk="<?= $disposisi_surat_masuk['id_disposisi_surat_masuk'] ?>" 
                            data-instruksi="<?= $disposisi_surat_masuk['instruksi'] ?>" 
                            data-no_surat="<?= $disposisi_surat_masuk['no_surat'] ?>">
                            <i class="fa fa-trash-can"></i>
                          </button>
                        </td>
                      </tr>

                    <?php endwhile ?>
                  </tbody>
                </table>
              </div>
            </div>
            
          </div>
        </main>
        
        <!--============================= FOOTER =============================-->
        <?php include '_partials/footer.php' ?>
        <!--//END FOOTER -->

      </div>
    </div>
    
    <!--============================= MODAL INPUT DISPOSISI SURAT MASUK =============================-->
    <div class="modal fade" id="ModalInputJabatan" tabindex="-1" role="dialog" aria-labelledby="ModalInputJabatanTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ModalInputJabatanTitle">Modal title</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form>
            <div class="modal-body">
              
              <input type="hidden" id="xid_disposisi_surat_masuk" name="xid_disposisi_surat_masuk">
              
              <div class="mb-3">
                <label class="small mb-1" for="xid_surat_masuk">Surat Masuk (id, no surat) <span class="text-danger fw-bold">*</span></label>
                <select name="xid_surat_masuk" class="form-control mb-1 select2" id="xid_surat_masuk">
                  <option value="">-- Pilih --</option>
                  <?php $query_surat_masuk = mysqli_query($connection, "SELECT id, no_surat FROM tbl_surat_masuk ORDER BY id ASC") ?>
                  <?php while ($surat_masuk = mysqli_fetch_assoc($query_surat_masuk)): ?>
  
                    <option value="<?= $surat_masuk['id'] ?>"><?= "{$surat_masuk['id']} -- {$surat_masuk['no_surat']}" ?></option>
  
                  <?php endwhile ?>
                </select>
              </div>
            
              <div class="mb-3">
                <label class="small mb-1" for="xtgl_penyelesaian">Tanggal Penyelesaian <span class="text-danger fw-bold">*</span></label>
                <input type="date" name="xtgl_penyelesaian" value="<?= date('Y-m-d') ?>" class="form-control" id="xtgl_penyelesaian" required />
              </div>
              
              <div class="mb-3">
                <label class="small mb-1" for="xid_diteruskan_ke">Diteruskan ke <span class="text-danger fw-bold">*</span></label>
                <select name="xid_diteruskan_ke[]" class="form-control mb-1 select2" id="xid_diteruskan_ke" multiple="multiple">
                  <option value="">-- Pilih --</option>
                  <?php $query_jabatan = mysqli_query($connection, "SELECT id, nama_jabatan FROM tbl_jabatan ORDER BY nama_jabatan ASC") ?>
                  <?php while ($jabatan = mysqli_fetch_assoc($query_jabatan)): ?>
  
                    <option value="<?= $jabatan['id'] ?>"><?= $jabatan['nama_jabatan'] ?></option>
  
                  <?php endwhile ?>
                </select>
              </div>
            
              <div class="mb-3">
                <label class="small mb-1" for="xinstruksi">Instruksi</label>
                <input type="text" name="xinstruksi" class="form-control" id="xinstruksi" placeholder="Enter instruksi" required />
              </div>

            </div>
            <div class="modal-footer">
              <button class="btn btn-light border" type="button" data-bs-dismiss="modal">Batal</button>
              <button class="btn btn-primary" id="toggle_swal_submit" type="submit">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!--/.modal-input-disposisi-surat-masuk -->
    
    <?php include '_partials/script.php' ?>
    <?php include '../helpers/sweetalert2_notify.php' ?>
    
    <!-- PAGE SCRIPT -->
    <script>
      $(document).ready(function() {
        $('.toggle_modal_tambah').on('click', function() {
          $('#ModalInputJabatan .modal-title').html(`<i data-feather="plus-circle" class="me-2 mt-1"></i>Tambah Disposisi Surat Masuk`);
          $('#ModalInputJabatan form').attr({action: 'disposisi_surat_masuk_tambah.php', method: 'post'});

          // Re-init all feather icons
          feather.replace();
          
          $('#ModalInputJabatan').modal('show');
        });


        $('.toggle_modal_ubah').on('click', function() {
          const data = $(this).data();
          const id_diteruskan_ke_arr = data.id_diteruskan_ke.split(',');
          
          $('#ModalInputJabatan .modal-title').html(`<i data-feather="edit" class="me-2 mt-1"></i>Ubah Disposisi Surat Masuk`);
          $('#ModalInputJabatan form').attr({action: 'disposisi_surat_masuk_ubah.php', method: 'post'});

          $('#ModalInputJabatan #xid_disposisi_surat_masuk').val(data.id_disposisi_surat_masuk);
          $('#ModalInputJabatan #xid_surat_masuk').val(data.id_surat_masuk).trigger('change');
          $('#ModalInputJabatan #xtgl_penyelesaian').val(data.tgl_penyelesaian);
          $('#ModalInputJabatan #xid_diteruskan_ke').val(id_diteruskan_ke_arr).trigger('change');
          $('#ModalInputJabatan #xinstruksi').val(data.instruksi);

          // Re-init all feather icons
          feather.replace();
          
          $('#ModalInputJabatan').modal('show');
        });
        

        $('#datatablesSimple').on('click', '.toggle_swal_hapus', function() {
          const id_disposisi_surat_masuk = $(this).data('id_disposisi_surat_masuk');
          const no_surat = $(this).data('no_surat');
          const instruksi = $(this).data('instruksi');
          
          Swal.fire({
            title: "Konfirmasi Tindakan?",
            html: `<div class="mb-1">Hapus data disposisi surat masuk: </div><strong>${no_surat} -- ${instruksi}?</strong>`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, konfirmasi!"
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire({
                title: "Tindakan Dikonfirmasi!",
                text: "Halaman akan di-reload untuk memproses.",
                icon: "success",
                timer: 3000
              }).then(() => {
                window.location = `disposisi_surat_masuk_hapus.php?xid_disposisi_surat_masuk=${id_disposisi_surat_masuk}`;
              });
            }
          });
        });
        

        const formSubmitBtn = $('#toggle_swal_submit');
        const eventName = 'click';
        toggleSwalSubmit(formSubmitBtn, eventName);
        
      });
    </script>

  </body>

  </html>

<?php endif ?>