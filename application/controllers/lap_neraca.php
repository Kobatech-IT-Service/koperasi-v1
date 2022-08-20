<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_neraca extends OperatorController {

public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('general_m');
		$this->load->model('lap_neraca_m');
	}	

	public function index() {
		$this->load->library("pagination");

		$this->data['judul_browser'] = 'Laporan';
		$this->data['judul_utama'] = 'Laporan';
		$this->data['judul_sub'] = 'Neraca Saldo';

		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/default/easyui.css';
		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/icon.css';
		$this->data['js_files'][] = base_url() . 'assets/easyui/jquery.easyui.min.js';

		//include tanggal
		$this->data['css_files'][] = base_url() . 'assets/extra/bootstrap_date_time/css/bootstrap-datetimepicker.min.css';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/bootstrap-datetimepicker.min.js';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/locales/bootstrap-datetimepicker.id.js';

		//include seach
		$this->data['css_files'][] = base_url() . 'assets/theme_admin/css/daterangepicker/daterangepicker-bs3.css';
		$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/daterangepicker/daterangepicker.js';

		$this->data['data_jns_kas'] = $this->lap_neraca_m->get_data_jenis_kas();

		$this->data['data_akun'] = $this->lap_neraca_m->get_data_akun();
		
		$this->data['isi'] = $this->load->view('lap_neraca_list_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);

	}

	function cetak() {
		$data_jns_kas= $this->lap_neraca_m->get_data_jenis_kas();
		$data_akun = $this->lap_neraca_m->get_data_akun();

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
		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->set_nsi_header(TRUE);
		$pdf->AddPage('P');
		$html = '<style>
					.h_tengah {text-align: center;}
					.h_kiri {text-align: left;}
					.h_kanan {text-align: right;}
					.txt_judul {font-size: 12pt; font-weight: bold; padding-bottom: 15px;}
					.header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
				</style>
				'.$pdf->nsi_box($text = '<span class="txt_judul">Laporan Neraca Saldo Periode '.$tgl_periode_txt.'</span>', $width = '100%', $spacing = '1', $padding = '1', $border = '0', $align = 'center').'';
				$html .= '
				<table width="100%" cellspacing="0" cellpadding="3" border="1" nobr="true">
				<tr class="header_kolom">
					<th width="5%"> No. </th>
					<th width="55%"> Nama Akun</th>
					<th width="20%"> Debet </th>
					<th width="20%"> Kredit </th>
				</tr>
				<tr>
					<td width="5%" class="h_tengah"><strong>A</strong></td>
					<td><strong>Aktiva Lancar</strong></td>
					<td></td>
				</tr>';
		$jum_debet = 0;
		$jum_kredit = 0;

				//ambil data kass
		$no_kas = 1;
		foreach ($data_jns_kas as $jenis) {
			$nilai_debet = $this->lap_neraca_m->get_jml_debet($jenis->id);
			$nilai_kredit = $this->lap_neraca_m->get_jml_kredit($jenis->id);

			$debet_row = $nilai_debet->jml_total; 
			$kredit_row = $nilai_kredit->jml_total;
			$saldo_row = $debet_row - $kredit_row;
			$html .= '<tr>
				<td class="h_kanan">A'.$no_kas.'</td>
				<td> '.$jenis->nama.'</td>
				<td class="h_kanan"> '.number_format(nsi_round($saldo_row)).' </td>
				<td class="h_kanan"> 0 </td>
			</tr>';
			$jum_debet += $saldo_row;
			$no_kas++;
		}
		foreach ($data_akun as $nama) {
			$akun_arr[$nama->id] = $nama->jns_trans;
			if (strlen($nama->kd_aktiva) != 1) {
				$kode 		= '<td class="h_kanan">'.$nama->kd_aktiva.'</td>';
				$nama_akun 	= '<td> '.$nama->jns_trans.'</td>';
			} else {
				$kode 		= '<td class="h_tengah"><strong>'.$nama->kd_aktiva.'</strong></td>';
				$nama_akun 	= '<td><strong>'.$nama->jns_trans.'</strong></td>';
			}

			$html.='<tr>
			'.$kode.'
			'.$nama_akun;

			$jml_akun = $this->lap_neraca_m->get_jml_akun($nama->id);
			$akun_d = $jml_akun->jum_debet;
			$akun_k = $jml_akun->jum_kredit;

			if ($nama->akun == 'Aktiva') {
				$lancar_j = $akun_k - $akun_d;
				$html.=' <td class="h_kanan">'.number_format(abs($lancar_j)).'</td>
				<td class="h_kanan">0</td>';
				$jum_debet += $lancar_j;
			}

			if ($nama->akun == 'Pasiva') {
				$pasiva_j = $akun_d - $akun_k;
				$html.=' <td class="h_kanan">0</td>
				<td class="h_kanan">'.number_format(abs($pasiva_j)).'</td>';
				$jum_kredit += $pasiva_j;
			}

			$html .= '</tr>';	
		}
		$html .= ' 	<tr class="header_kolom">
							<td colspan="2"> JUMLAH </td>
							<td>'.number_format(abs($jum_debet)).'</td>
							<td>'.number_format(abs($jum_kredit)).'</td>
						</tr>
					</table>';
		$pdf->nsi_html($html);
		$pdf->Output('lap_neraca'.date('Ymd_His') . '.pdf', 'I');
    } 
}