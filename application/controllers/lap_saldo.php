<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_saldo extends OperatorController {

	public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('general_m');
		$this->load->model('lap_saldo_m');
	}	

	public function index() {
		$this->load->library("pagination");

		$this->data['judul_browser'] = 'Laporan';
		$this->data['judul_utama'] = 'Laporan';
		$this->data['judul_sub'] = 'Saldo Kas';

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


		$config = array();
		$config["base_url"] = base_url() . "lap_saldo/index/halaman";
		$config["total_rows"] = $this->lap_saldo_m->get_jml_data_kas(); // banyak data
		$config["per_page"] = 10;
		$config["uri_segment"] = 4;
		$config['use_page_numbers'] = TRUE;


		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';

		$config['first_link'] = '&laquo; First';
		$config['first_tag_open'] = '<li class="prev page">';
		$config['first_tag_close'] = '</li>';

		$config['last_link'] = 'Last &raquo;';
		$config['last_tag_open'] = '<li class="next page">';
		$config['last_tag_close'] = '</li>';

		$config['next_link'] = 'Next &rarr;';
		$config['next_tag_open'] = '<li class="next page">';
		$config['next_tag_close'] = '</li>';

		$config['prev_link'] = '&larr; Previous';
		$config['prev_tag_open'] = '<li class="prev page">';
		$config['prev_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="active"><a href="">';
		$config['cur_tag_close'] = '</a></li>';

		$config['num_tag_open'] = '<li class="page">';
		$config['num_tag_close'] = '</li>';

		$this->pagination->initialize($config);
		$offset = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		if($offset > 0) {
			$offset = ($offset * $config['per_page']) - $config['per_page'];
		}
		$this->data["data_jns_kas"] = $this->lap_saldo_m->get_data_jenis_kas($config["per_page"], $offset); // panggil seluruh data aanggota
		$this->data["halaman"] = $this->pagination->create_links();
		$this->data["offset"] = $offset;

		$this->data["saldo_sblm"] = $this->lap_saldo_m->get_saldo_sblm();
		
		$this->data['isi'] = $this->load->view('lap_saldo_list_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);

	}

	function cetak() {

		$nama_kas = $this->lap_saldo_m->lap_jenis_kas();
		if($nama_kas == FALSE) {
			echo 'Data Kosong';
			exit();
			//redirect('lap_saldo');
		}

		$saldo_sblm = $this->lap_saldo_m->get_saldo_sblm();

		$txt_periode_arr = explode('-', $_REQUEST['periode']);
		if(is_array($txt_periode_arr)) {
			$periode = jin_nama_bulan($txt_periode_arr[1]) . ' ' . $txt_periode_arr[0];
		}

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
		'.$pdf->nsi_box($text = '<span class="txt_judul">Laporan Saldo Kas Periode '.$periode.'</span>', $width = '100%', $spacing = '1', $padding = '1', $border = '0', $align = 'center').'';
		$html .= '
		<table width="100%" cellspacing="0" cellpadding="3" border="1">
			<tr class="header_kolom">
				<th style="width:5%;" > No. </th>
				<th style="width:60%;">Nama Kas </th>
				<th style="width:35%;"> Saldo  </th>
			</tr>

			<tr>
				<td class="h_kanan" colspan="2"><strong> SALDO PERIODE SEBELUMNYA </strong></td>
				<td class="h_kanan"><strong> '.number_format(nsi_round($saldo_sblm)).'</strong></td>
			</tr>';

			$no = 1;
			$kas_arr = array();
			$debet_total = 0; 
			$kredit_total = 0; 
			$saldo_total = 0; 
			foreach ($nama_kas as $jenis) {

				$kas_arr[$jenis->id] = $jenis->nama;
				$nilai_debet = $this->lap_saldo_m->get_jml_debet($jenis->id);
				$nilai_kredit = $this->lap_saldo_m->get_jml_kredit($jenis->id);

				$debet_row = $nilai_debet->jml_total; 
				$kredit_row = $nilai_kredit->jml_total;
				$saldo_row = $debet_row - $kredit_row; 

				$debet_total += $debet_row;
				$kredit_total += $kredit_row;
				$saldo_total += $saldo_row;

				$html.='
				<tr>
					<td class="h_tengah">'.$no++.'</td>
					<td>'.$jenis->nama.'</td>
					<td class="h_kanan">'. number_format(nsi_round($saldo_row)).'</td>
				</tr>';
			}

			$html .= '
			<tr class="header_kolom">
				<td colspan="2" class="h_kanan"><strong>Jumlah </strong></td>
				<td class="h_kanan"><strong>'.number_format(nsi_round($saldo_total)).'</strong></td>
			</tr>
			<tr class="header_kolom">
				<td colspan="2" class="h_kanan"><strong>Total Saldo </strong></td>
				<td class="h_kanan"><strong>'.number_format(nsi_round($saldo_total + $saldo_sblm)).'</strong></td>
			</tr>';
			$html .= '</table>';
			$pdf->nsi_html($html);
			$pdf->Output('lap_saldo'.date('Ymd_His') . '.pdf', 'I');
		} 

	}