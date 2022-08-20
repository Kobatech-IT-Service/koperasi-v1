<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Angsuran extends OperatorController {
	public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('angsuran_m');
		$this->load->model('general_m');
		$this->load->model('bunga_m');
	}	

	public function index($master_id = NULL) {
		if($master_id == NULL) {
			redirect('bayar');
			exit();
		}

		$this->data['judul_browser'] = 'Bayar Angsuran';
		$this->data['judul_utama'] = 'Bayar Angsuran';
		$this->data['judul_sub'] = 'Kode Pinjam  TPJ' . sprintf('%05d', $master_id) . '';

		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/default/easyui.css';
		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/icon.css';
		$this->data['js_files'][] = base_url() . 'assets/easyui/jquery.easyui.min.js';

		//include tanggal
		$this->data['css_files'][] = base_url() . 'assets/extra/bootstrap_date_time/css/bootstrap-datetimepicker.min.css';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/bootstrap-datetimepicker.min.js';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/locales/bootstrap-datetimepicker.id.js';
		
		//include serch tanggal
		$this->data['css_files'][] = base_url() . 'assets/theme_admin/css/daterangepicker/daterangepicker-bs3.css';
		$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/daterangepicker/daterangepicker.js';

		$this->data['master_id'] = $master_id;
		$row_pinjam = $this->general_m->get_data_pinjam ($master_id);
		$this->data['row_pinjam'] = $row_pinjam; 
		$this->data['data_anggota'] = $this->general_m->get_data_anggota ($row_pinjam->anggota_id);
		$this->data['kas_id'] = $this->angsuran_m->get_data_kas();

		$this->data['hitung_denda'] = $this->general_m->get_jml_denda($master_id);
		$this->data['hitung_dibayar'] = $this->general_m->get_jml_bayar($master_id);
		$this->data['sisa_ags'] = $this->general_m->get_record_bayar($master_id);

		$this->data['isi'] = $this->load->view('angsuran_list_v', $this->data, TRUE);

		$this->load->view('themes/layout_utama_v', $this->data);
	}

	function ajax_list($id = NULL) {
		if($id == NULL) {
			redirect('bayar');
			exit();
		}
		/*Default request pager params dari jeasyUI*/
		$offset = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$limit  = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort  = isset($_POST['sort']) ? $_POST['sort'] : 'tgl_bayar';
		$order  = isset($_POST['order']) ? $_POST['order'] : 'desc';
		$kode_transaksi = isset($_POST['kode_transaksi']) ? $_POST['kode_transaksi'] : '';
		$tgl_dari = isset($_POST['tgl_dari']) ? $_POST['tgl_dari'] : '';
		$tgl_sampai = isset($_POST['tgl_sampai']) ? $_POST['tgl_sampai'] : '';
		$search = array('kode_transaksi' => $kode_transaksi, 'tgl_dari' => $tgl_dari, 'tgl_sampai' => $tgl_sampai);
		$offset = ($offset-1)*$limit;
		$data   = $this->angsuran_m->get_data_transaksi_ajax($offset,$limit,$search,$sort,$order,$id);
		$i	= 0;
		$rows   = array(); 

		foreach ($data['data'] as $r) {
			$tgl_bayar1 = explode(' ', $r->tgl_bayar);
			$txt_tanggal = jin_date_ina($tgl_bayar1[0]);
			$txt_tanggal .= ' - ' . substr($tgl_bayar1[1], 0, 5);	

			$pinjam = $this->general_m->get_data_pinjam($r->pinjam_id);
			$anggota = $this->general_m->get_data_anggota($pinjam->anggota_id); 

			// HARI TELAT
			$hari_telat = 0;
			$tgl_pinjam = substr($pinjam->tgl_pinjam, 0, 7) . '-01';
			$tgl_tempo = date('Y-m-d', strtotime("+".$r->angsuran_ke." months", strtotime($tgl_pinjam)));
			$tgl_bayar  = substr($r->tgl_bayar, 0, 10);
			$data_bunga_arr = $this->bunga_m->get_key_val();
			$denda_hari = $data_bunga_arr['denda_hari'];

			$tgl_tempo_max = date('Y-m-d', strtotime("+".($denda_hari - 1)." days", strtotime($tgl_tempo)));

			$tgl_tempo_h = str_replace('-', '', $tgl_tempo_max);
			$tgl_bayar_h = str_replace('-', '', $tgl_bayar);
			$hari_telat = $tgl_bayar_h - ($tgl_tempo_h);
			if($hari_telat < 0) {
				$hari_telat = 0;
			}

			$txt_tgl_tempo_max = jin_date_ina($tgl_tempo_max);

			//array keys ini = attribute 'field' di view nya     
			$rows[$i]['id'] = $r->id;
			$rows[$i]['id_txt'] ='TBY' . sprintf('%05d', $r->id) . '';
			$rows[$i]['tgl_tempo'] = $txt_tgl_tempo_max;
			$rows[$i]['tgl_bayar'] = $r->tgl_bayar;
			$rows[$i]['tgl_bayar_txt'] = $txt_tanggal;
			$rows[$i]['pinjam_id'] = $r->pinjam_id;
			$rows[$i]['angsuran_ke'] = $r->angsuran_ke;
			$rows[$i]['jumlah_bayar'] = number_format(nsi_round($r->jumlah_bayar));
			$rows[$i]['denda'] = number_format($r->denda_rp);
			$rows[$i]['terlambat'] = $hari_telat.' Hari';
			$rows[$i]['kas_id'] = $r->kas_id;
			$rows[$i]['ket'] = $r->keterangan;
			$rows[$i]['user'] = $r->user_name;
			$rows[$i]['nota'] = '<p></p><p>
			<a href="'.site_url('cetak_angsuran').'/cetak/' . $r->id . '"  title="Cetak Bukti Transaksi" target="_blank"> <i class="glyphicon glyphicon-print"></i> Nota </a></p>';
			$i++;
		}
		//keys total & rows wajib bagi jEasyUI
		$result = array('total'=>$data['count'],'rows'=>$rows);
		echo json_encode($result); //return nya json
	}

	public function create(){
		if(!isset($_POST)) {
			show_404();
		}
		if($this->angsuran_m->create()){
			echo json_encode(array('ok' => true, 'msg' => '<div class="text-green"><i class="fa fa-check"></i> Data berhasil disimpan </div>'));
		} else {
			echo json_encode(array('ok' => false, 'msg' => '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Data tidak dapat disimpan </div>'));
		}
		exit();
	}


	public function update($id=null) {
		if(!isset($_POST)) {
			show_404();
		}
		if($this->angsuran_m->update($id)) {
			echo json_encode(array('ok' => true, 'msg' => '<div class="text-green"><i class="fa fa-check"></i> Data berhasil diubah </div>'));
		}	else {
			echo json_encode(array('ok' => false, 'msg' => '<div class="text-red"><i class="fa fa-ban"></i>Maaf, Data gagal diubah </div>'));
		}
	}

	public function delete() {
		if(!isset($_POST)) {
			show_404();
		}
		$id = $this->input->post('id');
		$master_id = $this->input->post('master_id');
		if($this->angsuran_m->delete($id, $master_id)) {
			echo json_encode(array('ok' => true, 'msg' => '<div class="text-green"><i class="fa fa-check"></i> Data berhasil dihapus </div>'));
		} else {
			echo json_encode(array('ok' => false, 'msg' => '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Anda harus hapus data sebelumnya </div>'));
		}
	}

	function get_ags_ke($master_id) {
		$id_bayar = $this->input->post('id_bayar');
		if($id_bayar > 0) {
			$data_bayar = $this->general_m->get_data_pembayaran_by_id($id_bayar);
			if($data_bayar) {
				$ags_ke = $data_bayar->angsuran_ke;
			} else {
				$ags_ke = 1;
			}
		} else {
			$ags_ke = $this->general_m->get_record_bayar($master_id) + 1;
		}

		// -- bayar angsuran --
		$row_pinjam = $this->general_m->get_data_pinjam($master_id); #data pinjam
		$lama_ags = $row_pinjam->lama_angsuran; # lama angsuran
		$status_lunas = $row_pinjam->lunas; # status lunas
		$sisa_ags = $lama_ags  - $ags_ke; #sisa angsuran 
		$jml_pinjaman = $row_pinjam->lama_angsuran  * $row_pinjam->ags_per_bulan; #jml pinjaman

		//hitung denda
		$denda = $this->general_m->get_jml_denda($master_id);
		$jml_denda_num = $denda->total_denda * 1;
		
		//hitung sudah dibayar
		$dibayar=$this->general_m->get_jml_bayar($master_id);
		$sudah_bayar= $dibayar->total * 1;

		//total harus bayar 
		$total_bayar = $jml_pinjaman + $jml_denda_num;

		$sisa_tagihan = number_format(nsi_round($row_pinjam->ags_per_bulan * $sisa_ags)); #sisa tagihan 
		$sisa= $row_pinjam->ags_per_bulan * $sisa_ags; #sisa tagihan 

		//sisa pembayaran
		$sisa_pembayaran = $sisa + $jml_denda_num ;

		//--- update angsuran --
		$sisa_ags_det = $row_pinjam->lama_angsuran - ($ags_ke - 1) ;
		$sudah_bayar_det = number_format(nsi_round($dibayar ->total));
		$sisa_tagihan_num = ($jml_pinjaman - $sudah_bayar);
		$sisa_tagihan_det = number_format(nsi_round($sisa_tagihan_num));
		$jml_denda_det = number_format(nsi_round($jml_denda_num));
		$total_bayar_det = number_format(nsi_round($sisa_tagihan_num + $jml_denda_num));
		$total_tagihan = number_format(nsi_round($sisa_tagihan_num + $jml_denda_num));

		// DENDA
		$denda = 0;
		$denda_semua = 0;
		$denda_semua_num = 0;
		$tgl_pinjam = substr($row_pinjam->tgl_pinjam, 0, 7) . '-01';
		$tgl_tempo = date('Y-m-d', strtotime("+".$ags_ke." months", strtotime($tgl_pinjam)));
		$tgl_bayar  = isset($_POST['tgl_bayar']) ? $_POST['tgl_bayar'] : '';
		if($tgl_bayar != '') {
			$data_bunga_arr = $this->bunga_m->get_key_val();
			$denda_hari = $data_bunga_arr['denda_hari'];
			$tgl_tempo = str_replace('-', '', $tgl_tempo);
			$tgl_bayar = str_replace('-', '', $tgl_bayar);
			$tgl_toleransi = $tgl_bayar - ($tgl_tempo - 1);
			if ( $tgl_toleransi > $denda_hari ) { 
				$denda = '' . number_format($data_bunga_arr['denda']);
			}
		}

		if($ags_ke > $lama_ags) {
			$data = array(
				'ags_ke' 				=> 0,
				'sisa_ags' 				=> $sisa_ags,
				'sisa_tagihan'			=> $sisa_tagihan,
				'denda' 					=> $denda,
				'sisa_pembayaran' 	=> $sisa_pembayaran,

				'sisa_ags_det' 		=> $sisa_ags_det,
				'sudah_bayar_det' 	=> $sudah_bayar_det,
				'sisa_tagihan_det'	=> $sisa_tagihan_det,
				'jml_denda_det' 		=> $jml_denda_det,
				'total_bayar_det' 	=> $total_bayar_det,

				'status_lunas' 		=> $status_lunas,
				'total_tagihan' 		=> $total_tagihan,
				'denda_semua' 			=> $denda_semua
			);
			echo json_encode($data);		
		} else {
			$data = array(
				'ags_ke' 				=> $ags_ke,
				'sisa_ags' 				=> $sisa_ags,
				'sisa_tagihan'			=> $sisa_tagihan,
				'denda' 					=> $denda,
				'sisa_pembayaran' 	=> $sisa_pembayaran,

				'sisa_ags_det' 		=> $sisa_ags_det,
				'sudah_bayar_det' 	=> $sudah_bayar_det,
				'sisa_tagihan_det'	=> $sisa_tagihan_det,
				'jml_denda_det' 		=> $jml_denda_det,
				'total_bayar_det' 	=> $total_bayar_det,

				'status_lunas' 		=> $status_lunas,
				'total_tagihan' 		=> $total_tagihan,
				'denda_semua' 			=> $denda_semua
				);
			echo json_encode($data);
		}
		exit();
	}

	function cek_sebelum_update() {
		$id_bayar = $this->input->post('id_bayar');
		$master_id = $this->input->post('master_id');
		
		$this->db->select('MAX(id) AS id_akhir');
		$this->db->where('pinjam_id', $master_id);
		$qu_akhir = $this->db->get('tbl_pinjaman_d');
		$row_akhir = $qu_akhir->row();

		$out = array('success' => '0');

		if($row_akhir->id_akhir != $id_bayar) {
			$out = array('success' => '0');
		} else {
			$this->db->select('lama_angsuran, tagihan');
			$this->db->where('id', $master_id);
			$qu_header = $this->db->get('v_hitung_pinjaman');
			$row_header = $qu_header->row();

			// sudah dibayar
			$this->db->select('SUM(jumlah_bayar) AS jumlah_bayar');
			$this->db->where('pinjam_id', $master_id);
			$qu_bayar = $this->db->get('tbl_pinjaman_d');
			$row_bayar = $qu_bayar->row();

			// berapa kali dibayar
			$this->db->select('id');
			$this->db->where('pinjam_id', $master_id);
			$qu_num_bayar = $this->db->get('tbl_pinjaman_d');
			$num_row_bayar = $qu_num_bayar->num_rows();			

			//sisa tagihan
			$sisa_tagihan = number_format($row_header->tagihan - $row_bayar->jumlah_bayar);
			if($sisa_tagihan <= 0 ) {
				$sisa_tagihan = 0;
			}
			$out = array('success' => '1', 'sisa_ags' => ($row_header->lama_angsuran - $num_row_bayar), 'sisa_tagihan' => $sisa_tagihan);
		}
		echo json_encode($out);
		exit();
	}
}