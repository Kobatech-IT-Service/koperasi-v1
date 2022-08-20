<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Angsuran_lunas extends OperatorController {
	public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('angsuran_lunas_m');
		$this->load->model('general_m');
		$this->load->model('bunga_m');
	}	

	public function index($master_id = NULL) {
		if($master_id == NULL) {
			redirect('angsuran');
			exit();
		}

		$this->data['judul_browser'] = 'Bayar Pelunasan';
		$this->data['judul_utama'] = 'Bayar Pelunasan';
		$this->data['judul_sub'] = 'Kode Pinjam  TPJ' . sprintf('%05d', $master_id) . '';

		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/default/easyui.css';
		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/icon.css';
		$this->data['js_files'][] = base_url() . 'assets/easyui/jquery.easyui.min.js';

		#include tanggal
		$this->data['css_files'][] = base_url() . 'assets/extra/bootstrap_date_time/css/bootstrap-datetimepicker.min.css';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/bootstrap-datetimepicker.min.js';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/locales/bootstrap-datetimepicker.id.js';
		
		#include serch tanggal
		$this->data['css_files'][] = base_url() . 'assets/theme_admin/css/daterangepicker/daterangepicker-bs3.css';
		$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/daterangepicker/daterangepicker.js';

		//number_format
		$this->data['js_files'][] = base_url() . 'assets/extra/fungsi/number_format.js';

		$this->data['master_id'] = $master_id;
		$row_pinjam = $this->general_m->get_data_pinjam ($master_id);
		$this->data['row_pinjam'] = $row_pinjam; 
		$this->data['data_anggota'] = $this->general_m->get_data_anggota ($row_pinjam->anggota_id);
		$this->data['kas_id'] = $this->angsuran_lunas_m->get_data_kas();

		$this->data['hitung_denda'] = $this->general_m->get_jml_denda($master_id);
		$this->data['hitung_dibayar'] = $this->general_m->get_jml_bayar($master_id);
		$this->data['sisa_ags'] = $this->general_m->get_record_bayar($master_id);

		$this->data['isi'] = $this->load->view('angsuran_lunas_list_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}

	function ajax_list($id=NULL) {
		if($id == NULL) {
			redirect('angsuran');
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
		$search = array(
				'kode_transaksi' => $kode_transaksi, 
				'tgl_dari' => $tgl_dari, 
				'tgl_sampai' => $tgl_sampai,
				'pelunasan' => true
				);
		$offset = ($offset-1)*$limit;
		$data   = $this->angsuran_lunas_m->get_data_transaksi_ajax($offset,$limit,$search,$sort,$order,$id);
		$i	= 0;
		$rows   = array(); 

		foreach ($data['data'] as $r) {
			$tgl_bayar1 = explode(' ', $r->tgl_bayar);
			$txt_tanggal = jin_date_ina($tgl_bayar1[0]);
			$txt_tanggal .= ' - ' . substr($tgl_bayar1[1], 0, 5);	

			$id_pinjam = $this->general_m->get_data_pinjam($r->pinjam_id);
			$anggota = $this->general_m->get_data_anggota($id_pinjam->anggota_id); 

			//array keys ini = attribute 'field' di view nya     
			$rows[$i]['id'] = $r->id;
			$rows[$i]['id_txt'] ='TBY' . sprintf('%05d', $r->id) . '';
			$rows[$i]['tgl_bayar'] = $r->tgl_bayar;
			$rows[$i]['tgl_bayar_txt'] = $txt_tanggal;
			$rows[$i]['pinjam_id'] = $r->pinjam_id;
			$rows[$i]['jumlah_bayar'] = number_format($r->jumlah_bayar);
			$rows[$i]['ket_bayar'] = $r->ket_bayar;
			$rows[$i]['kas_id'] = $r->kas_id;
			$rows[$i]['user'] = $r->user_name;
			$rows[$i]['nota'] = '<p></p><p>
			<a href="'.site_url('cetak_lunas').'/cetak/' . $r->id . '"  title="Cetak Bukti Transaksi" target="_blank"> <i class="glyphicon glyphicon-print"></i> Nota </a></p>';
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
		if($this->angsuran_lunas_m->create()){
			echo json_encode(array('ok' => true, 'msg' => '<div class="text-green"><i class="fa fa-check"></i> Data berhasil disimpan </div>'));
		}else{
			echo json_encode(array('ok' => false, 'msg' => '<div class="text-red"><i class="fa fa-ban"></i> Gagal menyimpan data, pastikan nilai lebih dari <strong>0 (NOL)</strong>. </div>'));
		}
		exit();
	}


	public function update($id=null, $master_id){
		if(!isset($_POST))	{
			show_404();
		}
		if($this->angsuran_lunas_m->update($id, $master_id))
		{
			echo json_encode(array('ok' => true, 'msg' => '<div class="text-green"><i class="fa fa-check"></i> Data berhasil diubah </div>'));
		} else {
			echo json_encode(array('ok' => false, 'msg' => '<div class="text-red"><i class="fa fa-ban"></i>Maaf, Data gagal diubah </div>'));
		}
	}

	public function delete() {
		if(!isset($_POST)) {
			show_404();
		}
		$id = $this->input->post('id');
		$master_id = $this->input->post('master_id');
			if($this->angsuran_lunas_m->delete($id, $master_id)) {
				echo json_encode(array('ok' => true, 'msg' => '<div class="text-green"><i class="fa fa-check"></i> Data berhasil dihapus </div>'));
			} else {
				echo json_encode(array('ok' => false, 'msg' => '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Anda harus hapus data sebelumnya </div>'));
			}
		}
}