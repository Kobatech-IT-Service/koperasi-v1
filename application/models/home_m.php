<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_m extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	//hitung jumlah anggota total
	function get_anggota_all() {
		$this->db->select('*');
		$this->db->from('tbl_anggota');
		$query = $this->db->get();
		return $query->num_rows();
	}

	//hitung jumlah anggota aktif
	function get_anggota_aktif() {
		$this->db->select('*');
		$this->db->from('tbl_anggota');
		$this->db->where('aktif','Y');
		$query = $this->db->get();
		return $query->num_rows();
	}

	//hitung jumlah anggota tdk aktif
	function get_anggota_non() {
		$this->db->select('*');
		$this->db->from('tbl_anggota');
		$this->db->where('aktif','N');
		$query = $this->db->get();
		return $query->num_rows();
	}

	
	//menghitung jumlah simpanan
	function get_jml_simpanan() {
		$this->db->select('SUM(jumlah) AS jml_total');
		$this->db->from('tbl_trans_sp');
		$this->db->where('dk','D');

		$thn = date('Y');			
		$bln = date('m');			
		$where = "YEAR(tgl_transaksi) = '".$thn."' AND  MONTH(tgl_transaksi) = '".$bln."' ";
		$this->db->where($where);

		$query = $this->db->get();
		return $query->row();
	}

	//menghitung jumlah penarikan
	function get_jml_penarikan() {
		$this->db->select('SUM(jumlah) AS jml_total');
		$this->db->from('tbl_trans_sp');
		$this->db->where('dk','K');

		$thn = date('Y');			
		$bln = date('m');			
		$where = "YEAR(tgl_transaksi) = '".$thn."' AND  MONTH(tgl_transaksi) = '".$bln."' ";
		$this->db->where($where);

		$query = $this->db->get();
		return $query->row();
	}

	//hitung jumlah peminjam aktif
	function get_peminjam_aktif() {
		$this->db->select('*');
		$this->db->from('v_hitung_pinjaman');
		
		$tgl_dari = date('Y') . '-01-01';
		$tgl_samp = date('Y') . '-12-31';
		
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

		$tgl_dari = date('Y') . '-01-01';
		$tgl_samp = date('Y') . '-12-31';
		
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

		$tgl_dari = date('Y') . '-01-01';
		$tgl_samp = date('Y') . '-12-31';
		
		$this->db->where('DATE(tgl_pinjam) >= ', ''.$tgl_dari.'');
		$this->db->where('DATE(tgl_pinjam) <= ', ''.$tgl_samp.'');

		$query = $this->db->get();
		return $query->num_rows();
	}

	//menghitung jumlah pinjaman Rp
	function get_jml_pinjaman() {
		$this->db->select('SUM(tagihan) AS jml_total');
		$this->db->from('v_hitung_pinjaman');

		$tgl_dari = date('Y') . '-01-01';
		$tgl_samp = date('Y') . '-12-31';
		
		$this->db->where('DATE(tgl_pinjam) >= ', ''.$tgl_dari.'');
		$this->db->where('DATE(tgl_pinjam) <= ', ''.$tgl_samp.'');

		$query = $this->db->get();
		return $query->row();
	}

	//menghitung jumlah angsuran
	function get_jml_angsuran() {
		$this->db->select('SUM(jumlah_bayar) AS jml_total');
		$this->db->from('tbl_pinjaman_d');

		$tgl_dari = date('Y') . '-01-01';
		$tgl_samp = date('Y') . '-12-31';
		
		$this->db->where('DATE(tgl_bayar) >= ', ''.$tgl_dari.'');
		$this->db->where('DATE(tgl_bayar) <= ', ''.$tgl_samp.'');

		$query = $this->db->get();
		return $query->row();
	}

	function get_jml_denda() {
		$this->db->select('SUM(denda_rp) AS total_denda');
		$this->db->from('tbl_pinjaman_d');

		if(isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
			$tgl_dari = $_REQUEST['tgl_dari'];
			$tgl_samp = $_REQUEST['tgl_samp'];
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';
		}
		$this->db->where('DATE(tgl_bayar) >= ', ''.$tgl_dari.'');
		$this->db->where('DATE(tgl_bayar) <= ', ''.$tgl_samp.'');

		$query = $this->db->get();
		return $query->row();
	}

	function get_peminjam_bln_ini() {
		$this->db->select('*');
		$this->db->from('v_hitung_pinjaman');
		$this->db->where('lunas','Belum');

		$thn = date('Y');			
		$bln = date('m');			
		$where = "YEAR(tgl_pinjam) = '".$thn."' AND  MONTH(tgl_pinjam) = '".$bln."' ";
		$this->db->where($where);

		$query = $this->db->get();
		return $query->num_rows();
	}

	//menghitung jumlah kas debet
	function get_jml_debet() {
		$this->db->select('SUM(debet) AS jml_total');
		$this->db->from('v_transaksi');
		$thn = date('Y');			
		$bln = date('m');			
		$where = "YEAR(tgl) = '".$thn."' AND  MONTH(tgl) = '".$bln."' ";
		$this->db->where($where);
		$query = $this->db->get();
		return $query->row();
	}

	//menghitung jumlah kas kredit
	function get_jml_kredit() {
		$this->db->select('SUM(kredit) AS jml_total');
		$this->db->from('v_transaksi');
		$thn = date('Y');			
		$bln = date('m');			
		$where = "YEAR(tgl) = '".$thn."' AND  MONTH(tgl) = '".$bln."' ";
		$this->db->where($where);
		$query = $this->db->get();
		return $query->row();
	}

	//hitung jumlah user aktif
	function get_user_aktif() {
		$this->db->select('*');
		$this->db->from('tbl_user');
		$this->db->where('aktif','Y');
		$query = $this->db->get();
		return $query->num_rows();
	}

	//hitung jumlah anggota tdk aktif
	function get_user_non() {
		$this->db->select('*');
		$this->db->from('tbl_user');
		$this->db->where('aktif','N');
		$query = $this->db->get();
		return $query->num_rows();
	}
}