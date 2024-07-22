
<?php
include '../helpers/isAccessAllowedHelper.php';

// cek apakah user yang mengakses adalah pengelola_surat?
if (!isAccessAllowed('pengelola_surat')) :
  session_destroy();
  echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
else :
  include_once '../config/connection.php';

  $dari_tanggal = $_GET['dari_tanggal'] ?? null;
  $sampai_tanggal = $_GET['sampai_tanggal'] ?? null;

  if (!$dari_tanggal || !$sampai_tanggal) {
    echo 'Input dari dan sampai tanggal harus diisi!';
    return;
  }
?>


  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php include '_partials/head.php' ?>

    <meta name="description" content="Data Pengumuman" />
    <meta name="author" content="" />
    <title>Laporan Surat Masuk <?= "({$dari_tanggal} s.d. {$sampai_tanggal})" ?></title>
  </head>

  <body class="bg-white">
    <?php
    $no = 1;
    
    $stmt = mysqli_stmt_init($connection);
    $query = "SELECT
        a.id AS id_surat_masuk, a.asal_surat, a.no_surat, a.tgl_surat, a.perihal_indeks, a.isi_surat, a.jml_lampiran, a.file_sm,
        b.id AS id_kode_surat, b.kode_surat, b.nama_kode, b.keterangan
      FROM tbl_surat_masuk AS a
      LEFT JOIN tbl_kode_surat AS b
        ON b.id = a.id_kode_surat
      WHERE a.tgl_surat BETWEEN ? AND ?
      ORDER BY a.id DESC";

    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, 'ss', $dari_tanggal, $sampai_tanggal);
    mysqli_stmt_execute($stmt);

	  $result = mysqli_stmt_get_result($stmt);

    $surat_masuks = mysqli_fetch_all($result, MYSQLI_ASSOC);
    ?>

    <h4 class="text-center mb-4">Laporan Surat Masuk <?= "({$dari_tanggal} s.d. {$sampai_tanggal})" ?></h4>

    <table class="table table-striped table-bordered table-sm">
      <thead>
        <tr>
          <th>#</th>
          <th>Kode Surat</th>
          <th>No Surat</th>
          <th>Tgl. Surat</th>
          <th>Asal Surat</th>
          <th>Indeks</th>
          <th>Isi Surat</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!$result->num_rows): ?>

          <tr>
            <td colspan="8"><div class="text-center">Tidak ada data</div></td>
          </tr>
        
        <?php else: ?>

          <?php foreach($surat_masuks as $surat_masuk) : ?>

            <tr>
              <td><?= $no++ ?></td>
              <td><?= $surat_masuk['kode_surat'] ?></td>
              <td><?= $surat_masuk['no_surat'] ?></td>
              <td><?= $surat_masuk['tgl_surat'] ?></td>
              <td><?= $surat_masuk['asal_surat'] ?></td>
              <td><?= $surat_masuk['perihal_indeks'] ?></td>
              <td><?= $surat_masuk['isi_surat'] ?></td>
            </tr>

          <?php endforeach ?>

        <?php endif ?>
      </tbody>
    </table>

  </body>

  </html>

<?php endif ?>