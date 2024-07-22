<?php
    include_once '../helpers/isAccessAllowedHelper.php';

    // cek apakah user yang mengakses adalah admin?
    if (!isAccessAllowed('admin')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    include_once '../config/connection.php';
    
    $id_surat_masuk = $_GET['xid_surat_masuk'];
    
    $stmt_surat_masuk = mysqli_stmt_init($connection);

    mysqli_stmt_prepare($stmt_surat_masuk, "SELECT file_sm FROM tbl_surat_masuk WHERE id=?");
    mysqli_stmt_bind_param($stmt_surat_masuk, 'i', $id_surat_masuk);
    mysqli_stmt_execute($stmt_surat_masuk);

    $result = mysqli_stmt_get_result($stmt_surat_masuk);
    $surat_masuk = mysqli_fetch_assoc($result);

    $stmt_hapus = mysqli_stmt_init($connection);

    mysqli_stmt_prepare($stmt_hapus, "DELETE FROM tbl_surat_masuk WHERE id=?");
    mysqli_stmt_bind_param($stmt_hapus, 'i', $id_surat_masuk);

    $delete = mysqli_stmt_execute($stmt_hapus);
    
    // Delete file if data deletion is success
    if ($delete) {
        $target_dir = '../assets/uploads/file_sm/';
        $old_file_sm = $surat_masuk['file_sm'];
        $file_path_to_unlink = $target_dir . $old_file_sm;
        
        // Delete the old file_sm
        if ($old_file_sm && file_exists($file_path_to_unlink)) {
            unlink("{$target_dir}{$old_file_sm}");
        }
    }

    !$delete
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'delete_success';

    mysqli_stmt_close($stmt_surat_masuk);
    mysqli_stmt_close($stmt_hapus);
    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;surat_masuk.php?go=surat_masuk'>";
?>