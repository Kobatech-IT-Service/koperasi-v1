<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Suku_bunga extends AdminController {

	public function __construct() {
		parent::__construct();	
	}	
	
	public function index() {
		$this->data['judul_browser'] = 'Setting';
		$this->data['judul_utama'] = 'Setting';
		$this->data['judul_sub'] = 'Biaya dan Administrasi';

		$this->load->helper('form');
		$out = array ();
		$out['tersimpan'] = '';
		$this->load->model('bunga_m');
		if ($this->input->post('submit')) {
			if($this->bunga_m->simpan()) {
				$out['tersimpan'] = 'Y';
			} else {
				$out['tersimpan'] = 'N';
			}
		}
		$opsi_val_arr = $this->bunga_m->get_key_val();
		foreach ($opsi_val_arr as $key => $value){
			$out[$key] = $value;
		}

		$this->data['isi'] = $this->load->view('form_bunga_v', $out, TRUE);

		$this->load->view('themes/layout_utama_v', $this->data);
	}
}
