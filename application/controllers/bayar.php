<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bayar extends OperatorController {
	public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('bayar_m');
		$this->load->model('general_m');
	}	

	public function index() {
		$this->data['judul_browser'] = 'Pinjaman';
		$this->data['judul_utama'] = 'Transaksi';
		$this->data['judul_sub'] = 'Pembayaran Angsuran';

		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/default/easyui.css';
		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/icon.css';
		$this->data['js_files'][] = base_url() . 'assets/easyui/jquery.easyui.min.js';
		//$this->data['js_files'][] = base_url() . 'assets/easyui/datagrid-detailview.js';

		#include tanggal
		$this->data['css_files'][] = base_url() . 'assets/extra/bootstrap_date_time/css/bootstrap-datetimepicker.min.css';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/bootstrap-datetimepicker.min.js';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/locales/bootstrap-datetimepicker.id.js';
		#include seach
		$this->data['css_files'][] = base_url() . 'assets/theme_admin/css/daterangepicker/daterangepicker-bs3.css';
		$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/daterangepicker/daterangepicker.js';

		$this->data['isi'] = $this->load->view('bayar_list_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}


	function ajax_list() {
		$this->load->model('bunga_m');
		/*Default request pager params dari jeasyUI*/
		$offset = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$limit  = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort  = isset($_POST['sort']) ? $_POST['sort'] : 'tgl_pinjam';
		$order  = isset($_POST['order']) ? $_POST['order'] : 'desc';
		$kode_transaksi = isset($_POST['kode_transaksi']) ? $_POST['kode_transaksi'] : '';
		$cari_nama = isset($_POST['cari_nama']) ? $_POST['cari_nama'] : '';
		$tgl_dari = isset($_POST['tgl_dari']) ? $_POST['tgl_dari'] : '';
		$tgl_sampai = isset($_POST['tgl_sampai']) ? $_POST['tgl_sampai'] : '';
		$search = array(
			'kode_transaksi' => $kode_transaksi, 
			'cari_nama' => $cari_nama, 
			'tgl_dari' => $tgl_dari, 
			'tgl_sampai' => $tgl_sampai
			);
		$offset = ($offset-1)*$limit;
		$data   = $this->bayar_m->get_data_transaksi_ajax($offset,$limit,$search,$sort,$order);
		$i	= 0;
		$rows   = array(); 

		$data_bunga_arr = $this->bunga_m->get_key_val();

		foreach ($data['data'] as $r) {
			$tgl_pinjam = explode(' ', $r->tgl_pinjam);
			$txt_tanggal = jin_date_ina($tgl_pinjam[0],'p');		

			//array keys ini = attribute 'field' di view nya
			$anggota = $this->general_m->get_data_anggota($r->anggota_id);   

			$rows[$i]['id'] = $r->id;
			$rows[$i]['id_txt'] ='TPJ' . sprintf('%05d', $r->id) . '';
			$rows[$i]['tgl_pinjam_txt'] = $txt_tanggal;
			//$rows[$i]['anggota_id'] ='AG' . sprintf('%04d', $r->anggota_id) . '';
			$rows[$i]['anggota_id'] = $anggota->identitas;
			$rows[$i]['anggota_id_txt'] = $anggota->nama.' - '.$anggota->departement;
			$rows[$i]['lama_angsuran_txt'] = $r->lama_angsuran.' Bulan';
			$rows[$i]['jumlah'] = number_format($r->jumlah);
			$rows[$i]['ags_pokok'] = number_format($r->pokok_angsuran);
			$rows[$i]['bunga'] = number_format($r->bunga_pinjaman);
			$rows[$i]['biaya_adm'] = number_format($r->biaya_adm);
			$rows[$i]['angsuran_bln'] = number_format(nsi_round($r->ags_per_bulan));
			// Jatuh Tempo
			$sdh_ags_ke = $r->bln_sudah_angsur;
			$ags_ke = $r->bln_sudah_angsur + 1;

			$denda_hari = $data_bunga_arr['denda_hari'];
			$tgl_pinjam = substr($r->tgl_pinjam, 0, 7) . '-01';
			$tgl_tempo = date('Y-m-d', strtotime("+".$ags_ke." months", strtotime($tgl_pinjam)));
			$tgl_tempo = substr($tgl_tempo, 0, 7) . '-' . sprintf("%02d", $denda_hari);
			$txt_status = '';
			$txt_status_tip = 'Ags Ke: ' . $ags_ke . ' Tempo: ' . $tgl_tempo;
			if($tgl_tempo < date('Y-m-d')) {
				$rows[$i]['merah'] = 1;
				$txt_status .= '<span title="'.$txt_status_tip.'" class="text-red"><i class="fa fa-warning"></i></span>';
			} else {
				$rows[$i]['merah'] = 0;
				$txt_status .= '<span title="'.$txt_status_tip.'" class="text-green"><i class="fa fa-check-circle" title="'.$txt_status_tip.'"></i></span>';
			}
			//$rows[$i]['status'] = $txt_status;

			$rows[$i]['bayar'] = '<br><p>'.$txt_status.' 
			<a href="'.site_url('angsuran').'/index/' . $r->id . '" title="Bayar Angsuran"> <i class="fa fa-money"></i> Bayar </a></p>';
			$i++;
		}
		//keys total & rows wajib bagi jEasyUI
		$result = array('total'=>$data['count'],'rows'=>$rows);
		echo json_encode($result); //return nya json
	}
}
