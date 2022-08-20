<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cetak_lunas extends OperatorController {
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
        $resolution = array(210, 140);
        $pdf->AddPage('L', $resolution);
        $html = '<style>
                    .h_tengah {text-align: center;}
                    .h_kiri {text-align: left;}
                    .h_kanan {text-align: right;}
                    .txt_judul {font-size: 12pt; font-weight: bold; padding-bottom: 12px;}
                    .header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
                    .txt_content {font-size: 7pt; text-align: center;}
                </style>';
        $html .= ''.$pdf->nsi_box($text ='<table width="100%">
                <tr>
                    <td colspan="2" class="h_kiri" class="txt_judul"><strong>'.$out['nama_lembaga'].'</strong>
                    </td>
                </tr>
                <tr>
                    <td class="h_kiri" width="100%">'.$out['alamat'].' Tel. '.$out['telepon'].'
                    <hr width="100%">
                    </td>
                </tr>
                </table>', $width = '100%', $spacing = '0', $padding = '1', $border = '0', $align = 'left').'';
            $no =1;
            foreach ($angsuran as $row) {

            $pinjaman= $this->general_m->get_data_pinjam($row->pinjam_id);

            $anggota_id = $pinjaman->anggota_id;
            $anggota= $this->general_m->get_data_anggota($anggota_id);

            $hitung_dibayar = $this->general_m->get_jml_bayar($row->pinjam_id);
            $dibayar = $hitung_dibayar->total;
            $tagihan = $pinjaman->ags_per_bulan * $pinjaman->lama_angsuran;
            

            $hitung_denda = $this->general_m->get_jml_denda($row->pinjam_id);
            $jml_denda=$hitung_denda->total_denda;

            $sisa_bayar = $tagihan - $dibayar + $jml_denda ;

            $tgl_bayar = explode(' ', $row->tgl_bayar);
            $txt_tanggal = jin_date_ina($tgl_bayar[0]);

            $tgl_pinjam = explode(' ', $pinjaman->tgl_pinjam);
            $tgl_pinjam = jin_date_ina($tgl_pinjam[0]);   

            $tgl_tempo = explode(' ', $pinjaman->tempo);
            $tgl_tempo = jin_date_ina($tgl_tempo[0]); 

        $html.='<table width="100%">
                <tr>
                    <td class="h_tengah"><strong>BUKTI PELUNASAN KREDIT</strong>
                    </td>
                </tr>
                <tr>
                    <td class="h_tengah">No. Transaksi  '.'TRD'.sprintf('%05d', $row->id).'
                    </td>
                </tr>
                <tr><td></td></tr>
                <tr>
                    <td> Telah terima dari Bapak/Ibu '.strtoupper($anggota->nama).' ('.'AG'.sprintf('%04d', $anggota_id).') pada tanggal '.$txt_tanggal.' sejumlah <strong> Rp. '.number_format($row->jumlah_bayar).' ('.$this->terbilang->eja(nsi_round($row->jumlah_bayar)).' RUPIAH) </strong> untuk Pelunasan Pembayaran Kredit <br>
                    </td>
                </tr>
                </table>';
       $html.='<table width="100%">   
               <tr>
                   <td width="18%"> Nomor Pinjam </td>
                   <td width="2%"> :</td>
                   <td width="35%"> '.'TPJ'.sprintf('%05d', $pinjaman->id).'</td>
               </tr>
               <tr>
                   <td> Tanggal Pinjam </td>
                   <td> :</td>
                   <td> '.$tgl_pinjam.'</td>
               </tr>
               <tr>
                   <td> Tanggal Tempo </td>
                   <td> :</td>
                   <td> '.$tgl_tempo.'</td>
               </tr>
               <tr>
                   <td> Lama Pinjam </td>
                   <td> :</td>
                   <td> '.$pinjaman->lama_angsuran.' Bulan</td>
               </tr>
               <tr>
                   <td> Pokok Pinjaman </td>
                   <td> : </td>
                   <td> Rp. '.number_format($pinjaman->jumlah).'</td>
               </tr>';
           }
        $html .= '</table>
        <br><br><strong> Detail Pembayaran</strong><br><br>';
        $html .='<table width="100%">
                    <tr>
                        <td width="20%"> Total Pinjman</td>
                        <td width="10%"> : Rp. </td>
                        <td width="15%" class="h_kanan"> '.number_format(nsi_round($tagihan)).'</td>

                        <td class="h_kanan"> Sisa Tagihan</td>
                        <td class="h_kiri" width="20%"> : Rp. '.number_format(nsi_round($sisa_bayar )).'</td>
                        <td class="h_kiri" width="15%"></td>
                    </tr>
                    <tr>
                        <td> Total Denda</td>
                        <td> : Rp. </td>
                        <td class="h_kanan"> '.number_format(nsi_round($jml_denda)).'</td>

                        <td class="h_kanan"> Status Pelunasan  </td> 
                        <td class="h_kiri" width="20%"> : <strong>'.strtoupper($pinjaman->lunas).'</strong></td>
                    </tr>
                    <tr>
                        <td> Total Tagihan</td>
                        <td> : Rp. </td>
                        <td class="h_kanan"> '.number_format($tagihan + $jml_denda).'</td>
                    </tr>
                    <tr>
                        <td> Sudah Dibayar</td>
                        <td> : Rp. </td>
                        <td class="h_kanan"> '.number_format(nsi_round($dibayar - $row->jumlah_bayar)).'</td>
                    </tr>
                    <tr>
                        <td> Pelunasan</td>
                        <td> : Rp. </td>
                        <td class="h_kanan"> '.number_format($row->jumlah_bayar).'</td>
                    </tr>
                </table>
                 <p>TERBILANG : '.$this->terbilang->eja(nsi_round($row->jumlah_bayar)).' RUPIAH</p>';;
          $html .='<table width="90%">
                <tr>
                    <td height="50px"></td>
                    <td class="h_tengah"> '.$out['kota'].', '.jin_date_ina(date('Y-m-d')).'</td>
                </tr>
                <tr>
                    <td class="h_tengah"> '.strtoupper($row->user_name).'</td>
                    <td class="h_tengah"> '.strtoupper($anggota->nama).'</td>
                </tr>
                </table>';
        $pdf->nsi_html($html);
        $pdf->Output(date('Ymd_His') . '.pdf', 'I');
    } 
}