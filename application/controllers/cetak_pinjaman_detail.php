<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cetak_pinjaman_detail extends OperatorController {
	public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('general_m');
		$this->load->model('pinjaman_m');
		$this->load->model('angsuran_m');
		$this->load->model('setting_m');
	}	

	function cetak($id) {
		$row = $this->pinjaman_m->get_data_pinjam($id);
		if($row == FALSE) {
			echo 'DATA KOSONG';
        //redirect('angsuran_detail');
			exit();
		}

		$opsi_val_arr = $this->setting_m->get_key_val();
		foreach ($opsi_val_arr as $key => $value){
			$out[$key] = $value;
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
			.txt_judul {font-size: 12pt; font-weight: bold; padding-bottom: 12px;}
			.header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
			.txt_content {font-size: 10pt; font-style: arial;}
		</style>
		'.$pdf->nsi_box($text = '<span class="txt_judul">Detail Transaksi Pembayaran Kredit <br></span>', $width = '100%', $spacing = '0', $padding = '1', $border = '0', $align = 'center').'
		<table width="100%" cellspacing="0" cellpadding="3" border="1" border-collapse= "collapse">';

			$anggota = $this->general_m->get_data_anggota($row->anggota_id);
			$angsuran = $this->angsuran_m->get_data_angsuran($row->id);

			$hitung_denda = $this->general_m->get_jml_denda($row->id);
			$hitung_dibayar = $this->general_m->get_jml_bayar($row->id);
			$sisa_ags = $this->general_m->get_record_bayar($row->id);
			$angsuran = $this->angsuran_m->get_data_angsuran($row->id);

			$tgl_bayar = explode(' ', $row->tgl_pinjam);
			$txt_tanggal = jin_date_ina($tgl_bayar[0]);   

			$tgl_tempo = explode(' ', $row->tempo);
			$tgl_tempo = jin_date_ina($tgl_tempo[0]); 

			//AG'.sprintf('%05d', $row->anggota_id).'
			$html .='<table width="100%">   
			<tr>
				<td width="18%"> ID Anggota </td>
				<td width="2%"> : </td>
				<td width="45%"> '.$anggota->identitas.'</td>

				<td> Pokok Pinjaman </td>
				<td width="5%"> : Rp. </td>
				<td width="10%" class="h_kanan"> '.number_format($row->jumlah).'</td>
			</tr>
			<tr>
				<td> Nama Anggota </td>
				<td> : </td>
				<td> <strong>'.strtoupper($anggota->nama).'</strong></td>

				<td> Angsuran Pokok </td>
				<td> : Rp. </td>
				<td class="h_kanan"> '.number_format($row->pokok_angsuran).'</td>
			</tr>
			<tr>
				<td> Dept </td>
				<td> : </td>
				<td> '.$anggota->departement.'</td>

				<td> Biaya Admin </td>
				<td> : Rp. </td>
				<td class="h_kanan"> '.number_format($row->biaya_adm).'</td>
			</tr>
			<tr>
				<td> Alamat </td>
				<td> : </td>
				<td> '.$anggota->alamat.'</td>

				<td> Angsuran Bunga </td>
				<td> : Rp. </td>
				<td class="h_kanan"> '.number_format($row->bunga_pinjaman).'</td>
			</tr>
			<tr>
				<td > Nomor Pinjam </td>
				<td > :  </td>
				<td > '.'TPJ'.sprintf('%05d', $row->id).'</td>

				<td> Jumlah Angsuran </td>
				<td> : Rp. </td>
				<td class="h_kanan"> '.number_format(nsi_round($row->ags_per_bulan)).'</td>
			</tr>
			<tr>
				<td> Tanggal Pinjam </td>
				<td> : </td>
				<td> '.$txt_tanggal.'</td>
			</tr>
			<tr>
				<td> Tanggal Tempo </td>
				<td> : </td>
				<td> '.$tgl_tempo.'</td>
			</tr>

			<tr>
				<td> Lama Pinjam </td>
				<td> : </td>
				<td> '.$row->lama_angsuran.' Bulan</td>
			</tr>';
			$html .= '</table>';

			$tagihan = $row->ags_per_bulan * $row->lama_angsuran;
			$dibayar = $hitung_dibayar->total;
			$jml_denda = $hitung_denda->total_denda;
			$sisa_bayar = $tagihan - $dibayar;
			$total_bayar = $sisa_bayar + $jml_denda;
			$sisa_angsuran = $row->lama_angsuran - $sisa_ags;

			$html .= '<br><br><strong> Detail Pembayaran </strong><br><br>';
			$html .= '<table width="80%">
			<tr>
				<td> Total Pinjman</td><td class="h_kanan">'.number_format(nsi_round($tagihan)).'</td>
				<td class="h_kanan"> Status Lunas </td> 
				<td class="h_kiri"> : '.$row->lunas.'</td>
			</tr>
			<tr>
				<td> Total Denda</td>
				<td class="h_kanan"> '.number_format(nsi_round($jml_denda)).'</td>
			</tr>
			<tr>
				<td> Total Tagihan</td>
				<td class="h_kanan">'.number_format(nsi_round($tagihan + $jml_denda)).'</td>
			</tr>
			<tr>
				<td> Sudah Dibayar </td>
				<td class="h_kanan"> '.number_format(nsi_round($dibayar)).'</td>
			</tr>
			<tr>
				<td> Sisa Tagihan </td>
				<td class="h_kanan"> '.number_format(nsi_round($total_bayar )).'</td>
			</tr>
		</table> <br><br>';

		$simulasi_tagihan = $this->pinjaman_m->get_simulasi_pinjaman($id);

		$html .= '<br><br><strong> Simulasi Tagihan </strong><br><br>';
		$html .= '<table width="100%">
			<tr class="header_kolom">
				<th style="width:10%;"> Bln ke</th>
				<th style="width:20%;"> Angsuran Pokok</th>
				<th style="width:20%;"> Angsuran Bunga</th>
				<th style="width:10%;"> Biaya Adm</th>
				<th style="width:20%;"> Jumlah Angsuran</th>
				<th style="width:20%;"> Tanggal Tempo</th>
			</tr>';

		if(!empty($simulasi_tagihan)) {
			$no = 1;
			$row = array();
			$jml_pokok = 0;
			$jml_bunga = 0;
			$jml_ags = 0;
			$jml_adm = 0;
			foreach ($simulasi_tagihan as $row) {

				$txt_tanggal = jin_date_ina($row['tgl_tempo']);
				$jml_pokok += $row['angsuran_pokok'];
				$jml_bunga += $row['bunga_pinjaman'];
				$jml_adm += $row['biaya_adm'];
				$jml_ags += $row['jumlah_ags'];

				$html .= '
					<tr>
						<td class="h_tengah">'.$no.'</td>
						<td class="h_kanan">'.number_format(nsi_round($row['angsuran_pokok'])).'</td>
						<td class="h_kanan">'.number_format(nsi_round($row['bunga_pinjaman'])).'</td>
						<td class="h_kanan">'.number_format(nsi_round($row['biaya_adm'])).'</td>
						<td class="h_kanan">'.number_format(nsi_round($row['jumlah_ags'])).'</td>
						<td class="h_kanan">'.$txt_tanggal.'</td>
					</tr>';
				$no++;
			}
			$html .= '<tr bgcolor="#eee">
						<td class="h_tengah"><strong>Jumlah</strong></td>
						<td class="h_kanan"><strong>'.number_format(nsi_round($jml_pokok)).'</strong></td>
						<td class="h_kanan"><strong>'.number_format(nsi_round($jml_bunga)).'</strong></td>
						<td class="h_kanan"><strong>'.number_format(nsi_round($jml_adm)).'</strong></td>
						<td class="h_kanan"><strong>'.number_format(nsi_round($jml_ags)).'</strong></td>
						<td></td>
					</tr>
				</table>';
		}
		$html .= '<br><br><strong> Data Pembayaran </strong><br><br>';
		if(!empty($angsuran)) {
			$html .='<br><br><table width="100%" cellspacing="0" cellpadding="3" border="1" border-collapse= "collapse">
			<tr class="header_kolom" >
				<th style=" width:5%;"> No. </th>
				<th style=" width:15%;"> Kode Bayar</th>
				<th style=" width:15%;"> Tanggal Bayar</th>
				<th style=" width:10%;"> Angsuran Ke </th>
				<th style=" width:15%;"> Jenis Pembayaran </th>
				<th style=" width:20%;"> Jumlah Bayar</th>
				<th style=" width:20%;"> Denda  </th>
			</tr>';

			$no=1;
			$jml_tot = 0;
			$jml_denda = 0;


			foreach ($angsuran as $rows) {
				$tgl_bayar      = explode(' ', $rows->tgl_bayar);
				$txt_tanggal    = jin_date_ina($tgl_bayar[0],'p');
				$jml_tot        += $rows->jumlah_bayar;
				$jml_denda      += $rows->denda_rp;

				$html.= '<tr>
				<td class="h_tengah"> '.$no++.'</td>
				<td class="h_tengah"> '.'TBY'.sprintf('%05d',$rows->id).'</td>
				<td class="h_tengah"> '.$txt_tanggal.'</td>
				<td class="h_tengah"> '.$rows->angsuran_ke.'</td>
				<td class="tengah"> '.$rows->ket_bayar.'</td>
				<td class="h_kanan"> '.number_format(nsi_round($rows->jumlah_bayar)).'</td>
				<td class="h_kanan"> '.number_format(nsi_round($rows->denda_rp)).'</td>
			</tr>';
			}
			$html.='
			<tr class="header_kolom">
				<td class="h_tengah" colspan="5"><strong>Jumlah</strong></td>
				<td class="h_kanan"><strong>'.number_format(nsi_round($jml_tot)).'</strong></td>
				<td class="h_kanan"><strong>'.number_format(nsi_round($jml_denda)).'</strong></td>
			</tr>
			</table>';
		} else {
			$html.='Tidak Ada Data Transkasi';
		}
		$pdf->nsi_html($html);
		$pdf->Output('detail'.date('Ymd_His') . '.pdf', 'I');
	}
}