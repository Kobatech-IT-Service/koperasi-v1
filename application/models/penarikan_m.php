<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penarikan_m extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	#panggil data kas
	function get_data_kas() {
		$this->db->select('*');
		$this->db->from('nama_kas_tbl');
		$this->db->where('aktif', 'Y');
		$this->db->where('tmpl_penarikan', 'Y');
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$out = $query->result();
			return $out;
		} else {
			return FALSE;
		}
	}

	//panggil data penarikan untuk laporan 
	function lap_data_penarikan() {
		$kode_transaksi = isset($_REQUEST['kode_transaksi']) ? $_REQUEST['kode_transaksi'] : '';
		$cari_simpanan = isset($_REQUEST['cari_simpanan']) ? $_REQUEST['cari_simpanan'] : '';
		$tgl_dari = isset($_REQUEST['tgl_dari']) ? $_REQUEST['tgl_dari'] : '';
		$tgl_sampai = isset($_REQUEST['tgl_sampai']) ? $_REQUEST['tgl_sampai'] : '';
		$sql = '';
		$sql = " SELECT * FROM tbl_trans_sp WHERE dk='K' ";
		$q = array('kode_transaksi' => $kode_transaksi, 
			'cari_simpanan' => $cari_simpanan,
			'tgl_dari' => $tgl_dari, 
			'tgl_sampai' => $tgl_sampai);
		if(is_array($q)) {
			if($q['kode_transaksi'] != '') {
				$q['kode_transaksi'] = str_replace('TRD', '', $q['kode_transaksi']);
				$q['kode_transaksi'] = str_replace('AG', '', $q['kode_transaksi']);
				$q['kode_transaksi'] = $q['kode_transaksi'] * 1;
				$sql .=" AND (id LIKE '".$q['kode_transaksi']."' OR anggota_id LIKE '".$q['kode_transaksi']."') ";
			} else {
				if($q['cari_simpanan'] != '') {
					$sql .=" AND jenis_id = '".$q['cari_simpanan']."%' ";
				}

				if($q['tgl_dari'] != '' && $q['tgl_sampai'] != '') {
					$sql .=" AND DATE(tgl_transaksi) >= '".$q['tgl_dari']."' ";
					$sql .=" AND DATE(tgl_transaksi) <= '".$q['tgl_sampai']."' ";
				}
			}
		}
		$query = $this->db->query($sql);
		if($query->num_rows() > 0) {
			$out = $query->result();
			return $out;
		} else {
			return FALSE;
		}
	}

	//panggil data anggota
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

	//panggil data jenis simpan
	function get_jenis_simpan($id) {
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

	//hitung jumlah total simpanan
	function get_jml_penarikan() {
		$this->db->select('SUM(jumlah) AS jml_total');
		$this->db->from('tbl_trans_sp');
		$this->db->where('dk','K');
		$query = $this->db->get();
		return $query->row();
	}

	//panggil data simpanan untuk esyui
	function get_data_transaksi_ajax($offset, $limit, $q='', $sort, $order) {
		$sql = "SELECT * FROM tbl_trans_sp WHERE dk='K' ";
		if(is_array($q)) {
			if($q['kode_transaksi'] != '') {
				$q['kode_transaksi'] = str_replace('TRK', '', $q['kode_transaksi']);
				$q['kode_transaksi'] = str_replace('AG', '', $q['kode_transaksi']);
				$q['kode_transaksi'] = $q['kode_transaksi'] * 1;
				$sql .=" AND (id LIKE '".$q['kode_transaksi']."' OR anggota_id LIKE '".$q['kode_transaksi']."') ";
			} else {
				if($q['cari_simpanan'] != '') {
					$sql .=" AND jenis_id = '".$q['cari_simpanan']."%' ";
				}

				if($q['tgl_dari'] != '' && $q['tgl_sampai'] != '') {
					$sql .=" AND DATE(tgl_transaksi) >= '".$q['tgl_dari']."' ";
					$sql .=" AND DATE(tgl_transaksi) <= '".$q['tgl_sampai']."' ";
				}
			}
		}
		$result['count'] = $this->db->query($sql)->num_rows();
		$sql .=" ORDER BY {$sort} {$order} ";
		$sql .=" LIMIT {$offset},{$limit} ";
		$result['data'] = $this->db->query($sql)->result();
		return $result;
	}

	public function create() {
		if(str_replace(',', '', $this->input->post('jumlah')) <= 0) {
			return FALSE;
		}
		$data = array(			
			'tgl_transaksi'		=>	$this->input->post('tgl_transaksi'),
			'anggota_id'			=>	$this->input->post('anggota_id'),
			'jenis_id'				=>	$this->input->post('jenis_id'),
			'jumlah'					=>	str_replace(',', '', $this->input->post('jumlah')),
			'keterangan'			=> $this->input->post('ket'),
			'akun'					=>	'Penarikan',
			'dk'						=>	'K',
			'kas_id'					=>	$this->input->post('kas_id'),
			'user_name'				=> $this->data['u_name'],
			'nama_penyetor'			=> $this->input->post('nama_penyetor'),
			'no_identitas'			=> $this->input->post('no_identitas'),
			'alamat'					=> $this->input->post('alamat')
			);
		return $this->db->insert('tbl_trans_sp', $data);
	}


	public function update($id) {
		if(str_replace(',', '', $this->input->post('jumlah')) <= 0) {
			return FALSE;
		}

		$tanggal_u = date('Y-m-d H:i');
		$this->db->where('id', $id);
		return $this->db->update('tbl_trans_sp',array(
			'tgl_transaksi'		=>	$this->input->post('tgl_transaksi'),
			'jenis_id'				=>	$this->input->post('jenis_id'),
			'jumlah'					=>	str_replace(',', '', $this->input->post('jumlah')),
			'keterangan'			=> $this->input->post('ket'),
			'kas_id'					=>	$this->input->post('kas_id'),
			'update_data'			=> $tanggal_u,
			'user_name'				=> $this->data['u_name'],
			'nama_penyetor'			=> $this->input->post('nama_penyetor'),
			'no_identitas'			=> $this->input->post('no_identitas'),
			'alamat'					=> $this->input->post('alamat')
			));
	}

	public function delete($id) {
		return $this->db->delete('tbl_trans_sp', array('id' => $id)); 
	}
}