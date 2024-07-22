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
    
    $id_pegawai           = $_POST['xid_pegawai'] ?? NULL;
    $username             = htmlspecialchars($purifier->purify($_POST['xusername']));
    $password             = password_hash($_POST['xpassword'], PASSWORD_DEFAULT);
    $is_allowed_hak_akses = in_array($_POST['xhak_akses'], ['pengelola_surat', 'kepala_desa', 'sekretaris_desa', 'admin']); 
    $hak_akses            = $is_allowed_hak_akses ? $_POST['xhak_akses'] : NULL;

    if (!$is_allowed_hak_akses) {
        $_SESSION['msg'] = 'Hak akses yang diinput tidak diperbolehkan!';
        echo "<meta http-equiv='refresh' content='0;pengguna.php?go=pengguna'>";
        return;
    }

    mysqli_autocommit($connection, false);

    $success = true;
    
    if ($hak_akses === 'admin'):
        
        $stmt_pengguna = mysqli_stmt_init($connection);

        mysqli_stmt_prepare($stmt_pengguna, "INSERT INTO tbl_pengguna (username, password, hak_akses) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt_pengguna, 'sss', $username, $password, $hak_akses);

        if (!mysqli_stmt_execute($stmt_pengguna)):
            $success = false;
            $_SESSION['msg'] = 'Statement Pengguna preparation failed: ' . mysqli_stmt_error($stmt_pengguna);
        endif;
    
    else:

        $stmt_pengguna = mysqli_stmt_init($connection);

        mysqli_stmt_prepare($stmt_pengguna, "INSERT INTO tbl_pengguna (username, password, hak_akses) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt_pengguna, 'sss', $username, $password, $hak_akses);

        if (!mysqli_stmt_execute($stmt_pengguna)):
            $success = false;
            $_SESSION['msg'] = 'Statement Pengguna preparation failed: ' . mysqli_stmt_error($stmt_pengguna);
        endif;

        $stmt_pegawai = mysqli_stmt_init($connection);
        $id_pengguna = mysqli_insert_id($connection);

        mysqli_stmt_prepare($stmt_pegawai, "UPDATE tbl_pegawai SET id_pengguna=? WHERE id=?");
        mysqli_stmt_bind_param($stmt_pegawai, 'ii', $id_pengguna, $id_pegawai);

        if (!mysqli_stmt_execute($stmt_pegawai)):
            $success = false;
            $_SESSION['msg'] = 'Statement Pegawai preparation failed: ' . mysqli_stmt_error($stmt_pegawai);
        endif;
    
    endif;
    
    !$success
        ? mysqli_rollback($connection)
        : mysqli_commit($connection);

    !$success
        ? ''
        : $_SESSION['msg'] = 'save_success';

    mysqli_stmt_close($stmt_pengguna);

    !isset($stmt_pegawai)
        ? ''
        : mysqli_stmt_close($stmt_pegawai);

    mysqli_autocommit($connection, true);
    
    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;pengguna.php?go=pengguna'>";
?>