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
		<h3 class="card-title">Cetak Data Transaksi Kas</h3>
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
							<div id="filter_kas" class="input-group" style="display: inline;">
							    <select id = "opt_kas" name = "opt_kas" onchange = "doSearch()">
							        <option value = "all" >Semua</option>
							        <?php
							        foreach($ops_kas as $row){
							            if($_GET['opt_kas'] == $row->id){
							            ?>
							            <option value = "<?= $row->id ?>" selected ><?= $row->nama ?></option>
							            <?php 
							            }else{
							            ?>
							            <option value = "<?= $row->id ?>" ><?= $row->nama ?></option>
							            <?php  
							                
							            }
							        }
							        ?>
							    </select>
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
	<p style="text-align:center; font-size: 15pt; font-weight: bold;"> Laporan Transkasi Kas Periode <?php echo $tgl_periode_txt; ?></p>
	<table  class="table table-bordered">
		<tr class="header_kolom">
			<th class="h_tengah" style="width:5%; vertical-align: middle " > No. </th>
			<th class="h_tengah" style="width:8%; vertical-align: middle"> Kode <br>Transaksi</th>
			<th class="h_tengah" style="width:8%; vertical-align: middle"> Tanggal Transaksi</th>
			<th class="h_tengah" style="width:29%; vertical-align: middle"> Akun Transaksi </th>
			<th class="h_tengah" style="width:10%; vertical-align: middle"> Dari Kas  </th>
			<th class="h_tengah" style="width:10%; vertical-align: middle"> Untuk Kas  </th>
			<th class="h_tengah" style="width:10%; vertical-align: middle"> Debet </th>
			<th class="h_tengah" style="width:10%; vertical-align: middle"> Kredit </th>
			<th class="h_tengah" style="width:10%; vertical-align: middle"> Saldo  </th>
		</tr>

	<?php 
	$no = $offset + 1;
	echo '
		<tr bgcolor="#FFFFEE">
				<td class="h_kanan" colspan="7"> <strong>SALDO SEBELUMNYA</strong></td>
				<td class="h_kanan" colspan="3"><strong>'.number_format(nsi_round($saldo_awal + $saldo_sblm)).'</strong></td>
		</tr>';
	$saldo = $saldo_awal + $saldo_sblm;
	foreach ($data_kas as $row) {
		$saldo += ($row->debet - $row->kredit);

		if(($no % 2) == 0) {
			$warna="#EEEEEE"; } 
		else {
			$warna="#FFFFFF"; }

		$tgl = explode(' ', $row->tgl);
		
		$txt_tanggal = jin_date_ina($tgl[0],'p');
		$dari_kas = $this->lap_trans_kas_m->get_nama_kas_id($row->dari_kas);
		$untuk_kas = $this->lap_trans_kas_m->get_nama_kas_id($row->untuk_kas);
		switch ($row->tbl) {
			case 'A':	$kode = 'TPJ';
			break;

			case 'B':	$kode = 'TBY';
			break;
			
			case 'C':
				if($row->dari_kas == NULL) {
					$kode = 'TRD';
				} else {
					$kode = 'TRK';
				}
			break;
			
			case 'D':
				$kode = 'TRF';
				if($row->dari_kas == NULL) {
					$kode = 'TKD';
				}
				if($row->untuk_kas == NULL) {
					$kode = 'TKK';
				}
			break;
			
			default:
				$kode = '';
			break;
		}

		if ($row->dari_kas == NULL){
			$dari_kas = '-'; } 
		else {
			$dari_kas = $dari_kas->nama; }

		if ($row->untuk_kas == NULL){
			$untuk_kas = '-'; } 
		else {
			$untuk_kas = $untuk_kas->nama; }

		$nm_akun = $this->lap_trans_kas_m->get_nama_akun_id($row->transaksi);
		echo '
			<tr bgcolor='.$warna.'>
					<td class="h_tengah" style="vertical-align:middle">'.$no++.'</td>
					<td class="h_tengah" style="vertical-align:middle"> '.$kode.sprintf('%05d', $row->id).'</td>
					<td class="h_tengah" style="vertical-align:middle"> '.$txt_tanggal.'</td>
					<td class="h_kiri" style="vertical-align:middle"> '.@$nm_akun->jns_trans.' <br><code>'.$row->ket.'</code></td>
					<td class="h_kiri" style="vertical-align:middle"> '.$dari_kas.'</td>
					<td class="h_kiri" style="vertical-align:middle"> '.$untuk_kas.'</td>
					<td class="h_kanan" style="vertical-align:middle"> '.number_format(nsi_round($row->debet)).' </td>
					<td class="h_kanan" style="vertical-align:middle"> '.number_format(nsi_round($row->kredit)).'</td>
					<td class="h_kanan" style="vertical-align:middle"> '.number_format(nsi_round($saldo)).' </td>
			</tr>';
	}
	echo '</table>
	<div class="card-footer">'.$halaman.'</div>';
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
	window.location.href = '<?php echo site_url("lap_trans_kas"); ?>';
}

function doSearch() {
	var tgl_dari = $('input[name=daterangepicker_start]').val();
	var tgl_samp = $('input[name=daterangepicker_end]').val();
	var opt_kas = $('#opt_kas').val();
	$('input[name=tgl_dari]').val(tgl_dari);
	$('input[name=tgl_samp]').val(tgl_samp);
	$('#fmCari').attr('action', '<?php echo site_url('lap_trans_kas'); ?>');
	$('#fmCari').submit();	
}

function cetak () {
	var tgl_dari = $('input[name=daterangepicker_start]').val();
	var tgl_samp = $('input[name=daterangepicker_end]').val();
	var opt_kas = $('#opt_kas').val();
	var t;
	//$('input[name=tgl_dari]').val(tgl_dari);
	//$('input[name=tgl_samp]').val(tgl_samp);
	//$('#fmCari').attr('action', '<?php echo site_url('lap_trans_kas/cetak'); ?>');
	//$('#fmCari').submit();

	var win = window.open('<?php echo site_url("lap_trans_kas/cetak/?tgl_dari=' + tgl_dari + '&tgl_samp=' + tgl_samp + '&opt_kas=' + opt_kas"); ?>);
	if (win) {
		win.focus();
	} else {
		alert('Popup jangan di block');
	}

}
</script>