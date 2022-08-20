<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_shu extends OperatorController {

public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('general_m');
		$this->load->model('lap_shu_m');
		$this->load->model('lap_laba_m');
	}	

	public function index() {
		$this->load->library("pagination");

		$this->data['judul_browser'] = 'Laporan';
		$this->data['judul_utama'] = 'Laporan';
		$this->data['judul_sub'] = 'Sisa Hasil Usaha';

		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/default/easyui.css';
		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/icon.css';
		$this->data['js_files'][] = base_url() . 'assets/easyui/jquery.easyui.min.js';

		#include tanggal
		$this->data['css_files'][] = base_url() . 'assets/extra/bootstrap_date_time/css/bootstrap-datetimepicker.min.css';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/bootstrap-datetimepicker.min.js';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/locales/bootstrap-datetimepicker.id.js';

			#include seach
		$this->data['css_files'][] = base_url() . 'assets/theme_admin/css/daterangepicker/daterangepicker-bs3.css';
		$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/daterangepicker/daterangepicker.js';

		$this->data['jml_pinjaman'] = $this->lap_laba_m->get_jml_pinjaman();
		$this->data['jml_tagihan'] = $this->lap_laba_m->get_jml_tagihan();
		$this->data['jml_angsuran'] = $this->lap_laba_m->get_jml_angsuran();
		$this->data['jml_denda'] = $this->lap_laba_m->get_jml_denda();

		$this->data['data_dapat'] = $this->lap_laba_m->get_data_akun_dapat();
		$this->data['data_biaya'] = $this->lap_laba_m->get_data_akun_biaya();		

		//$this->data['data_pasiva'] = $this->lap_shu_m->get_data_akun_pasiva();

		$this->data['isi'] = $this->load->view('lap_shu_list_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);

	}

}