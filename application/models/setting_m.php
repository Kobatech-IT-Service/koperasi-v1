<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Setting_m extends CI_Model {

	function get_key_val() {
		$out = array();
		$this->db->select('id,opsi_key,opsi_val');
		$this->db->from('tbl_setting');
		$query = $this->db->get();
		if($query->num_rows()>0){
				$result = $query->result();
				foreach($result as $value){
					$out[$value->opsi_key] = $value->opsi_val;
				}
				return $out;
		} else {
			return FALSE;
		}
	}

	function simpan() {
		$opsi_val_arr = $this->get_key_val();
		foreach ($opsi_val_arr as $key => $val) {
			if($this->input->post($key) || $this->input->post($key) == 0 ) {
				$data = array ('opsi_val'=> $this->input->post($key));
				$this->db->where('opsi_key',$key);
				if($this->db->update('tbl_setting',$data)) {
					// ok 
				} else {
					return FALSE;
				}
			}
		}
		return TRUE;
	}
}