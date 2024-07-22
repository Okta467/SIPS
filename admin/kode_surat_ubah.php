<?php
    include_once '../helpers/isAccessAllowedHelper.php';

    // cek apakah user yang mengakses adalah admin?
    if (!isAccessAllowed('admin')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    require_once '../vendor/htmlpurifier/HTMLPurifier.auto.php';
    include_once '../config/connection.php';

    // to sanitize user input
    $config   = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
    
    $id_kode_surat = $_POST['xid_kode_surat'];
    $kode_surat = htmlspecialchars($purifier->purify($_POST['xkode_surat']));
    $nama_kode = htmlspecialchars($purifier->purify($_POST['xnama_kode']));

    $stmt = mysqli_stmt_init($connection);

    mysqli_stmt_prepare($stmt, "UPDATE tbl_kode_surat SET kode_surat=?, nama_kode=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, 'ssi', $kode_surat, $nama_kode, $id_kode_surat);

    $update = mysqli_stmt_execute($stmt);

    !$update
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'update_success';

    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;kode_surat.php?go=kode_surat'>";
?>