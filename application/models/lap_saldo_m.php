<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_saldo_m extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	//panggil data simpanan
	function get_data_jenis_kas($limit, $start) {
		$this->db->select('*');
		$this->db->from('nama_kas_tbl');
		$this->db->where('aktif','Y');
		$this->db->order_by('id', 'ASC');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		if($query->num_rows()>0){
			$out = $query->result();
			return $out;
		} else {
			return FALSE;
		}
	}


	function get_jml_data_kas() {
		$this->db->where('aktif', 'Y');
		return $this->db->count_all_results('nama_kas_tbl');
	}

	//menghitung jumlah simpanan
	function get_jml_debet($jenis) {
		$this->db->select('SUM(debet) AS jml_total');
		$this->db->from('v_transaksi');
		$this->db->where('untuk_kas', $jenis);

		if(isset($_REQUEST['periode'])) {
			$tgl_arr = explode('-', $_REQUEST['periode']);
			$thn = $tgl_arr[0];
			$bln = $tgl_arr[1];
		} else {
			$thn = date('Y');			
			$bln = date('m');			
		}
		$where = "YEAR(tgl) = '".$thn."' AND  MONTH(tgl) = '".$bln."' ";
		$this->db->where($where);

		$query = $this->db->get();
		return $query->row();
	}

	//menghitung jumlah penarikan
	function get_jml_kredit($jenis) {
		$this->db->select('SUM(kredit) AS jml_total');
		$this->db->from('v_transaksi');
		$this->db->where('dari_kas', $jenis);

		if(isset($_REQUEST['periode'])) {
			$tgl_arr = explode('-', $_REQUEST['periode']);
			$thn = $tgl_arr[0];
			$bln = $tgl_arr[1];
		} else {
			$thn = date('Y');			
			$bln = date('m');			
		}
		$where = "YEAR(tgl) = '".$thn."' AND  MONTH(tgl) = '".$bln."' ";
		$this->db->where($where);

		$query = $this->db->get();
		return $query->row();
	}

	function get_saldo_sblm() {
		// SALDO SEBELUM NYA
	
		$this->db->select('SUM(debet) AS jum_debet, SUM(kredit) AS jum_kredit');
		$this->db->from('v_transaksi');

		if(isset($_REQUEST['periode'])) {
			$tgl_arr = explode('-', $_REQUEST['periode']);
			$thn = $tgl_arr[0];
			$bln = $tgl_arr[1];
		} else {
			$thn = date('Y');			
			$bln = date('m');			
		}
		$where = "DATE(tgl) < '".$thn."-".$bln."-01' ";

		$this->db->where($where);

		$query_sblm = $this->db->get();
		$saldo_sblm = 0;
		if($query_sblm->num_rows() > 0) {
			$row_sblm = $query_sblm->row();
			$saldo_sblm = ($row_sblm->jum_debet - $row_sblm->jum_kredit);
		}
		return $saldo_sblm;
	}

	//panggil data jenis kas untuk laporan
	function lap_jenis_kas() {
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
}