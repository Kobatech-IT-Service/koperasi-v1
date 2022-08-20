<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ubah_password extends OperatorController {

	public function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('profil_m');
	}
	
	public function index() {
		$this->data['judul_browser'] = 'Ubah Password';
		$this->data['judul_utama'] = 'Profil';
		$this->data['judul_sub'] = 'Ubah Password';
	
		$out = array ();
		$out['tersimpan'] = '';
		
		$this->load->model('profil_m');
		if ($this->input->post('submit')) {
			if($this->profil_m->validasi()) {
				if ($this->input->post('password_baru') == $this->input->post('ulangi_password_baru')) {
					if($this->profil_m->simpan()) {
						$out['tersimpan'] = 'Y';
					} else {
						$out['tersimpan'] = 'N';
					}
				} else {
					$out['pesan'] ='Password Tidak Sama, Silahkan Ulangi';
				}
			}
		}
		$this->data['isi'] = $this->load->view('form_ubah_password_v', $out, TRUE);

		$this->load->view('themes/layout_utama_v', $this->data);
	}
}