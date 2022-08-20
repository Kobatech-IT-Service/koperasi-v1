<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_macet_m extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

		//panggil data simpanan
	function get_data_tempo($limit, $start) {
		$this->db->select('v_hitung_pinjaman.id AS id,v_hitung_pinjaman.tempo AS tempo,v_hitung_pinjaman.tgl_pinjam AS tgl_pinjam, v_hitung_pinjaman.tagihan AS tagihan, v_hitung_pinjaman.lama_angsuran AS lama_angsuran, tbl_anggota.nama AS nama, SUM(tbl_pinjaman_d.jumlah_bayar) AS jum_bayar, SUM(tbl_pinjaman_d.denda_rp) AS jum_denda');
		$this->db->from('v_hitung_pinjaman');
		$this->db->where('lunas','Belum');
		
		$this->db->join('tbl_anggota', 'tbl_anggota.id = v_hitung_pinjaman.anggota_id', 'LEFT');
		$this->db->join('tbl_pinjaman_d', 'tbl_pinjaman_d.pinjam_id = v_hitung_pinjaman.id', 'LEFT');
		$this->db->order_by('v_hitung_pinjaman.tempo', 'ASC');
		$this->db->group_by('v_hitung_pinjaman.id');

		if(isset($_REQUEST['periode'])) {
			$tgl_arr = explode('-', $_REQUEST['periode']);
			$thn = $tgl_arr[0];
			$bln = $tgl_arr[1];
		} else {
			$thn = date('Y');			
			$bln = date('m');			
		}
		$where = "YEAR(tempo) = '".$thn."' AND  MONTH(tempo) < '".$bln."' ";
		$this->db->where($where);
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		if($query->num_rows()>0) {
			$out = $query->result();
			return $out;
		} else {
			return array();
		}
	}

	function get_jml_data_tempo() {
		$this->db->where('lunas', 'Belum');
		return $this->db->count_all_results('v_hitung_pinjaman');
	}

	//panggil data jenis simpan untuk laporan
	function lap_data_tempo() {
		$this->db->select('*');
		$this->db->from('v_hitung_pinjaman');
		if(isset($_REQUEST['periode'])) {
			$tgl_arr = explode('-', $_REQUEST['periode']);
			$thn = $tgl_arr[0];
			$bln = $tgl_arr[1];
		} else {
			$thn = date('Y');			
			$bln = date('m');			
		}
		$where = "YEAR(tempo) = '".$thn."' AND  MONTH(tempo) < '".$bln."' ";
		$this->db->where($where);
		$this->db->where('lunas','Belum');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$out = $query->result();
			return $out;
		} else {
			return array();
		}
	}
}