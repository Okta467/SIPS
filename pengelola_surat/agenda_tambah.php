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
    
    $tgl_acara    = $_POST['xtgl_acara'];
    $tempat       = htmlspecialchars($purifier->purify($_POST['xtempat']));
    $dari_jam     = $_POST['xdari_jam'];
    $sampai_jam   = $_POST['xsampai_jam'];
    $peserta      = htmlspecialchars($purifier->purify($_POST['xpeserta']));
    $detail_acara = htmlspecialchars($purifier->purify($_POST['xdetail_acara']));

    $stmt = mysqli_stmt_init($connection);

    mysqli_stmt_prepare($stmt, "INSERT INTO tbl_agenda (tempat, dari_jam, sampai_jam, peserta, detail_acara, tgl_acara) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'ssssss', $tempat, $dari_jam, $sampai_jam, $peserta, $detail_acara, $tgl_acara);

    $insert = mysqli_stmt_execute($stmt);

    !$insert
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'save_success';

    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;agenda.php?go=agenda'>";
?>