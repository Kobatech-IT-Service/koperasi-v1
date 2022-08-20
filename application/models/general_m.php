<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General_m extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	//panggil data anggota untuk combo 
	function get_data_anggota_ajax($q) {
		$sql = "SELECT * FROM tbl_anggota WHERE aktif='Y' ";
		if($q !='') {
			$sql .=" AND (identitas LIKE '%{$q}%' OR nama LIKE '%{$q}%') ";
		}
		$result['count'] = $this->db->query($sql)->num_rows();
		$sql .=" ORDER BY identitas ASC ";
		$sql .=" LIMIT 50 ";
		$result['data'] = $this->db->query($sql)->result();
		return $result;
	}

	//panggil data anggota berdasarkan ID
	function get_data_anggota($id) {
		$this->db->select('*');
		$this->db->from('tbl_anggota');
		$this->db->where('id',$id);
		$query = $this->db->get();
		if($query->num_rows()>0){
			$out = $query->row();
			return $out;
		} else {
			return FALSE;
		}
	}

	//panggil data anggota tanpa ID
	function get_anggota() {
		$this->db->select('*');
		$this->db->from('tbl_anggota');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$out = $query->row();
			return $out;
		} else {
			return FALSE;
		}
	}

	//hitung jumlah anggota
	function get_jml_anggota($id) {
		$this->db->select('id');
		$this->db->from('tbl_anggota');
		$this->db->where('aktif','Y');
		$query = $this->db->get();
		return $query->num_rows();
	}

	//panggil data jenis simpanan dengan id
	function get_jns_simpanan($id) {
		$this->db->select('*');
		$this->db->from('jns_simpan');
		$this->db->where('id',$id);
		$query = $this->db->get();
		if($query->num_rows()>0){
			$out = $query->row();
			return $out;
		} else {
			return FALSE;
		}
	}

	//panggil data jenis simpanan
	function get_id_simpanan() {
		$this->db->select('*');
		$this->db->from('jns_simpan');
		$this->db->where('tampil', 'Y');
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$out = $query->result();
			return $out;
		} else {
			return array();
		}
	}

	//menghitung jumlah pinjaman seluruhnya
	function get_total_pinjaman() {
		$this->db->select('SUM(tagihan) AS total');
		$this->db->from('v_hitung_pinjaman');
		$query = $this->db->get();
		return $query->row();
	}

	//menghitung jumlah yang sudah dibayar dengan id pinjam
	function get_jml_bayar($id) {
		$this->db->select('SUM(jumlah_bayar) AS total');
		$this->db->from('tbl_pinjaman_d');
		$this->db->where('pinjam_id',$id);
		$query = $this->db->get();
		return $query->row();
	}

	//menghitung jumlah yang sudah dibayar seluruhnya
	function get_total_dibayar() {
		$this->db->select('SUM(jumlah_bayar) AS total');
		$this->db->from('tbl_pinjaman_d');
		$query = $this->db->get();
		return $query->row();
	}

	//menghitung jumlah denda harus dibayar dengan ID pinjam
	function get_jml_denda($id) {
		$this->db->select('SUM(denda_rp) AS total_denda');
		$this->db->from('tbl_pinjaman_d');
		$this->db->where('pinjam_id',$id);
		$query = $this->db->get();
		return $query->row();
	}

	//menghitung jumlah   denda seluruhnya
	function get_total_denda() {
		$this->db->select('SUM(denda_rp) AS total_denda');
		$this->db->from('tbl_pinjaman_d');
		$query = $this->db->get();
		return $query->row();
	}

	//mecari banyaknya data yg diinput pinjaman detail
	function get_record_bayar($id) {
		$this->db->select('id');
		$this->db->from('tbl_pinjaman_d');
		$this->db->where('pinjam_id',$id);
		$this->db->where('ket_bayar','Angsuran');
		$query = $this->db->get();
		return $query->num_rows();
	}

	//ambil data pinjaman header berdasarkan ID
	function get_data_pinjam($id) {
		$this->db->select('*');
		$this->db->from('v_hitung_pinjaman');
		$this->db->where('id',$id);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$out = $query->row();
			return $out;
		} else {
			return FALSE;
		}
	}

	//panggil data pinjaman tanpa id
	function data_pinjaman() {
		$this->db->select('*');
		$this->db->from('v_hitung_pinjaman');
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$out = $query->result();
			return $out;
		} else {
			return FALSE;
		}
	}


	//panggil data pinjaman detail berdasarkan pinjam ID
	function get_data_pembayaran($id) {
		$this->db->select('*');
		$this->db->from('tbl_pinjaman_d');
		$this->db->where('pinjam_id', $id);
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$out = $query->result();
			return $out;
		} else {
			return FALSE;
		}
	}

	//panggil data pinjaman detail berdasarkan ID
	function get_data_pembayaran_by_id($id) {
		$this->db->select('*');
		$this->db->from('tbl_pinjaman_d');
		$this->db->where('id', $id);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$out = $query->row();
			return $out;
		} else {
			return FALSE;
		}
	}

	//panggil data denda dan tempo 
	function get_semua_denda_by_pinjaman($master_id) {
		$pinjam = $this->get_data_pinjam($master_id);
		$this->db->select('MAX(angsuran_ke) AS angsuran_ke');
		$this->db->from('tbl_pinjaman_d');
		$this->db->where('pinjam_id', $master_id);
		$query = $this->db->get();
		$ags = $query->row();
		$ags_ke = $ags->angsuran_ke;

		$sisa_ags_det = $pinjam->lama_angsuran - ($ags_ke) ;
		// DENDA
		$denda_semua = 0;
		$tgl_pinjam = substr($pinjam->tgl_pinjam, 0, 7) . '-01';
		$tgl_tempo = date('Y-m-d', strtotime("+".$ags_ke." months", strtotime($tgl_pinjam)));
		$tgl_bayar = date('Y-m-d');
		$data_bunga_arr = $this->bunga_m->get_key_val();
		$denda_hari = $data_bunga_arr['denda_hari'];
		$tgl_tempo = str_replace('-', '', $tgl_tempo);
		$tgl_bayar = str_replace('-', '', $tgl_bayar);
		$tgl_toleransi = $tgl_bayar - ($tgl_tempo - 1);
		if ( $tgl_toleransi > $denda_hari ) { // 20140615 - 20140600
			$denda_semua = ($data_bunga_arr['denda'] * $sisa_ags_det);
		}
		return $denda_semua;
	}	
}

