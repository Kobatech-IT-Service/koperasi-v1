<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_buku_besar extends OperatorController {
	public function __construct() {
		parent::__construct();
		$this->load->helper('fungsi');
		$this->load->model('lap_buku_besar_m');
		$this->load->model('general_m');
	}	

	public function index() {
		$this->data['judul_browser'] = 'Laporan';
		$this->data['judul_utama'] = 'Laporan';
		$this->data['judul_sub'] = 'Buku Besar';

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

		$this->data["nama_kas"] = $this->lap_buku_besar_m->get_nama_kas(); 
		
		$this->data['isi'] = $this->load->view('lap_buku_besar_list_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}

	function cetak() {
		$nama_kas = $this->lap_buku_besar_m->get_nama_kas(); 
		if($nama_kas == FALSE) {
			redirect('lap_buku_besar');
			exit();
		}

		if(isset($_REQUEST['periode'])) {
			$tanggal = $_REQUEST['periode'];
		} else {
			$tanggal = date('Y-m');
		}

		$txt_periode_arr = explode('-', $tanggal);
		if(is_array($txt_periode_arr)) {
			$txt_periode = jin_nama_bulan($txt_periode_arr[1]) . ' ' . $txt_periode_arr[0];
		}

		
		$this->load->library('Pdf');
		$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->set_nsi_header(TRUE);
		$pdf->AddPage('L');
		$html = '<style>
					.h_tengah {text-align: center;}
					.h_kiri {text-align: left;}
					.h_kanan {text-align: right;}
					.txt_judul {font-size: 12pt; font-weight: bold; padding-bottom: 15px;}
					.header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
				</style>
				'.$pdf->nsi_box($text = '<span class="txt_judul">Laporan Buku Besar Periode '.$txt_periode.'</span>', $width = '100%', $spacing = '1', $padding = '1', $border = '0', $align = 'center').'';
		$no = 1;
		$total_saldo = 0;
		$saldo = 0;
		foreach ($nama_kas as $key) {
			$transD = $this->lap_buku_besar_m->get_transaksi_kas($key->id);

			$html.= '<h3>'.$key->nama.'</h3>';
			$html.= '<table  width="90%" cellspacing="0" cellpadding="3" border="1" nobr="true">
			<tr class="header_kolom">
				<th class="h_tengah" style="width:5%;"> No</th>
				<th class="h_tengah" style="width:10%;"> Tanggal </th>
				<th class="h_tengah" style="width:20%;"> Jenis Transaksi</th>
				<th class="h_tengah" style="width:45%;"> Keterangan </th>
				<th class="h_tengah" style="width:10%;"> Debet </th>
				<th class="h_tengah" style="width:10%;"> Kredit </th>
				<th class="h_tengah" style="width:10%;"> Saldo </th>
			</tr>';
			$jmlD = 0;
			$jmlk = 0;
			$no = 1;
			foreach ($transD as $rows) {
				$nm_akun = $this->lap_buku_besar_m->get_nama_akun_id($rows->transaksi);
				$tglD = explode(' ', $rows->tgl);
				$txt_tanggalD = jin_date_ina($tglD[0],'p');

				if($rows->dari_kas == $key->id) {
					$jmlk += $rows->kredit;
					$rows->debet = 0;
				}
				if($rows->untuk_kas == $key->id) {
					$jmlD += $rows->debet;
					$rows->kredit = 0;
				}
				$saldo = $jmlD - $jmlk;

				$html.= '<tr>
					<td class="h_tengah"> '.$no++.' </td>
					<td class="h_tengah"> '.$txt_tanggalD.' </td>
					<td> '.@$nm_akun->jns_trans.'</td>
					<td> '.$rows->ket.'</td>
					<td class="h_kanan"> '.number_format(nsi_round($rows->debet)).' </td>
					<td class="h_kanan"> '.number_format(nsi_round($rows->kredit)).' </td>
					<td class="h_kanan"> '.number_format(nsi_round($saldo )).' </td>
				</tr>';
			}
			$total_saldo += $saldo;
			$html.= '</table>';
		}

		$html.= '<br><br><table">
		<tr class="header_kolom">
			<td class="h_kanan">TOTAL SALDO KAS BANK</td>
			<td class="h_kanan">'.number_format(nsi_round($total_saldo)).'</td>	
		</tr>
		</table>';
		$pdf->nsi_html($html);
		$pdf->Output('lap_buku_besar'.date('Ymd_His') . '.pdf', 'I');
	}
}