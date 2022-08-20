<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cetak extends AdminController {

    public function __construct() {
        parent::__construct();  
        $this->load->helper('fungsi');
        $this->load->model('simpanan_m');
        $this->load->model('general_m');
    }   

function cetak($id) {
        $this->load->library('Pdf');

        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->set_nsi_header(TRUE);
        $pdf->AddPage('P');
        $html = '
            <style>
                .h_tengah {text-align: center;}
                .h_kiri {text-align: left;}
                .h_kanan {text-align: right;}
                .txt_judul {font-size: 15pt; font-weight: bold; padding-bottom: 15px;}
                .header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}


            </style>
            '.$pdf->nsi_box($text = '<span class="txt_judul">Laporan PDF</span>', $width = '100%', $spacing = '0', $padding = '1', $border = '0', $align = 'center').'
            <table width="100%" cellspacing="0" cellpadding="1" border="1">
                <tr>
                    <td width="5%"     class="header_kolom">No</td>
                    <td width="70%"     class="header_kolom">Keterangan</td>
                    <td width="25%"     class="header_kolom">Jumlah</td>
                </tr>
                <tr>
                    <td class="h_kanan">123</td>
                    <td class="h_kiri">Percobaan</td>
                    <td class="h_kanan">5</td>
                </tr>
            </table>
        ';
        $pdf->nsi_html($html);
        $pdf->Output(date('Ymd_His') . '.pdf', 'I');

    } 
}