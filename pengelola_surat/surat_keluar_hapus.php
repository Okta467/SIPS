<?php
    include_once '../helpers/isAccessAllowedHelper.php';

    // cek apakah user yang mengakses adalah pengelola_surat?
    if (!isAccessAllowed('pengelola_surat')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    include_once '../config/connection.php';
    
    $id_surat_keluar = $_GET['xid_surat_keluar'];
    
    $stmt_surat_keluar = mysqli_stmt_init($connection);

    mysqli_stmt_prepare($stmt_surat_keluar, "SELECT file_sk FROM tbl_surat_keluar WHERE id=?");
    mysqli_stmt_bind_param($stmt_surat_keluar, 'i', $id_surat_keluar);
    mysqli_stmt_execute($stmt_surat_keluar);

    $result = mysqli_stmt_get_result($stmt_surat_keluar);
    $surat_keluar = mysqli_fetch_assoc($result);

    $stmt_hapus = mysqli_stmt_init($connection);

    mysqli_stmt_prepare($stmt_hapus, "DELETE FROM tbl_surat_keluar WHERE id=?");
    mysqli_stmt_bind_param($stmt_hapus, 'i', $id_surat_keluar);

    $delete = mysqli_stmt_execute($stmt_hapus);
    
    // Delete file if data deletion is success
    if ($delete) {
        $target_dir = '../assets/uploads/file_sk/';
        $old_file_sk = $surat_keluar['file_sk'];
        $file_path_to_unlink = $target_dir . $old_file_sk;
        
        // Delete the old file_sk
        if ($old_file_sk && file_exists($file_path_to_unlink)) {
            unlink("{$target_dir}{$old_file_sk}");
        }
    }

    !$delete
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'delete_success';

    mysqli_stmt_close($stmt_surat_keluar);
    mysqli_stmt_close($stmt_hapus);
    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;surat_keluar.php?go=surat_keluar'>";
?>