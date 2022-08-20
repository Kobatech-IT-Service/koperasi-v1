<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_tempo extends OperatorController {

public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('general_m');
		$this->load->model('lap_tempo_m');
	}	

	public function index() {
		$this->load->library("pagination");

		$this->data['judul_browser'] = 'Laporan';
		$this->data['judul_utama'] = 'Laporan';
		$this->data['judul_sub'] = 'Pembayaran Kredit';

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
		$config["base_url"] = base_url() . "lap_tempo/index/halaman";
		$config["total_rows"] = $this->lap_tempo_m->get_jml_data_tempo(); // banyak data
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
		$this->data["data_tempo"] = $this->lap_tempo_m->get_data_tempo($config["per_page"], $offset); // panggil seluruh data aanggota
		$this->data["halaman"] = $this->pagination->create_links();
		$this->data["offset"] = $offset;
		
		$this->data['isi'] = $this->load->view('lap_tempo_list_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);

	}

	function cetak() {

		$data_tempo = $this->lap_tempo_m->lap_data_tempo();
		if($data_tempo == FALSE) {
			echo 'DATA KOSONG';
			//redirect('lap_tempo');
			exit();
		}

		$txt_periode_arr = explode('-', $_REQUEST['periode']);
		if(is_array($txt_periode_arr)) {
			$periode = jin_nama_bulan($txt_periode_arr[1]) . ' ' . $txt_periode_arr[0];
		}

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
         '.$pdf->nsi_box($text = '<span class="txt_judul">Laporan Pembayaran Jatuh Tempo Periode '.$periode.' </span>', $width = '100%', $spacing = '1', $padding = '1', $border = '0', $align = 'center').'';
      $html.='<table width="100%" cellspacing="0" cellpadding="3" border="1">
		<tr class="header_kolom">
			<th style="width:5%;" > No. </th>
			<th style="width:10%;"> Kode Pinjam</th>
			<th style="width:16%;"> Anggota</th>
			<th style="width:11%;"> Tanggal Pinjam  </th>
			<th style="width:11%;"> Tanggal Tempo  </th>
			<th style="width:8%;"> Lama Pinjam </th>
			<th style="width:13%;"> Jumlah Tagihan  </th>
			<th style="width:13%;"> Sudah <br> Dibayar  </th>
			<th style="width:13%;"> Sisa Tagihan  </th>
		</tr>';

		$no = 1;
		$jml_tagihan = 0;
		$jml_dibayar = 0;
		$jml_sisa = 0;
		
		foreach ($data_tempo as $rows) {

			$anggota = $this->general_m->get_data_anggota($rows->anggota_id);

			$tgl_pinjam = explode(' ', $rows->tgl_pinjam);
			$tgl_pinjam = jin_date_ina($tgl_pinjam[0],'p');

			$tgl_tempo = explode(' ', $rows->tempo);
			$tgl_tempo = jin_date_ina($tgl_tempo[0],'p');

			$jml_bayar = $this->general_m->get_jml_bayar($rows->id); 
			$jml_denda = $this->general_m->get_jml_denda($rows->id); 
			$total_tagihan = $rows->tagihan + $jml_denda->total_denda;
			$sisa_tagihan = $total_tagihan - $jml_bayar->total;

			$jml_tagihan += $total_tagihan;
			$jml_dibayar += $jml_bayar->total;
			$jml_sisa += $sisa_tagihan;

			$html.='
				<tr>
					<td class="h_tengah"> '.$no++.'</td>
					<td class="h_tengah"> '.'TPJ' . sprintf('%05d', $rows->id) . ''.'</td>
					<td> '.$anggota->identitas.'<br> '.$anggota->nama.'</td>
					<td class="h_tengah"> '.$tgl_pinjam.'</td>
					<td class="h_tengah"> '.$tgl_tempo.'</td>
					<td class="h_tengah"> '.$rows->lama_angsuran.' bln</td>
					<td class="h_kanan"> '.number_format(nsi_round($total_tagihan)).'</td>
					<td class="h_kanan"> '.number_format(nsi_round($jml_bayar->total)).'</td>
					<td class="h_kanan"> '.number_format(nsi_round($sisa_tagihan)).'</td>
				</tr>
			';
		}
	$html.='
			<tr class="header_kolom">
				<td colspan="6" class="h_tengah"><strong>Jumlah Total</strong></td>
				<td class="h_kanan"><strong>'.number_format(nsi_round($jml_tagihan)).'</strong></td>
				<td class="h_kanan"><strong>'.number_format(nsi_round($jml_dibayar)).'</strong></td>
				<td class="h_kanan"><strong>'.number_format(nsi_round($jml_sisa)).'</strong></td>
			</tr>';
        $html.='</table>';
        $pdf->nsi_html($html);
        $pdf->Output('lap_tempo'.date('Ymd_His') . '.pdf', 'I');
    } 
}