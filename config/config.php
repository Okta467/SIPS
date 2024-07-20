<?php 
	function base_url($path = '') {
		echo "/sips/" . $path;
	}

	function base_url_return($path = '') {
		return "/sips/" . $path;
	}

    date_default_timezone_set("Asia/Bangkok");
	
	DEFINE("SITE_NAME", "Sistem Informasi Pengelolaan Surat");
	DEFINE("SITE_NAME_SHORT", "SIPS");
	DEFINE("SITE_NAME_SHORT_ALTERNATIVE", "Desa Rawa Jaya");
?>