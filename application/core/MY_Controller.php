<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

	public $data = array();

	public function __construct() {

		parent::__construct();

		//$this->output->enable_profiler(TRUE);

		// cek status login user
		if ($this->session->userdata('login') == FALSE) {
			redirect('login');
		} else {
			if($this->session->userdata('level') == 'member') {
				redirect('login');
			}
			$this->data['u_name'] = $this->session->userdata('u_name');
			$this->data['level'] = $this->session->userdata('level');

			$this->data['isi'] = '';
			$this->data['judul_browser'] = '';
			$this->data['judul_utama'] = '';
			$this->data['judul_sub'] = '';
			$this->data['link_aktif'] = '';
			$this->data['css_files'] = array();
			$this->data['js_files'] = array();
			$this->data['js_files2'] = array();

			// notifikasi
			$this->load->model('notif_m');
			$this->load->helper('fungsi');
			$notif['notif_tempo'] = array();
			if($this->session->userdata('level') == 'operator' || $this->session->userdata('level') == 'admin') {
				$notif['notif_tempo'] = $this->notif_m->get_data_tempo();
			}
			$notif['notif_pengajuan'] = $this->notif_m->get_pengajuan();
			$this->data['notif_v'] = $this->load->view('notifikasi_v', $notif, true);

		}
	}
}


class PinjamanController extends MY_Controller
{

	public function __construct() {
		parent::__construct();
		// cek status level admin
		if ($this->session->userdata('level') == 'admin' || $this->session->userdata('level') == 'pinjaman') {
			//oke
			$this->data['akses'] = TRUE;
		} else {
			// no
			$this->data['akses'] = FALSE;
			redirect('home/no_akses');
		}
	}   

}

class OPPController extends MY_Controller
{

	public function __construct() {
		parent::__construct();
		// cek status level admin
		if ($this->session->userdata('level') == 'admin' || $this->session->userdata('level') == 'pinjaman' || $this->session->userdata('level') == 'operator') {
			//oke
			$this->data['akses'] = TRUE;
		} else {
			// no
			$this->data['akses'] = FALSE;
			redirect('home/no_akses');
		}
	}   

}