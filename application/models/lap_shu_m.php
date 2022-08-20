<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class lap_shu_m extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	
	function get_data_akun_pasiva() {
		$this->db->select('*');
		$this->db->from('jns_akun');
		$this->db->where('aktif', 'Y');
		$this->db->where('akun', 'Pasiva');
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$out = $query->result();
			return $out;
		} else {
			return array();
		}
	}	

	function get_jml_aktiva($akun) {
		$this->db->select('SUM(debet) AS jum_debet, SUM(kredit) AS jum_kredit');
		$this->db->from('v_transaksi');
		$this->db->where('transaksi', $akun);

		if(isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
			$tgl_dari = $_REQUEST['tgl_dari'];
			$tgl_samp = $_REQUEST['tgl_samp'];
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';
		}
		$this->db->where('DATE(tgl) >= ', ''.$tgl_dari.'');
		$this->db->where('DATE(tgl) <= ', ''.$tgl_samp.'');

		$query = $this->db->get();
		return $query->row();
	}

	//menghitung jumlah simpanan tanpa ID
	function jml_simpanan() {
		$this->db->select('SUM(jumlah) AS total');
		$this->db->from('tbl_trans_sp');
		$this->db->where('dk','D');
		$where_id = "(jenis_id = 40 OR jenis_id = 41)";
		$this->db->where($where_id);		

		if(isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
			$tgl_dari = $_REQUEST['tgl_dari'];
			$tgl_samp = $_REQUEST['tgl_samp'];
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';
		}
		$this->db->where('DATE(tgl_transaksi) >= ', ''.$tgl_dari.'');
		$this->db->where('DATE(tgl_transaksi) <= ', ''.$tgl_samp.'');

		$query = $this->db->get();
		return $query->row();
	}

	//menghitung jumlah penarikan tanpa ID
	function jml_penarikan() {
		$this->db->select('SUM(jumlah) AS total');
		$this->db->from('tbl_trans_sp');
		$this->db->where('dk','K');
		$where_id = "(jenis_id = 40 OR jenis_id = 41)";
		$this->db->where($where_id);

		if(isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
			$tgl_dari = $_REQUEST['tgl_dari'];
			$tgl_samp = $_REQUEST['tgl_samp'];
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';
		}
		$this->db->where('DATE(tgl_transaksi) >= ', ''.$tgl_dari.'');
		$this->db->where('DATE(tgl_transaksi) <= ', ''.$tgl_samp.'');

		$query = $this->db->get();
		return $query->row();
	}

	function get_key_val() {
		$out = array();
		$this->db->select('id,opsi_key,opsi_val');
		$this->db->from('suku_bunga');
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
}