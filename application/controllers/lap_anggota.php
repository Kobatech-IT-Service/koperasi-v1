<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_anggota extends OperatorController {
public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('general_m');
		$this->load->model('lap_anggota_m');
	}	

	public function index() {
		$this->load->library("pagination");

		$this->data['judul_browser'] = 'Laporan';
		$this->data['judul_utama'] = 'Laporan';
		$this->data['judul_sub'] = 'Data Anggota';

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
		$config["base_url"] = base_url() . "lap_anggota/index/halaman";
		$config["total_rows"] = $this->lap_anggota_m->get_jml_data_anggota(); // banyak data
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
		$this->data["data_anggota"] = $this->lap_anggota_m->get_data_anggota($config["per_page"], $offset); // panggil seluruh data aanggota
		$this->data["halaman"] = $this->pagination->create_links();
		$this->data["offset"] = $offset;

		$this->data["data_jns_simpanan"] = $this->lap_anggota_m->get_jenis_simpan(); // panggil seluruh data aanggota
		
		$this->data['isi'] = $this->load->view('lap_anggota_list_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}

	function cetak() {
		$anggota = $this->lap_anggota_m->lap_data_anggota();
		if($anggota == FALSE) {
			//redirect('lap_anggota');
			echo 'DATA KOSONG';
			exit();
		}

		$data_jns_simpanan = $this->lap_anggota_m->get_jenis_simpan();

		$this->load->library('Pdf');
		$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->set_nsi_header(TRUE);
		$pdf->AddPage('L');
		$html = '';
		$html .= '
		<style>
			.h_tengah {text-align: center;}
			.h_kiri {text-align: left;}
			.h_kanan {text-align: right;}
			.txt_judul {font-size: 15pt; font-weight: bold; padding-bottom: 12px;}
			.header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
		</style>
		'.$pdf->nsi_box($text = '<span class="txt_judul">Laporan Data Anggota <br></span>', $width = '100%', $spacing = '0', $padding = '1', $border = '0', $align = 'center').'
			<table width="100%" cellspacing="0" cellpadding="3" border="1" nobr="true">
				<tr class="header_kolom">
					<th style="width:4%;" > No. </th>
					<th style="width:10%;"> ID Anggota </th>
					<th style="width:25%;"> Nama Anggota </th>
					<th style="width:3%;"> L/P  </th>
					<th style="width:8%;"> Jabatan  </th>
					<th style="width:23%;"> Alamat </th>
					<th style="width:10%;"> Status Anggota </th>
					<th style="width:10%;"> Tgl Registrasi </th>
					<th style="width:7%;"> Photo</th>
				</tr>';
		$no =1;
		$batas = 1;
		foreach ($anggota as $row) {
			if($batas == 0) {
				$html .= '
				<tr class="header_kolom" pagebreak="true">
					<th style="width:4%;" > No. </th>
					<th style="width:10%;"> ID Anggota </th>
					<th style="width:25%;"> Nama Anggota </th>
					<th style="width:3%;"> L/P  </th>
					<th style="width:8%;"> Jabatan  </th>
					<th style="width:23%;"> Alamat </th>
					<th style="width:10%;"> Status Anggota </th>
					<th style="width:10%;"> Tgl Registrasi </th>
					<th style="width:7%;"> Photo</th>
            </tr>';
            $batas = 1;
			}
			$batas++;

			//photo
			$photo_w = 3 * 7;
			$photo_h = 4 * 7;
			if($row->file_pic == '') {
				$photo ='<img src="'.base_url().'assets/theme_admin/img/photo.jpg" alt="default" width="'.$photo_w.'" height="'.$photo_h.'" />';
			} else {
				$photo= '<img src="'.base_url().'uploads/anggota/' . $row->file_pic . '" alt="Foto" width="'.$photo_w.'" height="'.$photo_h.'" />';
			}
			
			//jabatan
			if ($row->jabatan_id == "1") {
				$jabatan = "Pengurus";
			} else {
				$jabatan = "Anggota"; 
			}

			//status
			if ($row->aktif == "Y"){
				$status = "Aktif"; 
			} else {
				$status = "Non-Aktif";
			}

			$tgl_reg  = explode(' ', $row->tgl_daftar);
		   $txt_tanggal = jin_date_ina($tgl_reg[0],'p');

		   $tgl_lahir = explode(' ', $row->tgl_lahir);
		   $txt_lahir = jin_date_ina($tgl_lahir[0],'full');
			// AG'.sprintf('%04d', $row->id).'
			$html .= '
			<tr nobr="true">
				<td class="h_tengah">'.$no++.' </td>
				<td class="h_tengah">'.$row->identitas.'</td>
				<td class="h_kiri"><b>'.strtoupper($row->nama).'</b><br>'.$row->tmp_lahir.', '.$txt_lahir.'</td>
				<td class="h_tengah">'.$row->jk.'</td>
				<td class="h_tengah">'.$jabatan.'<br>'.$row->departement.'</td>
				<td class="h_left">'.$row->alamat.'<br>Telp. '.$row->notelp.'  </td>
				<td class="h_tengah">'.$status.'</td>
				<td class="h_tengah">'.$txt_tanggal.'</td>
				<td class="h_tengah">'.$photo.'</td>
			</tr>'; 
		}
		$html .= '</table>';
		$pdf->nsi_html($html);
		$pdf->Output('lap_anggota'.date('Ymd_His') . '.pdf', 'I');
	} 
}