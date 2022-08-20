<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class AdminController extends MY_Controller
{

	public function __construct() {
		parent::__construct();

		// cek status level admin
		if ($this->session->userdata('level') == 'admin') {
			// oke
			$this->data['akses'] = TRUE;
		} else {
			$this->data['akses'] = FALSE;
			redirect('home/no_akses');
		}
	}

}