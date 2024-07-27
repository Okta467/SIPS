
<?php
include '../helpers/isAccessAllowedHelper.php';

// cek apakah user yang mengakses adalah pengelola_surat?
if (!isAccessAllowed('pengelola_surat')) :
  session_destroy();
  echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
else :
  include_once '../config/connection.php';

  $id_surat_masuk = $_GET['id_surat_masuk'] ?? null;

  if (!$id_surat_masuk) {
    echo 'ID Surat Masuk tidak terisi!';
    return;
  }

  $no = 1;
  $_POST['id_surat_masuk'] = $id_surat_masuk;
  $_POST['return_as_json'] = false;

  $surat_masuk = include_once 'get_surat_masuk.php';

  if (!$surat_masuk) {
    echo 'Surat masuk tidak ada!';
    return;
  } else {
    $surat_masuk = $surat_masuk[0];
  }
?>


  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php include '_partials/head.php' ?>

    <meta name="description" content="Data Pengumuman" />
    <meta name="author" content="" />
    <title>Surat Masuk <?= $surat_masuk['no_surat'] ?></title>
  </head>

  <body class="bg-white">
    <div class="row p-5">
      <div class="mb-4">
        ............................., <?= date('d M Y', strtotime($surat_masuk['tgl_surat'])) ?>
      </div>
      <!-- Nomor surat -->
      <div class="col-2">Nomor</div>
      <div class="col-10">: <?= $surat_masuk['no_surat'] ?></div>

      <!-- Jumlah Lampiran -->
      <div class="col-2">Lampiran</div>
      <div class="col-10">: <?= $surat_masuk['jml_lampiran'] ?></div>

      <!-- Asal Surat -->
      <div class="col-2">Pengirim</div>
      <div class="col-10">: <?= $surat_masuk['asal_surat'] ?></div>

      <!-- Perihal -->
      <div class="col-2">Perihal</div>
      <div class="col-10">: <?= $surat_masuk['perihal_indeks'] ?></div>

      <!-- Isi Surat -->
      <div class="mt-4" id="isi_surat">
      </div>

    </div>

    <script src="<?= base_url('vendor/jquery/jquery-3.7.1.min.js') ?>"></script>
    <script src="<?= base_url('vendor/marked/marked.min.js') ?>"></script>

    <script>
      const isi_surat = `<?= $surat_masuk['isi_surat'] ?>`;
      const isi_surat_marked = marked.parse(isi_surat);

      $('#isi_surat').html(isi_surat_marked);
    </script>
  </body>

  </html>

<?php endif ?>