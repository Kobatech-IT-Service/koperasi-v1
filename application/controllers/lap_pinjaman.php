<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_pinjaman extends AdminController {

	public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('general_m');
		$this->load->model('pinjaman_m');
	}	


	function cetak_laporan() {
		$data_pinjam = $this->pinjaman_m->lap_data_pinjaman();
		if($data_pinjam == FALSE) {
			echo 'DATA KOSONG<br>Pastikan Filter Tanggal dengan benar.';
			exit();
		}

		$tgl_dari = $_REQUEST['tgl_dari']; 
		$tgl_sampai = $_REQUEST['tgl_sampai']; 
		$cari_status = $_REQUEST['cari_status']; 

		if ($cari_status == "") {
			$status = "Status Pelunasan : Semua";
		} else {
			$status = "Status Pelunasan :". $cari_status ;
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
		'.$pdf->nsi_box($text = '<span class="txt_judul">Laporan Data Pinjaman <br></span> <span> Periode '.jin_date_ina($tgl_dari).' - '.jin_date_ina($tgl_sampai).' | '.$status.'</span> ', $width = '100%', $spacing = '0', $padding = '1', $border = '0', $align = 'center').'
		<table width="100%" cellspacing="0" cellpadding="3" border="1" nobr="true">
			<tr class="header_kolom">
				<th style="width:3%;" > No </th>
				<th style="width:28%;"> Identitas Anggota</th>
				<th style="width:25%;"> Pinjaman  </th>
				<th style="width:22%;"> Hitungan </th>
				<th style="width:22%;"> Tagihan  </th>
			</tr>';
		$no =1;
		$batas = 1;
		$total_pinjaman = 0;
		$total_denda = 0;
		$total_tagihan = 0;
		$tot_sdh_dibayar = 0;
		$tot_sisa_tagihan = 0;
		foreach ($data_pinjam as $r) {
			if($batas == 0) {
				$html .= '
				<tr class="header_kolom" pagebreak="false">
					<th style="width:3%;" > No </th>
					<th style="width:27%;"> Identitas Anggota</th>
					<th style="width:26%;"> Pinjaman  </th>
					<th style="width:22%;"> Hitungan </th>
					<th style="width:22%;"> Tagihan  </th>
				</tr>';
				$batas = 1;
			}
			$batas++;

			$barang = $this->pinjaman_m->get_data_barang($r->barang_id);   
			$anggota = $this->general_m->get_data_anggota($r->anggota_id);   
			$jml_bayar = $this->general_m->get_jml_bayar($r->id); 
			$jml_denda = $this->general_m->get_jml_denda($r->id); 
			$jml_tagihan = $r->tagihan + $jml_denda->total_denda;
			$sisa_tagihan = $jml_tagihan - $jml_bayar->total;


			//total pinjaman
			$total_pinjaman += @$r->jumlah;
			//total tagihan
			$total_tagihan += $jml_tagihan;
			//total dibayar
			$tot_sdh_dibayar += $jml_bayar->total;
			//sisa tagihan
			$tot_sisa_tagihan += $sisa_tagihan;

			//jabatan
			if ($anggota->jabatan_id == "1"){
				$jabatan = "Pengurus";
			} else {
				$jabatan = "Anggota";
			}

			//jk
			if ($anggota->jk == "L"){
				$jk = "Laki-laki";
			} else {
				$jk = "Perempuan";
			}

			$tgl_pinjam = explode(' ', $r->tgl_pinjam);
			$txt_tanggal = jin_date_ina($tgl_pinjam[0],'full');

			$tgl_tempo = explode(' ', $r->tempo);
			$txt_tempo = jin_date_ina($tgl_tempo[0],'full');

			// AG'.sprintf('%04d',$anggota->id).'
			$html .= '
			<tr nobr="true">
				<td class="h_tengah">'.$no++.' </td>
				<td>
					<table width="100%"> 
						<tr>
							<td width="20%">ID </td><td width="5%">:</td><td class="h_kiri" width="75%">'.$anggota->identitas.'</td>
						</tr>
						<tr>
							<td>Nama </td>
							<td>:</td>
							<td class="h_kiri"><strong>'.strtoupper($anggota->nama).'</strong></td>
						</tr>
						<tr>
							<td>Dept </td>
							<td>:</td>
							<td class="h_kiri">'.$anggota->departement.'</td>
						</tr>
						<tr>
							<td>L/P </td>
							<td>:</td>
							<td class="h_kiri">'.$jk.' </td>
						</tr>
						<tr>
							<td>Jabatan </td>
							<td>:</td>
							<td class="h_kiri">'.$jabatan.' </td>
						</tr>
						<tr>
							<td>Alamat </td>
							<td>:</td>
							<td class="h_kiri">'.$anggota->alamat.'<br>Telp. '. $anggota->notelp.'</td>
						</tr>
					</table>
				</td>
				<td>
					<table width="100%">
						<tr>
							<td width="44%"> Nomor Kontrak</td>
							<td width="6%">:</td>
							<td width="50%" class="h_kiri">'.'PJ'.sprintf('%05d',$r->id).'</td>
						</tr>
						<tr>
							<td> Tanggal Pinjam</td>
							<td>:</td>
							<td class="h_kiri">'.$txt_tanggal.'</td>
						</tr>
						<tr>
							<td> Tanggal Tempo</td>
							<td>:</td>
							<td class="h_kiri">'.$txt_tempo.'</td>
						</tr>
						<tr>
							<td> Pokok Pinjaman</td>
							<td>:</td>
							<td class="h_kiri">'.number_format(@$r->jumlah).'</td>
						</tr>
						<tr>
							<td> Lama Pinjaman</td>
							<td>:</td>
							<td class="h_kiri">'.number_format(@$r->lama_angsuran).' Bulan</td>
						</tr>
						<tr>
							<td> Status Lunas</td>
							<td>:</td>
							<td class="h_kiri">'.@$r->lunas.'</td>
						</tr>
					</table>
				</td>
				<td>
					<table> 
						<tr>
							<td>Pokok Angsuran </td> 
							<td class="h_kanan"> '.number_format(@$r->pokok_angsuran).' </td>
						</tr>
						<tr>
							<td>Bunga Pinjaman </td>
							<td class="h_kanan"> '.number_format(@$r->bunga_pinjaman).'</td>
						</tr>
						<tr>
							<td>Biaya Admin </td>
							<td class="h_kanan">'.number_format(@$r->biaya_adm).'</td>
						</tr>
						<tr>
							<td>Jumlah Angsuran </td>
							<td class="h_kanan"> '.number_format(nsi_round(@$r->ags_per_bulan)).'</td>
						</tr>
						<tr>
							<td>Jumlah Pinjaman </td>
							<td class="h_kanan"> <strong>'.number_format(nsi_round(@$r->ags_per_bulan * @$r->lama_angsuran)).'</strong></td>
						</tr>
					</table>
				</td>
				<td>
					<table> 
						<tr>
							<td>Jumlah Tagihan </td> 
							<td class="h_kanan"> '.number_format(nsi_round($r->tagihan)).' </td>
						</tr>
						<tr>
							<td>Jumlah Denda </td> 
							<td class="h_kanan"> '.number_format(nsi_round($jml_denda->total_denda)).' </td>
						</tr>
						<tr>
							<td>Dibayar </td>
							<td class="h_kanan"> '.number_format(nsi_round($jml_bayar->total)).'</td>
						</tr>
						<tr>
							<td>Sisa Tagihan </td>
							<td class="h_kanan"><strong>'.number_format(nsi_round($sisa_tagihan)).'</strong></td>
						</tr>
					</table>
				</td>
			</tr>';
			}

		$html .= '
				<tr>
					<td colspan="3" class="h_kanan"> <strong> Total Pokok Pinjaman </strong> </td>
					<td class="h_kanan"><strong> '.number_format(nsi_round($total_pinjaman)).' </strong></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="3" class="h_kanan"> <strong> Total Tagihan </strong> </td>
					<td class="h_kanan"><strong>'.number_format(nsi_round($total_tagihan)).'</strong></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="3" class="h_kanan"> <strong> Total Dibayar </strong> </td>
					<td class="h_kanan"><strong>'.number_format(nsi_round($tot_sdh_dibayar)).'</strong></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="3" class="h_kanan"> <strong> Sisa Tagihan </strong> </td>
					<td class="h_kanan"><strong>'.number_format(nsi_round($tot_sisa_tagihan)).'</strong></td>
					<td></td>
				</tr>
			</table>';
		$pdf->nsi_html($html);
		$pdf->Output('pinjam'.date('Ymd_His') . '.pdf', 'I');
	} 
}