<!-- Styler -->
<style type="text/css">
.panel * {
	font-family: "Arial","​Helvetica","​sans-serif";
}
.fa {
	font-family: "FontAwesome";
}
.datagrid-header-row * {
	font-weight: bold;
}
.messager-window * a:focus, .messager-window * span:focus {
	color: blue;
	font-weight: bold;
}
.daterangepicker * {
	font-family: "Source Sans Pro","Arial","​Helvetica","​sans-serif";
	card-sizing: border-card;
}
.glyphicon	{font-family: "Glyphicons Halflings"}

.form-control {
	height: 20px;
	padding: 4px;
}	
</style>

<?php 
// buaat tanggal sekarang
if(isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
	$tgl_dari = $_REQUEST['tgl_dari'];
	$tgl_samp = $_REQUEST['tgl_samp'];
} else {
	$tgl_dari = date('Y') . '-01-01';
	$tgl_samp = date('Y') . '-12-31';
}
$tgl_dari_txt = jin_date_ina($tgl_dari, 'p');
$tgl_samp_txt = jin_date_ina($tgl_samp, 'p');
$tgl_periode_txt = $tgl_dari_txt . ' - ' . $tgl_samp_txt;
?>

<div class="card card-solid card-primary">
	<div class="card-header">
		<h3 class="card-title">Laporan Neraca Saldo</h3>
		<div class="card-tools pull-right">
			<button class="btn btn-primary btn-sm" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
	</div>
	<div class="card-body">
		<div>
			<form id="fmCari" method="GET">
				<input type="hidden" name="tgl_dari" id="tgl_dari">
				<input type="hidden" name="tgl_samp" id="tgl_samp">
					<table>
						<tr>
							<td>
								<div id="filter_tgl" class="input-group" style="display: inline;">
									<button class="btn btn-default" id="daterange-btn">
										<i class="fa fa-calendar"></i> <span id="reportrange"><span><?php echo $tgl_periode_txt; ?>
										</span></span>
										<i class="fa fa-caret-down"></i>
									</button>
								</div>
							</td>
							<td>
								<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="false" onclick="cetak()">Cetak Laporan</a>

								<a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-clear" plain="false" onclick="clearSearch()">Hapus Filter</a>
							</td>
						</tr>
					</table>
					</form>
			</div>
	</div>
</div>
<div class="card card-solid card-primary">
<div class="card-body">
<p></p>

<p style="text-align:center; font-size: 15pt; font-weight: bold;"> Laporan Neraca Saldo Periode <?php echo $tgl_periode_txt; ?></p>

	<table class="table table-bordered">
		<tr class="header_kolom">
			<th style="text-align:center; width:5%"> </th>
			<th style="text-align:center; width:55%"> Nama Akun</th>
			<th style="text-align:center; width:20%"> Debet </th>
			<th style="text-align:center; width:20%"> Kredit </th>
		</tr>
		<tr>
			<td class="h_tengah"> &nbsp; <i class="fa fa-folder-open-o"></i> </td>
			<td><strong> A. Aktiva Lancar </strong></td>
			<td></td>
		</tr>
		<?php
			$jum_debet = 0;
			$jum_kredit = 0;
			
			//ambil data kass
			$no_kas = 1;
			foreach ($data_jns_kas as $jenis) {
				$nilai_debet = $this->lap_neraca_m->get_jml_debet($jenis->id);
				$nilai_kredit = $this->lap_neraca_m->get_jml_kredit($jenis->id);

				$debet_row = $nilai_debet->jml_total; 
				$kredit_row = $nilai_kredit->jml_total;
				$saldo_row = $debet_row - $kredit_row;
				echo'
					<tr>
						<td></td>
						<td>A'.$no_kas.'. '. $jenis->nama.'</td>
						<td class="h_kanan"> '.number_format(nsi_round($saldo_row)).' </td>
						<td class="h_kanan"> 0 </td>
				  </tr>';
				$jum_debet += $saldo_row;
				$no_kas++;
			}
						
			foreach ($data_akun as $nama) {
				echo '<tr>';
				if (strlen($nama->kd_aktiva) != 1) {
					echo '<td> &nbsp; </td>
							<td>'.$nama->kd_aktiva.'. '.$nama->jns_trans.'</td>';
				} else {
					echo'<td class="h_tengah"> &nbsp; <i class="fa fa-folder-open-o"></i> </td>
						  <td> <strong>'.$nama->kd_aktiva.'. '.$nama->jns_trans.'</strong></td>';
				}

				$jml_akun = $this->lap_neraca_m->get_jml_akun($nama->id);
				$akun_d = $jml_akun->jum_debet;
				$akun_k = $jml_akun->jum_kredit;

				if ($nama->akun == 'Aktiva') {
					$lancar_j = $akun_k - $akun_d;
					echo '
					<td class="h_kanan">'.number_format($lancar_j).'</td>
					<td class="h_kanan">0</td>';
					$jum_debet += $lancar_j;
				}

				if ($nama->akun == 'Pasiva') {
					$pasiva_j = $akun_d - $akun_k;
					echo '
					<td class="h_kanan">0</td>
					<td class="h_kanan">'.number_format($pasiva_j).'</td>';
					$jum_kredit += $pasiva_j;
				}
				echo '</tr>';
			}
		?>
		<tr class="header_kolom" >
			<td colspan="2"> JUMLAH </td>
			<td><?php echo number_format($jum_debet); ?></td>
			<td><?php echo number_format($jum_kredit); ?></td>
		</tr>
	</table>

