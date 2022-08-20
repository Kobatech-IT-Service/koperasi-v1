<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jenis_simpanan extends AdminController {

	public function __construct() {
		parent::__construct();	
	}	
	
	public function index() {
		$this->data['judul_browser'] = 'Setting';
		$this->data['judul_utama'] = 'Setting';
		$this->data['judul_sub'] = 'Jenis Simpanan';

		$this->output->set_template('gc');

		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_table('jns_simpan');
		$crud->set_subject('Jenis Simpanan');
	
		
		$crud->display_as('jns_simpan','Jenis Simpanan');
		$crud->fields('jumlah','tampil');

		$crud->required_fields('jns_simpan');

		
		$crud->unset_read();
		$crud->unset_add();
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
