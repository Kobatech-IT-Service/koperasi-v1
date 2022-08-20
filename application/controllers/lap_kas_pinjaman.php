<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_kas_pinjaman extends OperatorController {
	public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('general_m');
		$this->load->model('lap_kas_pinjaman_m');
	}	

	public function index() {
		$this->load->library("pagination");

		$this->data['judul_browser'] = 'Laporan';
		$this->data['judul_utama'] = 'Laporan';
		$this->data['judul_sub'] = 'Data Kas Pinjaman';

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

		$this->data['jml_pinjaman'] = $this->lap_kas_pinjaman_m->get_jml_pinjaman();
		$this->data['jml_tagihan'] = $this->lap_kas_pinjaman_m->get_jml_tagihan();
		$this->data['jml_angsuran'] = $this->lap_kas_pinjaman_m->get_jml_angsuran();
		$this->data['jml_denda'] = $this->lap_kas_pinjaman_m->get_jml_denda();

		$this->data['peminjam_aktif'] = $this->lap_kas_pinjaman_m->get_peminjam_aktif();
		$this->data['peminjam_lunas'] = $this->lap_kas_pinjaman_m->get_peminjam_lunas();
		$this->data['peminjam_belum'] = $this->lap_kas_pinjaman_m->get_peminjam_belum();
		
		$this->data['isi'] = $this->load->view('lap_kas_pinjaman_list_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}

	function cetak() {
		$jml_pinjaman = $this->lap_kas_pinjaman_m->get_jml_pinjaman();
		$jml_tagihan = $this->lap_kas_pinjaman_m->get_jml_tagihan();
		$jml_angsuran = $this->lap_kas_pinjaman_m->get_jml_angsuran();
		$jml_denda = $this->lap_kas_pinjaman_m->get_jml_denda();

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
		$html = '<style>
			.h_tengah {text-align: center;}
			.h_kiri {text-align: left;}
			.h_kanan {text-align: right;}
			.txt_judul {font-size: 12pt; font-weight: bold; padding-bottom: 15px;}
			.header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
			</style>
			'.$pdf->nsi_box($text = '<span class="txt_judul">Laporan Pinjaman Periode '.$tgl_periode_txt.'</span>', $width = '100%', $spacing = '1', $padding = '1', $border = '0', $align = 'center').'';

		$tot_tagihan = $jml_tagihan->jml_total + $jml_denda->total_denda;
		$dibayar = $tot_tagihan - $jml_angsuran->jml_total;	
		
		$html .= '
		<table width="100%" cellspacing="0" cellpadding="3" border="0">
			<tr class="header_kolom">
				<th style="width:10%; vertical-align: middle; text-align:center" > No. </th>
				<th style="width:50%; vertical-align: middle; text-align:center">Keterangan </th>
				<th style="width:40%; vertical-align: middle; text-align:center"> Jumlah  </th>
			</tr>
			<tr>
				<td class="h_tengah"> 1 </td>
				<td> Pokok Pinjaman</td>
				<td class="h_kanan">'.number_format(nsi_round($jml_pinjaman->jml_total)) .'</td>
			</tr>
			<tr>
				<td class="h_tengah"> 2 </td>
				<td> Tagihan Pinjaman</td>
				<td class="h_kanan">'.number_format(nsi_round($jml_tagihan->jml_total)).'</td>
			</tr>
			<tr>
				<td class="h_tengah"> 3 </td>
				<td> Tagihan Denda </td>
				<td class="h_kanan">'.number_format(nsi_round($jml_denda->total_denda)).'</td>
			</tr>
			<tr class="header_kolom">
				<td class="h_tengah">  </td>
				<td> Jumlah Tagihan + Denda </td>
				<td class="h_kanan">'.number_format(nsi_round($tot_tagihan)).'</td>
			</tr>
			<tr>
				<td class="h_tengah"> 4 </td>
				<td> Tagihan Sudah Dibayar </td>
				<td class="h_kanan">'.number_format(nsi_round($jml_angsuran->jml_total)).'</td>
			</tr>
			<tr style="background-color: #98FB98;">
				<td class="h_tengah"> 5 </td>
				<td> Sisa Tagihan </td>
				<td class="h_kanan">'.number_format(nsi_round($tot_tagihan -$jml_angsuran->jml_total)).'</td>
			</tr>
		</table>';

		$pdf->nsi_html($html);
		$pdf->Output('lap_pinjam'.date('Ymd_His') . '.pdf', 'I');
	} 
}