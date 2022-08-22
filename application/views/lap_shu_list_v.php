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
		<h3 class="card-title">Cetak Laporan SHU</h3>
		<div class="card-tools pull-right">
			<button class="btn btn-primary btn-sm" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
	</div>
	<div class="card-body">
		<form id="fmCari" method="POST">
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
				<td> Pilih ID Anggota </td>
				<td>
					<input id="anggota_id" name="anggota_id" style="width:200px; height:25px" class="">
				</td>	
				<td>
					<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="false" onclick="cetak()">Cetak Laporan</a>

					<a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-clear" plain="false" onclick="clearSearch()">Hapus Filter</a>
				</td>
			</tr>
		</table>

	</div>
</div>

<div class="card card-primary">
	<div class="card-body">
		<p></p>
		<p style="text-align:center; font-size: 15pt; font-weight: bold;"> Laporan Pembagian SHU Periode <?php echo $tgl_periode_txt; ?></p>

		<?php 

		$sd_dibayar = $jml_angsuran->jml_total;
		$pinjaman = $jml_pinjaman->jml_total; 
		$laba_pinjaman = $sd_dibayar - $pinjaman;

		$jml_dapat = 0;
		foreach ($data_dapat as $row) {
			$jml_akun = $this->lap_laba_m->get_jml_akun($row->id);
			$jumlah = $jml_akun->jum_debet + $jml_akun->jum_kredit;
			$jml_dapat += $jumlah;
		}

		$jml_beban = 0;
		foreach ($data_biaya as $rows) {
			$jml_akun = $this->lap_laba_m->get_jml_akun($rows->id);
			$jumlah = $jml_akun->jum_debet + $jml_akun->jum_kredit;
			$jml_beban += $jumlah;
		}
		$jml_pendaptan = $laba_pinjaman + $jml_dapat;

		$shu_belum = $jml_pendaptan - $jml_beban;

		$jml_sp = $this->lap_shu_m->jml_simpanan();
		$jml_simpanan = $jml_sp->total;
		$jml_pn = $this->lap_shu_m->jml_penarikan();
		$jml_penarikan = $jml_pn->total;

		//ambil pajak 
		$opsi_val_arr = $this->lap_shu_m->get_key_val();
		foreach ($opsi_val_arr as $key => $value) {
			$out[$key] = $value;
		}
		$pajak = $shu_belum * $out['pjk_pph'] /100;
		$shu_stl_pajak = $shu_belum - $pajak;

		$jml_cadangan = $out['dana_cadangan'] * $shu_stl_pajak/100; 
		$jml_jasa_anggota = $out['jasa_anggota'] * $shu_stl_pajak/100; 
		$jml_dn_pengurus = $out['dana_pengurus'] * $shu_stl_pajak/100; 
		$jml_dn_karyawan = $out['dana_karyawan'] * $shu_stl_pajak/100; 
		$jml_dn_pend = $out['dana_pend'] * $shu_stl_pajak/100; 
		$jml_dn_sos = $out['dana_sosial'] * $shu_stl_pajak/100; 

		$jml_tot_simpanan = $jml_simpanan - $jml_penarikan;

		$jml_js_modal = $out['jasa_modal'] * $jml_jasa_anggota/100; 
		$jml_js_usaha = $out['jasa_usaha'] * $jml_jasa_anggota/100; 
		?>

		<table width="100%" cellspacing="0" cellpadding="3">
			<tr class="header_kolom">
				<td class="h_kiri" colspan="2">SHU Sebelum Pajak</td>
				<td class="h_kanan"><?php echo number_format(nsi_round($shu_belum)) ?>
				</td>
			</tr>
			<tr class="header_kolom">
				<td class="h_kiri" colspan="2"> Pajak PPh (<?php echo $out['pjk_pph'] ?>%) </td>
				<td class="h_kanan"><?php echo number_format($pajak) ?></td>
			</tr>
			<tr class="header_kolom">
				<td class="h_kiri" colspan="2">SHU Setelah Pajak</td>
				<td class="h_kanan"><?php echo number_format(nsi_round($shu_stl_pajak)) ?>
				</td>
			</tr>
			<tr>
				<td colspan="3"><strong>PEMBAGIAN SHU UNTUK DANA-DANA</strong></td>
			</tr>
			<tr>
				<td>Dana Cadangan</td>
				<td class="h_kanan"><?php echo $out['dana_cadangan'] ?> % </td>
				<td class="h_kanan"> <?php echo number_format($jml_cadangan) ?></td>
			</tr>
			<tr>
				<td>Jasa Anggota</td>
				<td class="h_kanan"> <?php echo $out['jasa_anggota'] ?> %</td>
				<td class="h_kanan"> <?php echo number_format($jml_jasa_anggota) ?></td>
			</tr>
			<tr>
				<td>Dana Pengurus</td>
				<td class="h_kanan"><?php echo $out['dana_pengurus'] ?> %</td>
				<td class="h_kanan"><?php echo number_format($jml_dn_pengurus) ?></td>
			</tr>
			<tr>
				<td>Dana Karyawan</td>
				<td class="h_kanan"><?php echo $out['dana_karyawan'] ?> %</td>
				<td class="h_kanan"><?php echo number_format($jml_dn_karyawan) ?></td>
			</tr>
			<tr>
				<td>Dana Pendidikan</td>
				<td class="h_kanan"><?php echo $out['dana_pend'] ?> %</td>
				<td class="h_kanan"><?php echo number_format($jml_dn_pend) ?> </td>
			</tr>
			<tr>
				<td>Dana Sosial</td>
				<td class="h_kanan"> <?php echo $out['dana_sosial'] ?> %</td>
				<td class="h_kanan"><?php echo number_format($jml_dn_sos) ?> </td>
			</tr>
			<tr>
				<td colspan="2"><strong>PEMBAGIAN SHU ANGGOTA</strong></td>
			</tr>

			<tr>
				<td>Jasa Usaha</td>
				<td class="h_kanan"><?php echo $out['jasa_usaha'] ?> %</td>
				<td class="h_kanan"><?php echo number_format(nsi_round($jml_js_usaha)) ?>
					<input type="hidden" id="js_usaha" name="js_usaha" value="<?php echo $jml_js_usaha ?>">
				</td>
			</tr>
			<tr>
				<tr>
					<td>Jasa Modal</td>
					<td class="h_kanan"><?php echo $out['jasa_modal'] ?> %</td>
					<td class="h_kanan"><?php echo number_format(nsi_round($jml_js_modal)) ?>
						<input type="hidden" id="js_modal" name="js_modal" value="<?php echo $jml_js_modal ?>">
					</td>
				</tr>
				<td>Total Pendapatan Anggota</td>
				<td colspan="2" class="h_kanan"><?php echo number_format(nsi_round($laba_pinjaman)) ?>
					<input type="hidden" id="tot_pendpatan" name="tot_pendpatan" value="<?php echo $laba_pinjaman ?>">
				</td>
			</tr>
			<tr>
				<td>Total Simpanan Anggota</td>
				<td colspan="2" class="h_kanan"><?php echo number_format(nsi_round($jml_tot_simpanan)) ?>
					<input type="hidden" id="tot_simpanan" name="tot_simpanan" value="<?php echo $jml_tot_simpanan ?>">
				</td>
			</tr>
		</table>
	</div>
