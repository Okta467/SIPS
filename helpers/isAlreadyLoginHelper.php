<?php

/**
 * Check and redirect user to its own page if already logged in
 * 
 * @param string $hak_akses $_SESSION (usually $_SESSION['hak_akses'])
 */
function isAlreadyLoggedIn($hak_akses): bool {
	// alihkan user ke halamannya masing-masing
	switch ($hak_akses) {
		case 'admin':
			header("location:admin?go=dashboard");
			break;

		case 'pengelola_surat':
			header("location:pengelola_surat/?go=dashboard");
			break;

		case 'kepala_desa':
			header("location:kepala_desa/?go=dashboard");
			break;

		case 'sekretaris_desa':
			header("location:sekretaris_desa/?go=dashboard");
			break;
		
		default:
			header("location:logout.php");
			break;
	}

    return true;
}

?>