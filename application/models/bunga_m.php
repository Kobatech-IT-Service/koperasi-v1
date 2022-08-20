<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bunga_m extends CI_Model {

	function get_key_val() {
		$out = array();
		$this->db->select('id,opsi_key,opsi_val');
		$this->db->from('suku_bunga');
		$query = $this->db->get();
		if($query->num_rows()>0){
				$result = $query->result();
				foreach($result as $value){
					$out[$value->opsi_key] = $value->opsi_val;
				}
				return $out;
		} else {
			return array();
		}
	}

	function simpan() {
		$opsi_val_arr = $this->get_key_val();
		foreach ($opsi_val_arr as $key => $val) {
			if($this->input->post($key) || $this->input->post($key) == 0 ) {
				$data = array ('opsi_val'=> $this->input->post($key));
				$this->db->where('opsi_key', $key);
				if($this->db->update('suku_bunga',$data)) {
					// update view hitungan pinjaman
					if($key == 'pinjaman_bunga_tipe') {
						$this->update_db_view_hpin($this->input->post('pinjaman_bunga_tipe'));
					}
				} else {
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	function update_db_view_hpin($tipe) {
		$this->db->query("DROP VIEW IF EXISTS `v_hitung_pinjaman`");
		if($tipe == 'A') {
			$sql = " CREATE VIEW `v_hitung_pinjaman` AS SELECT `tbl_pinjaman_h`.`id` AS `id`,`tbl_pinjaman_h`.`tgl_pinjam` AS `tgl_pinjam`,`tbl_pinjaman_h`.`anggota_id` AS `anggota_id`,`tbl_pinjaman_h`.`lama_angsuran` AS `lama_angsuran`,`tbl_pinjaman_h`.`jumlah` AS `jumlah`,`tbl_pinjaman_h`.`bunga` AS `bunga`,`tbl_pinjaman_h`.`biaya_adm` AS `biaya_adm`,`tbl_pinjaman_h`.`lunas` AS `lunas`,`tbl_pinjaman_h`.`dk` AS `dk`,`tbl_pinjaman_h`.`kas_id` AS `kas_id`,`tbl_pinjaman_h`.`user_name` AS `user_name`,(`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran`) AS `pokok_angsuran`, round(ceiling((((`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran`) * `tbl_pinjaman_h`.`bunga`) / 100)),0) AS `bunga_pinjaman`, round(ceiling((((((((`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran`) * `tbl_pinjaman_h`.`bunga`) / 100) + (`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran`)) + `tbl_pinjaman_h`.`biaya_adm`) * 100) / 100)),0) AS `ags_per_bulan`, (`tbl_pinjaman_h`.`tgl_pinjam` + interval `tbl_pinjaman_h`.`lama_angsuran` month) AS `tempo`, (round(ceiling((((((((`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran`) * `tbl_pinjaman_h`.`bunga`) / 100) + (`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran`)) + `tbl_pinjaman_h`.`biaya_adm`) * 100) / 100)),0) * `tbl_pinjaman_h`.`lama_angsuran`) AS `tagihan`, `tbl_pinjaman_h`.`keterangan` AS `keterangan`,`tbl_pinjaman_h`.`barang_id` AS `barang_id`, IFNULL(MAX(`tbl_pinjaman_d`.`angsuran_ke`), 0) AS `bln_sudah_angsur` FROM `tbl_pinjaman_h` LEFT JOIN `tbl_pinjaman_d` ON `tbl_pinjaman_h`.`id` = `tbl_pinjaman_d`.`pinjam_id` GROUP BY `tbl_pinjaman_h`.`id`
			";
			$this->db->query($sql);
		}
		if($tipe == 'B') {
			$sql = " CREATE VIEW `v_hitung_pinjaman` AS SELECT `tbl_pinjaman_h`.`id` AS `id`,`tbl_pinjaman_h`.`tgl_pinjam` AS `tgl_pinjam`,`tbl_pinjaman_h`.`anggota_id` AS `anggota_id`,`tbl_pinjaman_h`.`lama_angsuran` AS `lama_angsuran`,`tbl_pinjaman_h`.`jumlah` AS `jumlah`,`tbl_pinjaman_h`.`bunga` AS `bunga`,`tbl_pinjaman_h`.`biaya_adm` AS `biaya_adm`,`tbl_pinjaman_h`.`lunas` AS `lunas`,`tbl_pinjaman_h`.`dk` AS `dk`,`tbl_pinjaman_h`.`kas_id` AS `kas_id`,`tbl_pinjaman_h`.`user_name` AS `user_name`, (`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran`) AS `pokok_angsuran`, round(ceiling((((`tbl_pinjaman_h`.`jumlah`) * `tbl_pinjaman_h`.`bunga`) / 100)),0) AS `bunga_pinjaman`, round(ceiling((((((((`tbl_pinjaman_h`.`jumlah`) * `tbl_pinjaman_h`.`bunga`) / 100) + (`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran`)) + `tbl_pinjaman_h`.`biaya_adm`) * 100) / 100)),0) AS `ags_per_bulan`, (`tbl_pinjaman_h`.`tgl_pinjam` + interval `tbl_pinjaman_h`.`lama_angsuran` month) AS `tempo`, (round(ceiling((((((((`tbl_pinjaman_h`.`jumlah`) * `tbl_pinjaman_h`.`bunga`) / 100) + (`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran`)) + `tbl_pinjaman_h`.`biaya_adm`) * 100) / 100)),0) * `tbl_pinjaman_h`.`lama_angsuran`) AS `tagihan`, `tbl_pinjaman_h`.`keterangan` AS `keterangan`,`tbl_pinjaman_h`.`barang_id` AS `barang_id`, IFNULL(MAX(`tbl_pinjaman_d`.`angsuran_ke`), 0) AS `bln_sudah_angsur` FROM `tbl_pinjaman_h` LEFT JOIN `tbl_pinjaman_d` ON `tbl_pinjaman_h`.`id` = `tbl_pinjaman_d`.`pinjam_id` GROUP BY `tbl_pinjaman_h`.`id`
			";
			$this->db->query($sql);
		}
		if($tipe == 'C') {
			$sql = " CREATE VIEW `v_hitung_pinjaman` AS SELECT `tbl_pinjaman_h`.`id` AS `id`,`tbl_pinjaman_h`.`tgl_pinjam` AS `tgl_pinjam`,`tbl_pinjaman_h`.`anggota_id` AS `anggota_id`,`tbl_pinjaman_h`.`lama_angsuran` AS `lama_angsuran`,`tbl_pinjaman_h`.`jumlah` AS `jumlah`,`tbl_pinjaman_h`.`bunga` AS `bunga`,`tbl_pinjaman_h`.`biaya_adm` AS `biaya_adm`,`tbl_pinjaman_h`.`lunas` AS `lunas`,`tbl_pinjaman_h`.`dk` AS `dk`,`tbl_pinjaman_h`.`kas_id` AS `kas_id`,`tbl_pinjaman_h`.`user_name` AS `user_name`, (`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran`) AS `pokok_angsuran`, round(ceiling(((((`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran`) ) * `tbl_pinjaman_h`.`bunga`) / 100)),0) AS `bunga_pinjaman`, round(ceiling(((((((((`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran`) * (`tbl_pinjaman_h`.`lama_angsuran` - IFNULL(MAX(`tbl_pinjaman_d`.`angsuran_ke`), 0)) ) * `tbl_pinjaman_h`.`bunga`) / 100) + (`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran`)) + `tbl_pinjaman_h`.`biaya_adm`) * 100) / 100)),0) AS `ags_per_bulan`, (`tbl_pinjaman_h`.`tgl_pinjam` + interval `tbl_pinjaman_h`.`lama_angsuran` month) AS `tempo`, (round(ceiling((((((((`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran`) * `tbl_pinjaman_h`.`bunga`) / 100) + (`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran`)) + `tbl_pinjaman_h`.`biaya_adm`) * 100) / 100)),0) * `tbl_pinjaman_h`.`lama_angsuran`) AS `tagihan`, `tbl_pinjaman_h`.`keterangan` AS `keterangan`,`tbl_pinjaman_h`.`barang_id` AS `barang_id`, IFNULL(MAX(`tbl_pinjaman_d`.`angsuran_ke`), 0) AS `bln_sudah_angsur` FROM `tbl_pinjaman_h` LEFT JOIN `tbl_pinjaman_d` ON `tbl_pinjaman_h`.`id` = `tbl_pinjaman_d`.`pinjam_id` GROUP BY `tbl_pinjaman_h`.`id`
			";
			$this->db->query($sql);
		}
	}
}