<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_laba_m extends CI_Model {

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

	// jumlah yg harus diangsur
	function get_jml_estimasi_angsur() {
		$this->db->select('SUM(ags_per_bulan * lama_angsuran) AS jml_total');
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

	//jumlah biaya adm
	function get_jml_biaya_adm() {
		$this->db->select('SUM(biaya_adm * lama_angsuran) AS jml_total');
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

	//jumlah bunga
	function get_jml_bunga() {
		$this->db->select('SUM(bunga_pinjaman * lama_angsuran) AS jml_total');
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

	function get_data_akun_dapat() {
		$this->db->select('*');
		$this->db->from('jns_akun');
		$this->db->where('aktif', 'Y');
		$this->db->where('laba_rugi', 'PENDAPATAN');
		$this->db->where('CHAR_LENGTH(kd_aktiva) >', '1', FALSE);
		$this->db->_protect_identifiers = FALSE;
		$this->db->order_by('LPAD(kd_aktiva, 1, 0) ASC, LPAD(kd_aktiva, 5, 1)', 'ASC');
		$this->db->_protect_identifiers = TRUE;
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$out = $query->result();
			return $out;
		} else {
			return array();
		}
	}

	function get_data_akun_biaya() {
		$this->db->select('*');
		$this->db->from('jns_akun');
		$this->db->where('aktif', 'Y');
		$this->db->where('laba_rugi', 'BIAYA');
		$this->db->where('CHAR_LENGTH(kd_aktiva) >', '1', FALSE);
		$this->db->_protect_identifiers = FALSE;
		$this->db->order_by('LPAD(kd_aktiva, 1, 0) ASC, LPAD(kd_aktiva, 5, 1)', 'ASC');
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			$out = $query->result();
			return $out;
		} else {
			return array();
		}
	}


	function get_jml_akun($akun) {
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
}