<?php
    include_once '../helpers/isAccessAllowedHelper.php';

    // cek apakah user yang mengakses adalah kepala_desa?
    if (!isAccessAllowed('kepala_desa')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    include_once '../config/connection.php';
    
    $id_disposisi_surat_masuk = $_GET['xid_disposisi_surat_masuk'];

    $stmt = mysqli_stmt_init($connection);

    mysqli_stmt_prepare($stmt, "DELETE FROM tbl_disposisi_surat_masuk WHERE id=?");
    mysqli_stmt_bind_param($stmt, 'i', $id_disposisi_surat_masuk);

    $delete = mysqli_stmt_execute($stmt);

    !$delete
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'delete_success';

    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;disposisi_surat_masuk.php?go=disposisi_surat_masuk'>";
?>