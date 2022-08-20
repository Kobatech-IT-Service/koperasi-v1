<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Profil_m extends CI_Model {

	function get_data_user() {
		$out = array();
		$pass_word = sha1('nsi' . $this->input->post('password_lama'));
		$this->db->select('id,u_name,pass_word');
		$this->db->from('tbl_user');
		$this->db->where('u_name', $this->session->userdata('u_name'));
		$this->db->where('pass_word', $pass_word);
		$this->db->limit('1');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$out = $query->result();
			return $out;
		} else {
			return FALSE;
		}
	}

	function simpan() {
		$data_user = $this->get_data_user();
		if($data_user){
			$pass_word = sha1('nsi' . $this->input->post('password_baru'));
			$data = array ('pass_word'=> $pass_word);
			$this->db->where('u_name', $this->session->userdata('u_name'));
			if($this->db->update('tbl_user',$data)) {
				// ok
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	public function load_form_rules() {
		$form_rules = array(
			array(
				'field' => 'password_lama',
				'label' => 'Password Lama',
				'rules' => 'required'
				), array(
				'field' => 'password_baru',
				'label' => 'Password Baru',
				'rules' => 'required'
				), array(
				'field' => 'ulangi_password_baru',
				'label' => 'Ulangi Password Baru',
				'rules' => 'required'
				)
				);
		return $form_rules;
	}

	public function validasi() {
		$form = $this->load_form_rules();
		$this->form_validation->set_rules($form);

		if ($this->form_validation->run()) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}