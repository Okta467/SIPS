<?php
    include_once '../helpers/isAccessAllowedHelper.php';

    // cek apakah user yang mengakses adalah pengelola_surat?
    if (!isAccessAllowed('pengelola_surat')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    include_once '../config/connection.php';
    
    $id_kode_surat = $_GET['xid_kode_surat'];

    $stmt = mysqli_stmt_init($connection);

    mysqli_stmt_prepare($stmt, "DELETE FROM tbl_kode_surat WHERE id=?");
    mysqli_stmt_bind_param($stmt, 'i', $id_kode_surat);

    $delete = mysqli_stmt_execute($stmt);

    !$delete
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'delete_success';

    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;kode_surat.php?go=kode_surat'>";
?>