<?php
    include_once '../helpers/isAccessAllowedHelper.php';

    // cek apakah user yang mengakses adalah kepala_desa?
    if (!isAccessAllowed('kepala_desa')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    include_once '../config/connection.php';
    
    $stmt = mysqli_stmt_init($connection);
    $query = "SELECT
            a.id AS id_surat_masuk, a.asal_surat, a.no_surat, a.tgl_surat, a.perihal_indeks, a.isi_surat, a.jml_lampiran, a.file_sm,
            b.id AS id_kode_surat, b.kode_surat, b.nama_kode, b.keterangan
        FROM tbl_surat_masuk AS a
        LEFT JOIN tbl_kode_surat AS b
            ON b.id = a.id_kode_surat
        ORDER BY a.id DESC";

    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);

    $surat_masuks['data'] = !$result
        ? array()
        : mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    echo json_encode($surat_masuks);

?>