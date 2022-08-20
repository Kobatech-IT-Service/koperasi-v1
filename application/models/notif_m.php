<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notif_m extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	// tempo
	function get_data_tempo() {
		$this->db->select('v_hitung_pinjaman.tempo AS tempo, v_hitung_pinjaman.tagihan AS tagihan, tbl_anggota.nama AS nama, SUM(tbl_pinjaman_d.jumlah_bayar) AS jum_bayar, SUM(tbl_pinjaman_d.denda_rp) AS jum_denda');
		$this->db->from('v_hitung_pinjaman');
		$this->db->where('lunas','Belum');
		
		$where = " DATE(tempo) < (CURDATE() + INTERVAL 14 DAY) ";
		$this->db->where($where, false, false);
		$this->db->join('tbl_anggota', 'tbl_anggota.id = v_hitung_pinjaman.anggota_id', 'LEFT');
		$this->db->join('tbl_pinjaman_d', 'tbl_pinjaman_d.pinjam_id = v_hitung_pinjaman.id', 'LEFT');
		$this->db->order_by('v_hitung_pinjaman.tempo', 'ASC');
		$this->db->group_by('v_hitung_pinjaman.id');
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$out = $query->result();
			return $out;
		} else {
			return array();
		}
	}

	// pengajuan pinjaman
	function get_pengajuan() {
		if($this->session->userdata('level') == 'pinjaman' || $this->session->userdata('level') == 'admin') {
			$this->db->where('status', 0);
		} else {
			$this->db->where('status', 1);
		}
		$this->db->from('tbl_pengajuan');
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$out = $query->result();
			return $out;
		} else {
			return array();
		}		
	}

}