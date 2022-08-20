<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_laba extends OperatorController {

public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('general_m');
		$this->load->model('lap_laba_m');
	}	

	public function index() {
		$this->load->library("pagination");

		$this->data['judul_browser'] = 'Laporan';
		$this->data['judul_utama'] = 'Laporan';
		$this->data['judul_sub'] = 'Laba Rugi';

		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/default/easyui.css';
		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/icon.css';
		$this->data['js_files'][] = base_url() . 'assets/easyui/jquery.easyui.min.js';

		#include tanggal
		$this->data['css_files'][] = base_url() . 'assets/extra/bootstrap_date_time/css/bootstrap-datetimepicker.min.css';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/bootstrap-datetimepicker.min.js';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/locales/bootstrap-datetimepicker.id.js';

			#include seach
		$this->data['css_files'][] = base_url() . 'assets/theme_admin/css/daterangepicker/daterangepicker-bs3.css';
		$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/daterangepicker/daterangepicker.js';

		$this->data['jml_pinjaman'] = $this->lap_laba_m->get_jml_pinjaman();
		$this->data['jml_biaya_adm'] = $this->lap_laba_m->get_jml_biaya_adm();
		$this->data['jml_bunga'] = $this->lap_laba_m->get_jml_bunga();
		$this->data['jml_tagihan'] = $this->lap_laba_m->get_jml_tagihan();
		$this->data['jml_angsuran'] = $this->lap_laba_m->get_jml_angsuran();
		$this->data['jml_denda'] = $this->lap_laba_m->get_jml_denda();

		$this->data['data_dapat'] = $this->lap_laba_m->get_data_akun_dapat();
		$this->data['data_biaya'] = $this->lap_laba_m->get_data_akun_biaya();

		
		$this->data['isi'] = $this->load->view('lap_laba_list_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);

	}

	function cetak() {

		$jml_pinjaman = $this->lap_laba_m->get_jml_pinjaman();
		$jml_biaya_adm = $this->lap_laba_m->get_jml_biaya_adm();
		$jml_bunga = $this->lap_laba_m->get_jml_bunga();
		$jml_tagihan = $this->lap_laba_m->get_jml_tagihan();
		$jml_angsuran = $this->lap_laba_m->get_jml_angsuran();
		$jml_denda = $this->lap_laba_m->get_jml_denda();
		$data_dapat = $this->lap_laba_m->get_data_akun_dapat();
		$data_biaya = $this->lap_laba_m->get_data_akun_biaya();

		if(isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
			$tgl_dari = $_REQUEST['tgl_dari'];
			$tgl_samp = $_REQUEST['tgl_samp'];
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';
		}
		$tgl_dari_txt = jin_date_ina($tgl_dari, 'p');
		$tgl_samp_txt = jin_date_ina($tgl_samp, 'p');
		$tgl_periode_txt = $tgl_dari_txt . ' - ' . $tgl_samp_txt;

     $this->load->library('Pdf');
     $pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
     $pdf->set_nsi_header(TRUE);
     $pdf->AddPage('L');
     $html = '
         <style>
             .h_tengah {text-align: center;}
             .h_kiri {text-align: left;}
             .h_kanan {text-align: right;}
             .txt_judul {font-size: 12pt; font-weight: bold; padding-bottom: 15px;}
             .header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
         </style>
         '.$pdf->nsi_box($text = '<span class="txt_judul">Laporan Laba / Rugi Periode '.$tgl_periode_txt.'</span>', $width = '100%', $spacing = '1', $padding = '1', $border = '0', $align = 'center').'';

		$pinjaman = $jml_pinjaman->jml_total;
		$biaya_adm = $jml_biaya_adm->jml_total; 
		$bunga = $jml_bunga->jml_total;
		$bulatan = $jml_tagihan->jml_total - ($jml_pinjaman->jml_total + $jml_bunga->jml_total + $jml_biaya_adm->jml_total);
		$tagihan = $jml_tagihan->jml_total;
		$estimasi = $tagihan - $pinjaman;

		$sd_dibayar = $jml_angsuran->jml_total;
		$laba = $sd_dibayar - $pinjaman;

		$html .= 
		'<h3> Estimasi Data Pinjaman </h3>
			<table width="100%" cellspacing="0" cellpadding="3" border="1">
				<tr class="header_kolom">
					<th style="width:10%; vertical-align: middle; text-align:center" > No. </th>
					<th style="width:50%; vertical-align: middle; text-align:center">Keterangan </th>
					<th style="width:40%; vertical-align: middle; text-align:center"> Jumlah  </th>
				</tr>
				<tr>
					<td class="h_tengah"> 1 </td>
					<td> Jumlah Pinjaman</td>
					<td class="h_kanan">'.number_format(nsi_round($pinjaman)) .'</td>
				</tr>
				<tr>
					<td class="h_tengah"> 2 </td>
					<td> Pendapatan Biaya Administrasi</td>
					<td class="h_kanan">'.number_format(nsi_round($biaya_adm)) .'</td>
				</tr>
				<tr>
					<td class="h_tengah"> 3 </td>
					<td> Pendapatan Biaya Bunga</td>
					<td class="h_kanan">'.number_format(nsi_round($bunga)) .'</td>
				</tr>
				<tr>
					<td class="h_tengah"> 4 </td>
					<td> Pendapatan Biaya Pembulatan</td>
					<td class="h_kanan">'.number_format(nsi_round($bulatan)) .'</td>
				</tr>
				<tr class="header_kolom">
					<td colspan="2" class="h_kanan">Jumlah Tagihan</td>
					<td class="h_kanan">'.number_format($tagihan).'</td>
				</tr>
				<tr>
					<td colspan="2" class="h_kanan">Estimasi Pendapatan Pinjaman</td>
					<td class="h_kanan"><strong>'.number_format(nsi_round($estimasi)) .'</strong></td>
				</tr>			
			</table>
					';

		$html .= '
		<h3> Pendapatan </h3>
			<table width="100%" cellspacing="0" cellpadding="3" border="1">
				<tr class="header_kolom">
					<th style="width:10%; vertical-align: middle; text-align:center" > No. </th>
					<th style="width:50%; vertical-align: middle; text-align:center">Keterangan </th>
					<th style="width:40%; vertical-align: middle; text-align:center"> Jumlah  </th>
				</tr>
				<tr>
					<td class="h_tengah"> 1 </td>
					<td> Pendapatan Pinjaman</td>
					<td class="h_kanan">'.number_format(nsi_round($laba)) .'</td>
				</tr>';
		$jml_dapat = 0;
		foreach ($data_dapat as $row) {
			$jml_akun = $this->lap_laba_m->get_jml_akun($row->id);
			$jml_dapat += $jml_akun->jum_debet + $jml_akun->jum_kredit;
			$html .= '
				<tr>
					<td class="h_tengah"> 2 </td>
					<td> '.$row->jns_trans.'</td>
					<td class="h_kanan">'.number_format(nsi_round($jml_dapat)).'</td>
				</tr>';
		}
		$jml_p = $laba + $jml_dapat;
		$html .= '<tr class="header_kolom">
						<td colspan="2" class="h_kanan">Jumlah Pendapatan</td>
						<td class="h_kanan">'.number_format($jml_p).'</td>
					</tr>';
		$html .= '</table>';

		$html .= 
		'<h3> Biaya-biaya </h3>
			<table width="100%" cellspacing="0" cellpadding="3" border="1">
			<tr class="header_kolom">
				<th style="width:10%; vertical-align: middle; text-align:center" > No. </th>
				<th style="width:50%; vertical-align: middle; text-align:center">Keterangan </th>
				<th style="width:40%; vertical-align: middle; text-align:center"> Jumlah  </th>
			</tr>';
		$no=1;
		$jml_beban = 0;
		foreach ($data_biaya as $rows) {
			$jml_akun = $this->lap_laba_m->get_jml_akun($rows->id);
			$jumlah = $jml_akun->jum_debet + $jml_akun->jum_kredit;
			$jml_beban += $jumlah;

			$html .= '<tr>
							<td class="h_tengah">'.$no++.'</td>
							<td>'.$rows->jns_trans.'</td>
							<td class="h_kanan">'.number_format(nsi_round($jumlah)).'</td>
						</tr>';
		}
		$html.= '
		<tr class="header_kolom">
			<td colspan="2" class="h_kanan"> Jumlah Biaya </td>
			<td class="h_kanan"> '.number_format($jml_beban).'</td>
		</tr>
		</table>

		<p></p>
		<table width="100%" cellspacing="0" cellpadding="3" border="0">
		<tr class="header_kolom" style="background-color: #98FB98;">
			<td class="h_tengah"> Laba / Rugi </td>
			<td class="h_kanan">'.number_format(nsi_round($jml_p - $jml_beban )) .'</td>
		</tr>
		</table>';
		$pdf->nsi_html($html);
		$pdf->Output('lap_laba_rugi'.date('Ymd_His') . '.pdf', 'I');
	} 
}