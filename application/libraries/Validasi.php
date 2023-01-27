<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   
class Validasi {

	function validasi_nohp($nohp) {
		// filter nomorhp						
		if (preg_match("/^08+[0-9-+]{8,13}$/i", $nohp)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}