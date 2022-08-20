<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Member_m extends CI_Model {

	public function validasi() {
		$form_rules = array(
			array(
				'field' => 'u_name',
				'label' => 'username',
				'rules' => 'required'
				),
			array(
				'field' => 'pass_word',
				'label' => 'password',
				'rules' => 'required'
				),
			);
		$this->form_validation->set_rules($form_rules);

		if ($this->form_validation->run()) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

    // cek status user, login atau tidak?
	public function cek_user() {
		$u_name = $this->input->post('u_name');
		$pass_word = sha1('nsi' . $this->input->post('pass_word'));

		$this->db->where('identitas', $u_name);
		$this->db->where('pass_word', $pass_word);
		$this->db->where('aktif', 'Y');
		$this->db->limit(1);
		$query = $this->db->get('tbl_anggota');
		if ($query->num_rows() == 1) {
			$row = $query->row();
			//$level = $row->level;
			$data = array(
				'login'		=> TRUE,
				'u_name' 	=> $row->id, 
				'level'		=> 'member'
				);
			// simpan data session jika login benar
			$this->session->set_userdata($data);
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function get_data_anggota($id) {
		$out = array();
		$sql = "SELECT * FROM tbl_anggota WHERE aktif='Y'";
		$sql .=" AND (id = '".$id."') ";
		$query = $this->db->query($sql);
		if($query->num_rows() > 0) {
			$out = $query->row();
			return $out;
		}
	}


	// UBAH PASS
	public function validasi_ubah_pass() {
		$form_rules = array(
			array(
				'field' => 'password_lama',
				'label' => 'Password Lama',
				'rules' => 'required'
				), array(
				'field' => 'password_baru',
				'label' => 'Password Baru',
				'rules' => 'required'
				), array(
				'field' => 'ulangi_password_baru',
				'label' => 'Ulangi Password Baru',
				'rules' => 'required'
				)
			);
		$this->form_validation->set_rules($form_rules);
		if ($this->form_validation->run()) {
			return TRUE;
		} else {
			return FALSE;
		}
	}


	function cek_pass_lama($user_id) {
		$out = array();
		$pass_word = sha1('nsi' . $this->input->post('password_lama'));
		$this->db->select('id,pass_word');
		$this->db->from('tbl_anggota');
		$this->db->where('id', $user_id);
		$this->db->where('pass_word', $pass_word);
		$this->db->limit('1');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$out = $query->result();
			return $out;
		} else {
			return FALSE;
		}
	}

	function simpan() {
		$user_id = $this->session->userdata('u_name');
		$data_user = $this->cek_pass_lama($user_id);
		if($data_user){
			$pass_word = sha1('nsi' . $this->input->post('password_baru'));
			$data = array ('pass_word'=> $pass_word);
			$this->db->where('id', $user_id);
			if($this->db->update('tbl_anggota', $data)) {
				// ok
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	// PENGAJUAN
	public function validasi_pengajuan() {
		$form_rules = array(
			array(
				'field' => 'nominal',
				'label' => 'Nominal',
				'rules' => 'required'
				), array(
				'field' => 'jenis',
				'label' => 'Jenis',
				'rules' => 'required'
				), array(
				'field' => 'keterangan',
				'label' => 'Keterangan',
				'rules' => 'required'
				)
			);
		$this->form_validation->set_rules($form_rules);
		if ($this->form_validation->run()) {
			return TRUE;
		} else {
			return FALSE;
		}
	}	

	function pengajuan_simpan() {
		$user_id = $this->session->userdata('u_name');
		// last no
		$jenis = $this->input->post('jenis');
		$lama_ags = $this->input->post('lama_ags');
		$nominal = preg_replace('/\D/', '', $this->input->post('nominal'));
		if(date("d") >= 21) {
			$bln_1 = date("Y-m") . '-21';
			$bln_2 = date("Y-m", strtotime("+1 month")) . '-20';
		} else {
			$bln_1 = date("Y-m", strtotime("-1 month")) . '-21';
			$bln_2 = date("Y-m") . '-20';
		}
		$this->db->select_max('no_ajuan');
		$this->db->from('tbl_pengajuan');
		$this->db->where('DATE(tgl_input) >=', $bln_1);
		$this->db->where('DATE(tgl_input) <=', $bln_2);
		$this->db->where('jenis', $jenis);
		$query = $this->db->get();
		$no_ajuan = 1;
		if($query->num_rows() > 0) {
			$row = $query->row();
			$no_ajuan = $row->no_ajuan + 1;
		}
		// ajuan_id
		$ajuan_id = '';
		if($jenis == 'Biasa') {
			$ajuan_id .= 'B';
		}
		if($jenis == 'Darurat') {
			$lama_ags = 1;
			$ajuan_id .= 'D';
		}
		if($jenis == 'Barang') {
			$ajuan_id .= 'BR';
		}
		if(date("d") >= 21) {
			$ajuan_id .= '.' . substr(date("Y", strtotime("+1 month")), 2, 2);
			$ajuan_id .= '.' . date("m", strtotime("+1 month"));
		} else {
			$ajuan_id .= '.' . substr(date("Y"), 2, 2);
			$ajuan_id .= '.' . date("m");
		}
		$ajuan_id .= '.' . sprintf("%03d", $no_ajuan);

		$data = array (
			'no_ajuan'		=> $no_ajuan,
			'ajuan_id'		=> $ajuan_id,
			'anggota_id'	=> $user_id,
			'nominal'		=> $nominal,
			'jenis'			=> $jenis,
			'lama_ags'		=> $lama_ags,
			'keterangan'	=> $this->input->post('keterangan'),
			'tgl_input'		=> date('Y-m-d H:i:s'),
			'tgl_update'	=> date('Y-m-d H:i:s'),
			'status'			=> 0
			);
		if($this->db->insert('tbl_pengajuan', $data)) {
			// ok
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function pengajuan_batal($id) {
		$user_id = $this->session->userdata('u_name');
		$data = array('status' => 4);
		$this->db->where('id', $id);
		$this->db->where('status', 0);
		$this->db->where('anggota_id', $user_id);
		if($this->db->update('tbl_pengajuan', $data)) {
			// ok
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function get_last_pengajuan() {
		$user_id = $this->session->userdata('u_name');
		$this->db->from('tbl_pengajuan');
		$this->db->where('anggota_id', $user_id);
		$this->db->order_by('tgl_update', 'desc');
		$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			$out = $query->row();
			return $out;
		} else {
			return FALSE;
		}
	}

	public function import_db($data) {
		if(is_array($data)) {

			$pair_arr = array();
			foreach ($data as $rows) {
				//if(trim($rows['A']) == '') { continue; }
				// per baris
				$pair = array();
				foreach ($rows as $key => $val) {
					if($key == 'A') { $pair['nama'] = $val; }
					if($key == 'B') { $pair['identitas'] = $val; }
					if($key == 'C') { $pair['jk'] = $val; }
					if($key == 'D') { $pair['tmp_lahir'] = $val; }
					if($key == 'E') { $pair['tgl_lahir'] = $val; }
					if($key == 'F') { $pair['status'] = $val; }
					if($key == 'G') { $pair['agama'] = $val; }
					if($key == 'H') { $pair['pekerjaan'] = $val; }
					if($key == 'I') { $pair['alamat'] = $val; }
					if($key == 'J') { $pair['kota'] = $val; }
					if($key == 'K') { $pair['notelp'] = $val; }
					if($key == 'L') { $pair['tgl_daftar'] = $val; }
					if($key == 'M') { $pair['pass_word'] = sha1('nsi' . $val); }
					if($key == 'N') { $pair['departement'] = $val; }
				}
				$pair['jabatan_id'] = 2;
				$pair_arr[] = $pair;
			}
			//var_dump($pair_arr);
			//return 1;
			return $this->db->insert_batch('tbl_anggota', $pair_arr);
		} else {
			return FALSE;
		}
	}


	public function ubah_pic() {
		$out = array('error' => '', 'success' => '');
		$user_id = $this->session->userdata('u_name');
		$this->db->select('file_pic');
		$this->db->from('tbl_anggota');
		$this->db->where('id', $user_id);
		$query = $this->db->get();
		$row = $query->row();

		$file_lama = $row->file_pic;

		$config['upload_path'] = FCPATH . 'uploads/anggota/';
		$config['file_name'] = uniqid();
		$config['overwrite'] = FALSE;
		$config["allowed_types"] = 'jpg|jpeg|png|gif';
		$config["max_size"] = 1024;
		$config["max_width"] = 2000;
		$config["max_height"] = 2000;
		$this->load->library('upload', $config);

		if(!$this->upload->do_upload()) {
			//$out['error'] = $this->upload->display_errors();
			$data = array(
			    'alamat' => $this->input->post('alamat'),
			    'kota' => $this->input->post('kota'),
			    'notelp' => $this->input->post('notelp')
			);
			$this->db->where('id', $user_id);
			$this->db->update('tbl_anggota', $data);
			$out['success'] = 'OK';
		} else {
			$config['image_library'] = 'gd2';
			$config['source_image'] = $this->upload->upload_path.$this->upload->file_name;
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 250;
			$config['height'] = 250;
			$config['overwrite'] = TRUE;
			$this->load->library('image_lib',$config); 

			if ( !$this->image_lib->resize()){
				$out['error'] = $this->image_lib->display_errors();
			} else {
				//success
				$data = array(
				    'file_pic' => $this->upload->file_name,
				     'alamat' => $this->input->post('alamat'),
    			    'kota' => $this->input->post('kota'),
    			    'notelp' => $this->input->post('notelp')
				);
				$this->db->where('id', $user_id);
				$this->db->update('tbl_anggota', $data);

				// hapus file lama
				if($file_lama != '') {
					$file_lama_f = FCPATH . '/uploads/anggota/'.$file_lama;
					if(file_exists($file_lama_f)) {
						if(unlink($file_lama_f)) {
							// DELETED
						} else {
							// NOT DELETED
						}
					}
				}
				$out['success'] = 'OK';
			}
		}
		return $out;
	}

	public function logout() {
		$this->session->unset_userdata(array('u_name' => '', 'login' => FALSE));
		$this->session->sess_destroy();
	}

	function get_pengajuan() {
		$this->load->helper('fungsi');
		$user_id = $this->session->userdata('u_name');

		$offset = isset($_POST['offset']) ? $_POST['offset'] : 0;
		$limit = isset($_POST['limit']) ? $_POST['limit'] : 10;
		$search = isset($_POST['search']) ? $_POST['search'] : '';
		
		$where = " AND anggota_id = " . $user_id;
		$order_by = " ORDER BY tgl_input DESC";
		$sql_limit = " LIMIT ".$offset.",".$limit." ";
		
		$sql_tampil = "SELECT * FROM tbl_pengajuan WHERE 1=1 ".$where." ".$order_by." ".$sql_limit."";
		$query = $this->db->query($sql_tampil);
		$data_list = $query->result();

		$sql_total = "SELECT id FROM tbl_pengajuan WHERE 1=1 ".$where." ";
		$query = $this->db->query($sql_total);
		$total = $query->num_rows();

		// 
		$data_list_i = array();
		foreach ($data_list as $key => $val) {
			$tgl_arr = explode(' ', $val->tgl_input);
			$tgl = $tgl_arr[0];
			$val->tgl_input_txt = jin_date_ina($tgl);
			$val->tgl_update_txt = jin_date_ina($tgl);
			$val->tgl_cair_txt = jin_date_ina($val->tgl_cair);
			$val->tgl_input = substr($val->tgl_input, 0, 16);
			$val->tgl_update = substr($val->tgl_update, 0, 16);
			$val->nominal = number_format($val->nominal);
			$data_list_i[$key] = $val;
		}

		$out = array('rows' => $data_list_i, 'total' => $total);
		return $out;
	}

	function get_simpanan() {
		$this->load->helper('fungsi');
		$user_id = $this->session->userdata('u_name');

		$offset = isset($_POST['offset']) ? $_POST['offset'] : 0;
		$limit = isset($_POST['limit']) ? $_POST['limit'] : 10;
		$search = isset($_POST['search']) ? $_POST['search'] : '';
		
		$where = " AND anggota_id = " . $user_id;
		$order_by = " ORDER BY tgl_transaksi DESC";
		$sql_limit = " LIMIT ".$offset.",".$limit." ";
		
		$sql_tampil = "SELECT * FROM tbl_trans_sp WHERE 1=1 ".$where." ".$order_by." ".$sql_limit."";
		$query = $this->db->query($sql_tampil);
		$data_list = $query->result();

		$sql_total = "SELECT id FROM tbl_trans_sp WHERE 1=1 ".$where." ";
		$query = $this->db->query($sql_total);
		$total = $query->num_rows();

		// 
		$data_list_i = array();
		foreach ($data_list as $key => $val) {
			$tgl_arr = explode(' ', $val->tgl_transaksi);
			$tgl = $tgl_arr[0];
			$val->tgl_transaksi = jin_date_ina($tgl);
			$val->jumlah = number_format($val->jumlah);
			$data_list_i[$key] = $val;
		}

		$out = array('rows' => $data_list_i, 'total' => $total);
		return $out;
	}

	function get_pinjaman() {
		$this->load->helper('fungsi');
		$user_id = $this->session->userdata('u_name');

		$offset = isset($_POST['offset']) ? $_POST['offset'] : 0;
		$limit = isset($_POST['limit']) ? $_POST['limit'] : 10;
		$search = isset($_POST['search']) ? $_POST['search'] : '';
		
		$where = " AND anggota_id = " . $user_id;
		$order_by = " ORDER BY tgl_pinjam DESC";
		$sql_limit = " LIMIT ".$offset.",".$limit." ";
		
		$sql_tampil = "SELECT * FROM v_hitung_pinjaman WHERE 1=1 ".$where." ".$order_by." ".$sql_limit."";
		$query = $this->db->query($sql_tampil);
		$data_list = $query->result();

		$sql_total = "SELECT id FROM v_hitung_pinjaman WHERE 1=1 ".$where." ";
		$query = $this->db->query($sql_total);
		$total = $query->num_rows();

		// 
		$data_list_i = array();
		foreach ($data_list as $key => $val) {
			$tgl_arr = explode(' ', $val->tgl_pinjam);
			$tgl = $tgl_arr[0];
			$val->tgl_pinjam = jin_date_ina($tgl, 'pendek');
			$tgl_arr = explode(' ', $val->tempo);
			$tgl = $tgl_arr[0];
			$val->tempo = jin_date_ina($tgl, 'pendek');
			$val->jumlah = number_format($val->jumlah);
			$val->biaya_adm = number_format($val->biaya_adm);
			$val->pokok_angsuran = number_format($val->pokok_angsuran);
			$val->bunga_pinjaman = number_format($val->bunga_pinjaman);
			$val->ags_per_bulan = number_format($val->ags_per_bulan);
			$val->tagihan = number_format($val->tagihan);
			$data_list_i[$key] = $val;
		}

		$out = array('rows' => $data_list_i, 'total' => $total);
		return $out;

	}

	function get_bayar() {
		$this->load->helper('fungsi');
		$user_id = $this->session->userdata('u_name');

		$offset = isset($_POST['offset']) ? $_POST['offset'] : 0;
		$limit = isset($_POST['limit']) ? $_POST['limit'] : 10;
		$search = isset($_POST['search']) ? $_POST['search'] : '';
		
		$where = " AND tbl_pinjaman_h.anggota_id = " . $user_id;
		$order_by = " ORDER BY tbl_pinjaman_d.tgl_bayar DESC";
		$sql_limit = " LIMIT ".$offset.",".$limit." ";
		
		$sql_tampil = "SELECT 
				tbl_pinjaman_d.tgl_bayar AS tgl_bayar,
				tbl_pinjaman_d.angsuran_ke AS angsuran_ke,
				tbl_pinjaman_d.jumlah_bayar AS jumlah_bayar,
				tbl_pinjaman_d.denda_rp AS denda_rp,
				tbl_pinjaman_d.ket_bayar AS ket_bayar,
				tbl_pinjaman_d.keterangan AS keterangan
			 FROM tbl_pinjaman_d 
			 LEFT JOIN tbl_pinjaman_h ON tbl_pinjaman_h.id = tbl_pinjaman_d.pinjam_id
			 WHERE 1=1 
			 ".$where." ".$order_by." ".$sql_limit."";
		$query = $this->db->query($sql_tampil);
		$data_list = $query->result();

		$sql_total = "SELECT tbl_pinjaman_d.id 
			FROM tbl_pinjaman_d 
			LEFT JOIN tbl_pinjaman_h ON tbl_pinjaman_h.id = tbl_pinjaman_d.pinjam_id
			WHERE 1=1 ".$where." ";
		$query = $this->db->query($sql_total);
		$total = $query->num_rows();

		// 
		$data_list_i = array();
		foreach ($data_list as $key => $val) {
			$tgl_arr = explode(' ', $val->tgl_bayar);
			$tgl = $tgl_arr[0];
			$val->tgl_bayar = jin_date_ina($tgl, 'pendek');
			$val->jumlah_bayar = number_format($val->jumlah_bayar);
			$val->denda_rp = number_format($val->denda_rp);
			$data_list_i[$key] = $val;
		}

		$out = array('rows' => $data_list_i, 'total' => $total);
		return $out;		

	}

}
