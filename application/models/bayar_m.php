<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bayar_m extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	function get_data_transaksi_ajax($offset, $limit, $q='', $sort, $order) {
		$sql = "SELECT v_hitung_pinjaman.* FROM v_hitung_pinjaman ";
		$where = " WHERE lunas='Belum'  ";
		if(is_array($q)) {
			if($q['kode_transaksi'] != '') {
				$q['kode_transaksi'] = str_replace('TPJ', '', $q['kode_transaksi']);
				$q['kode_transaksi'] = $q['kode_transaksi'] * 1;
				$where .=" AND (id LIKE '".$q['kode_transaksi']."' OR anggota_id LIKE '".$q['kode_transaksi']."') ";
			} else {
				if($q['cari_nama'] != '') {
					$where .=" AND tbl_anggota.nama LIKE '%".$q['cari_nama']."%' ";
					$sql .= " LEFT JOIN tbl_anggota ON (v_hitung_pinjaman.anggota_id = tbl_anggota.id) ";
				}
				if($q['tgl_dari'] != '' && $q['tgl_sampai'] != '') {
					$where .=" AND DATE(tgl_pinjam) >= '".$q['tgl_dari']."' ";
					$where .=" AND DATE(tgl_pinjam) <= '".$q['tgl_sampai']."' ";
				}
			}
		}
		$sql .= $where;
		$result['count'] = $this->db->query($sql)->num_rows();
		$sql .=" ORDER BY {$sort} {$order} ";
		$sql .=" LIMIT {$offset},{$limit} ";
		$result['data'] = $this->db->query($sql)->result();
		return $result;
	}
}

