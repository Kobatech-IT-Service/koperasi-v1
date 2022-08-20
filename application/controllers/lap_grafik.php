<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_grafik extends AdminController {

public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('general_m');
		$this->load->model('lap_grafik_m');
	}	

	public function index() {
		$this->load->library("pagination");

		$this->data['judul_browser'] = 'Grafik';
		$this->data['judul_utama'] = 'Grafik';
		$this->data['judul_sub'] = 'Grafik Perkembangan';

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

		$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/sparkline/jquery.sparkline.min.js';

		$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/jqueryKnob/jquery.knob.js';

		$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/jquery.min.js';

		$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/bootstrap.min.js';

		$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/AdminLTE/app.js';

		$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/AdminLTE/app.js';

		//$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/AdminLTE/demo.js';

		  
     				
		$this->data['isi'] = $this->load->view('lap_grafik_list_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);

	}

	function cetak() {

		$simpanan = $this->lap_grafik_m->lap_jenis_simpan();

        $this->load->library('Pdf');

        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->set_nsi_header(TRUE);
        $pdf->AddPage('P');
        $html = '
            <style>
                .h_tengah {text-align: center;}
                .h_kiri {text-align: left;}
                .h_kanan {text-align: right;}
                .txt_judul {font-size: 12pt; font-weight: bold; padding-bottom: 15px;}
                .header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
            </style>
            '.$pdf->nsi_box($text = '<span class="txt_judul">Laporan Saldo Kas Simpanan</span>', $width = '100%', $spacing = '1', $padding = '1', $border = '0', $align = 'center').'';
          $html.='<table width="100%" cellspacing="0" cellpadding="3" border="1">
		<tr class="header_kolom">
			<th style="width:5%;"> No. </th>
			<th style="width:35%;"> Jenis Akun </th>
			<th style="width:20%;"> Simpanan  </th>
			<th style="width:20%;"> Penarikan  </th>
			<th style="width:20%;"> Jumlah  </th>
		</tr>';

	$no = 1;
	$simpanan_arr = array();
	$simpanan_row_total = 0; 
	$simpanan_total = 0; 
	$penarikan_total = 0; 
	foreach ($simpanan as $jenis) {

	$simpanan_arr[$jenis->id] = $jenis->jns_simpan;
	$nilai_s = $this->lap_grafik_m->get_jml_simpanan($jenis->id);
	$nilai_p = $this->lap_grafik_m->get_jml_penarikan($jenis->id);
	
	$simpanan_row=$nilai_s->jml_total; 
	$penarikan_row=$nilai_p->jml_total;
	$sub_total = $simpanan_row - $penarikan_row; 

	$simpanan_total += $simpanan_row;
	$penarikan_total += $penarikan_row;
	$simpanan_row_total += $sub_total;

	$html.='
	<tr>
		<td class="h_tengah">'.$no++.'</td>
		<td>'.$jenis->jns_simpan.'</td>
		<td class="h_kanan">'. number_format($simpanan_row).'</td>
		<td class="h_kanan">'. number_format($penarikan_row).'</td>
		<td class="h_kanan">'. number_format($sub_total).'</td>
	</tr>';
	}

	$html.='
	<tr class="header_kolom">
		<td colspan="2" class="h_tengah"><strong>Jumlah Total</strong></td>
		<td class="h_kanan"><strong>'.number_format($simpanan_total).'</strong></td>
		<td class="h_kanan"><strong>'.number_format($penarikan_total).'</strong></td>
		<td class="h_kanan"><strong>'.number_format($simpanan_row_total).'</strong></td>
	</tr>';
        $html.='</table>';
        $pdf->nsi_html($html);
        $pdf->Output(date('Ymd_His') . '.pdf', 'I');

    } 



}