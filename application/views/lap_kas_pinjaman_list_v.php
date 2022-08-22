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
	if(isset($_GET['tgl_dari']) && isset($_GET['tgl_samp'])) {
		$tgl_dari = $_GET['tgl_dari'];
		$tgl_samp = $_GET['tgl_samp'];
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
		<h3 class="card-title">Cetak Data Pinjaman</h3>
		<div class="card-tools pull-right">
			<button class="btn btn-primary btn-sm" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
	</div>
	<div class="card-body">
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
<div class="card card-primary">
<div class="card-body">
<p></p>
<p style="text-align:center; font-size: 15pt; font-weight: bold;"> Laporan Pinjaman Periode <?php echo $tgl_periode_txt; ?></p>
		<table width="20%">
		<tr>
			<td> Jumlah Peminjam </td>
			<td> : </td>
			<td> <?php echo $peminjam_aktif;?> </td>
		</tr>
		<tr>
			<td> Peminjam Lunas </td>
			<td> : </td>
			<td> <?php echo $peminjam_lunas;?> </td>
		</tr>
		<tr>
			<td> Pinjaman Belum Lunas </td>
			<td> : </td>
			<td> <?php echo $peminjam_belum;?> </td>
		</tr>
		</table>	
<p></p>
<table  class="table table-bordered">
	<tr class="header_kolom">
		<th style="width:5%; vertical-align: middle; text-align:center" > No. </th>
		<th style="width:35%; vertical-align: middle; text-align:center">Keterangan </th>
		<th style="width:20%; vertical-align: middle; text-align:center"> Jumlah  </th>
	</tr>
	<tr>
		<td class="h_tengah"> 1 </td>
		<td> Pokok Pinjaman</td>
		<td class="h_kanan"><?php echo number_format(nsi_round($jml_pinjaman->jml_total)); ?></td>
	</tr>
	<tr>
		<td class="h_tengah"> 2 </td>
		<td> Tagihan Pinjaman</td>
		<td class="h_kanan"><?php echo number_format(nsi_round($jml_tagihan->jml_total)); ?></td>
	</tr>
	<tr>
		<td class="h_tengah"> 3 </td>
		<td> Tagihan Denda </td>
		<td class="h_kanan"><?php echo number_format(nsi_round($jml_denda->total_denda)); ?></td>
	</tr>
	<tr class="header_kolom">
		<td class="h_tengah">  </td>
		<td> Jumlah Tagihan + Denda </td>
		<td class="h_kanan"><?php 
		$tot_tagihan = $jml_tagihan->jml_total + $jml_denda->total_denda;
		echo number_format(nsi_round($tot_tagihan)); ?></td>
	</tr>
	<tr>
		<td class="h_tengah"> 4 </td>
		<td> Tagihan Sudah Dibayar </td>
		<td class="h_kanan"><?php echo number_format(nsi_round($jml_angsuran->jml_total)); ?></td>
	</tr>
	<tr style="background-color: #98FB98 ;">
		<td class="h_tengah"> 5 </td>
		<td> Sisa Tagihan </td>
		<td class="h_kanan"><?php echo number_format(nsi_round($tot_tagihan -$jml_angsuran->jml_total)); ?></td>
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
	window.location.href = '<?php echo site_url("lap_kas_pinjaman"); ?>';
}

function doSearch() {
	var tgl_dari = $('input[name=daterangepicker_start]').val();
	var tgl_samp = $('input[name=daterangepicker_end]').val();
	$('input[name=tgl_dari]').val(tgl_dari);
	$('input[name=tgl_samp]').val(tgl_samp);
	$('#fmCari').attr('action', '<?php echo site_url('lap_kas_pinjaman'); ?>');
	$('#fmCari').submit();	
}

function cetak () {
	var tgl_dari = $('input[name=daterangepicker_start]').val();
	var tgl_samp = $('input[name=daterangepicker_end]').val();
	//$('input[name=tgl_dari]').val(tgl_dari);
	//$('input[name=tgl_samp]').val(tgl_samp);
	//$('#fmCari').attr('action', '<?php echo site_url('lap_kas_pinjaman/cetak'); ?>');
	//$('#fmCari').submit();

	var win = window.open('<?php echo site_url("lap_kas_pinjaman/cetak/?tgl_dari=' + tgl_dari + '&tgl_samp=' + tgl_samp + '"); ?>');
	if (win) {
		win.focus();
	} else {
		alert('Popup jangan di block');
	}
}
</script>