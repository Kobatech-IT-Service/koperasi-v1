<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Angsuran_detail extends OperatorController {

	public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('angsuran_m');
		$this->load->model('general_m');
		$this->load->model('bunga_m');
		$this->load->model('pinjaman_m');
	}	

	public function index($master_id = NULL) {
		if($master_id == NULL) {
			redirect('pinjaman');
			exit();
		}

		$this->data['judul_browser'] = 'Detail Pinjaman';
		$this->data['judul_utama'] = 'Detail Pinjaman';
		$this->data['judul_sub'] = 'Kode Pinjam  TPJ' . sprintf('%05d', $master_id) . '';

		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/default/easyui.css';
		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/icon.css';
		$this->data['js_files'][] = base_url() . 'assets/easyui/jquery.easyui.min.js';

		//include tanggal
		$this->data['css_files'][] = base_url() . 'assets/extra/bootstrap_date_time/css/bootstrap-datetimepicker.min.css';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/bootstrap-datetimepicker.min.js';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/locales/bootstrap-datetimepicker.id.js';
		
		//include serch tanggal
		$this->data['css_files'][] = base_url() . 'assets/theme_admin/css/daterangepicker/daterangepicker-bs3.css';
		$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/daterangepicker/daterangepicker.js';

		$this->data['master_id'] = $master_id;
		$row_pinjam = $this->general_m->get_data_pinjam ($master_id);
		$this->data['row_pinjam'] = $row_pinjam; 
		$this->data['data_anggota'] = $this->general_m->get_data_anggota ($row_pinjam->anggota_id);
		
		$this->data['kas_id'] = $this->angsuran_m->get_data_kas();
		$this->data['hitung_denda'] = $this->general_m->get_jml_denda($master_id);
		$this->data['hitung_dibayar'] = $this->general_m->get_jml_bayar($master_id);
		$this->data['sisa_ags'] = $this->general_m->get_record_bayar($master_id);
		$this->data['angsuran'] = $this->angsuran_m->get_data_angsuran($master_id);
		$this->data['simulasi_tagihan'] = $this->pinjaman_m->get_simulasi_pinjaman($master_id);

		$this->data['isi'] = $this->load->view('angsuran_detail_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}


function get_ags_ke($master_id) {
	$id_bayar = $this->input->post('id_bayar');
	if($id_bayar > 0) {
		$data_bayar = $this->general_m->get_data_pembayaran_by_id($id_bayar);
		$ags_ke = $data_bayar->angsuran_ke;
	} else {
		//ambil angsuran ke
		$ags_ke = $this->general_m->get_record_bayar($master_id) + 1;
	}
	$jml_bayar = $ags_ke;
	//ambil sisa angsuran 
	$row_pinjam = $this->general_m->get_data_pinjam($master_id);
	$status_lunas = $row_pinjam->lunas;
	$lama_ags = $row_pinjam->lama_angsuran;
	$sisa_ags = $row_pinjam->lama_angsuran - $jml_bayar;

	//hitung update angsuran 
	//denda
	$denda = $this->general_m->get_jml_denda($master_id);
	$jml_denda_num = $denda ->total_denda * 1;
	$jml_denda_det = number_format($denda ->total_denda * 1);
	//sudah dibayar
	$dibayar=$this->general_m->get_jml_bayar($master_id);
	$sudah_bayar_det = number_format($dibayar ->total);
	//sisa tagihan
	$tagihan_det = $row_pinjam->ags_per_bulan * $row_pinjam->lama_angsuran;
	$sisa_tagihan_det = number_format($tagihan_det - $dibayar ->total);
	$sisa_tagihan_num = ($tagihan_det - $dibayar ->total);
	$sisa_tagihan = number_format($sisa_tagihan_num);
	//sisa angsuran
	$sisa_ags_det = $row_pinjam->lama_angsuran - ($ags_ke - 1) ;
	//total pembayaran + denda
	$total_bayar_det = number_format($sisa_tagihan_num + $jml_denda_num);

	// DENDA
	$denda = 0;
	$denda_semua = 0;
	$denda_semua_num = 0;
	$tgl_pinjam = substr($row_pinjam->tgl_pinjam, 0, 7) . '-01';
	$tgl_tempo = date('Y-m-d', strtotime("+".$ags_ke." months", strtotime($tgl_pinjam)));
	$tgl_bayar  = isset($_POST['tgl_bayar']) ? $_POST['tgl_bayar'] : '';
	if($tgl_bayar != '') {
		$data_bunga_arr = $this->bunga_m->get_key_val();
		$denda_hari = $data_bunga_arr['denda_hari'];
		$tgl_tempo = str_replace('-', '', $tgl_tempo);
		$tgl_bayar = str_replace('-', '', $tgl_bayar);
		$tgl_toleransi = $tgl_bayar - ($tgl_tempo - 1);
		if ( $tgl_toleransi > $denda_hari ) { // 20140615 - 20140600
			$denda = '' . number_format($data_bunga_arr['denda']);
			$denda_semua_num = '' . ($data_bunga_arr['denda'] * $sisa_ags_det);
			$denda_semua = '' . number_format($denda_semua_num);
		}
	}

	// total tagihan
	$total_tagihan = number_format($sisa_tagihan_num + $jml_denda_num + $denda_semua_num);
	if($ags_ke > $lama_ags) {
		$data = array(
			'ags_ke' 				=> 0,
			'sisa_ags' 				=> $sisa_ags,
			'sisa_tagihan'			=> $sisa_tagihan,
			'sudah_bayar_det' 	=>$sudah_bayar_det,
			'sisa_tagihan_det'	=> $sisa_tagihan_det,
			'jml_denda_det' 		=> $jml_denda_det,
			'sisa_ags_det' 		=> $sisa_ags_det,
			'total_bayar_det' 	=> $total_bayar_det,
			'status_lunas' 		=> $status_lunas,
			'denda' 					=> $denda,
			'denda_semua' 			=> $denda_semua,
			'total_tagihan' 		=> $total_tagihan
		);
		echo json_encode($data);
	} else {
		$data = array(
			'ags_ke' 				=> $ags_ke,
			'sisa_ags' 				=> $sisa_ags,
			'sisa_tagihan'			=> $sisa_tagihan,
			'sudah_bayar_det' 	=> $sudah_bayar_det,
			'sisa_tagihan_det'	=> $sisa_tagihan_det,
			'jml_denda_det' 		=> $jml_denda_det,
			'sisa_ags_det' 		=> $sisa_ags_det,
			'total_bayar_det' 	=> $total_bayar_det,
			'status_lunas' 		=> $status_lunas,
			'denda' 					=> $denda,
			'denda_semua' 			=> $denda_semua,
			'total_tagihan' 		=> $total_tagihan
		);
		echo json_encode($data);
	}
	}
}
