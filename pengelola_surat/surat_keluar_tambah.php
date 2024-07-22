<?php
    include_once '../helpers/isAccessAllowedHelper.php';

    // cek apakah user yang mengakses adalah pengelola_surat?
    if (!isAccessAllowed('pengelola_surat')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    require_once '../vendor/htmlpurifier/HTMLPurifier.auto.php';
    require_once '../helpers/fileUploadHelper.php';
    require_once '../helpers/getHashedFileNameHelper.php';
    include_once '../config/connection.php';

    // to sanitize user input
    $config   = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
    
    $id_kode_surat  = $_POST['xid_kode_surat'];
    $no_surat       = htmlspecialchars($purifier->purify($_POST['xno_surat']));
    $tujuan_surat   = htmlspecialchars($purifier->purify($_POST['xtujuan_surat']));
    $pengolah_surat = htmlspecialchars($purifier->purify($_POST['xpengolah_surat']));
    $perihal_indeks = htmlspecialchars($purifier->purify($_POST['xperihal_indeks']));
    $tgl_surat      = $_POST['xtgl_surat'];
    $isi_surat      = htmlspecialchars($purifier->purify($_POST['xisi_surat']));
    $catatan        = htmlspecialchars($purifier->purify($_POST['xcatatan']));
    $jml_lampiran   = $_POST['xjml_lampiran'];
    $jml_lembar     = $_POST['xjml_lembar'];
    $file_sk        = $_FILES['xfile_sk'];
    $nama_berkas    = '';
    $is_file_sk_uploaded = file_exists($file_sk['tmp_name']) || is_uploaded_file($file_sk['tmp_name']);
    
    if ($is_file_sk_uploaded) {
        // Set upload configuration
        $target_dir    = '../assets/uploads/file_sk/';
        $max_file_size = 1 * 1024 * 1024; // 1MB in bytes
        $allowed_types = ['pdf'];

        // Upload surat lamaran using the configuration
        $upload_file_sk    = fileUpload($file_sk, $target_dir, $max_file_size, $allowed_types);
        $nama_berkas       = $upload_file_sk['hashedFilename'];
        $is_upload_success = $upload_file_sk['isUploaded'];
        $upload_messages   = $upload_file_sk['messages'];

        // Check is file uploaded?
        if (!$is_upload_success) {
            $_SESSION['msg'] = $upload_messages;
            echo "<meta http-equiv='refresh' content='0;surat_keluar.php?go=surat_keluar'>";
            return;
        }
    }

    $stmt = mysqli_stmt_init($connection);
    $query = 
        "INSERT INTO tbl_surat_keluar
        (
            id_kode_surat
            , pengolah_surat
            , tujuan_surat
            , no_surat
            , tgl_surat
            , perihal_indeks
            , isi_surat
            , jml_lampiran
            , jml_lembar
            , catatan
            , file_sk
        )
        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, 'issssssiiss', $id_kode_surat, $pengolah_surat, $tujuan_surat, $no_surat, $tgl_surat, $perihal_indeks, $isi_surat, $jml_lampiran, $jml_lembar, $catatan, $nama_berkas);

    $insert = mysqli_stmt_execute($stmt);

    !$insert
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'save_success';

    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;surat_keluar.php?go=surat_keluar'>";
?>