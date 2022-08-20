<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends CI_Controller {

	public $data = array ('pesan' => '');
	
	public function __construct () {
		parent::__construct();
		//$this->output->enable_profiler(TRUE);
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('Member_m','member', TRUE);
	}

	public function _cek_login() {
		if ($this->session->userdata('login') == FALSE) {
			redirect('member');
		}
	}
	
	public function index() {
		// status user login = BENAR, pindah ke halaman home
		if ($this->session->userdata('login') == TRUE && $this->session->userdata('level') == 'member') {
			redirect('member/view');
		} else {
			// status login salah, tampilkan form login
			// validasi sukses
			if($this->member->validasi()) {
				// cek di database sukses
				if($this->member->cek_user()) {
					redirect('member/view');
				} else {
					// cek database gagal
					$this->data['pesan'] = 'Username atau Password salah.';
				}
			} else {
				// validasi gagal
         }
         $this->data['jenis'] = 'member';
         $this->load->view('themes/login_form_v', $this->data);
		}
	}

	function simulasi() {
		$this->load->helper('fungsi');
		$jenis = $this->input->post('jenis');
		if($jenis == 'Darurat') {
			$lama_ags = 1;
		} else {
			$lama_ags = $this->input->post('lama_ags');
		}
		$nominal = $this->input->post('nominal');
		$nominal = preg_replace("/[^0-9]/", "", $nominal);

		$this->load->model('bunga_m');

		$out = array();
		$conf_bunga = $this->bunga_m->get_key_val();
		$denda_hari = sprintf('%02d', $conf_bunga['denda_hari']);
		$biaya_admin = $conf_bunga['biaya_adm'];
		$persen_bunga = $conf_bunga['bg_pinjam'];
		$angsuran_pokok = ($nominal / $lama_ags);
		$tgl_pinjam = date('Y-m-d');
		$tgl_tempo_next = 0;
		for ($i=1; $i <= $lama_ags; $i++) { 
			$odat = array();
			$odat['angsuran_pokok'] = number_format($angsuran_pokok);
			$odat['tgl_pinjam'] = $tgl_pinjam;
			
			if($conf_bunga['pinjaman_bunga_tipe'] == 'A') {
				$biaya_bunga = ($angsuran_pokok * $persen_bunga) / 100;
			} else {
				$biaya_bunga = ($nominal * $persen_bunga) / 100;
			}
			$odat['biaya_adm'] = number_format($biaya_admin);
			$odat['biaya_bunga'] = number_format($biaya_bunga);
			$odat['jumlah_ags'] = number_format($angsuran_pokok + $biaya_admin + $biaya_bunga);
			$tgl_tempo_var = substr($tgl_pinjam, 0, 7) . '-01';
			$tgl_tempo = date("Y-m-d", strtotime($tgl_tempo_var . " +".$i." month"));
			$tgl_tempo = substr($tgl_tempo, 0, 7) . '-' . $denda_hari;
			$odat['tgl_tempo'] = jin_date_ina($tgl_tempo);
			$out[] = $odat;
		}
		//var_dump($out);
		if(!empty($out)) {
			echo '<h3>Simulasi Pinjaman</h3>';
			echo '<table class="table">';
			echo '	<tr>';
			echo '		<th style="text-align: center;">Ags Ke</th>';
			echo '		<th style="text-align: center;">Tanggal Tempo</th>';
			echo '		<th style="text-align: center;">Angsuran Pokok</th>';
			echo '		<th style="text-align: center;">Biaya Bunga</th>';
			echo '		<th style="text-align: center;">Biaya Admin</th>';
			echo '		<th style="text-align: center;">Jumlah Tagihan</th>';
			echo '	</tr>';
			$no = 1;
			foreach ($out as $val) {
				echo '<tr>';
				echo '	<td style="text-align: center;">'.$no.'</td>';
				echo '	<td style="text-align: center;">'.$val['tgl_tempo'].'</td>';
				echo '	<td style="text-align: center;">'.$val['angsuran_pokok'].'</td>';
				echo '	<td style="text-align: center;">'.$val['biaya_bunga'].'</td>';
				echo '	<td style="text-align: center;">'.$val['biaya_adm'].'</td>';
				echo '	<td style="text-align: center;">'.$val['jumlah_ags'].'</td>';
				echo '</tr>';
				$no++;
			}
			echo '</table>';
		}
	}


	function edit() {
		$this->load->model('pinjaman_m');
		$res = $this->pinjaman_m->pengajuan_edit();
		echo $res;
	}

	public function view() {
		$this->_cek_login();
		$this->load->helper('fungsi');
		$this->load->model('lap_kas_anggota_m');
		$user_id = $this->session->userdata('u_name');
		$this->data['user_id'] = $user_id;
		$this->data['row'] = $this->member->get_data_anggota($user_id);
		$this->data["data_jns_simpanan"] = $this->lap_kas_anggota_m->get_jenis_simpan();
		$this->data['data_pengajuan'] =  $this->member->get_last_pengajuan();
		$this->load->view('themes/member_v', $this->data);
	}

	public function pengajuan() {
		$this->_cek_login();
		$this->load->model('pinjaman_m');
		$this->load->helper('fungsi');
		//editable
		$this->data['css_files'][] = base_url() . 'assets/extra/bootstrap3-editable/css/bootstrap-editable.css';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap3-editable/js/bootstrap-editable.min.js';

		$this->data['jenis_ags'] = $this->pinjaman_m->get_data_angsuran();

		$this->load->view('themes/member_pengajuan_v', $this->data);		
	}

	public function ajax_pengajuan() {
		$this->load->model('member_m');
		$out = $this->member_m->get_pengajuan();
		header('Content-Type: application/json');
		echo json_encode($out);
		exit();		
	}

	public function pengajuan_batal($id) {
		$this->_cek_login();
		$this->load->model('member_m');
		if($this->member_m->pengajuan_batal($id)) {
			$this->session->set_flashdata('ajuan_batal', 'Y');
		} else {
			$this->session->set_flashdata('ajuan_batal', 'N');
		}
		redirect('member/pengajuan');

	}


	public function pengajuan_baru() {
		$this->_cek_login();

		//number_format
		$this->data['js_files'][] = base_url() . 'assets/extra/fungsi/number_format.js';

		$this->load->model('pinjaman_m');
		$lama_ags = $this->pinjaman_m->get_data_angsuran();
		$lama_ags_arr = array();
		foreach ($lama_ags as $row) {
			$lama_ags_arr[$row->ket] = $row->ket . ' bln';
		}
		$this->data['lama_ags'] = $lama_ags_arr;
		$this->data['tersimpan'] = '';
		if ($this->input->post('submit')) {
			if($this->member->validasi_pengajuan()) {
				$pengajuan_simpan = $this->member->pengajuan_simpan();
				if($pengajuan_simpan) {
					$this->session->set_flashdata('ajuan_baru', 'Y');
					redirect('member/pengajuan');
				} else {
					$this->data['tersimpan'] = 'N';
				}
			}
		}
		$this->load->helper('fungsi');
		$this->load->view('themes/member_pengajuan_baru_v', $this->data);		
	}

	public function pinjaman_detil($id) {
		$this->_cek_login();
		$this->load->helper('fungsi');
		$this->load->model('pinjaman_m');
		$this->data['simulasi_tagihan'] = $this->pinjaman_m->get_simulasi_pinjaman($id);
		$this->load->view('themes/member_pinjaman_detil_v', $this->data);
	}


	public function lap_simpanan() {
		$this->_cek_login();
		$this->load->helper('fungsi');
		$this->load->view('themes/member_simpanan_v', $this->data);
	}

	public function ajax_lap_simpanan() {
		$this->load->model('member_m');
		$out = $this->member_m->get_simpanan();
		header('Content-Type: application/json');
		echo json_encode($out);
		exit();		
	}

	public function lap_pinjaman() {
		$this->_cek_login();
		$this->load->helper('fungsi');
		$this->load->view('themes/member_pinjaman_v', $this->data);
	}

	public function ajax_lap_pinjaman() {
		$this->load->model('member_m');
		$out = $this->member_m->get_pinjaman();
		header('Content-Type: application/json');
		echo json_encode($out);
		exit();		
	}


	public function lap_bayar() {
		$this->_cek_login();
		$this->load->helper('fungsi');
		$this->load->view('themes/member_bayar_v', $this->data);
	}

	public function ajax_lap_bayar() {
		$this->load->model('member_m');
		$out = $this->member_m->get_bayar();
		header('Content-Type: application/json');
		echo json_encode($out);
		exit();		
	}
	public function ubah_pass() {
		$this->_cek_login();
		$this->data['tersimpan'] = '';
		if ($this->input->post('submit')) {
			if($this->member->validasi_ubah_pass()) {
				if ($this->input->post('password_baru') == $this->input->post('ulangi_password_baru')) {
					if($this->member->simpan()) {
						$this->data['tersimpan'] = 'Y';
					} else {
						$this->data['tersimpan'] = 'N';
					}
				} else {
					$this->data['pesan'] ='Password Tidak Sama, Silahkan Ulangi';
				}
			}
		}		

		$this->load->view('themes/member_ubah_pass_v', $this->data);
	}

	public function ubah_pic() {
		$this->_cek_login();
		$user_id = $this->session->userdata('u_name');
		$anggota = $this->member->get_data_anggota($user_id);
		
        $this->data['alamat'] = $anggota->alamat;
        $this->data['kota'] = $anggota->kota;
        $this->data['notelp'] = $anggota->notelp;
		
		$this->data['tersimpan'] = '';
		$this->data['error'] = '';
		if ($this->input->post('submit')) {
			$ubah_pic = $this->member->ubah_pic();
			if($ubah_pic['success'] == 'OK') {
			    
			    $anggota = $this->member->get_data_anggota($user_id);
		
                $this->data['alamat'] = $anggota->alamat;
                $this->data['kota'] = $anggota->kota;
                $this->data['notelp'] = $anggota->notelp;
				$this->data['tersimpan'] = 'Y';
			} else {
				$this->data['tersimpan'] = 'N';
				$this->data['error'] = $ubah_pic['error'];
			}
		}
		$user_id = $this->session->userdata('u_name');
		$this->data['row'] = $this->member->get_data_anggota($user_id);

		$this->load->view('themes/member_ubah_pic_v', $this->data);
	}

	public function logout() {
		$this->member->logout();
		redirect('member');
	}
}