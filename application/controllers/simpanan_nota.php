<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Simpanan extends AdminController {

	public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('simpanan_m');
		$this->load->model('general_m');
	}	

	
function cetak_nota() {
	$simpanan = $this->simpanan_m->lap_data_simpanan();
	$jml_simpanan = $this->simpanan_m->get_jml_simpanan();

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
                .txt_content {font-size: 10pt; font-style: arial;}
            </style>
            '.$pdf->nsi_box($text = '<span class="txt_judul">Laporan Data Simpanan Anggota <br></span>', $width = '100%', $spacing = '0', $padding = '1', $border = '0', $align = 'center').'
            <table width="100%" cellspacing="0" cellpadding="3" border="1" border-collapse= "collapse">
            <tr class="header_kolom">
            <th class="h_tengah" style="width:5%;" > No. </th>
            <th class="h_tengah" style="width:13%;"> No Transaksi</th>
            <th class="h_tengah" style="width:13%;"> Tanggal </th>
            <th class="h_tengah" style="width:25%;"> Nama Anggota </th>
            <th class="h_tengah" style="width:20%;"> Jenis Simpanan </th>
            <th class="h_tengah" style="width:13%;"> Jumlah  </th>
            <th class="h_tengah" style="width:10%;"> User Akun </th>
            </tr>';

            $no =1;
            foreach ($simpanan as $row) {

            	$anggota= $this->simpanan_m->get_data_anggota($row->anggota_id);
            	$jns_simpan= $this->simpanan_m->get_jenis_simpan($row->jenis_id);

            	$tgl_bayar = explode(' ', $row->tgl_transaksi);
            	$txt_tanggal = jin_date_ina($tgl_bayar[0],'p');


        $html .= '
				      <tr>
							<td class="h_tengah" >'.$no++.'</td>
							<td class="h_tengah"> '.'TRD'.sprintf('%05d', $row->id).'</td>
							<td class="h_tengah"> '.$txt_tanggal.'</td>
							<td class="h_kiri"> '.'AG'.sprintf('%04d', $row->anggota_id).' - 
							 '.$anggota->nama.'</td>
							 <td> '.$jns_simpan->jns_simpan.'</td>
							<td class="h_kanan"> '.number_format($row->jumlah).'</td>
							<td> '.$row->user_name.'</td>
						</tr>';
					}
        $html .= '
        <tr class="header_kolom"><td colspan="5"> Jumlah Total </td><td class="h_kanan"> '.number_format($jml_simpanan->jml_total).'</td><td></td></tr>

            </table>
        ';
        $pdf->nsi_html($html);
        $pdf->Output(date('Ymd_His') . '.pdf', 'I');

    } 
}