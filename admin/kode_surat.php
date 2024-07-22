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

    <meta name="description" content="Data Kode Surat" />
    <meta name="author" content="" />
    <title>Kode Surat - <?= SITE_NAME ?></title>
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
                <h1 class="mb-0">Kode Surat</h1>
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
                  <i data-feather="hash" class="me-2 mt-1"></i>
                  Data Kode Surat
                </div>
                <button class="btn btn-sm btn-primary toggle_modal_tambah" type="button"><i data-feather="plus-circle" class="me-2"></i>Tambah Data</button>
              </div>
              <div class="card-body">
                <table id="datatablesSimple">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Kode Surat</th>
                      <th>Nama Kode</th>
                      <th>Keterangan</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    $query_kode_surat = mysqli_query($connection, "SELECT * FROM tbl_kode_surat ORDER BY id DESC");

                    while ($kode_surat = mysqli_fetch_assoc($query_kode_surat)):
                    ?>

                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $kode_surat['kode_surat'] ?></td>
                        <td><?= $kode_surat['nama_kode'] ?></td>
                        <td>
                          <?php if (!$kode_surat['keterangan']): ?>

                            <small class="text-muted">Tidak ada</small>
                            
                          <?php else: ?>
                            
                            <div class="ellipsis toggle_tooltip" title="<?= $kode_surat['keterangan'] ?>">
                              <?= $kode_surat['keterangan'] ?>
                            </div>
                            
                          <?php endif ?>
                        </td>
                        <td>
                          <button class="btn btn-datatable btn-icon btn-transparent-dark me-2 toggle_modal_ubah"
                            data-id_kode_surat="<?= $kode_surat['id'] ?>" 
                            data-kode_surat="<?= $kode_surat['kode_surat'] ?>" 
                            data-nama_kode="<?= $kode_surat['nama_kode'] ?>"
                            data-keterangan="<?= $kode_surat['keterangan'] ?>">
                            <i class="fa fa-pen-to-square"></i>
                          </button>
                          <button class="btn btn-datatable btn-icon btn-transparent-dark me-2 toggle_swal_hapus"
                            data-id_kode_surat="<?= $kode_surat['id'] ?>" 
                            data-kode_surat="<?= $kode_surat['kode_surat'] ?>" 
                            data-nama_kode="<?= $kode_surat['nama_kode'] ?>">
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
    
    <!--============================= MODAL INPUT KODE SURAT =============================-->
    <div class="modal fade" id="ModalInputKodeSurat" tabindex="-1" role="dialog" aria-labelledby="ModalInputKodeSuratTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ModalInputKodeSuratTitle">Modal title</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form>
            <div class="modal-body">
              
              <input type="hidden" id="xid_kode_surat" name="xid_kode_surat">
            
              <div class="mb-3">
                <label class="small mb-1" for="xkode_surat">Kode Surat</label>
                <input type="text" name="xkode_surat" maxlength="64" class="form-control" id="xkode_surat" placeholder="Enter kode surat" required />
              </div>
            
              <div class="mb-3">
                <label class="small mb-1" for="xnama_kode">Nama Kode</label>
                <input type="text" name="xnama_kode" maxlength="255" class="form-control" id="xnama_kode" placeholder="Enter nama kode" required />
              </div>
            
              <div class="mb-3">
                <label class="small mb-1" for="xketerangan">Keterangan</label>
                <textarea class="form-control" id="xketerangan" name="xketerangan" rows="5" placeholder="" autocomplete="off"></textarea>
              </div>

            </div>
            <div class="modal-footer">
              <button class="btn btn-light border" type="button" data-bs-dismiss="modal">Batal</button>
              <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!--/.modal-input-kode-surat -->
    
    <?php include '_partials/script.php' ?>
    <?php include '../helpers/sweetalert2_notify.php' ?>
    
    <!-- PAGE SCRIPT -->
    <script>
      $(document).ready(function() {
        $('.toggle_modal_tambah').on('click', function() {
          $('#ModalInputKodeSurat .modal-title').html(`<i data-feather="plus-circle" class="me-2 mt-1"></i>Tambah Kode Surat`);
          $('#ModalInputKodeSurat form').attr({action: 'kode_surat_tambah.php', method: 'post'});

          // Re-init all feather icons
          feather.replace();
          
          $('#ModalInputKodeSurat').modal('show');
        });


        $('.toggle_modal_ubah').on('click', function() {
          const data = $(this).data();
          
          $('#ModalInputKodeSurat .modal-title').html(`<i data-feather="edit" class="me-2 mt-1"></i>Ubah Kode Surat`);
          $('#ModalInputKodeSurat form').attr({action: 'kode_surat_ubah.php', method: 'post'});

          $('#ModalInputKodeSurat #xid_kode_surat').val(data.id_kode_surat);
          $('#ModalInputKodeSurat #xkode_surat').val(data.kode_surat);
          $('#ModalInputKodeSurat #xnama_kode').val(data.nama_kode);
          $('#ModalInputKodeSurat #xketerangan').val(data.keterangan);

          // Re-init all feather icons
          feather.replace();
          
          $('#ModalInputKodeSurat').modal('show');
        });
        

        $('#datatablesSimple').on('click', '.toggle_swal_hapus', function() {
          const id_kode_surat   = $(this).data('id_kode_surat');
          const nama_kode = $(this).data('nama_kode');
          
          Swal.fire({
            title: "Konfirmasi Tindakan?",
            html: `Hapus data kode_surat: <strong>${nama_kode}?</strong>`,
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
                window.location = `kode_surat_hapus.php?xid_kode_surat=${id_kode_surat}`;
              });
            }
          });
        });
        
      });
    </script>

  </body>

  </html>

<?php endif ?>