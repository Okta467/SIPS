<?php
    include_once '../helpers/isAccessAllowedHelper.php';

    // cek apakah user yang mengakses adalah pengelola_surat?
    if (!isAccessAllowed('pengelola_surat')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    require_once '../vendor/htmlpurifier/HTMLPurifier.auto.php';
    include_once '../config/connection.php';

    // to sanitize user input
    $config   = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);

    // echo "<pre>";
    // print_r($_POST);
    // $id_diteruskan_ke = $_POST['xid_diteruskan_ke'];
    // echo count($id_diteruskan_ke);
    // return;
    
    $id_disposisi_surat_masuk = htmlspecialchars($purifier->purify($_POST['xid_disposisi_surat_masuk']));
    $id_surat_masuk           = htmlspecialchars($purifier->purify($_POST['xid_surat_masuk']));
    $tgl_penyelesaian         = $_POST['xtgl_penyelesaian'];
    $id_diteruskan_ke         = $_POST['xid_diteruskan_ke'];
    $jml_id_diteruskan_ke     = count($id_diteruskan_ke);
    $instruksi                = htmlspecialchars($purifier->purify($_POST['xinstruksi']));

    mysqli_autocommit($connection, false);

    $success = true;

    try {
        /**
         * disposisi_surat_masuk statement preparation and execution
         */
        $stmt_disposisi_sm = mysqli_stmt_init($connection);
        $query_disposisi_sm = "UPDATE tbl_disposisi_surat_masuk SET
            id_surat_masuk=?
            , instruksi=?
            , tgl_penyelesaian=?
        WHERE id=?";
        
        if (!mysqli_stmt_prepare($stmt_disposisi_sm, $query_disposisi_sm)) {
            $_SESSION['msg'] = 'Statement Disposisi Surat Masuk preparation failed: ' . mysqli_stmt_error($stmt_disposisi_sm);
            // echo "<meta http-equiv='refresh' content='0;pegawai.php?go=pegawai'>";
            return;
        }
        
        mysqli_stmt_bind_param($stmt_disposisi_sm, 'issi', $id_surat_masuk, $instruksi, $tgl_penyelesaian, $id_disposisi_surat_masuk);
        
        if (!mysqli_stmt_execute($stmt_disposisi_sm)) {
            $_SESSION['msg'] = 'Statement Disposisi Surat Masuk preparation failed: ' . mysqli_stmt_error($stmt_disposisi_sm);
            // echo "<meta http-equiv='refresh' content='0;pegawai.php?go=pegawai'>";
            return;
        }

        /**
         * tujuan_disposisi_surat_masuk delete statement preparation and execution
         */
        $stmt_delete_tujuan_disposisi_sm = mysqli_stmt_init($connection);
        $query_delete_tujuan_disposisi_sm = "DELETE FROM tbl_tujuan_disposisi_surat_masuk WHERE id_disposisi_surat_masuk=?";
        
        if (!mysqli_stmt_prepare($stmt_delete_tujuan_disposisi_sm, $query_delete_tujuan_disposisi_sm)) {
            $_SESSION['msg'] = 'Statement Delete Tujuan Disposisi Surat Masuk preparation failed: ' . mysqli_stmt_error($stmt_insert_tujuan_disposisi_sm);
            // echo "<meta http-equiv='refresh' content='0;pegawai.php?go=pegawai'>";
            return;
        }

        mysqli_stmt_bind_param($stmt_delete_tujuan_disposisi_sm, 'i', $id_disposisi_surat_masuk);

        if (!mysqli_stmt_execute($stmt_delete_tujuan_disposisi_sm)) {
            $_SESSION['msg'] = 'Statement Delete Tujuan Disposisi Surat Masuk preparation failed: ' . mysqli_stmt_error($stmt_disposisi_sm);
            // echo "<meta http-equiv='refresh' content='0;pegawai.php?go=pegawai'>";
            return;
        }

        /**
         * tujuan_disposisi_surat_masuk insert statement preparation and execution
         */
        $stmt_insert_tujuan_disposisi_sm = mysqli_stmt_init($connection);
        $query_insert_tujuan_disposisi_sm = "INSERT INTO tbl_tujuan_disposisi_surat_masuk
        (
            id_disposisi_surat_masuk
            , id_jabatan
        )
        VALUES (?, ?)" . str_repeat(', (?, ?)', $jml_id_diteruskan_ke-1);
        
        if (!mysqli_stmt_prepare($stmt_insert_tujuan_disposisi_sm, $query_insert_tujuan_disposisi_sm)) {
            $_SESSION['msg'] = 'Statement Insert Tujuan Disposisi Surat Masuk preparation failed: ' . mysqli_stmt_error($stmt_insert_tujuan_disposisi_sm);
            // echo "<meta http-equiv='refresh' content='0;pegawai.php?go=pegawai'>";
            return;
        }

        $format = str_repeat('ii', $jml_id_diteruskan_ke);

        $params = [];
        foreach ($id_diteruskan_ke as $id) {
            $params[] = $id_disposisi_surat_masuk;
            $params[] = $id;
        }

        // Prepare the parameters for binding
        $bind_params = [];
        foreach ($params as $key => &$value) {
            $bind_params[$key] = &$value; // Reference is required for call_user_func_array
        }

        // Add format string at the beginning
        array_unshift($bind_params, $format);

        // Bind parameters dynamically
        call_user_func_array('mysqli_stmt_bind_param', array_merge([$stmt_insert_tujuan_disposisi_sm], $bind_params));

        if (!mysqli_stmt_execute($stmt_insert_tujuan_disposisi_sm)) {
            $_SESSION['msg'] = 'Statement Insert Tujuan Disposisi Surat Masuk preparation failed: ' . mysqli_stmt_error($stmt_disposisi_sm);
            // echo "<meta http-equiv='refresh' content='0;pegawai.php?go=pegawai'>";
            return;
        }

        // Commit the transaction if all statements succeed
        if (!mysqli_commit($connection)) {
            $_SESSION['msg'] = 'Transaction commit failed: ' . mysqli_stmt_error($stmt_disposisi_sm);
            // echo "<meta http-equiv='refresh' content='0;pegawai.php?go=pegawai'>";
            return;
        }
    } catch (Exception $e) {
        $success = false;
        mysqli_rollback($connection);
    }

    mysqli_stmt_close($stmt_disposisi_sm);
    mysqli_stmt_close($stmt_insert_tujuan_disposisi_sm);

    mysqli_autocommit($connection, true);
    mysqli_close($connection);

    !$success
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'update_success';

    echo "<meta http-equiv='refresh' content='0;disposisi_surat_masuk.php?go=disposisi_surat_masuk'>";
?>