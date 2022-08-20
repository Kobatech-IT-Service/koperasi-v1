<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_buku_besar_m extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	//panggil data jenis kas untuk laporan
	function get_nama_kas() {
		$this->db->select('*');
		$this->db->from('nama_kas_tbl');
		$this->db->where('aktif','Y');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$out = $query->result();
			return $out;
		} else {
			return array();
		}
	}

	//panggil data jenis kas untuk laporan
	function get_transaksi_kas($kas_id) {
		$this->db->select('*');
		$this->db->from('v_transaksi');
		
		if(isset($_REQUEST['periode'])) {
			$tgl_arr = explode('-', $_REQUEST['periode']);
			$thn = $tgl_arr[0];
			$bln = $tgl_arr[1];
		} else {
			$thn = date('Y');
			$bln = date('m');
		}
		$where = "(YEAR(tgl) = '".$thn."' AND  MONTH(tgl) = '".$bln."') AND (dari_kas = '".$kas_id."' OR  untuk_kas = '".$kas_id."')";
		$this->db->where($where);
		$this->db->order_by('tgl', 'ASC');
		$query = $this->db->get();

		if($query->num_rows()>0) {
			$out = $query->result();
			return $out;
		} else {
			return array();
		}
	}


	function get_nama_akun_id($id) {
		$this->db->select('*');
		$this->db->from('jns_akun');
		$this->db->where('id', $id);
		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$out = $query->row();
			return $out;
		} else {
			$out = (object) array('nama' => '');
			return $out;
		}
	}	
}