</div>
</div>
	
<script type="text/javascript">
$(document).ready(function() {
	fm_filter_tgl();
}); // ready

function fm_filter_tgl() {
	$('#daterange-btn').daterangepicker({
		ranges: {
			'Hari ini': [moment(), moment()],
			'Kemarin': [moment().subtract('days', 1), moment().subtract('days', 1)],
			'7 Hari yang lalu': [moment().subtract('days', 6), moment()],
			'30 Hari yang lalu': [moment().subtract('days', 29), moment()],
			'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
			'Bulan kemarin': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')],
			'Tahun ini': [moment().startOf('year').startOf('month'), moment().endOf('year').endOf('month')],
			'Tahun kemarin': [moment().subtract('year', 1).startOf('year').startOf('month'), moment().subtract('year', 1).endOf('year').endOf('month')]
		},
		locale: 'id',
		showDropdowns: true,
		format: 'YYYY-MM-DD',
		<?php 
			if(isset($tgl_dari) && isset($tgl_samp)) {
				echo "
					startDate: '".$tgl_dari."',
					endDate: '".$tgl_samp."'
				";
			} else {
				echo "
					startDate: moment().startOf('year').startOf('month'),
					endDate: moment().endOf('year').endOf('month')
				";
			}
		?>
	},

	function (start, end) {
		doSearch();
	});
}

function clearSearch(){
	window.location.href = '<?php echo site_url("lap_neraca"); ?>';
}

function doSearch() {
	var tgl_dari = $('input[name=daterangepicker_start]').val();
	var tgl_samp = $('input[name=daterangepicker_end]').val();
	$('input[name=tgl_dari]').val(tgl_dari);
	$('input[name=tgl_samp]').val(tgl_samp);
	$('#fmCari').attr('action', '<?php echo site_url('lap_neraca'); ?>');
	$('#fmCari').submit();	
}

function cetak () {
	var tgl_dari = $('input[name=daterangepicker_start]').val();
	var tgl_samp = $('input[name=daterangepicker_end]').val();
	//$('input[name=tgl_dari]').val(tgl_dari);
	//$('input[name=tgl_samp]').val(tgl_samp);
	//$('#fmCari').attr('action', '<?php echo site_url('lap_neraca/cetak'); ?>');
	//$('#fmCari').submit();

	var win = window.open('<?php echo site_url("lap_neraca/cetak/?tgl_dari=' + tgl_dari + '&tgl_samp=' + tgl_samp + '"); ?>');
	if (win) {
		win.focus();
	} else {
		alert('Popup jangan di block');
	}	
}

</script>
