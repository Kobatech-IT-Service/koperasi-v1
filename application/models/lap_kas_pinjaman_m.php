<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_kas_pinjaman_m extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	//menghitung jumlah tagihan
	function get_jml_pinjaman() {
		$this->db->select('SUM(jumlah) AS jml_total');
		$this->db->from('v_hitung_pinjaman');

		if(isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
			$tgl_dari = $_REQUEST['tgl_dari'];
			$tgl_samp = $_REQUEST['tgl_samp'];
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';
		}
		$this->db->where('DATE(tgl_pinjam) >= ', ''.$tgl_dari.'');
		$this->db->where('DATE(tgl_pinjam) <= ', ''.$tgl_samp.'');

		$query = $this->db->get();
		return $query->row();
	}

	//menghitung jumlah tagihan
	function get_jml_tagihan() {
		$this->db->select('SUM(tagihan) AS jml_total');
		$this->db->from('v_hitung_pinjaman');

		if(isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
			$tgl_dari = $_REQUEST['tgl_dari'];
			$tgl_samp = $_REQUEST['tgl_samp'];
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';
		}
		$this->db->where('DATE(tgl_pinjam) >= ', ''.$tgl_dari.'');
		$this->db->where('DATE(tgl_pinjam) <= ', ''.$tgl_samp.'');

		$query = $this->db->get();
		return $query->row();
	}

	//menghitung jumlah angsuran
	function get_jml_angsuran() {
		$this->db->select('SUM(jumlah_bayar) AS jml_total');
		$this->db->from('tbl_pinjaman_d');
		$this->db->join('tbl_pinjaman_h', 'tbl_pinjaman_h.id = tbl_pinjaman_d.pinjam_id', 'LEFT');

		if(isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
			$tgl_dari = $_REQUEST['tgl_dari'];
			$tgl_samp = $_REQUEST['tgl_samp'];
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';
		}
		$this->db->where('DATE(tbl_pinjaman_h.tgl_pinjam) >= ', ''.$tgl_dari.'');
		$this->db->where('DATE(tbl_pinjaman_h.tgl_pinjam) <= ', ''.$tgl_samp.'');

		$query = $this->db->get();
		return $query->row();
	}


	//menghitung jumlah denda harus dibayar
	function get_jml_denda() {
		$this->db->select('SUM(denda_rp) AS total_denda');
		$this->db->from('tbl_pinjaman_d');
		$this->db->join('tbl_pinjaman_h', 'tbl_pinjaman_h.id = tbl_pinjaman_d.pinjam_id', 'LEFT');

		if(isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
			$tgl_dari = $_REQUEST['tgl_dari'];
			$tgl_samp = $_REQUEST['tgl_samp'];
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';
		}
		$this->db->where('DATE(tbl_pinjaman_h.tgl_pinjam) >= ', ''.$tgl_dari.'');
		$this->db->where('DATE(tbl_pinjaman_h.tgl_pinjam) <= ', ''.$tgl_samp.'');

		$query = $this->db->get();
		return $query->row();
	}

		//hitung jumlah peminjam aktif
	function get_peminjam_aktif() {
		$this->db->select('*');
		$this->db->from('v_hitung_pinjaman');
		
		if(isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
			$tgl_dari = $_REQUEST['tgl_dari'];
			$tgl_samp = $_REQUEST['tgl_samp'];
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';
		}
		$this->db->where('DATE(tgl_pinjam) >= ', ''.$tgl_dari.'');
		$this->db->where('DATE(tgl_pinjam) <= ', ''.$tgl_samp.'');

		$query = $this->db->get();
		return $query->num_rows();
	}

	//hitung jumlah peminjam lunas
	function get_peminjam_lunas() {
		$this->db->select('*');
		$this->db->from('v_hitung_pinjaman');
		$this->db->where('lunas','Lunas');

		if(isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
			$tgl_dari = $_REQUEST['tgl_dari'];
			$tgl_samp = $_REQUEST['tgl_samp'];
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';
		}
		$this->db->where('DATE(tgl_pinjam) >= ', ''.$tgl_dari.'');
		$this->db->where('DATE(tgl_pinjam) <= ', ''.$tgl_samp.'');

		$query = $this->db->get();
		return $query->num_rows();
	}

	//hitung jumlah peminjam belum lunas
	function get_peminjam_belum() {
		$this->db->select('*');
		$this->db->from('v_hitung_pinjaman');
		$this->db->where('lunas','Belum');

		if(isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
			$tgl_dari = $_REQUEST['tgl_dari'];
			$tgl_samp = $_REQUEST['tgl_samp'];
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';
		}
		$this->db->where('DATE(tgl_pinjam) >= ', ''.$tgl_dari.'');
		$this->db->where('DATE(tgl_pinjam) <= ', ''.$tgl_samp.'');
		$query = $this->db->get();
		return $query->num_rows();
	}
}