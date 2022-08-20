<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_kas_anggota extends OPPController {
	public function __construct() {
			parent::__construct();	
			$this->load->helper('fungsi');
			$this->load->model('general_m');
			$this->load->model('lap_kas_anggota_m') ;
		
		}	

	public function index() {
		$this->load->library("pagination");
	
		$this->data['judul_browser'] = 'Laporan';
		$this->data['judul_utama'] = 'Laporan';
		$this->data['judul_sub'] = 'Data Kas Anggota';

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
		$config["base_url"] = base_url() . "lap_kas_anggota/index/halaman";
		$jumlah_row = $this->lap_kas_anggota_m->get_jml_data_anggota();
		if(isset($_GET['anggota_id']) && $_GET['anggota_id'] > 0) {
			$jumlah_row = 1;
		}
		$config["total_rows"] = $jumlah_row; // banyak data
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
		$this->data["data_anggota"] = $this->lap_kas_anggota_m->get_data_anggota($config["per_page"], $offset); // panggil seluruh data aanggota
		$this->data["halaman"] = $this->pagination->create_links();
		$this->data["offset"] = $offset;

		$this->data["data_jns_simpanan"] = $this->lap_kas_anggota_m->get_jenis_simpan(); // panggil seluruh data simpanan
		
		$this->data['isi'] = $this->load->view('lap_kas_anggota_list_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}


    function cetak_laporan() {
		$anggota = $this->lap_kas_anggota_m->lap_data_anggota();
		$data_jns_simpanan = $this->lap_kas_anggota_m->get_jenis_simpan();

		if($anggota == FALSE) {
			redirect('lap_kas_anggota');
			exit();
		}
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
         '.$pdf->nsi_box($text = '<span class="txt_judul">Laporan Data Kas Anggota <br></span>', $width = '100%', $spacing = '0', $padding = '1', $border = '0', $align = 'center').'
         <table width="100%" cellspacing="0" cellpadding="3" border="1" nobr="true">
         <tr class="header_kolom">
         	<th style="width:3%;" > No </th>
        
            <th style="width:32%;"> Identitas  </th>
            <th style="width:30%;"> Kas Simpanan </th>
            <th style="width:30%;"> Tagihan Pinjaman </th>
         </tr>';
			$no =1;
			$batas = 1;
			foreach ($anggota as $row) {
				if($batas == 0) {
					$html .= '
					<tr class="header_kolom" pagebreak="false">
		            <th style="width:3%;" > No </th>
		           
		            <th style="width:32%;"> Identitas  </th>
		            <th style="width:30%;"> Kas Simpanan </th>
		            <th style="width:30%;"> Tagihan Pinjaman </th>
	            </tr>';
	            $batas = 1;
				}
				$batas++;
			
			//pinjaman
			$pinjaman = $this->lap_kas_anggota_m->get_data_pinjam($row->id);
			$pinjam_id = @$pinjaman->id;

			//denda
			$denda = $this->lap_kas_anggota_m->get_jml_denda($pinjam_id);
			$tagihan= @$pinjaman->tagihan + $denda->total_denda;
			
			//dibayar
			$dibayar = $this->lap_kas_anggota_m->get_jml_bayar($pinjam_id);
			$sisa_tagihan = $tagihan - $dibayar->total;

			//photo
			$photo_w = 3 * 12;
			$photo_h = 4 * 12;
			if($row->file_pic == '') {
				$photo ='<img src="'.base_url().'assets/theme_admin/img/photo.jpg" alt="default" width="'.$photo_w.'" height="'.$photo_h.'" />';
			} else {
				$photo= '<img src="'.base_url().'uploads/anggota/' . $row->file_pic . '" alt="Foto" width="'.$photo_w.'" height="'.$photo_h.'" />';
			}

			//jk
			if ($row->jk == "L") {
				$jk="Laki-Laki"; 
			} else {
				$jk="Perempuan"; 
			}

			//jabatan
			if ($row->jabatan_id == "1") {
				$jabatan="Pengurus";
			} else {
				$jabatan="Anggota"; 
			}
			// AG'.sprintf('%04d', $row->id).'
         $html .= '
         <tr nobr="true">
				<td class="h_tengah" style="vertical-align: middle ">'.$no++.' </td>
				
				<td> 
				<table>
					<tr>
						<td><strong> '.$row->nama.'</strong></td>
					</tr>
					<tr>
						<td> '.$row->identitas.' </td>
					</tr>
					<tr>
						<td> '.$jk.' </td>
					</tr>
					<tr>
						<td> '.$jabatan.' - '.$row->departement.'</td>
					</tr>
					<tr>
						<td> '.$row->alamat.' Telp. '.$row->notelp.' </td>
					</tr>
				</table>
				</td>
				<td> 
					<table width="100%">';
					$simpanan_arr = array();
					$simpanan_row_total = 0; 
					foreach ($data_jns_simpanan as $jenis) {
						$simpanan_arr[$jenis->id] = $jenis->jns_simpan;
						$nilai_s = $this->lap_kas_anggota_m->get_jml_simpanan($jenis->id, $row->id);
						$nilai_p = $this->lap_kas_anggota_m->get_jml_penarikan($jenis->id, $row->id);	
						$simpanan_row=$nilai_s->jml_total - $nilai_p->jml_total;
						$simpanan_row_total += $simpanan_row;
		$html.=' <tr>
						<td> '.$jenis->jns_simpan.'</td>
						<td class="h_kanan"> '. number_format($simpanan_row).'</td>
					</tr>';
					}
		$html.='<tr>
						<td> <strong>Total Simpanan</strong></td>
						<td class="h_kanan"><strong> '.number_format($simpanan_row_total).'</strong></td>
					</tr>
					</table>
				</td> 
				<td>
					<table> 
					<tr>
						<td> Pokok Pinjaman</td>
						<td class="h_kanan">'.number_format(@nsi_round($pinjaman->jumlah)).'</td>
					</tr>
					<tr>
						<td> Total Tagihan </td> 
						<td class="h_kanan"> '.number_format(nsi_round($tagihan)).' </td>
					</tr>
					<tr>
						<td> Dibayar </td>
						<td class="h_kanan"> '.number_format(nsi_round($dibayar->total)).'</td></tr>
					<tr>
						<td> Sisa Tagihan </td>
						<td class="h_kanan"> <strong> '.number_format(nsi_round($sisa_tagihan)).'</strong>
						</td>
					</tr>
				</table>
			</td>
		</tr>'; 
		}     
      $html .= '</table>';
      $pdf->nsi_html($html);
      $pdf->Output('lap_kas_agt'.date('Ymd_His') . '.pdf', 'I');
	} 

    function cetak_laporan_ringkas() {
		$anggota = $this->lap_kas_anggota_m->lap_data_anggota();
		$data_jns_simpanan = $this->lap_kas_anggota_m->get_jenis_simpan();

		if($anggota == FALSE) {
			redirect('lap_kas_anggota');
			exit();
		}
     $this->load->library('Pdf');
     $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
     $pdf->set_nsi_header(TRUE);
     $pdf->AddPage('P');
     $html = '';
     $html .= '
         <style>
             .h_tengah {text-align: center;}
             .h_kiri {text-align: left;}
             .h_kanan {text-align: right;}
             .txt_judul {font-size: 15pt; font-weight: bold; padding-bottom: 12px;}
             .header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
         </style>
         '.$pdf->nsi_box($text = '<span class="txt_judul">Laporan Data Kas Anggota <br></span>', $width = '100%', $spacing = '0', $padding = '1', $border = '0', $align = 'center').'
         <table width="100%" cellspacing="0" cellpadding="3" border="1" nobr="true">
         <tr class="header_kolom">
         	<th style="width:3%;" > No </th>
            <th class="header_tengah" style="width:8%;"> No Anggota</th>
            <th style="width:27%;"> NAMA  </th>';
            foreach ($data_jns_simpanan as $jenis) {
                $html .= '<th style="width:15%;"> ' . $jenis->jns_simpan . '  </th>';
            }
         $html .= ' <th style="width:15%;"> Total Saldo  </th></tr>';
			$no =1;
			$batas = 1;
			foreach ($anggota as $row) {
				if($batas == 0) {
					$html .= '
					<tr class="header_kolom" pagebreak="false">
		            <th style="width:3%;" > No </th>
		            <th class="header_tengah" style="width:8%;">No Anggota</th>
		            <th style="width:27%;"> NAMA </th>';
                    foreach ($data_jns_simpanan as $jenis) {
                        $html .= '<th style="width:15%;"> ' . $jenis->jns_simpan . ' </th>';
                    }
           $html .= '<th style="width:15%;"> Total Saldo  </th></tr>';
	            $batas = 1;
				}
				$batas++;
			
			//pinjaman
			$pinjaman = $this->lap_kas_anggota_m->get_data_pinjam($row->id);
			$pinjam_id = @$pinjaman->id;

			//denda
			$denda = $this->lap_kas_anggota_m->get_jml_denda($pinjam_id);
			$tagihan= @$pinjaman->tagihan + $denda->total_denda;
			
			//dibayar
			$dibayar = $this->lap_kas_anggota_m->get_jml_bayar($pinjam_id);
			$sisa_tagihan = $tagihan - $dibayar->total;

			//photo
			$photo_w = 3 * 12;
			$photo_h = 4 * 12;
			if($row->file_pic == '') {
				$photo ='<img src="'.base_url().'assets/theme_admin/img/photo.jpg" alt="default" width="'.$photo_w.'" height="'.$photo_h.'" />';
			} else {
				$photo= '<img src="'.base_url().'uploads/anggota/' . $row->file_pic . '" alt="Foto" width="'.$photo_w.'" height="'.$photo_h.'" />';
			}

			//jk
			if ($row->jk == "L") {
				$jk="Laki-Laki"; 
			} else {
				$jk="Perempuan"; 
			}

			//jabatan
			if ($row->jabatan_id == "1") {
				$jabatan="Pengurus";
			} else {
				$jabatan="Anggota"; 
			}
			// AG'.sprintf('%04d', $row->id).'
	
         $html .= '
         <tr nobr="true">
				<td class="h_tengah" style="vertical-align: middle ">'.$no++.' </td>
				<td class="h_tengah" style="vertical-align: middle ">'.$row->identitas.'</td>
				<td> '. $row->nama .'</td>';
				
					$simpanan_arr = array();
					$simpanan_row_total = 0; 
					foreach ($data_jns_simpanan as $jenis) {
						$simpanan_arr[$jenis->id] = $jenis->jns_simpan;
						$nilai_s = $this->lap_kas_anggota_m->get_jml_simpanan($jenis->id, $row->id);
						$nilai_p = $this->lap_kas_anggota_m->get_jml_penarikan($jenis->id, $row->id);	
						$simpanan_row=$nilai_s->jml_total - $nilai_p->jml_total;
						$simpanan_row_total += $simpanan_row;
	
						$html.= '<td class="h_kanan"> '. number_format($simpanan_row).'</td>';
					}
				
				
			$html.= '	<td class="h_kanan"><strong> '.number_format($simpanan_row_total).'</strong></td>';
				
	
			$html .= '</tr>'; 
		}     
      $html .= '</table>';
      $pdf->nsi_html($html);
      $pdf->Output('lap_simpanan_agt'.date('Ymd_His') . '.pdf', 'I');
	} 
	

    
}

