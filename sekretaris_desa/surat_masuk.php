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
            
            <!-- Main page content-->
            <div class="card card-header-actions mb-4 mt-5">
              <div class="card-header">
                <div>
                  <i data-feather="inbox" class="me-2 mt-1"></i>
                  Data Surat Masuk
                </div>
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
    
    <?php include '_partials/script.php' ?>
    <?php include '../helpers/sweetalert2_notify.php' ?>
    
    <!-- PAGE SCRIPT -->
     <script></script>


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