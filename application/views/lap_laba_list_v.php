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
		<h3 class="card-title">Cetak Laporan Laba Rugi </h3>
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
<p style="text-align:center; font-size: 15pt; font-weight: bold;"> Laporan Laba Rugi <?php echo $tgl_periode_txt; ?></p>
	
<p></p>

<h3> Estimasi Data Pinjaman </h3>
<table  class="table table-bordered">
	<tr class="header_kolom">
		<th style="width:5%; vertical-align: middle; text-align:center" > No. </th>
		<th style="width:75%; vertical-align: middle; text-align:center">Keterangan </th>
		<th style="width:20%; vertical-align: middle; text-align:center"> Jumlah  </th>
	</tr>
	<tr>
		<td class="h_tengah"> 1 </td>
		<td> Jumlah Pinjaman</td>
		<td class="h_kanan">
			<?php
				$pinjaman = $jml_pinjaman->jml_total; 
				echo ''.number_format(nsi_round($pinjaman)).'<br>';
			?>
		</td>
	</tr>	
	<tr>
		<td class="h_tengah"> 2 </td>
		<td> Pendapatan Biaya Administrasi</td>
		<td class="h_kanan">
			<?php
				$biaya_adm = $jml_biaya_adm->jml_total; 
				echo ''.number_format(nsi_round($biaya_adm)).'<br>';
			?>
		</td>
	</tr>
	<tr>
		<td class="h_tengah"> 3 </td>
		<td> Pendapatan Biaya Bunga</td>
		<td class="h_kanan">
			<?php
				$bunga = $jml_bunga->jml_total; 
				echo ''.number_format(nsi_round($bunga)).'<br>';
			?>
		</td>
	</tr>
	<tr>
		<td class="h_tengah"> 4 </td>
		<td> Pendapatan Biaya Pembulatan</td>
		<td class="h_kanan">
			<?php
				$bulatan = $jml_tagihan->jml_total - ($jml_pinjaman->jml_total + $jml_bunga->jml_total + $jml_biaya_adm->jml_total); 
				echo ''.number_format(nsi_round($bulatan)).'<br>';
			?>
		</td>
	</tr>		
	<tr class="header_kolom">
		<td colspan="2" class="h_kanan"> Jumlah Tagihan</td>
		<td class="h_kanan">
			<?php
				$tagihan = $jml_tagihan->jml_total; 
				echo ''.number_format(nsi_round($tagihan)).'<br>';
			?>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="h_kanan"> <strong>Estimasi Pendapatan Pinjaman</strong></td>
		<td class="h_kanan">
			<?php
				$estimasi = $tagihan - $pinjaman; 
				echo '<strong>'.number_format(nsi_round($estimasi)).'</strong>';
			?>
		</td>
	</tr>

</table>

<h3> Pendapatan </h3>
<table  class="table table-bordered">
	<tr class="header_kolom">
		<th style="width:5%; vertical-align: middle; text-align:center" > No. </th>
		<th style="width:75%; vertical-align: middle; text-align:center">Keterangan </th>
		<th style="width:20%; vertical-align: middle; text-align:center"> Jumlah  </th>
	</tr>
	<tr>
		<td class="h_tengah"> 1 </td>
		<td> Pendapatan Pinjaman</td>
		<td class="h_kanan">
			<?php
				$sd_dibayar = $jml_angsuran->jml_total;
				$laba = $sd_dibayar - $pinjaman;
				echo ''.number_format(nsi_round($laba)).'';
			?>
		</td>
	</tr>

	<?php
	$no_dapat = 2;
	$jml_dapat = 0;
	foreach ($data_dapat as $row) {
		echo '
				<tr>
					<td class="h_tengah"> '.$no_dapat.' </td>
		';
		$jml_akun = $this->lap_laba_m->get_jml_akun($row->id);
		$jumlah = $jml_akun->jum_debet + $jml_akun->jum_kredit;
		echo '<td>'.$row->jns_trans.'</td>
				<td class="h_kanan">'.number_format(nsi_round($jumlah)).'</td>';
		$jml_dapat += $jumlah;
		echo '</tr>';
		$no_dapat++;
	}
	?>
	<tr class="header_kolom">
		<td colspan="2" class="h_kanan"> Jumlah Pendapatan</td>
		<td class="h_kanan"><?php $jml_p = $laba + $jml_dapat;
		echo number_format(nsi_round($jml_p))   ?></td>
	</tr>
</table>

<h3> Biaya-biaya </h3>
<table  class="table table-bordered">
	<tr class="header_kolom">
		<th style="width:5%; vertical-align: middle; text-align:center" > No. </th>
		<th style="width:75%; vertical-align: middle; text-align:center">Keterangan </th>
		<th style="width:20%; vertical-align: middle; text-align:center"> Jumlah  </th>
	</tr>
	<?php 
		$no=1;
		$jml_beban = 0;
		foreach ($data_biaya as $rows) {
			$jml_akun = $this->lap_laba_m->get_jml_akun($rows->id);
			$jumlah = $jml_akun->jum_debet + $jml_akun->jum_kredit;
			$jml_beban += $jumlah;

			echo '<tr>
						<td class="h_tengah">'.$no++.'</td>
						<td>'.$rows->jns_trans.'</td>
						<td class="h_kanan">'.number_format(nsi_round($jumlah)).'</td>
					</tr>';
		}
	?>
			<tr class="header_kolom">
				<td colspan="2" class="h_kanan"> Jumlah Biaya</td>
				<td class="h_kanan"> <?php echo number_format($jml_beban) ?></td>
			</tr>
</table>
<table width="100%">
	<tr class="header_kolom" style="background-color: #98FB98;">
		<td colspan="2" class="h_kanan"> Laba Rugi </td>
		<td class="h_kanan"><?php echo number_format(nsi_round($jml_p - $jml_beban )) ?></td>
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
	window.location.href = '<?php echo site_url("lap_laba"); ?>';
}

function doSearch() {
	var tgl_dari = $('input[name=daterangepicker_start]').val();
	var tgl_samp = $('input[name=daterangepicker_end]').val();
	$('input[name=tgl_dari]').val(tgl_dari);
	$('input[name=tgl_samp]').val(tgl_samp);
	$('#fmCari').attr('action', '<?php echo site_url('lap_laba'); ?>');
	$('#fmCari').submit();	
}

function cetak () {
	var tgl_dari = $('input[name=daterangepicker_start]').val();
	var tgl_samp = $('input[name=daterangepicker_end]').val();
	//$('input[name=tgl_dari]').val(tgl_dari);
	//$('input[name=tgl_samp]').val(tgl_samp);
	//$('#fmCari').attr('action', '<?php echo site_url('lap_laba/cetak'); ?>');
	//$('#fmCari').submit();

	var win = window.open('<?php echo site_url("lap_laba/cetak/?tgl_dari=' + tgl_dari + '&tgl_samp=' + tgl_samp + '"); ?>');
	if (win) {
		win.focus();
	} else {
		alert('Popup jangan di block');
	}
	
}
</script>