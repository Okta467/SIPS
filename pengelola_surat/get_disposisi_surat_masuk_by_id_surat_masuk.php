<?php
    include_once '../helpers/isAccessAllowedHelper.php';

    // cek apakah user yang mengakses adalah pengelola_surat?
    if (!isAccessAllowed('pengelola_surat')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    include_once '../config/connection.php';
    
    $id_surat_masuk = $_POST['id_surat_masuk'];

    $stmt1 = mysqli_stmt_init($connection);
    $query = 
        "SELECT
            a.id AS id_disposisi_surat_masuk, a.instruksi, a.tgl_penyelesaian,
            b.id AS id_tujuan_disposisi_surat_masuk,
            GROUP_CONCAT(DISTINCT c.nama_jabatan SEPARATOR ', ') AS diteruskan_ke,
            GROUP_CONCAT(DISTINCT c.id) AS id_diteruskan_ke,
            d.id AS id_surat_masuk, d.asal_surat, d.no_surat, d.tgl_surat, d.perihal_indeks, d.isi_surat, d.jml_lampiran, d.file_sm
        FROM tbl_disposisi_surat_masuk AS a
        LEFT JOIN tbl_tujuan_disposisi_surat_masuk AS b
            ON a.id = b.id_disposisi_surat_masuk
        LEFT JOIN tbl_jabatan AS c
            ON c.id = b.id_jabatan
        LEFT JOIN tbl_surat_masuk AS d
            ON d.id = a.id_surat_masuk
        WHERE d.id=?
        GROUP BY a.id";

    mysqli_stmt_prepare($stmt1, $query);
    mysqli_stmt_bind_param($stmt1, 'i', $id_surat_masuk);
    mysqli_stmt_execute($stmt1);

	$result = mysqli_stmt_get_result($stmt1);

    $disposisi_surat_masuks = !$result
        ? array()
        : mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_stmt_close($stmt1);
    mysqli_close($connection);

    echo json_encode($disposisi_surat_masuks);

?>