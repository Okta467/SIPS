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
    $asal_surat     = htmlspecialchars($purifier->purify($_POST['xasal_surat']));
    $perihal_indeks = htmlspecialchars($purifier->purify($_POST['xperihal_indeks']));
    $tgl_surat      = $_POST['xtgl_surat'];
    $isi_surat      = htmlspecialchars($purifier->purify($_POST['xisi_surat']));
    $jml_lampiran   = $_POST['xjml_lampiran'];
    $file_sm        = $_FILES['xfile_sm'];
    $nama_berkas    = '';
    $is_file_sm_uploaded = file_exists($file_sm['tmp_name']) || is_uploaded_file($file_sm['tmp_name']);
    
    if ($is_file_sm_uploaded) {
        // Set upload configuration
        $target_dir    = '../assets/uploads/file_sm/';
        $max_file_size = 1 * 1024 * 1024; // 1MB in bytes
        $allowed_types = ['pdf'];

        // Upload surat lamaran using the configuration
        $upload_file_sm    = fileUpload($file_sm, $target_dir, $max_file_size, $allowed_types);
        $nama_berkas       = $upload_file_sm['hashedFilename'];
        $is_upload_success = $upload_file_sm['isUploaded'];
        $upload_messages   = $upload_file_sm['messages'];

        // Check is file uploaded?
        if (!$is_upload_success) {
            $_SESSION['msg'] = $upload_messages;
            echo "<meta http-equiv='refresh' content='0;surat_masuk.php?go=surat_masuk'>";
            return;
        }
    }

    $stmt = mysqli_stmt_init($connection);
    $query = 
        "INSERT INTO tbl_surat_masuk
        (
            id_kode_surat
            , asal_surat
            , no_surat
            , tgl_surat
            , perihal_indeks
            , isi_surat
            , jml_lampiran
            , file_sm
        )
        VALUES(?, ?, ?, ?, ?, ?, ?, ?)";

    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, 'ssssssis', $id_kode_surat, $asal_surat, $no_surat, $tgl_surat, $perihal_indeks, $isi_surat, $jml_lampiran, $nama_berkas);

    $insert = mysqli_stmt_execute($stmt);

    !$insert
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'save_success';

    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;surat_masuk.php?go=surat_masuk'>";
?>