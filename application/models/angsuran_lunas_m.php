<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Angsuran_lunas_m extends CI_Model {
		public function __construct(){
		parent::__construct();
	}

	function get_data_kas() {
		$this->db->select('*');
		$this->db->from('nama_kas_tbl');
		$this->db->where('aktif', 'Y');
		$this->db->where('tmpl_bayar', 'Y');
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$out = $query->result();
			return $out;
		} else {
			return FALSE;
		}
	}
	
	function get_data_transaksi_ajax($offset, $limit, array $q = array(), $sort, $order, $id) {
		$sql = "SELECT * FROM tbl_pinjaman_d WHERE pinjam_id=".$id."";
		if(is_array($q)) {
			if($q['kode_transaksi'] != '') {
				$q['kode_transaksi'] = str_replace('TBY', '', $q['kode_transaksi']);
				$q['kode_transaksi'] = $q['kode_transaksi'] * 1;
				$sql .=" AND id LIKE '%".$q['kode_transaksi']."%'";
			}
			if($q['tgl_dari'] != '' && $q['tgl_sampai'] != '') {
				$sql .=" AND DATE(tgl_bayar) >= '".$q['tgl_dari']."' ";
				$sql .=" AND DATE(tgl_bayar) <= '".$q['tgl_sampai']."' ";
			}
			if(isset($q['pelunasan'])) {
				$sql .=" AND (ket_bayar = 'Pelunasan' OR ket_bayar = 'Bayar Denda') ";
			} else {
				$sql .=" AND (ket_bayar = 'Angsuran') ";
			}
		}
		$result['count'] = $this->db->query($sql)->num_rows();
		$sql .=" ORDER BY {$sort} {$order} ";
		$sql .=" LIMIT {$offset},{$limit} ";
		$result['data'] = $this->db->query($sql)->result();
		return $result;
	}
	
	public function create() {
		if(str_replace(',', '', $this->input->post('jumlah_bayar')) <= 0) {
			return FALSE;
		}

		$ags_ke = $this->general_m->get_record_bayar($this->input->post('pinjam_id')) + 1;

		$total_tagihan = str_replace(',', '', $this->input->post('tagihan')) * 1;
		$jumlah_bayar = str_replace(',', '', $this->input->post('jumlah_bayar')) * 1;
		$denda= str_replace(',', '', $this->input->post('denda_val'))*1;
		$jml_tagihan = $total_tagihan + $denda;
		$data = array(			
						'tgl_bayar'		=>	$this->input->post('tgl_transaksi'),
						'pinjam_id'		=>	$this->input->post('pinjam_id'),
						'angsuran_ke'	=>	$ags_ke,
						'jumlah_bayar'	=>	$jumlah_bayar,
						'ket_bayar'		=>	'Pelunasan',
						'kas_id'			=>	$this->input->post('kas_id'),
						'jns_trans'		=>	'48',
						'keterangan'	=>	$this->input->post('ket'),
						'user_name'		=> $this->data['u_name']
						);
		$this->db->trans_start();
		$this->db->insert('tbl_pinjaman_d', $data);
		if($jumlah_bayar >= $jml_tagihan) {
			$status = 'Lunas';} 
		else {
			$status = 'Belum';}
		$data = array('lunas' => $status);
		$this->db->where('id', $this->input->post('pinjam_id'));
		$this->db->update('tbl_pinjaman_h', $data);
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		} else {
			$this->db->trans_complete();
			return TRUE;
		}
	}
	
	public function update($id, $master_id) {
		$jumlah_bayar = str_replace(',', '', $this->input->post('jumlah_bayar')) * 1;
		$tanggal_u = date('Y-m-d H:i');
		$this->db->where('id', $id);
		$this->db->update('tbl_pinjaman_d',array(
			'tgl_bayar'		=>$this->input->post('tgl_transaksi'),
			'kas_id'			=>	$this->input->post('kas_id'),
			'jumlah_bayar'	=> $jumlah_bayar,
			'update_data'	=> $tanggal_u,
			'keterangan'	=>	$this->input->post('ket'),
			'user_name'		=> $this->data['u_name']
		));
		if($this->auto_status_lunas($master_id)) {
			return TRUE;
		}
	}
	
	public function delete($id, $master_id) {
		$this->db->delete('tbl_pinjaman_d', array('id' => $id));
		if($this->auto_status_lunas($master_id)) {
			return TRUE;
		}
	}

	function auto_status_lunas($master_id) {
		$pinjam = $this->general_m->get_data_pinjam($master_id);
		$tagihan = $pinjam->lama_angsuran * $pinjam->ags_per_bulan;
		$denda = $this->general_m->get_semua_denda_by_pinjaman($master_id);
		$total_tagihan = $tagihan + $denda;
		if($total_tagihan <= 0) {
			$status = 'Lunas';} 
		else {
			$status = 'Belum';}
		$data = array('lunas' => $status);
		$this->db->where('id', $master_id);
		$this->db->update('tbl_pinjaman_h', $data);
		return TRUE;
	}	
}