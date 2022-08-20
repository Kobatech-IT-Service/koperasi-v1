<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jenis_kas extends AdminController {

	public function __construct() {
		parent::__construct();	
	}	
	
	public function index() {
		$this->data['judul_browser'] = 'Data';
		$this->data['judul_utama'] = 'Data';
		$this->data['judul_sub'] = 'Jenis Kas';

		$this->output->set_template('gc');

		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_table('nama_kas_tbl');
		$crud->set_subject('Jenis Kas');

		$crud->columns('nama', 'aktif', 'tmpl_simpan', 'tmpl_penarikan', 'tmpl_pinjaman', 'tmpl_bayar','tmpl_pemasukan','tmpl_pengeluaran','tmpl_transfer');
		$crud->fields('nama', 'aktif', 'tmpl_simpan', 'tmpl_penarikan', 'tmpl_pinjaman', 'tmpl_bayar','tmpl_pemasukan','tmpl_pengeluaran','tmpl_transfer');
	
		$crud->display_as('nama','Nama Kas');
		$crud->display_as('tmpl_simpan','Simpanan');
		$crud->display_as('tmpl_penarikan','Penarikan');
		$crud->display_as('tmpl_pinjaman','Pinjaman');
		$crud->display_as('tmpl_bayar','Angsuran');
		$crud->display_as('tmpl_pemasukan','Pemasukan Kas');
		$crud->display_as('tmpl_pengeluaran','Pengeluaran Kas');
		$crud->display_as('tmpl_transfer','Transfer Kas');
		$crud->required_fields('nama');

		$crud->unset_read();
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
