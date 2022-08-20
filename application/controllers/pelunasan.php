<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pelunasan extends OperatorController {
	public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('pelunasan_m');
		$this->load->model('general_m');
	}	
	
	public function index() {

		$this->data['judul_browser'] = 'Pinjaman';
		$this->data['judul_utama'] = 'Pinjaman';
		$this->data['judul_sub'] = 'Pelunasan Pinjaman';

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

		$this->data['isi'] = $this->load->view('pelunasan_list_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
		
	}

	function ajax_list() {

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
			'tgl_sampai' => $tgl_sampai);
		$offset = ($offset-1)*$limit;
		$data   = $this->pelunasan_m->get_data_transaksi_ajax($offset,$limit,$search,$sort,$order);
		$i	= 0;
		$rows   = array(); 

		foreach ($data['data'] as $r) {
			$tgl_bayar = explode(' ', $r->tgl_pinjam);
			$txt_tanggal = jin_date_ina($tgl_bayar[0],'p');
			//$txt_tanggal .= ' - ' . substr($tgl_bayar[1], 0, 5);

			$tgl_tempo = explode(' ', $r->tempo);
			$tgl_tempo = jin_date_ina($tgl_tempo[0],'p');		
			 			
			//array keys ini = attribute 'field' di view nya
			$anggota = $this->general_m->get_data_anggota($r->anggota_id);   
			$jml_bayar = $this->general_m->get_jml_bayar($r->id); 
			$jml_denda = $this->general_m->get_jml_denda($r->id); 
			$total_tagihan = $r->tagihan + $jml_denda->total_denda;
			$sisa_tagihan = $total_tagihan - $jml_bayar->total;

		

			$rows[$i]['id'] = $r->id;
			$rows[$i]['id_txt'] ='TPJ' . sprintf('%05d', $r->id) . '';
			//$rows[$i]['anggota_id_txt'] ='AG' . sprintf('%04d', $r->anggota_id).' - '.$anggota->nama;
			$rows[$i]['anggota_id_txt'] = $anggota->identitas.' - '.$anggota->nama;
			$rows[$i]['departement'] = $anggota->departement;
			$rows[$i]['tgl_pinjam_txt'] = $txt_tanggal;
			$rows[$i]['tgl_tempo_txt'] = $tgl_tempo;
			$rows[$i]['lama_angsuran_txt'] = $r->lama_angsuran.' Bulan';
			$rows[$i]['pinjaman'] = number_format(nsi_round($r->tagihan));
			$rows[$i]['tagihan'] = number_format(nsi_round($total_tagihan));
			$rows[$i]['denda'] = number_format(nsi_round($jml_denda->total_denda)); // denda
			$rows[$i]['dibayar'] = number_format(nsi_round($jml_bayar->total)); // sudah dibayar
			$rows[$i]['sisa'] = number_format(nsi_round($sisa_tagihan)); // sisa tagihan
			$rows[$i]['kas_id'] = $r->kas_id;

			$rows[$i]['bayar'] = '<p></p><p>
			<a href="'.site_url('angsuran_lunas').'/index/' . $r->id . '" title="Detail" > <i class="fa fa-search"></i> Detail </a></p>';
			$i++;
		}

		//keys total & rows wajib bagi jEasyUI
		$result = array('total'=>$data['count'],'rows'=>$rows);
		echo json_encode($result); //return nya json

	}

	public function create()
	{
		if(!isset($_POST)) {
			show_404();
		}
		
		if($this->bayar_m->create()){
			//echo json_encode(array('success'=>true));
			echo json_encode(array('ok' => true, 'msg' => '<div class="text-green"><i class="fa fa-check"></i> Data berhasil disimpan </div>'));
		}else
		{
		echo json_encode(array('ok' => false, 'msg' => '<div class="text-red"><i class="fa fa-ban"></i> Gagal menyimpan data </div>'));
		}
			
	}
	
	
	public function update($id=null)
	{
		if(!isset($_POST))	
		{
			show_404();
		}
		if($this->bayar_m->update($id))
		{
			//echo json_encode(array('success'=>true));
			echo json_encode(array('ok' => true, 'msg' => '<div class="text-green"><i class="fa fa-check"></i> Data berhasil diubah </div>'));
		}	else
		{
			echo json_encode(array('ok' => false, 'msg' => '<div class="text-red"><i class="fa fa-ban"></i>  Maaf, Data gagal diubah </div>'));
		}	
	}
	
	public function delete()
	{
		if(!isset($_POST))	{
			show_404();
		}
			
		$id = intval(addslashes($_POST['id']));
		if($this->bayar_m->delete($id))

			{
			//echo json_encode(array('success'=>true));
			echo json_encode(array('ok' => true, 'msg' => '<div class="text-green"><i class="fa fa-check"></i> Data berhasil dihapus </div>'));
		} else {
			echo json_encode(array('ok' => false, 'msg' => '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Data gagal dihapus </div>'));
		}
	}

}
