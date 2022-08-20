<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cetak_penarikan extends OperatorController {

	public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('cetak_simpanan_m');
		$this->load->model('general_m');
		$this->load->model('setting_m');
		$this->load->library('terbilang');
	}	

	function cetak($id) {
		$simpanan = $this->cetak_simpanan_m->lap_data_penarikan($id);

		$opsi_val_arr = $this->setting_m->get_key_val();
		foreach ($opsi_val_arr as $key => $value){
			$out[$key] = $value;
		}

		$this->load->library('Struk');
		$pdf = new Struk('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->set_nsi_header(false);
		$resolution = array(210, 80);
		$pdf->AddPage('L', $resolution);
		$html = '<style>
		.h_tengah {text-align: center;}
		.h_kiri {text-align: left;}
		.h_kanan {text-align: right;}
		.txt_judul {font-size: 12pt; font-weight: bold; padding-bottom: 12px;}
		.header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
		.txt_content {font-size: 8pt; text-align: center;}
	</style>';
	$html .= ''.$pdf->nsi_box($text =' <table width="100%">
		<tr>
			<td colspan="2" class="h_kanan"><strong>'.$out['nama_lembaga'].'</strong></td>
		</tr>
		<tr>
			<td width="25%"><strong>BUKTI PENARIKAN TUNAI</strong>
				<hr width="100%">
			</td>
			<td class="h_kanan" width="75%">'.$out['alamat'].'</td>
		</tr>
	</table>', $width = '100%', $spacing = '0', $padding = '1', $border = '0', $align = 'left').'';

	$no =1;
	foreach ($simpanan as $row) {

		$anggota= $this->cetak_simpanan_m->get_data_anggota($row->anggota_id);
		$jns_simpan= $this->cetak_simpanan_m->get_jenis_simpan($row->jenis_id);

		$tgl_bayar = explode(' ', $row->tgl_transaksi);
		$txt_tanggal = jin_date_ina($tgl_bayar[0]);
		$txt_tanggal .= ' / ' . substr($tgl_bayar[1], 0, 5);

		if($row->nama_penyetor ==''){
			$penyetor = '-';
		} else {
			$penyetor = $row->nama_penyetor;
		}

		if($row->alamat ==''){
			$alamat = '-';
		} else {
			$alamat = $row->alamat;
		}
		//AG'.sprintf('%04d', $row->anggota_id).'
		$html .='<table width="100%">
		<tr>
			<td width="20%"> Tanggal Transaksi </td>
			<td width="2%">:</td>
			<td width="35%" class="h_kiri">'.$txt_tanggal.'</td>

			<td> Tanggal Cetak </td>
			<td width="2%">:</td>
			<td width="25%" class="h_kiri">'.jin_date_ina(date('Y-m-d')).' / '.date('H:i').'</td>
		</tr>
		<tr>
			<td> Nomor Transaksi </td>
			<td>:</td>
			<td>'.'TRD'.sprintf('%05d', $row->id).'</td>

			<td> User Akun </td>
			<td width="2%">:</td>
			<td class="h_kiri">'.$row->user_name.'</td>
		</tr>
		<tr>
			<td> ID Anggota </td>
			<td>:</td>
			<td>'.$anggota->identitas.'</td>

			<td> Status </td>
			<td width="2%">:</td>
			<td class="h_kiri">SUKSES</td>
		</tr>
		<tr>
			<td> Nama Anggota </td>
			<td>:</td>
			<td>'.strtoupper($anggota->nama).'</td>
		</tr>
		<tr>
			<td> Dept </td>
			<td>:</td>
			<td>'.$anggota->departement.'</td>
		</tr>		
		<tr>
			<td> Nama Kuasa </td>
			<td>:</td>
			<td>'.$penyetor.'</td>

			<td></td>
			<td width="2%"></td>
			<td class="h_kiri">Paraf, </td>
		</tr>
		<tr>
			<td> Alamat </td>
			<td>:</td>
			<td>'.$alamat.'</td>
		</tr>
		<tr>
			<td> Jumlah </td>
			<td>:</td>
			<td>Rp. '.number_format($row->jumlah).'</td>
		</tr>
		<tr>
			<td> Jenis Akun </td>
			<td>:</td>
			<td>'.$jns_simpan->jns_simpan.'</td>

			<td></td>
			<td width="2%"></td>
			<td class="h_kiri">____________ </td>
		</tr>
		<tr>
			<td> Terbilang </td> 
			<td>:</td>
			<td colspan="3">'.$this->terbilang->eja($row->jumlah).' RUPIAH </td>
		</tr>';
	}
	$html .='</table> 
	
	<p class="txt_content"></p>
	
	<p class="txt_content">Ref. '.date('Ymd_His').'<br> 
		Informasi Hubungi Call Center : '.$out['telepon'].'
		<br>
		atau dapat diakses melalui : '.$out['web'].'
	</p>';

	$pdf->nsi_html($html);
	$pdf->Output(date('Ymd_His') . '.pdf', 'I');
} 
}