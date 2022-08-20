<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cetak_angsuran extends OperatorController {
	public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('angsuran_m');
		$this->load->model('general_m');
		$this->load->model('setting_m');
		$this->load->library('terbilang');
	}	

	function cetak($id) {
		$angsuran = $this->angsuran_m->get_data_pembayaran_by_id($id);
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
		.txt_content {font-size: 7pt; text-align: center;}
	</style>';
	$html .= ''.$pdf->nsi_box($text =' <table width="100%">
		<tr>
			<td colspan="2" class="h_kanan"><strong>'.$out['nama_lembaga'].'</strong></td>
		</tr>
		<tr>
			<td width="30%"><strong>BUKTI SETORAN ANGSURAN KREDIT</strong>
				<hr width="100%">
			</td>
			<td class="h_kanan" width="70%">'.$out['alamat'].'</td>
		</tr>
	</table>', $width = '100%', $spacing = '0', $padding = '1', $border = '0', $align = 'left').'';
	$no =1;
	foreach ($angsuran as $row) {
		$pinjaman= $this->general_m->get_data_pinjam($row->pinjam_id);

		$anggota_id = $pinjaman->anggota_id;
		$anggota= $this->general_m->get_data_anggota($anggota_id);

		$hitung_denda = $this->general_m->get_jml_denda($row->pinjam_id);
		$jml_denda=$hitung_denda->total_denda;

		$hitung_dibayar = $this->general_m->get_jml_bayar($row->pinjam_id);
		$dibayar = $hitung_dibayar->total;
		$tagihan = $pinjaman->ags_per_bulan * $pinjaman->lama_angsuran;
		$sisa_bayar = $tagihan - $dibayar ;

		$total_dibayar = $sisa_bayar + $jml_denda;

		$tgl_bayar = explode(' ', $row->tgl_bayar);
		$txt_tanggal = jin_date_ina($tgl_bayar[0]);
		$txt_tanggal .= ' / ' . substr($tgl_bayar[1], 0, 5);    

		//AG'.sprintf('%04d', $anggota_id).'
		$html .='<table width="100%">
		<tr>
			<td width="20%"> Tanggal Transaksi </td>
			<td width="2%">:</td>
			<td width="35%" class="h_kiri">'.$txt_tanggal.'</td>

			<td> Tanggal Cetak </td>
			<td colspan="2">: '.jin_date_ina(date('Y-m-d')).' / '.date('H:i').'</td>
		</tr>
		<tr>
			<td> Nomor Transaksi </td>
			<td>:</td>
			<td>'.'TRD'.sprintf('%05d', $row->id).'</td>

			<td> User Akun </td>
			<td colspan="2">: '.$row->user_name.' </td>           
		</tr>
		<tr>
			<td> ID Anggota </td>
			<td>:</td>
			<td>'.$anggota->identitas.' / '.strtoupper($anggota->nama).'</td>

			<td> Status </td>
			<td colspan="2">: SUKSES</td>
		</tr>
		<tr>
			<td> Dept </td>
			<td>:</td>
			<td class="h_kiri">'.$anggota->departement.'</td>
		</tr>
		<tr>
			<td> Nomor Kontrak </td>
			<td >:</td>
			<td class="h_kiri">'.'TPJ'.sprintf('%05d', $pinjaman->id).'</td>
		</tr>
		<tr>
			<td> Angsuran Ke </td>
			<td>: </td>
			<td class="h_kiri">'.$row->angsuran_ke.' / '.$pinjaman->lama_angsuran.'</td>
		</tr>
	</table>
	<table width="100%">
		<tr>
			<td width="20%"> Angsuran Pokok </td>
			<td width="5%">: Rp. </td>
			<td width="15%"  class="h_kanan">'.number_format($pinjaman->pokok_angsuran).'</td>

			<td width="17%"></td>
			<td width="16.5%">Total Denda </td>
			<td width="5%">: Rp. </td>
			<td width="20%" class="h_kanan">'.number_format(nsi_round($jml_denda)).'</td>
		</tr>
		<tr>
			<td> Bunga Angsuran</td>
			<td width="5%">: Rp. </td>
			<td class="h_kanan">'.number_format($pinjaman->bunga_pinjaman).'</td>

			<td width="17%"> </td>
			<td width="16.5%">Sisa Pinjman</td>
			<td width="5%">: Rp. </td>
			<td width="20%" class="h_kanan">'.number_format(nsi_round($sisa_bayar)).'</td>
		</tr>
		<tr>
			<td> Biaya Admin </td>
			<td>: Rp. </td>
			<td class="h_kanan">'.number_format(nsi_round($pinjaman->biaya_adm)).'</td>

			<td width="17%"></td>
			<td width="16.5%">Total Tagihan </td>
			<td width="5%">: Rp. </td>
			<td width="20%" class="h_kanan">'.number_format(nsi_round($total_dibayar)).'</td>
		</tr>
		<tr>
			<td> Jumlah Angsuran </td>
			<td>: Rp.</td>
			<td class="h_kanan"><strong>'.number_format(nsi_round($row->jumlah_bayar)).'</strong></td>
		</tr>
		<tr>
			<td> Terbilang </td>
			<td colspan="4">: '.$this->terbilang->eja(nsi_round($row->jumlah_bayar)).' RUPIAH</td>
		</tr>';
	}
	$html .= '</table>
	<p class="txt_content">Ref. '.date('Ymd_His').'<br> 
		Informasi Hubungi Call Center : '.$out['telepon'].'
		<br>
		atau dapat diakses melalui : '.$out['web'].'
	</p>';

	$pdf->nsi_html($html);
	$pdf->Output(date('Ymd_His') . '.pdf', 'I');

} 

}