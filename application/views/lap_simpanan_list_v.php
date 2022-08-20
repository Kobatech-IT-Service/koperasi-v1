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
		<h3 class="card-title">Cetak Data Simpanan</h3>
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

<div class="card card-primary">
<div class="card-body">
<p></p>
<p style="text-align:center; font-size: 15pt; font-weight: bold;"> Laporan Simpanan Anggota <br> Periode <?php echo $tgl_periode_txt; ?> </p>

<table  class="table table-bordered">
	<tr class="header_kolom">
		<th style="width:5%; vertical-align: middle; text-align:center" > No. </th>
		<th style="width:35%; vertical-align: middle; text-align:center">Jenis Akun </th>
		<th style="width:20%; vertical-align: middle; text-align:center"> Simpanan  </th>
		<th style="width:20%; vertical-align: middle; text-align:center"> Penarikan  </th>
		<th style="width:20%; vertical-align: middle; text-align:center"> Jumlah  </th>
	</tr>
	<?php

	$no = $offset + 1;
	$mulai=1;
	$simpanan_arr = array();
	$simpanan_row_total = 0; 
	$simpanan_total = 0; 
	$penarikan_total = 0;

	foreach ($data_jns_simpanan as $jenis) {
	if(($no % 2) == 0) {
		$warna="#FFFFCC"; } 
	else {
		$warna="#FFFFFF"; }

	$simpanan_arr[$jenis->id] = $jenis->jns_simpan;
	$nilai_s = $this->lap_simpanan_m->get_jml_simpanan($jenis->id);
	$nilai_p = $this->lap_simpanan_m->get_jml_penarikan($jenis->id);
	
	$simpanan_row=$nilai_s->jml_total; 
	$penarikan_row=$nilai_p->jml_total;
	$sub_total = $simpanan_row - $penarikan_row; 

	$simpanan_total += $simpanan_row;
	$penarikan_total += $penarikan_row;
	$simpanan_row_total += $sub_total;

	echo'<tr>
			<td class="h_tengah">'.$no++.'</td>
			<td>'.$jenis->jns_simpan.'</td>
			<td class="h_kanan">'. number_format($simpanan_row).'</td>
			<td class="h_kanan">'. number_format($penarikan_row).'</td>
			<td class="h_kanan">'. number_format($sub_total).'</td>
		</tr>';
	}
	echo '<tr class="header_kolom">
				<td colspan="2" class="h_tengah"><strong>Jumlah Total</strong></td>
				<td class="h_kanan"><strong>'.number_format($simpanan_total).'</strong></td>
				<td class="h_kanan"><strong>'.number_format($penarikan_total).'</strong></td>
				<td class="h_kanan"><strong>'.number_format($simpanan_row_total).'</strong></td>
			</tr>';
	echo '</table>';
	echo $halaman;
?>
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
	window.location.href = '<?php echo site_url("lap_simpanan"); ?>';
}

function doSearch() {
	var tgl_dari = $('input[name=daterangepicker_start]').val();
	var tgl_samp = $('input[name=daterangepicker_end]').val();
	$('input[name=tgl_dari]').val(tgl_dari);
	$('input[name=tgl_samp]').val(tgl_samp);
	$('#fmCari').attr('action', '<?php echo site_url('lap_simpanan'); ?>');
	$('#fmCari').submit();	
}

function cetak () {
	var tgl_dari = $('input[name=daterangepicker_start]').val();
	var tgl_samp = $('input[name=daterangepicker_end]').val();
	//$('input[name=tgl_dari]').val(tgl_dari);
	//$('input[name=tgl_samp]').val(tgl_samp);
	//$('#fmCari').attr('action', '<?php echo site_url('lap_simpanan/cetak'); ?>');
	//$('#fmCari').submit();
	var win = window.open('<?php echo site_url("lap_simpanan/cetak/?tgl_dari=' + tgl_dari + '&tgl_samp=' + tgl_samp + '"); ?>');
	if (win) {
		win.focus();
	} else {
		alert('Popup jangan di block');
	}

}
</script>