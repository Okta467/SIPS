<?php
    include_once '../helpers/isAccessAllowedHelper.php';

    // cek apakah user yang mengakses adalah admin?
    if (!isAccessAllowed('admin')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    include_once '../config/connection.php';
    
    $stmt = mysqli_stmt_init($connection);

    // If `AS sampai_jam` removes, in datatables it will become `undefined`, i don't know why
    $query = "SELECT id AS id_agenda, tempat, dari_jam, sampai_Jam AS sampai_jam, peserta, tgl_acara, detail_acara FROM tbl_agenda ORDER BY id DESC";

    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);

    $agendas['data'] = !$result
        ? array()
        : mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    echo json_encode($agendas);

?>