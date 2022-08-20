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
		box-sizing: border-box;
	}
	.glyphicon	{font-family: "Glyphicons Halflings"}

	.form-control {
		height: 20px;
		padding: 4px;
	}	
</style>

<?php
if(isset($_REQUEST['periode'])) {
	//echo $_REQUEST['periode'];
	$tanggal = $_REQUEST['periode'];
} else {
	$tanggal = date('Y-m');
}

$txt_periode_arr = explode('-', $tanggal);
	if(is_array($txt_periode_arr)) {
		$txt_periode = jin_nama_bulan($txt_periode_arr[1]) . ' ' . $txt_periode_arr[0];
	}
?>

<div class="box box-solid box-primary">
	<div class="box-header">
		<h3 class="box-title">Laporan Saldo Kas</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-primary btn-sm" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
	</div>
	<div class="box-body">
	<div>
		<table>
			<tr>
				<td>
					<div class="input-group date dtpicker col-md-5" data-date="<?php echo $tanggal; ?>">
						<input id="txt_periode" style="width: 125px; text-align: center;" class="form-control" type="text" value="<?php echo $txt_periode;?>" readonly />
						<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
					</div>
					<form id="fmCari">
						<input type="hidden" name="periode" id="periode" value="<?php echo $tanggal; ?>" />
					</form>
				</td>
				<td>
					<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="false" onclick="cetak()">Cetak Laporan</a>

					<a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-clear" plain="false" onclick="clearSearch()">Hapus Filter</a>
				</td>
			</tr>
		</table>
</div>
</div>
</div>

<div class="box box-primary">
<div class="box-body">
<p></p>
<p style="text-align:center; font-size: 15pt; font-weight: bold;"> Laporan Saldo Kas Periode <?php echo $txt_periode; ?></p>
	<table  class="table table-bordered">
		<tr class="header_kolom">
			<th style="width:5%; vertical-align: middle; text-align:center" > No. </th>
			<th style="width:35%; vertical-align: middle; text-align:center">Nama Kas </th>
			<th style="width:20%; vertical-align: middle; text-align:center"> Saldo  </th>
		</tr>
		<tr>
				<td class="h_kanan" colspan="2"><strong> SALDO PERIODE SEBELUMNYA </strong></td>
				<td class="h_kanan"><strong> <?php echo number_format(nsi_round($saldo_sblm)) ?></strong></td>
		</tr>

	<?php

	//$no = 1;
	$no = $offset + 1;

	$kas_arr = array();
	$debet_total = 0; 
	$kredit_total = 0; 
	$saldo_total = 0; 
	foreach ($data_jns_kas as $jenis) {
	
	//Apabila sisa baginya genap,
	if(($no % 2) == 0) {
	$warna="#EEEEEE";
	}
	//Apabila sisa baginya tidak genap, 
	else {
	$warna="#FFFFFF";
	}

	$kas_arr[$jenis->id] = $jenis->nama;
	$nilai_debet = $this->lap_saldo_m->get_jml_debet($jenis->id);
	$nilai_kredit = $this->lap_saldo_m->get_jml_kredit($jenis->id);

	$debet_row = $nilai_debet->jml_total; 
	$kredit_row = $nilai_kredit->jml_total;
	$saldo_row = $debet_row - $kredit_row; 

	$saldo_total += $saldo_row;

	echo'
	<tr>
		<td class="h_tengah">'.$no++.'</td>
		<td>'.$jenis->nama.'</td>
		<td class="h_kanan">'. number_format(nsi_round($saldo_row)).'</td>
	</tr>
		';
	}
	echo '<tr class="header_kolom">
				<td colspan="2" class="h_kanan"><strong>Jumlah </strong></td>
				<td class="h_kanan"><strong>'.number_format(nsi_round($saldo_total)).'</strong></td>
			</tr>
			<tr class="header_kolom" style="background-color: #98FB98;">
				<td colspan="2" class="h_kanan"><strong> Saldo </strong></td>
				<td class="h_kanan"><strong>'.number_format(nsi_round($saldo_total + $saldo_sblm)).'</strong></td>
			
			</tr>';
echo '</table>';
echo $halaman;
?>
</div>
</div>
	
<script type="text/javascript">
$(document).ready(function() {

	$(".dtpicker").datetimepicker({
		language:  'id',
		weekStart: 1,
		autoclose: true,
		todayBtn: true,
		todayHighlight: true,
		pickerPosition: 'bottom-right',
		format: "MM yyyy",
		linkField: "periode",
		linkFormat: "yyyy-mm",
		startView: 3,
		minView: 3
	}).on('changeDate', function(ev){
		doSearch();
	});

}); // ready

function doSearch() {
	$('#fmCari').attr('action', '<?php echo site_url('lap_saldo'); ?>');
	$('#fmCari').submit();
}

function clearSearch(){
	window.location.href = '<?php echo site_url("lap_saldo"); ?>';
}

function cetak () {
	//$('#fmCari').attr('action', '<?php echo site_url('lap_saldo/cetak'); ?>');
	//$('#fmCari').submit();

	var periode 	= $('#periode').val();
	var win = window.open('<?php echo site_url("lap_saldo/cetak/?periode=' + periode + '"); ?>');
	if (win) {
		win.focus();
	} else {
		alert('Popup jangan di block');
	}

}

</script>

