<?php

namespace Package\August\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class SettingController {
	public static function registerCSS($path) {
		if (file_exists($_SERVER["DOCUMENT_ROOT"]."/".$path)) {
			echo "<style>".file_get_contents($_SERVER["DOCUMENT_ROOT"]."/".$path)."</style>";
		}
	}
}