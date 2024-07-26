<?php
include '../helpers/isAccessAllowedHelper.php';

// cek apakah user yang mengakses adalah pengelola_surat?
if (!isAccessAllowed('pengelola_surat')) :
  session_destroy();
  echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
else :
  include_once '../config/connection.php';
?>


  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php include '_partials/head.php' ?>

    <meta name="description" content="Data Surat Masuk" />
    <meta name="author" content="" />
    <title>Surat Masuk - <?= SITE_NAME ?></title>
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
                <h1 class="mb-0">Surat Masuk</h1>
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
            
            <!-- Tools Cetak Pengumuman -->
            <div class="card mb-4 mt-5">
              <div class="card-header">
                <div>
                  <i data-feather="settings" class="me-2 mt-1"></i>
                  Tools Cetak Laporan
                </div>
              </div>
              <div class="card-body">
                <div class="row gx-3">
                  <div class="col-md-2 mb-3">
                    <label class="small mb-1" for="xdari_tanggal">Dari Tanggal</label>
                    <input class="form-control" id="xdari_tanggal" type="date" name="xdari_tanggal" required>
                  </div>
                  <div class="col-md-2 mb-3">
                    <label class="small mb-1" for="xsampai_tanggal">Sampai Tanggal</label>
                    <input class="form-control" id="xsampai_tanggal" type="date" name="xsampai_tanggal" required>
                  </div>
                  <div class="col-md-2 mb-3">
                    <label class="small mb-1 invisible" for="xcetak_laporan">Filter Button</label>
                    <button class="btn btn-primary w-100" id="xcetak_laporan" type="button">
                      <i data-feather="printer" class="me-1"></i>
                      Cetak
                    </button>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Main page content-->
            <div class="card card-header-actions mb-4 mt-5">
              <div class="card-header">
                <div>
                  <i data-feather="inbox" class="me-2 mt-1"></i>
                  Data Surat Masuk
                </div>
                <button class="btn btn-sm btn-primary toggle_modal_tambah" type="button"><i data-feather="plus-circle" class="me-2"></i>Tambah Data</button>
              </div>
              <div class="card-body">
                <table class="table table-hover table-bordered datatables" id="tabel_surat_masuk" cellspacing="0" width="100%" style="font-size: 0.875rem">
                  <thead>
                    <tr>
                      <th></th>
                      <th>#</th>
                      <th>Kode Surat</th>
                      <th>No Surat</th>
                      <th>Asal Surat</th>
                      <th>Tgl. Surat</th>
                      <th>Indeks</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>

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
    
    <!--============================= MODAL INPUT SURAT MASUK =============================-->
    <div class="modal fade" id="ModalInputSuratKeluar" tabindex="-1" role="dialog" aria-labelledby="ModalInputSuratKeluarTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ModalInputSuratKeluarTitle">Modal title</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form>
            <div class="modal-body">
              
              <input type="hidden" id="xid_surat_masuk" name="xid_surat_masuk">
              
              <div class="mb-3">
                <label class="small mb-1" for="xid_kode_surat">Kode Surat <span class="text-danger fw-bold">*</span></label>
                <select name="xid_kode_surat" class="form-control mb-1 select2" id="xid_kode_surat">
                  <option value="">-- Pilih --</option>
                  <?php $query_kode_surat = mysqli_query($connection, "SELECT * FROM tbl_kode_surat ORDER BY kode_surat ASC") ?>
                  <?php while ($kode_surat = mysqli_fetch_assoc($query_kode_surat)): ?>
  
                    <option value="<?= $kode_surat['id'] ?>"><?= "{$kode_surat['kode_surat']} -- {$kode_surat['nama_kode']}" ?></option>
  
                  <?php endwhile ?>
                </select>
              </div>
              
              <div class="mb-3">
                <label class="small mb-1" for="xno_surat">No Surat <span class="text-danger fw-bold">*</span></label>
                <input type="text" name="xno_surat" class="form-control" id="xno_surat" placeholder="Enter no surat" required />
              </div>
              
              <div class="mb-3">
                <label class="small mb-1" for="xasal_surat">Asal Surat <span class="text-danger fw-bold">*</span></label>
                <input type="text" name="xasal_surat" class="form-control" id="xasal_surat" placeholder="Enter asal surat" required />
              </div>

              <div class="row gx-3">
              
                <div class="col-6 mb-3">
                  <label class="small mb-1" for="xperihal_indeks">Indeks <span class="text-danger fw-bold">*</span></label>
                  <input type="text" name="xperihal_indeks" class="form-control" id="xperihal_indeks" placeholder="Enter indeks" required />
                </div>
              
                <div class="col-6 mb-3">
                  <label class="small mb-1" for="xtgl_surat">Tanggal Surat <span class="text-danger fw-bold">*</span></label>
                  <input type="date" name="xtgl_surat" value="<?= date('Y-m-d') ?>" class="form-control" id="xtgl_surat" required />
                </div>

              </div>
              
              
              <div class="mb-3">
                <label class="small mb-1" for="xisi_surat">Isi Surat <span class="text-danger fw-bold">*</span></label>
                <textarea class="form-control" id="xisi_surat" name="xisi_surat" rows="5" placeholder="Keterangan isi surat" autocomplete="off"></textarea>
              </div>

              <div class="mb-3">
                <label class="small mb-1" for="xjml_lampiran">Jumlah Lampiran <span class="text-danger fw-bold">*</span></label>
                <input type="number" name="xjml_lampiran" min="0" class="form-control" id="xjml_lampiran" placeholder="Enter jumlah lampiran" required />
              </div>
              
              <div class="mb-3">
              <label class="small mb-1" for="xfile_sm">File Surat Masuk</label>
                <input type="file" name="xfile_sm" class="form-control form-control-sm mb-1 dropify xfile_sm" id="xfile_sm" 
                  data-height="100"
                  data-max-file-size="1M"
                  data-allowed-file-extensions="pdf">
                <div class="d-flex flex-column">
                  <small class="text-muted mb-1 xfile_sm_help">*) File <span class="text-danger">.pdf</span> dengan maks. <span class="text-danger">1MB</span></small>
                  <div id="xfile_sm_old"></div>
                </div>
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
    <!--/.modal-input-surat-masuk -->
    
    <?php include '_partials/script.php' ?>
    <?php include '../helpers/sweetalert2_notify.php' ?>
    
    <!-- PAGE SCRIPT -->
    <script>
      $(document).ready(function() {
        
        $('.dropify').dropify({
          messages: {
            'default': 'Drag and drop a file here or click',
            'replace': 'Drag and drop or click to replace',
            'remove':  'Remove',
            'error':   'Ooops, something wrong happended.'
          },
          error: {
            'fileSize': 'Ukuran berkas maksimal ({{ value }}).',
            'minWidth': 'The image width is too small ({{ value }}}px min).',
            'maxWidth': 'The image width is too big ({{ value }}}px max).',
            'minHeight': 'The image height is too small ({{ value }}}px min).',
            'maxHeight': 'The image height is too big ({{ value }}px max).',
            'imageFormat': 'The image format is not allowed ({{ value }} only).',
            'fileExtension': 'Ekstensi file hanya boleh ({{ value }}).'
          }
        });

        
        $('#xcetak_laporan').on('click', function() {
          const dari_tanggal = $('#xdari_tanggal').val();
          const sampai_tanggal = $('#xsampai_tanggal').val();
          
          const url = `laporan_surat_masuk.php?dari_tanggal=${dari_tanggal}&sampai_tanggal=${sampai_tanggal}`;
          
          printExternal(url);
        });

        
        $('.toggle_modal_tambah').on('click', function() {
          $('#ModalInputSuratKeluar .modal-title').html(`<i data-feather="plus-circle" class="me-2 mt-1"></i>Tambah Surat Masuk`);
          $('#ModalInputSuratKeluar form').attr({action: 'surat_masuk_tambah.php', method: 'post', enctype: 'multipart/form-data'});

          // Re-init all feather icons
          feather.replace();
          
          $('#ModalInputSuratKeluar').modal('show');
        });


        $('.toggle_modal_ubah').on('click', function() {
          const id_surat_masuk   = $(this).data('id_surat_masuk');
          const nama_surat_masuk = $(this).data('nama_surat_masuk');
          
          $('#ModalInputSuratKeluar .modal-title').html(`<i data-feather="edit" class="me-2 mt-1"></i>Ubah Surat Masuk`);
          $('#ModalInputSuratKeluar form').attr({action: 'surat_masuk_ubah.php', method: 'post', enctype: 'multipart/form-data'});

          $.ajax({
            url: 'get_surat_masuk.php',
            type: 'POST',
            data: {
              id_surat_masuk: id_surat_masuk
            },
            dataType: 'JSON',
            success: function(data) {
              data = data[0];

              let file_sm_old_html = `<small>File SK lama: </small>`;

              file_sm_old_html += data.file_sm === ''
                ? '<small class="text-muted">Tidak ada</small>'
                : `<a href="<?= base_url_return('assets/uploads/file_sm') ?>${data.file_sm}" target="_blank">file</a>`;
              
              $('#ModalInputSuratKeluar #xid_surat_masuk').val(data.id_surat_masuk);
              $('#ModalInputSuratKeluar #xid_kode_surat').val(data.id_kode_surat).trigger('change');
              $('#ModalInputSuratKeluar #xasal_surat').val(data.asal_surat);
              $('#ModalInputSuratKeluar #xno_surat').val(data.no_surat);
              $('#ModalInputSuratKeluar #xperihal_indeks').val(data.perihal_indeks);
              $('#ModalInputSuratKeluar #xtanggal_surat').val(data.tanggal_surat);
              $('#ModalInputSuratKeluar #xisi_surat').val(data.isi_surat);
              $('#ModalInputSuratKeluar #xcatatan').val(data.catatan);
              $('#ModalInputSuratKeluar #xjml_lampiran').val(data.jml_lampiran);
              $('#ModalInputSuratKeluar #xfile_sm_old').html(file_sm_old_html);
              
              // Re-init all feather icons
              feather.replace();
              
              $('#ModalInputSuratKeluar').modal('show');
            },
            error: function(request, status, error) {
              // console.log("ajax call went wrong:" + request.responseText);
              console.log("ajax call went wrong:" + error);
            }
          })
        });
        

        $('#tabel_surat_masuk').on('click', '.toggle_swal_hapus', function() {
          const id_surat_masuk = $(this).data('id_surat_masuk');
          const kode_surat = $(this).data('kode_surat');
          const no_surat = $(this).data('no_surat');
          
          Swal.fire({
            title: "Konfirmasi Tindakan?",
            html: `<div class="mb-1">Hapus data surat masuk: </div><strong>${kode_surat} -- ${no_surat}?</strong>`,
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
                window.location = `surat_masuk_hapus.php?xid_surat_masuk=${id_surat_masuk}`;
              });
            }
          });
        });
        

        const formSubmitBtn = $('#toggle_swal_submit');
        const eventName = 'click';
        toggleSwalSubmit(formSubmitBtn, eventName);
        
      });
    </script>


    <!-- Script for inner page Agenda Datatables with child row -->
    <script>
      // Formatting function for row details - modify as you need
      function format(d) {

        const file_sm = d.file_sm === ''
          ? '<small class="text-muted">Tidak ada</small>'
          : `<a class="btn btn-xs rounded-pill bg-purple-soft text-purple" href="<?= base_url('assets/uploads/file_sm/') ?>${d.file_sm}" target="_blank">
            <i data-feather="eye" class="me-1"></i>Preview
          </a>
          
          <a class="btn btn-xs rounded-pill bg-blue-soft text-blue" href="<?= base_url('assets/uploads/file_sm/') ?>${d.file_sm}" download>
            <i data-feather="download-cloud" class="me-1"></i>Download
          </a>`;

        // `d` is the original data object for the row
        return (
          '<dl>' +
          '<dt>File Surat Masuk:</dt>' +
          '<dd>' +
          file_sm +
          '</dd>' +
          '<dt>Jml. Lampiran:</dt>' +
          '<dd>' +
          d.jml_lampiran +
          '</dd>' +
          '<dt>Isi Surat:</dt>' +
          '<dd>' +
          d.isi_surat +
          '</dd>' +
          '</dl>'
        );
      }
        
      let table = new DataTable('#tabel_surat_masuk', {  
        ajax: `<?= 'get_all_surat_masuk.php' ?>`,
        order: [],
        columns: [
          {
            className: 'dt-control',
            orderable: false,
            data: null,
            defaultContent: ''
          },
          { 
            data: null,
            className: 'text-start',
            render: function(data, type, row, meta) {
              return meta.row + 1; // Return the row number starting from 1
            }
          }, // Incremental number
          { data: 'kode_surat' },
          { data: 'no_surat' },
          { data: 'asal_surat' },
          { data: 'tgl_surat' },
          { data: 'perihal_indeks' },
          {
            data: null,
            render: function( data, type, row ) {
              return `<button class="btn btn-datatable btn-icon btn-transparent-dark me-2 toggle_modal_ubah"
                  data-id_surat_masuk="${data.id_surat_masuk}">
                  <i class="fa fa-pen-to-square"></i>
                </button>
                <button class="btn btn-datatable btn-icon btn-transparent-dark me-2 toggle_swal_hapus"
                  data-id_surat_masuk="${data.id_surat_masuk}"
                  data-kode_surat="${data.kode_surat}"
                  data-no_surat="${data.no_surat}">
                  <i class="fa fa-trash-can"></i>
                </button>`
            }
          },
        ],
      });
        
      // Add event listener for opening and closing details
      table.on('click', 'td.dt-control', function (e) {
        let tr = e.target.closest('tr');
        let row = table.row(tr);
      
        if (row.child.isShown()) {
          // This row is already open - close it
          row.child.hide();
        }
        else {
          // Open this row
          row.child(format(row.data())).show();
          
          // Re-init all feather icons
          feather.replace();
        }
      });
    </script>

  </body>

  </html>

<?php endif ?>