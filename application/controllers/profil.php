<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profil extends AdminController {

	public function __construct() {
		parent::__construct();	
	}	
	
	public function index() {
		$this->data['judul_browser'] = 'Data';
		$this->data['judul_utama'] = 'Data';
		$this->data['judul_sub'] = 'Profil';

		$this->load->helper('form');
		$out = array ();
		$out['tersimpan'] = '';
		$this->load->model('setting_m');
		if ($this->input->post('submit')) {
			if($this->setting_m->simpan()) {
				$out['tersimpan'] = 'Y';
			} else {
				$out['tersimpan'] = 'N';
			}
		}
		$opsi_val_arr = $this->setting_m->get_key_val();
		foreach ($opsi_val_arr as $key => $value){
			$out[$key] = $value;
		}

		$this->data['isi'] = $this->load->view('form_setting_v', $out, TRUE);

		$this->load->view('themes/layout_utama_v', $this->data);
	}
}
