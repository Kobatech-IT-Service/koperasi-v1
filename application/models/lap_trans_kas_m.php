<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_trans_kas_m extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	//panggil data simpanan
	function get_data_simpanan($limit, $start) {		
		if(isset($_GET['tgl_dari']) && isset($_GET['tgl_samp'])) {
			$tgl_dari = $_GET['tgl_dari'];
			$tgl_samp = $_GET['tgl_samp'];
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';
		}
		$this->db->select('*');
		$this->db->from('v_transaksi');
		$this->db->where('DATE(tgl) >= ', ''.$tgl_dari.'');
		$this->db->where('DATE(tgl) <= ', ''.$tgl_samp.'');
		
		if(isset($_GET['opt_kas']) &&  $_GET['opt_kas'] != 'all'){
		    
		    $this->db->where("(dari_kas='".  $_GET['opt_kas'] . "' OR untuk_kas='".  $_GET['opt_kas'] . "' )", NULL, FALSE);
		    
		}
		
		$this->db->order_by('tgl', 'ASC');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$out = $query->result();
			return $out;
		} else {
			return array();
		}
	}


	function get_jml_data_kas() {
		if(isset($_GET['tgl_dari']) && isset($_GET['tgl_samp'])) {
			$tgl_dari = $_GET['tgl_dari'];
			$tgl_samp = $_GET['tgl_samp'];
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';
		}
		$this->db->where('DATE(tgl) >= ', ''.$tgl_dari.'');
		$this->db->where('DATE(tgl) <= ', ''.$tgl_samp.'');
		
		if(isset($_GET['opt_kas']) &&  $_GET['opt_kas'] != 'all'){
		    
		    $this->db->where("(dari_kas='".  $_GET['opt_kas'] . "' OR untuk_kas='".  $_GET['opt_kas'] . "' )", NULL, FALSE);
		    
		}
		
		return $this->db->count_all_results('v_transaksi');
	}

	function get_saldo_sblm() {
		// SALDO SEBELUM NYA
		if(isset($_GET['tgl_dari']) && isset($_GET['tgl_samp'])) {
			$tgl_dari = $_GET['tgl_dari'];
		} else {
			$tgl_dari = date('Y') . '-01-01';
		}
		$this->db->select('SUM(debet) AS jum_debet, SUM(kredit) AS jum_kredit');
		$this->db->from('v_transaksi');
		
		$this->db->where('DATE(tgl) < ', ''.$tgl_dari.'');	
		
		if(isset($_GET['opt_kas']) &&  $_GET['opt_kas'] != 'all'){
		    
		    $this->db->where("(dari_kas='".  $_GET['opt_kas'] . "' OR untuk_kas='".  $_GET['opt_kas'] . "' )", NULL, FALSE);
		    
		}
		
		$query_sblm = $this->db->get();
		$saldo_sblm = 0;
		if($query_sblm->num_rows() > 0) {
			$row_sblm = $query_sblm->row();
			$saldo_sblm = ($row_sblm->jum_debet - $row_sblm->jum_kredit);
		}
		return $saldo_sblm;
	}

	function get_saldo_awal($limit, $start) {
		$this->db->select('debet, kredit');
		$this->db->from('v_transaksi');
		
		if(isset($_GET['tgl_dari']) && isset($_GET['tgl_samp'])) {
			$tgl_dari = $_GET['tgl_dari'];
			$tgl_samp = $_GET['tgl_samp'];
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';
		}
		$this->db->where('DATE(tgl) >= ', ''.$tgl_dari.'');
		$this->db->where('DATE(tgl) <= ', ''.$tgl_samp.'');
		
		if(isset($_GET['opt_kas']) &&  $_GET['opt_kas'] != 'all'){
		    
		    $this->db->where("(dari_kas='".  $_GET['opt_kas'] . "' OR untuk_kas='".  $_GET['opt_kas'] . "' )", NULL, FALSE);
		    
		}

		$this->db->order_by('tgl', 'ASC');
		$this->db->limit($start, 0);
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$res = $query->result();
			$saldo = 0;
			foreach ($res as $row) {
				$saldo += ($row->debet - $row->kredit);
			}
			return $saldo;
		} else {
			return 0;
		}		
	}
    
    function get_nama_kas_all() {
		$this->db->select('*');
		$this->db->from('nama_kas_tbl');
		
		$query = $this->db->get();
        
        return $query->result();
		
	}
//panggil nama kas
	function get_nama_kas_id($id) {
		$this->db->select('*');
		$this->db->from('nama_kas_tbl');
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

	//panggil transaksi kas  untuk laporan
	function lap_trans_kas() {
        	  
		if(isset($_GET['tgl_dari']) && isset($_GET['tgl_samp'])) {
			$tgl_dari = $_GET['tgl_dari'];
			$tgl_samp = $_GET['tgl_samp'];
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';
		}

		$this->db->select('*');
		$this->db->from('v_transaksi');
		$this->db->where('DATE(tgl) >= ', ''.$tgl_dari.'');
		$this->db->where('DATE(tgl) <= ', ''.$tgl_samp.'');
		if(isset($_GET['opt_kas']) &&  $_GET['opt_kas'] != 'all'){
	
		    
		    $this->db->where("(dari_kas='".  $_GET['opt_kas'] . "' OR untuk_kas='".  $_GET['opt_kas'] . "' )", NULL, FALSE);
		    
		}
		
		
		$this->db->order_by('tgl', 'ASC');

		$query = $this->db->get();

		if($query->num_rows()>0){
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