<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_shu_anggota extends OPPController {

public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('general_m');
		$this->load->model('lap_shu_anggota_m');
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
			$rows[$i]['nama'] = $r->nama. '<br>' . $r->departement;
			$rows[$i]['id_nama'] = 'AG'.sprintf('%04d', $r->id) . ' - ' . $r->nama;
			$i++;
		}
		//keys total & rows wajib bagi jEasyUI
		$result = array('total'=>$data['count'],'rows'=>$rows);
		echo json_encode($result); //return nya json
	}


	function cetak_laporan() {

		$anggota = $this->lap_shu_anggota_m->lap_data_anggota();
		$data_jns_simpanan = $this->lap_shu_anggota_m->get_jenis_simpan();

		if(empty($_REQUEST['js_usaha']) && empty($_REQUEST['js_modal']) && empty($_REQUEST['tot_pendpatan']) && empty($_REQUEST['tot_simpanan']) ) {
			echo 'Data Kosong';
			//redirect('lap_shu');
			exit();
		}

		$js_usaha = $_REQUEST['js_usaha'];
		$tot_pendpatan = $_REQUEST['tot_pendpatan'];

		$js_modal = $_REQUEST['js_modal'];
		$tot_simpanan = $_REQUEST['tot_simpanan'];

		$tgl_dari = $_REQUEST['tgl_dari'];
		$tgl_samp = $_REQUEST['tgl_samp'];

		$tgl_dari_txt = jin_date_ina($tgl_dari, 'p');
		$tgl_samp_txt = jin_date_ina($tgl_samp, 'p');
		$tgl_periode_txt = $tgl_dari_txt . ' - ' . $tgl_samp_txt;


		
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
                .txt_judul {font-size: 12pt; font-weight: bold; padding-bottom: 12px;}
                .header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
            </style>
            '.$pdf->nsi_box($text = '<span class="txt_judul">Laporan SHU Anggota <br> Periode '.$tgl_periode_txt.' </span>', $width = '100%', $spacing = '0', $padding = '1', $border = '0', $align = 'center').'
            <table width="100%" cellspacing="0" cellpadding="3" border="1" nobr="true">
	            <tr class="header_kolom">
		            <th style="width:5%;" > No </th>
		            <th style="width:30%;"> Identitas  </th>
		            <th style="width:65%;" colspan="2"> Pembagian SHU </th>
            </tr>';
			$no =1;
			$batas = 1;
			foreach ($anggota as $row) {
				if($batas == 0) {
					$html .= '
					<tr class="header_kolom" pagebreak="false">
		            <th style="width:5%;" > No </th>
		            <th style="width:30%;"> Identitas  </th>
		            <th style="width:65%;" colspan="2"> Pembagian SHU </th>
	            </tr>';
	            $batas = 1;
				}
				$batas++;
			
			//pinjaman
			$pinjaman = $this->lap_shu_anggota_m->get_data_pinjam($row->id);
			$pinjam_id = @$pinjaman->id;
			//denda
			$denda = $this->lap_shu_anggota_m->get_jml_denda($pinjam_id);
			$tagihan= @$pinjaman->tagihan + $denda->total_denda;
			//dibayar
			$dibayar = $this->lap_shu_anggota_m->get_jml_bayar($pinjam_id);
			$sisa_tagihan = $tagihan - $dibayar->total;

			$laba_anggota = @$dibayar->total - @$pinjaman->jumlah;

			//jabatan
			if ($row->jabatan_id == "1"){
				$jabatan="Pengurus";
			}else{
				$jabatan="Anggota";
			}
			// AG'.sprintf('%04d',@$row->id).'
			$html .= '
         <tr nobr="true">
			<td rowspan="2" class="h_tengah" style="vertical-align: middle ">'.$no++.' </td>
			<td rowspan="2"> 
				<table>
					<tr>
						<td>Id Anggota</td>
						<td> : '.$row->identitas.' </td>
					</tr>
					<tr>
						<td>Nama Anggota </td>
						<td> : <strong>'.@$row->nama.'</strong></td>
					</tr>
					<tr>
						<td>Jabatan </td>
						<td> : '.@$jabatan.' - '.@$row->departement.' </td>
					</tr>
					<tr>
						<td>Alamat </td>
						<td> : '.@$row->alamat.' </td>
					</tr>
					<tr>
						<td>No. HP </td>
						<td> : '.@$row->notelp.' </td>
					</tr>
				</table>
			</td>';
			$html.='<td>';
			$simpanan_arr = array();
			$simpanan_row_anggota = 0; 

			foreach ($data_jns_simpanan as $jenis) {
				$simpanan_arr[$jenis->id] = $jenis->jns_simpan;
				$nilai_s = $this->lap_shu_anggota_m->get_jml_simpanan($jenis->id, $row->id);
				$nilai_p = $this->lap_shu_anggota_m->get_jml_penarikan($jenis->id, $row->id);
				
				$simpanan_row = $nilai_s->jml_total - $nilai_p->jml_total;
				$simpanan_row_anggota += $simpanan_row;
			}

			$shu_laba = 1;
			$shu_modal = 1;

			if ($shu_laba > 0 || $shu_modal > 0 ) {
				if($tot_pendpatan > 0) {
					$shu_laba = ($laba_anggota / $tot_pendpatan) * $js_usaha;
				} else {
					$shu_laba = 0;
				}
				if($tot_simpanan > 0) {
					$shu_modal = ($simpanan_row_anggota / $tot_simpanan) * $js_modal;
				} else {
					$shu_modal = 0;
				}
			}

			$html.= '<table width="100%">
						<tr>
							<td colspan="3"><strong>Jasa Usaha </strong></td>
						</tr>
						<tr>
							<td>Laba Anggota  </td>
							<td class="h_kanan">'.number_format(nsi_round($laba_anggota)).'</td>
						</tr>
						<tr>
							<td>Total Laba </td>
							<td class="h_kanan">'.number_format(nsi_round($tot_pendpatan)).'</td>
						</tr>
						<tr>
							<td>Jasa Usaha  </td>
							<td class="h_kanan">'.number_format(nsi_round($js_usaha)).'</td>
						</tr>
						<tr>
							<td>SHU Jasa Usaha </td>
							<td colspan="3" class="h_kanan">'.number_format(nsi_round($shu_laba)).'</td>
						</tr>
						</table></td>';
				$html.='<td><table width="100%">
						<tr>
							<td colspan="3"><strong>Modal Usaha </strong></td>
						</tr>
						<tr>
							<td>Simpanan Anggota</td>
							<td class="h_kanan">'.number_format($simpanan_row_anggota).'</td>
						</tr>
						<tr>
							<td>Total Simpanan </td>
							<td class="h_kanan">'.number_format($tot_simpanan).'</td>
						</tr>
						<tr>
							<td>Jasa Simpanan</td>
							<td class="h_kanan">'.number_format($js_modal).'</td>
						</tr>
						<tr>
							<td>SHU Jasa Modal</td>
							<td colspan="3" class="h_kanan">'.number_format($shu_modal).'</td>
						</tr>
						</table></td>';	
					$html.='</tr>
					<tr>
							<td><strong>SHU Diterima </strong></td>
							<td class="h_kanan"><strong>'.number_format($shu_laba + $shu_modal).'</strong></td>
					</tr>'; 
		}     
     $html .= '</table>';
     $pdf->nsi_html($html);
     $pdf->Output('lap_shu_agt'.date('Ymd_His') . '.pdf', 'I');
    } 
}