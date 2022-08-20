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
	if(isset($_REQUEST['periode'])) {
		$tanggal = $_REQUEST['periode'];
	} else {
		$tanggal = date('Y-m');
	}

$txt_periode_arr = explode('-', $tanggal);
	if(is_array($txt_periode_arr)) {
		$txt_periode = jin_nama_bulan($txt_periode_arr[1]) . ' ' . $txt_periode_arr[0];
	}
?>

<div class="card card-solid card-primary">
	<div class="card-header">
		<h3 class="card-title">Cetak Laporan Buku Besar</h3>
		<div class="card-tools pull-right">
			<button class="btn btn-primary btn-sm" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
	</div>
	<div class="card-body">
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

<div class="card card-primary">
<div class="card-body">
<p></p>
<p style="text-align:center; font-size: 15pt; font-weight: bold;"> Laporan Buku Besar Periode <?php echo $txt_periode; ?></p>

<?php
$total_saldo = 0;
foreach ($nama_kas as $key) {
	$transD = $this->lap_buku_besar_m->get_transaksi_kas($key->id);

	echo '<h3>'.$key->nama.'</h3>';
	echo '<table  class="table table-bordered">
				<tr class="header_kolom">
					<th class="h_tengah" style="width:5%; vertical-align: middle "> No</th>
					<th class="h_tengah" style="width:10%; vertical-align: middle "> Tanggal </th>
					<th class="h_tengah" style="width:20%; vertical-align: middle "> Jenis Transaksi</th>
					<th class="h_tengah" style="width:45%; vertical-align: middle "> Keterangan </th>
					<th class="h_tengah" style="width:10%; vertical-align: middle "> Debet </th>
					<th class="h_tengah" style="width:10%; vertical-align: middle "> Kredit </th>
					<th class="h_tengah" style="width:10%; vertical-align: middle "> Saldo </th>
				</tr>';
	$jmlD = 0;
	$jmlk = 0;
	$no = 1;
	$saldo = 0;
	foreach ($transD as $rows) {
		$nm_akun = $this->lap_buku_besar_m->get_nama_akun_id($rows->transaksi);
		$tglD = explode(' ', $rows->tgl);
		$txt_tanggalD = jin_date_ina($tglD[0],'p');

		if($rows->dari_kas == $key->id) {
			$jmlk += $rows->kredit;
			$rows->debet = 0;
		}
		if($rows->untuk_kas == $key->id) {
			$jmlD += $rows->debet;
			$rows->kredit = 0;
		}
		$saldo = $jmlD - $jmlk;
		echo '<tr>
					<td class="h_tengah"> '.$no++.' </td>
					<td class="h_tengah"> '.$txt_tanggalD.' </td>
					<td> '.@$nm_akun->jns_trans.'</td>
					<td> '.$rows->ket.'</td>
					<td class="h_kanan"> '.number_format(nsi_round($rows->debet)).' </td>
					<td class="h_kanan"> '.number_format(nsi_round($rows->kredit)).' </td>
					<td class="h_kanan"> '.number_format(nsi_round($saldo )).' </td>
				</tr>';
	}
	$total_saldo += $saldo;
		echo '</table>';
	}
	echo '<br><table  class="table table-bordered">
				<tr class="header_kolom">
					<td class="h_kanan">TOTAL SALDO KAS BANK</td>
					<td class="h_kanan">'.number_format(nsi_round($total_saldo)).'</td>
					
				</tr>
			</table>
	';
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
	$('#fmCari').attr('action', '<?php echo site_url('lap_buku_besar'); ?>');
	$('#fmCari').submit();
}

function clearSearch(){
	window.location.href = '<?php echo site_url("lap_buku_besar"); ?>';
}

function cetak () {
	//$('#fmCari').attr('action', '<?php echo site_url('lap_buku_besar/cetak'); ?>');
	//$('#fmCari').submit();
	var periode 	= $('#periode').val();
	var win = window.open('<?php echo site_url("lap_buku_besar/cetak/?periode=' + periode + '"); ?>');
	if (win) {
		win.focus();
	} else {
		alert('Popup jangan di block');
	}

}
</script>