</div>
</form>

<script type="text/javascript">
	$(document).ready(function() {
		$('#anggota_id').combogrid({
			panelWidth:300,
			url: '<?php echo site_url('lap_shu_anggota/list_anggota'); ?>' ,
			idField:'id',
			valueField:'id',
			textField:'id_nama',
			mode:'remote',
			fitColumns:true,
			columns:[[
			{field:'photo',title:'Photo',align:'center',width:5},
			{field:'id',title:'ID', hidden: true},
			{field:'id_nama', title:'IDNama', hidden: true},
			{field:'kode_anggota', title:'ID', align:'center', width:15},
			{field:'nama',title:'Nama Anggota',align:'left',width:20}
			]],
			onChange:function(value) {
			//doSearch();
		}
	});
		<?php if(isset($_POST['anggota_id'])) { ?>
			$('#anggota_id').combogrid('setValue', '<?php echo $_POST['anggota_id']; ?>');
			<?php } ?>

			fm_filter_tgl();

	//doSearch();
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
		window.location.href = '<?php echo site_url("lap_shu"); ?>';
	}

	function doSearch() {
		var tgl_dari = $('input[name=daterangepicker_start]').val();
		var tgl_samp = $('input[name=daterangepicker_end]').val();
		$('input[name=tgl_dari]').val(tgl_dari);
		$('input[name=tgl_samp]').val(tgl_samp);
		$('#fmCari').attr('action', '<?php echo site_url('lap_shu'); ?>');
		$('#fmCari').submit();
	}

	function cetak () {	
		<?php 
		if(isset($_GET['anggota_id'])) {
			echo 'var anggota_id = "'.$_GET['anggota_id'].'";';
		} else {
			echo 'var anggota_id = $("input[name=anggota_id]").val();';
		}
		?>

		var tgl_dari = $('input[name=daterangepicker_start]').val();
		var tgl_samp = $('input[name=daterangepicker_end]').val();
		var js_modal = $('#js_modal').val();
		var js_usaha = $('#js_usaha').val();
		var tot_pendpatan = $('#tot_pendpatan').val();
		var tot_simpanan = $('#tot_simpanan').val();

		$('input[name=tgl_dari]').val(tgl_dari);
		$('input[name=tgl_samp]').val(tgl_samp);

		var win = window.open('<?php echo site_url("lap_shu_anggota/cetak_laporan/?anggota_id=' + anggota_id + '&tgl_dari='+ tgl_dari +'&tgl_samp='+ tgl_samp +'&js_modal='+ js_modal +'&js_usaha='+ js_usaha +'&tot_pendpatan='+ tot_pendpatan +'&tot_simpanan='+ tot_simpanan +'"); ?>');
		if (win) {
			win.focus();
		} else {
			alert('Popup jangan di block');
		}

	//$('#fmCari').attr('action', '<?php echo site_url('lap_shu_anggota/cetak_laporan'); ?>');
	//$('#fmCari').submit();
}
</script>