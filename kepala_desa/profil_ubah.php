<?php
    include_once '../helpers/isAccessAllowedHelper.php';

    // cek apakah user yang mengakses adalah kepala_desa?
    if (!isAccessAllowed('kepala_desa')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    require_once '../vendor/htmlpurifier/HTMLPurifier.auto.php';
    include_once '../config/connection.php';

    // to sanitize user input
    $config   = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
    
    $id_pegawai          = $_SESSION['id_pegawai'];
    $alamat              = htmlspecialchars($purifier->purify($_POST['xalamat']));
    $tmp_lahir           = htmlspecialchars($purifier->purify($_POST['xtmp_lahir']));
    $tgl_lahir           = $_POST['xtgl_lahir'];
    $tahun_ijazah        = $_POST['xtahun_ijazah'];
    $id_jabatan          = $_POST['xid_jabatan'];
    $id_pangkat_golongan = $_POST['xid_pangkat_golongan'];
    $id_pendidikan       = $_POST['xid_pendidikan'];
    $id_jurusan          = $_POST['xid_jurusan'] ?? null;

    $stmt = mysqli_stmt_init($connection);
    $query = "UPDATE tbl_pegawai SET
        id_jabatan = ?
        , id_pangkat_golongan = ?
        , id_pendidikan = ?
        , id_jurusan_pendidikan = ?
        , alamat = ?
        , tmp_lahir = ?
        , tgl_lahir = ?
        , tahun_ijazah = ?
    WHERE id = ?";

    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, 'iiiisssii', $id_jabatan, $id_pangkat_golongan, $id_pendidikan, $id_jurusan, $alamat, $tmp_lahir, $tgl_lahir, $tahun_ijazah, $id_pegawai);
    mysqli_stmt_execute($stmt);

    $update = mysqli_stmt_execute($stmt);

    !$update
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'update_success';

    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;profil.php?go=profil'>";
?>
