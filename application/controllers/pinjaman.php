<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pinjaman extends OperatorController {
	public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('pinjaman_m');
		$this->load->model('general_m');
	}	

	public function index() {
		$this->data['judul_browser'] = 'Pinjaman';
		$this->data['judul_utama'] = 'Pinjaman';
		$this->data['judul_sub'] = 'Pinjaman';

		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/default/easyui.css';
		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/icon.css';
		$this->data['js_files'][] = base_url() . 'assets/easyui/jquery.easyui.min.js';

		#include tanggal
		$this->data['css_files'][] = base_url() . 'assets/extra/bootstrap_date_time/css/bootstrap-datetimepicker.min.css';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/bootstrap-datetimepicker.min.js';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/locales/bootstrap-datetimepicker.id.js';
		
		#include daterange
		$this->data['css_files'][] = base_url() . 'assets/theme_admin/css/daterangepicker/daterangepicker-bs3.css';
		$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/daterangepicker/daterangepicker.js';

		//number_format
		$this->data['js_files'][] = base_url() . 'assets/extra/fungsi/number_format.js';

		$this->data['kas_id'] = $this->pinjaman_m->get_data_kas();
		$this->data['jenis_ags'] = $this->pinjaman_m->get_data_angsuran();
		$this->data['suku_bunga'] = $this->pinjaman_m->get_data_bunga();
		$this->data['biaya'] = $this->pinjaman_m->get_biaya_adm();

		$this->data['barang_id'] = $this->pinjaman_m->get_id_barang();

		$this->data['isi'] = $this->load->view('pinjaman_list_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}

	function list_anggota() {
		$q = isset($_POST['q']) ? $_POST['q'] : '';
		$data   = $this->general_m->get_data_anggota_ajax($q);
		$i	= 0;
		$rows   = array(); 
		foreach ($data['data'] as $r) {
			if($r->file_pic == '') {
				$rows[$i]['photo'] = '<img src="'.base_url().'assets/theme_admin/img/photo.jpg" alt="default" width="30" height="40" />';
			} else {
				$rows[$i]['photo'] = '<img src="'.base_url().'uploads/anggota/' . $r->file_pic . '" alt="Foto" width="30" height="40" />';
			}
			$rows[$i]['id'] = $r->id;
			$rows[$i]['kode_anggota'] = 'AG'.sprintf('%04d', $r->id) . '<br>' . $r->identitas;
			$rows[$i]['nama'] = $r->nama;
			$rows[$i]['kota'] = $r->kota. '<br>' . $r->departement;		
			$i++;
		}
		//keys total & rows wajib bagi jEasyUI
		$result = array('total'=>$data['count'],'rows'=>$rows);
		echo json_encode($result); //return nya json
	}

	function get_anggota_by_id() {
		$id = isset($_POST['anggota_id']) ? $_POST['anggota_id'] : '';
		$r   = $this->general_m->get_data_anggota($id);
		$out = '';
		$photo_w = 3 * 30;
		$photo_h = 4 * 30;
		if($r->file_pic == '') {
			$out ='<img src="'.base_url().'assets/theme_admin/img/photo.jpg" alt="default" width="'.$photo_w.'" height="'.$photo_h.'" />'
			.'<br> ID : '.'AG' . sprintf('%04d', $r->id) . '';
		} else {
			$out = '<img src="'.base_url().'uploads/anggota/' . $r->file_pic . '" alt="Foto" width="'.$photo_w.'" height="'.$photo_h.'" />'
			.'<br> ID : '.'AG' . sprintf('%04d', $r->id) . '';
		}
		echo $out;
		exit();
	}

	function ajax_list() {
		/*Default request pager params dari jeasyUI*/
		$offset = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$limit  = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort  = isset($_POST['sort']) ? $_POST['sort'] : 'tgl_pinjam';
		$order  = isset($_POST['order']) ? $_POST['order'] : 'desc';
		$kode_transaksi = isset($_POST['kode_transaksi']) ? $_POST['kode_transaksi'] : '';
		$cari_status = isset($_POST['cari_status']) ? $_POST['cari_status'] : '';
		$cari_nama = isset($_POST['cari_nama']) ? $_POST['cari_nama'] : '';
		$tgl_dari = isset($_POST['tgl_dari']) ? $_POST['tgl_dari'] : '';
		$tgl_sampai = isset($_POST['tgl_sampai']) ? $_POST['tgl_sampai'] : '';
		$search = array('kode_transaksi' => $kode_transaksi, 
			'cari_status' => $cari_status,
			'cari_nama' => $cari_nama,
			'tgl_dari' => $tgl_dari, 
			'tgl_sampai' => $tgl_sampai);
		$offset = ($offset-1)*$limit;
		$data   = $this->pinjaman_m->get_data_transaksi_ajax($offset,$limit,$search,$sort,$order);
		$i	= 0;
		$rows   = array(); 
		foreach ($data['data'] as $r) {
			$tgl_bayar = explode(' ', $r->tgl_pinjam);
			$txt_tanggal = jin_date_ina($tgl_bayar[0],'p');
			$txt_tanggal .= ' - ' . substr($tgl_bayar[1], 0, 5);		

			//array keys ini = attribute 'field' di view nya
			$barang = $this->pinjaman_m->get_data_barang($r->barang_id);   
			$anggota = $this->general_m->get_data_anggota($r->anggota_id);   
			$jml_bayar = $this->general_m->get_jml_bayar($r->id); 
			$jml_denda = $this->general_m->get_jml_denda($r->id); 
			$total_tagihan = $r->tagihan + $jml_denda->total_denda;
			$sisa_tagihan = $total_tagihan - $jml_bayar->total;

			$sisa_angsur = 0;
			if($r->lunas == 'Belum') {
				$sisa_angsur = $r->lama_angsuran - $r->bln_sudah_angsur;
			}

			$rows[$i]['id'] = $r->id;
			$rows[$i]['id_txt'] = 'PJ' . sprintf('%05d', $r->id) . '';
			$rows[$i]['tgl_pinjam'] = $r->tgl_pinjam;
			$rows[$i]['tgl_pinjam_txt'] = $txt_tanggal;
			$rows[$i]['anggota_id'] = $r->anggota_id;
			//$rows[$i]['anggota_id_txt'] ='AG' . sprintf('%04d', $r->anggota_id).' <br>'.$anggota->nama;
			$rows[$i]['anggota_id_txt'] = $anggota->identitas.' <br>'.$anggota->nama.' <br>'.$anggota->departement;
			$rows[$i]['barang_id'] = $r->barang_id;
			$rows[$i]['lama_angsuran'] = $r->lama_angsuran;
			$rows[$i]['lama_angsuran_txt'] = $r->lama_angsuran.' Bulan';
			$rows[$i]['bunga'] = $r->bunga;
			$rows[$i]['bunga_txt'] = $r->bunga;
			$rows[$i]['biaya_adm'] = $r->biaya_adm;
			$rows[$i]['biaya_adm_txt'] = $r->biaya_adm;
			$rows[$i]['jumlah'] = number_format(nsi_round($r->jumlah));
			$rows[$i]['hitungan'] = '<table>
						<tr>
							<td width="100px" align="left">Nama Barang</td> 
							<td width="10px" align="center"> : </td>
							<td width="75px" align="left">'.$barang->nm_barang.'</td>
						</tr>
						<tr>
							<td width="100px" align="left">Harga Barang</td> 
							<td width="10px" align="center"> : </td>
							<td width="75px" align="right">'.number_format($r->jumlah) .'</td>
						</tr>
						<tr>
							<td width="100px" align="left">Lama Angsuran</td> 
							<td width="10px" align="center"> : </td>
							<td width="75px" align="right">'.$r->lama_angsuran.' Bulan</td>
						</tr>
						<tr>
							<td width="100px" align="left">Pokok Angsuran</td> 
							<td width="10px" align="center"> : </td>
							<td width="75px" align="right">'.number_format($r->pokok_angsuran) .'</td>
						</tr>
						<tr>
							<td width="100px" align="left">Bunga Pinjaman</td> 
							<td width="10px" align="center"> : </td>
							<td width="75px" align="right">'.number_format(nsi_round($r->bunga_pinjaman)).'</td>
						</tr>
						<tr>
							<td width="100px" align="left">Biaya Admin</td> 
							<td width="10px" align="center"> : </td>
							<td width="75px" align="right">'.number_format($r->biaya_adm) .'</td>
						</tr>
						</table>';
			$rows[$i]['tagihan'] = '<table>
						<tr>
							<td width="100px" align="left">Jumlah Angsuran</td> 
							<td width="10px" align="center"> : </td>
							<td width="75px" align="right">'.number_format(nsi_round($r->ags_per_bulan)).
							'</td>
						</tr>
						<tr>
							<td width="100px" align="left">Jumlah Denda</td> 
							<td width="10px" align="center"> : </td>
							<td width="75px" align="right">'.number_format(nsi_round($jml_denda->total_denda)).'</td>
						</tr>
						<tr>
							<td width="100px" align="left">Total Tagihan</td> 
							<td width="10px" align="center"> : </td>
							<td width="75px" align="right">'.number_format(nsi_round($total_tagihan)).'</td>
						</tr>
						<tr>
							<td width="100px" align="left">Sudah Dibayar</td> 
							<td width="10px" align="center"> : </td>
							<td width="75px" align="right">'.number_format(nsi_round($jml_bayar->total)).'</td>
						</tr>
						<tr>
							<td width="100px" align="left">Sisa Angsuran</td> 
							<td width="10px" align="center"> : </td>
							<td width="75px" align="right">'.$sisa_angsur.
							'</td>
						</tr>						
						<tr>
							<td width="100px" align="left">Sisa Tagihan</td> 
							<td width="10px" align="center"> : </td>
							<td width="75px" align="right">'.number_format(nsi_round($sisa_tagihan)).'</td>
						</tr>
						</table>';
			$rows[$i]['lunas'] = $r->lunas;
			$rows[$i]['user'] = $r->user_name;
			$rows[$i]['ket'] = $r->keterangan;
			$rows[$i]['kas_id'] = $r->kas_id;
			$rows[$i]['detail'] ='<a href="'.site_url('angsuran_detail').'/index/' . $r->id . '" title="Detail"> <i class="fa fa-search"></i> Detail </a>
				&nbsp;
				<a href="'.site_url('cetak_pinjaman').'/cetak/' . $r->id . '"  title="Cetak Bukti Transaksi" target="_blank"> <i class="glyphicon glyphicon-print"></i> Nota </a>';
			$i++;
		}
	//keys total & rows wajib bagi jEasyUI
	$result = array('total'=>$data['count'],'rows'=>$rows);
	echo json_encode($result); //return nya json
	}

	function get_jenis_barang() {
		$id = $this->input->post('barang_id');
		$jenis_barang = $this->pinjaman_m->get_id_barang();
		foreach ($jenis_barang as $row) {
			if($row->id == $id) {
				echo number_format($row->harga);
			}
		}
		exit();
	}

	public function create(){
		if(!isset($_POST)) {
			show_404();
		}

		if($this->pinjaman_m->create()){
			echo json_encode(array('ok' => true, 'msg' => '<div class="text-green"><i class="fa fa-check"></i> Data berhasil disimpan </div>'));
		} else {
			echo json_encode(array('ok' => false, 'msg' => '<div class="text-red"><i class="fa fa-ban"></i> Gagal menyimpan data, pastikan nilai lebih dari <strong>0 (NOL)</strong>. </div>'));
		}
	}

	public function update($id=null) {
		if(!isset($_POST)) {
			show_404();
		}
		if($this->pinjaman_m->update($id)) {
			echo json_encode(array('ok' => true, 'msg' => '<div class="text-green"><i class="fa fa-check"></i> Data berhasil diubah </div>'));
		} else {
			echo json_encode(array('ok' => false, 'msg' => '<div class="text-red"><i class="fa fa-ban"></i>  Maaf, Data gagal diubah </div>'));
		}	
	}

	public function delete() {
		if(!isset($_POST))	{
			show_404();
		}

		$id = intval(addslashes($_POST['id']));
		if($this->pinjaman_m->delete($id)) {
			echo json_encode(array('ok' => true, 'msg' => '<div class="text-green"><i class="fa fa-check"></i> Data berhasil dihapus </div>'));
		} else {
			echo json_encode(array('ok' => false, 'msg' => '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Data gagal dihapus </div>'));
		}
	}
}
