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

    <meta name="description" content="Data Agenda" />
    <meta name="author" content="" />
    <title>Agenda - <?= SITE_NAME ?></title>
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
                <h1 class="mb-0">Agenda</h1>
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
                  <i data-feather="calendar" class="me-2 mt-1"></i>
                  Data Agenda
                </div>
                <button class="btn btn-sm btn-primary toggle_modal_tambah" type="button"><i data-feather="plus-circle" class="me-2"></i>Tambah Data</button>
              </div>
              <div class="card-body">
                <table class="table table-hover table-bordered datatables" id="tabel_agenda" cellspacing="0" width="100%" style="font-size: 0.875rem">
                  <thead>
                    <tr>
                      <th></th>
                      <th>#</th>
                      <th>Tempat</th>
                      <th>Waktu</th>
                      <th>Peserta</th>
                      <th>Tgl Acara</th>
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
    
    <!--============================= MODAL INPUT AGENDA =============================-->
    <div class="modal fade" id="ModalInputAgenda" tabindex="-1" role="dialog" aria-labelledby="ModalInputAgendaTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ModalInputAgendaTitle">Modal title</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form>
            <div class="modal-body">
              
              <input type="hidden" id="xid_agenda" name="xid_agenda">
            
              <div class="mb-3">
                <label class="small mb-1" for="xtgl_acara">Tanggal Acara</label>
                <input type="date" name="xtgl_acara" value="<?= date('Y-m-d') ?>" class="form-control" id="xtgl_acara" required />
              </div>
            
              <div class="mb-3">
                <label class="small mb-1" for="xtempat">Tempat</label>
                <input type="text" name="xtempat" class="form-control" id="xtempat" placeholder="Enter tempat" required />
              </div>
            
              <div class="row gx-x">

                <div class="col-6 mb-3">
                  <label class="small mb-1" for="xdari_jam">Dari Jam</label>
                  <input type="time" name="xdari_jam" class="form-control" id="xdari_jam" required />
                </div>

                <div class="col-6 mb-3">
                  <label class="small mb-1" for="xsampai_jam">Sampai Jam</label>
                  <input type="time" name="xsampai_jam" class="form-control" id="xsampai_jam" required />
                </div>

              </div>
            
              <div class="mb-3">
                <label class="small mb-1" for="xpeserta">Peserta</label>
                <input type="text" name="xpeserta" class="form-control" id="xpeserta" placeholder="Enter peserta" required />
              </div>
            
              <div class="mb-3">
                <label class="small mb-1" for="xdetail_acara">Detail Acara</label>
                <textarea class="form-control" id="xdetail_acara" name="xdetail_acara" rows="5" placeholder="Keterangan detail acara" autocomplete="off"></textarea>
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
    <!--/.modal-input-agenda -->
    
    <?php include '_partials/script.php' ?>
    <?php include '../helpers/sweetalert2_notify.php' ?>
    
    <!-- PAGE SCRIPT -->
    <script>
      $(document).ready(function() {
        $('.toggle_modal_tambah').on('click', function() {
          $('#ModalInputAgenda .modal-title').html(`<i data-feather="plus-circle" class="me-2 mt-1"></i>Tambah Agenda`);
          $('#ModalInputAgenda form').attr({action: 'agenda_tambah.php', method: 'post'});

          // Re-init all feather icons
          feather.replace();
          
          $('#ModalInputAgenda').modal('show');
        });


        $('.toggle_modal_ubah').on('click', function() {
          const data = $(this).data();
          
          $('#ModalInputAgenda .modal-title').html(`<i data-feather="edit" class="me-2 mt-1"></i>Ubah Agenda`);
          $('#ModalInputAgenda form').attr({action: 'agenda_ubah.php', method: 'post'});

          $('#ModalInputAgenda #xid_agenda').val(data.id_agenda);
          $('#ModalInputAgenda #xtempat').val(data.tempat);
          $('#ModalInputAgenda #xdari_jam').val(data.dari_jam);
          $('#ModalInputAgenda #xsampai_jam').val(data.sampai_jam);
          $('#ModalInputAgenda #xpeserta').val(data.peserta);
          $('#ModalInputAgenda #xdetail_acara').val(data.detail_acara);

          // Re-init all feather icons
          feather.replace();
          
          $('#ModalInputAgenda').modal('show');
        });
        

        $('#tabel_agenda').on('click', '.toggle_swal_hapus', function() {
          const id_agenda = $(this).data('id_agenda');
          const tempat = $(this).data('tempat');
          const tgl_acara = $(this).data('tgl_acara');
          
          Swal.fire({
            title: "Konfirmasi Tindakan?",
            html: `<div class="mb-1">Hapus data agenda: </div><strong>${tempat} (${tgl_acara})?</strong>`,
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
                window.location = `agenda_hapus.php?xid_agenda=${id_agenda}`;
              });
            }
          });
        });
        
      });
    </script>


    <!-- Script for inner page Agenda Datatables with child row -->
    <script>
      // Formatting function for row details - modify as you need
      function format(d) {
        // `d` is the original data object for the row
        return (
          '<dl>' +
          '<dt>Detail Acara:</dt>' +
          '<dd>' +
          d.detail_acara +
          '</dd>' +
          '</dl>'
        );
      }
        
      let table = new DataTable('#tabel_agenda', {  
        ajax: `<?= 'get_all_agenda.php' ?>`,
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
          { data: 'tempat' },
          { 
            data: null,
            render: function( data, type, row ) {
              return `${data.dari_jam} - ${data.sampai_jam}`
            }
          },
          { data: 'peserta' },
          { data: 'tgl_acara' },
          {
            data: null,
            render: function( data, type, row ) {
              return `<button class="btn btn-datatable btn-icon btn-transparent-dark me-2 toggle_modal_ubah"
                  data-id_agenda="${data.id_agenda}"
                  data-tempat="${data.tempat}"
                  data-dari_jam="${data.dari_jam}"
                  data-sampai_jam="${data.sampai_jam}"
                  data-peserta="${data.peserta}"
                  data-tgl_acara="${data.tgl_acara}"
                  data-detail_acara="${data.detail_acara}">
                  <i class="fa fa-pen-to-square"></i>
                </button>
                <button class="btn btn-datatable btn-icon btn-transparent-dark me-2 toggle_swal_hapus"
                  data-id_agenda="${data.id_agenda}"
                  data-tempat="${data.tempat}"
                  data-tgl_acara="${data.tgl_acara}">
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
        }
      });
    </script>

  </body>

  </html>

<?php endif ?>