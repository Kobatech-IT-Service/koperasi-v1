<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cetak_pengajuan extends OPPController {

	public function __construct() {
		parent::__construct();

		$this->load->helper('fungsi');
		$this->load->model('general_m');
		$this->load->model('pinjaman_m');
		$this->load->model('setting_m');
        // angka
		$this->load->library('terbilang');
	}

	function laporan() {
		$data_ajuan = $this->pinjaman_m->get_pengajuan_cetak();
		$opsi_val_arr = $this->setting_m->get_key_val();
		foreach ($opsi_val_arr as $key => $value) {
			$out[$key] = $value;
		}

		//var_dump($data_ajuan);
		//exit();
		if($data_ajuan['total'] == 0) {
			echo 'Data Kosong';
			exit();
		}
		$list = $data_ajuan['rows'];

		$fr_jenis = isset($_REQUEST['fr_jenis']) ? explode(',', $_REQUEST['fr_jenis']) : array();
		$fr_status = isset($_REQUEST['fr_status']) ? explode(',', $_REQUEST['fr_status']) : array();		
		
		$fr_jenis = array_diff($fr_jenis, array(NULL)); // NULL / FALSE / ''
		$fr_status = array_diff($fr_status, array(NULL)); // NULL / FALSE / ''

		$fr_bulan = isset($_REQUEST['fr_bulan']) ? $_REQUEST['fr_bulan'] : '';
		
		if($fr_bulan != '') {
			$bln_dari = date("Y-m-d", strtotime($fr_bulan . "-01 -1 month"));
			$tgl_dari = substr($bln_dari, 0, 7) . '-21';
			$tgl_sampai = $fr_bulan . '-20';
		} else {
			$tgl_dari = $_REQUEST['tgl_dari']; 
			$tgl_sampai = $_REQUEST['tgl_sampai'];
		}	


		//$fr_jenis = explode(',', $fr_jenis);
		//$fr_status = explode(',', $fr_status);

		if(! empty($fr_jenis)) {
			$txt_jenis = implode(', ', $fr_jenis);
		} else {
			$txt_jenis = "Semua";
		}
		$status_arr = array(0 => 'Menunggu Konfirmasi', 1 => 'Disetujui', 2 => 'Ditolak', 3 => 'Sudah Terlaksana', 4 => 'Batal');
		if(! empty($fr_status)) {
			$status_rep = str_replace(
				array('0', '1', '2', '3', '4'), 
				array('Menunggu Konfirmasi', 'Disetujui', 'Ditolak', 'Sudah Terlaksana', 'Batal'), 
				$fr_status);
			$txt_status = implode(', ', $status_rep);
			//echo $txt_status; exit();
		} else {
			$txt_status = "Semua";
		}
		//echo $txt_status; exit();
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
		'.$pdf->nsi_box($text = '<span class="txt_judul">Laporan Data Pengajuan <br></span> <span> Periode '.jin_date_ina($tgl_dari).' - '.jin_date_ina($tgl_sampai).' | Jenis: '.$txt_jenis.' | Staus: '.$txt_status.' </span> ', $width = '100%', $spacing = '0', $padding = '1', $border = '0', $align = 'center').'
		<table width="100%" cellspacing="0" cellpadding="3" border="1">
			<tr class="header_kolom" pagebreak="false">
				<th style="width:3%;" >No</th>
				<th style="width:8%;">ID Ajuan</th>
				<th style="width:10%;">NIK</th>
				<th style="width:25%;">Nama</th>
				<th style="width:11%;">Dept</th>
				<th style="width:8%;">Tanggal</th>
				<th style="width:10%;">Nominal</th>
				<th style="width:10%;">Pelunasan</th>
				<th style="width:3%;">Bln</th>
				<th style="width:12%;">Status</th>
			</tr>';
		$no =1;
		$total_nominal = 0;
		$total_sisa_arr = array();
		foreach ($list as $row) {
			$sisa_tagihan = '-';
			if($row->jenis != 'Darurat') {
				$sisa_tagihan = $row->sisa_tagihan;
				$total_sisa_arr[$row->anggota_id] = str_replace(',', '', $row->sisa_tagihan);
			}
			$html .= '
			<tr nobr="true">
				<td class="h_tengah">'.$no++.' </td>
				<td class="h_tengah">'.$row->ajuan_id.'</td>
				<td class="h_tengah">'.$row->identitas.'</td>
				<td>'.$row->nama.'</td>
				<td>'.$row->departement.'</td>
				<td class="h_tengah">'.$row->tgl_input_txt.'</td>
				<td class="h_kanan">'.$row->nominal.'</td>
				<td class="h_kanan">'.$sisa_tagihan.'</td>
				<td class="h_tengah">'.$row->lama_ags.'</td>
				<td>'.$status_arr[$row->status].'</td>
			</tr>
			';
			$total_nominal += str_replace(',', '', $row->nominal);
		}
		$total_sisa = 0;
		foreach ($total_sisa_arr as $val) {
			$total_sisa += $val;
		}

		$html .= '
		<tr>
			<td colspan="6" class="h_kanan"> <strong> Total </strong> </td>
			<td class="h_kanan"><strong> '.number_format(nsi_round($total_nominal)).' </strong></td>
			<td class="h_kanan"><strong> '.number_format(nsi_round($total_sisa)).' </strong></td>
			<td colspan="2"></td>
		</tr>';
		$html .= '</table>';

		$html .= '
		<br><br>
		<table width="97%">
		<tr>
			<td class="h_tengah" height="50px" width="40%">Dibuat oleh,</td>
			<td class="h_tengah" width="60%"> '.$out['kota'].', '.jin_date_ina(date('Y-m-d')).'</td>
		</tr>
		<tr>
			<td class="h_tengah"> BENDAHARA </td>
			<td class="h_tengah"> KETUA </td>
		</tr>
		</table>';

		$pdf->nsi_html($html);
		$pdf->Output('pinjam'.date('Ymd_His') . '.pdf', 'I');       
	}

	function cetak($id) {
		$row = $this->pinjaman_m->get_data_pengajuan($id);

		$opsi_val_arr = $this->setting_m->get_key_val();
		foreach ($opsi_val_arr as $key => $value){
			$out[$key] = $value;
		}

		$this->load->library('Struk');
		$pdf = new Struk('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->set_nsi_header(false);
		$resolution = array(210, 140);
		$pdf->AddPage('L', $resolution);

		$html = '
		<style>
			.h_tengah {text-align: center;}
			.h_kiri {text-align: left;}
			.h_kanan {text-align: right;}
			.txt_judul {font-size: 12pt; font-weight: bold; padding-bottom: 12px;}
			.header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
			.txt_content {font-size: 7pt; text-align: center;}
		</style>';
		$html .= ''.$pdf->nsi_box($text ='
			<table width="100%">
				<tr>
					<td colspan="2" class="h_kiri" class="txt_judul"><strong>'.$out['nama_lembaga'].'</strong>
					</td>
				</tr>
				<tr>
					<td class="h_kiri" width="100%">'.$out['alamat'].' Tel. '.$out['telepon'].'
						<hr width="100%"></td>
					</tr>
				</table>
				', $width = '100%', $spacing = '0', $padding = '1', $border = '0', $align = 'left').'';

		$anggota= $this->general_m->get_data_anggota($row->anggota_id);

		$tgl_input = explode(' ', $row->tgl_input);
		$txt_tanggal = jin_date_ina($tgl_input[0]);

		$tgl_cair = explode(' ', $row->tgl_cair);
		$tgl_cair = jin_date_ina($tgl_cair[0]);

		$status_arr = array(0 => 'Menunggu Konfirmasi', 1 => 'Disetujui', 2 => 'Ditolak', 3 => 'Sudah Terlaksana', 4 => 'Batal');

		$html .='<div class="h_tengah"><strong>BUKTI PENGAJUAN DANA KREDIT </strong> <br> Ref. '.date('Ymd_His').'</div>

		<table width="100%">
			<tr>
				<td colspan="3"><span style="font-size: 12px;"> Identitas Anggota</span> </td>
			</tr>        
			<tr>
				<td width="18%"> Nomor Kontrak </td>
				<td width="2%">:</td>
				<td width="45%">'.'TPP'.sprintf('%05d', $row->id).'</td>
			</tr>
			<tr>
				<td> Id Anggota </td>
				<td>:</td>
				<td>'.$row->identitas.'</td>
			</tr>
			<tr>
				<td> Nama Anggota </td>
				<td>:</td>
				<td>'.strtoupper($anggota->nama).'</td>
			</tr>
			<tr>
				<td> Departement </td>
				<td>:</td>
				<td>'.($row->departement).'</td>
			</tr>
			<tr>
				<td> Alamat </td>
				<td>:</td>
				<td>'.$anggota->alamat.'</td>
			</tr>

			<tr>
				<td colspan="3"><br><br> <span style="font-size: 12px;">Rincian Pengajuan</span> </td>
			</tr>
			<tr>
				<td> Tanggal Pengajuan </td>
				<td>:</td>
				<td>'.$txt_tanggal.'</td>
			</tr>
			<tr>
				<td> Jumlah Pinjaman </td>
				<td>:</td>
				<td>Rp '.number_format($row->nominal).',-</td>
			</tr>
			<tr>
				<td> Status Ajuan </td>
				<td>:</td>
				<td>'.$status_arr[$row->status].'</td>
			</tr>

			<tr>
				<td> Tanggal Pencairan </td>
				<td>:</td>
				<td>'.$tgl_cair.'</td>
			</tr>
			<tr>
				<td> Lama Angsuran </td>
				<td>:</td>
				<td>'.$row->lama_ags.' Bulan</td>
			</tr>
		</table>
		<br><br>
		TERBILANG = '.$this->terbilang->eja(nsi_round($row->nominal)).' RUPIAH
		<p></p>
		<table width="90%">
			<tr>
				<td height="50px"></td>
				<td class="h_tengah">'.$out['kota'].', '.jin_date_ina(date('Y-m-d')).'</td>
			</tr>
			<tr>
				<td class="h_tengah"> '.strtoupper($this->data['u_name']).'</td>
				<td class="h_tengah">'.strtoupper($anggota->nama).'</td>
			</tr>
		</table>';
		$pdf->nsi_html($html);
		$pdf->Output(date('Ymd_His') . '.pdf', 'I');
	} 
}