<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jenis_akun extends AdminController {

	public function __construct() {
		parent::__construct();	
	}	
	
	public function index() {
		$this->data['judul_browser'] = 'Setting';
		$this->data['judul_utama'] = 'Setting';
		$this->data['judul_sub'] = 'Jenis Akun Transaksi';

		$this->output->set_template('gc');

		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_table('jns_akun');
		$crud->set_subject('Jenis Akun Transaksi');
	
		//$crud->fields('jns_trans','pemasukan','pengeluaran','aktif');
		$crud->fields('kd_aktiva','jns_trans', 'akun', 'pemasukan', 'pengeluaran', 'aktif', 'laba_rugi');
		$crud->columns('kd_aktiva','jns_trans', 'akun', 'pemasukan', 'pengeluaran', 'aktif', 'laba_rugi');
		
		$crud->required_fields('kd_aktiva','jns_trans', 'akun', 'pemasukan', 'pengeluaran', 'aktif');
		$crud->display_as('jns_trans','Jenis Transaksi');
		$this->db->_protect_identifiers = FALSE;
		$crud->order_by('LPAD(kd_aktiva, 1, 0) ASC, LPAD(kd_aktiva, 5, 1)', 'ASC');
		//$this->db->_protect_identifiers = TRUE;

		$crud->unset_read();
		//$crud->unset_add();
		$crud->unset_delete();
		$output = $crud->render();

		$out['output'] = $this->data['judul_browser'];
		$this->load->section('judul_browser', 'default_v', $out);
		$out['output'] = $this->data['judul_utama'];
		$this->load->section('judul_utama', 'default_v', $out);
		$out['output'] = $this->data['judul_sub'];
		$this->load->section('judul_sub', 'default_v', $out);
		$out['output'] = $this->data['u_name'];
		$this->load->section('u_name', 'default_v', $out);

		$this->load->view('default_v', $output);
		

	}

}
