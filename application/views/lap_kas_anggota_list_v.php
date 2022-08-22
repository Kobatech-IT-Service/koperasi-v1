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

<div class="card card-solid card-primary">
	<div class="card-header">
		<h3 class="card-title">Cetak Data Kas Anggota</h3>
		<div class="card-tools pull-right">
			<button class="btn btn-primary btn-sm" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
	</div>
	<div class="card-body">
		<table>
			<tr>
				<td> Pilih ID Anggota </td>
				<td>
					<form id="fmCari">
					 <input id="anggota_id" name="anggota_id" value="" style="width:200px; height:25px" class="">
					 </form>
				</td>	
				<td>
					<a href="javascript:void(0);" id="btn_filter" class="easyui-linkbutton" iconCls="icon-search" plain="false" onclick="doSearch()">Lihat Laporan</a>
					<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="false" onclick="cetak()">Cetak Laporan</a>
					<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="false" onclick="cetak2()">Cetak Laporan Ringkas</a>
					
					<a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-clear" plain="false" onclick="clearSearch()">Hapus Filter</a>
				</tr>
			</table>
		</div>
</div>

<div class="card card-primary">
	<div class="card-body">
	<p></p>
	<p style="text-align:center; font-size: 15pt; font-weight: bold;"> Laporan Data Kas Per Anggota </p>
	<table  class="table table-bordered">
		<tr class="header_kolom">
			<th style="width:5%; vertical-align: middle; text-align:center" > No. </th>
			<th style="width:5%; vertical-align: middle; text-align:center">Photo</th>
			<th style="width:25%; vertical-align: middle; text-align:center"> Identitas  </th>
			<th style="width:20%; vertical-align: middle; text-align:center">Saldo Simpanan</th>
			<th style="width:20%; vertical-align: middle; text-align:center"> Tagihan Kredit </th>
			<th style="width:23%; vertical-align: middle; text-align:center"> Keterangan </th>
		</tr>
	<?php
	
	$no = $offset + 1;
	$mulai=1;
	if (!empty($data_anggota)) {

		foreach ($data_anggota as $row) {
		if(($no % 2) == 0) {
			$warna="#EEEEEE"; } 
		else {
			$warna="#FFFFFF";}

		//pinjaman
		$pinjaman = $this->lap_kas_anggota_m->get_data_pinjam($row->id);
		$pinjam_id = @$pinjaman->id;
		$anggota_id = @$pinjaman->anggota_id;

		$jml_pj = $this->lap_kas_anggota_m->get_jml_pinjaman($anggota_id);
		$pj_anggota= @$jml_pj->total;

		//denda
		$denda = $this->lap_kas_anggota_m->get_jml_denda($pinjam_id);
		$tagihan= @$pinjaman->tagihan + $denda->total_denda;
		//dibayar
		$dibayar = $this->lap_kas_anggota_m->get_jml_bayar($pinjam_id);
		$sisa_tagihan = $tagihan - $dibayar->total;

		$peminjam_tot = $this->lap_kas_anggota_m->get_peminjam_tot($row->id);
		$peminjam_lunas = $this->lap_kas_anggota_m->get_peminjam_lunas($row->id);

		$tgl_tempo = explode(' ', @$pinjaman->tempo);
		$tgl_tempo_txt = jin_date_ina($tgl_tempo[0],'p');
		$tgl_tempo_r = $tgl_tempo[0];

		$tgl_tempo_rr = explode('-', $tgl_tempo_r);
		$thn = $tgl_tempo_rr[0];
		$bln = @$tgl_tempo_rr[1];

		if ((@$pinjaman->lunas == 'Belum') && (date('m') > $bln )) {
			$data = 'Macet';
		} else {
			$data = 'Lancar';
		}

		//photo
		$photo_w = 3 * 20;
		$photo_h = 4 * 20;
		if($row->file_pic == '') {
			$photo ='<img src="'.base_url().'assets/theme_admin/img/photo.jpg" alt="default" width="'.$photo_w.'" height="'.$photo_h.'" />';
		} else {
			$photo= '<img src="'.base_url().'uploads/anggota/' . $row->file_pic . '" alt="Foto" width="'.$photo_w.'" height="'.$photo_h.'" />';
		}

		//jk
		if ($row->jk == "L") {
			$jk="Laki-Laki";
		} else {
			$jk="Perempuan"; 
		}

		//jabatan
		if ($row->jabatan_id == "1") {
			$jabatan="Pengurus";
		} else {
			$jabatan="Anggota"; 
		}
		// AG'.sprintf('%04d', $row->id).'
	 	echo '
			<tr bgcolor='.$warna.' >
				<td class="h_tengah" style="vertical-align: middle "> '.$no++.' </td>
				<td class="h_tengah" style="vertical-align: middle "> '.$photo.'</td>
				<td> 
					<table>
						<tr><td> ID Anggota : '.$row->identitas.'</td></tr>
						<tr><td> Nama : <b>'.strtoupper($row->nama).'</b> </td></tr>
						<tr><td> Jenis Kelamin : '.$jk.' </td></tr>
						<tr><td> Jabatan : '.$jabatan.' - '.$row->departement.'</td></tr>
						<tr><td> Alamat  : '.$row->alamat.' Telp.'.$row->notelp.' </td></tr>
					</table>
				</td>
				<td>';
				$simpanan_arr = array();
				$simpanan_row_total = 0; 
				$simpanan_total = 0; 
				foreach ($data_jns_simpanan as $jenis) {
					$simpanan_arr[$jenis->id] = $jenis->jns_simpan;
					$nilai_s = $this->lap_kas_anggota_m->get_jml_simpanan($jenis->id, $row->id);
					$nilai_p = $this->lap_kas_anggota_m->get_jml_penarikan($jenis->id, $row->id);
					
					$simpanan_row=$nilai_s->jml_total - $nilai_p->jml_total;
					$simpanan_row_total += $simpanan_row;
					$simpanan_total += $simpanan_row_total;

					echo'<table style="width:100%;">
							<tr>
								<td>'.$jenis->jns_simpan.'</td>
								<td class="h_kanan">'. number_format($simpanan_row).'</td>
							</tr>';
					}
					echo '<tr>
								<td><strong> Jumlah Simpanan </strong></td>
								<td class="h_kanan"><strong> '.number_format($simpanan_row_total).'</strong></td>
							</tr>
							</table>';
					echo '		
					<td>
						<table style="width:100%;"> 
							<tr>
								<td> Pokok Pinjaman</td>
								<td class="h_kanan">'.number_format(@nsi_round($pinjaman->jumlah)).'</td>
							</tr>
							<tr>
								<td> Tagihan + Denda </td> 
								<td class="h_kanan"> '.number_format(nsi_round($tagihan)).' </td>
							</tr>
							<tr>
								<td> Dibayar </td>
								<td class="h_kanan"> '.number_format(nsi_round($dibayar->total)).'</td>
							</tr>
							<tr>
								<td><strong> Sisa Tagihan</strong></td>
								<td class="h_kanan"> <strong>'.number_format(nsi_round($sisa_tagihan)).'</strong></td>
							</tr>
						</table>
					</td>
					<td> 
						<table style="width:100%;"> 
							<tr>
								<td> Jumlah Pinjaman </td>
								<td class="h_kanan">'.$peminjam_tot.'</td>
							</tr>
							<tr>
								<td> Pinjaman Lunas </td>
								<td class="h_kanan">'.$peminjam_lunas.'</td>
							</tr>
							<tr>
								<td> Pembayaran</td>
								<td class="h_kanan"> <code>'.$data.'</code></td>
							</tr>
							<tr>
								<td> Tanggal Tempo</td>
								<td class="h_kanan"> <code>'.$tgl_tempo_txt.'</code></td>
							</tr>
						</table>
					</td>
				</tr>';
			}
		echo '</table>
		<div class="card-footer">'.$halaman.'</div>';
	} else {
		echo '<tr>
					<td colspan="9" >
						<code> Tidak Ada Data <br> </code>
					</td>
				</tr>';
			}
	?>
</div>
</div>
	
<script type="text/javascript">
	$(document).ready(function() {

	<?php 
		if(isset($_GET['anggota_id'])) {
			echo 'var anggota_id = "'.$_GET['anggota_id'].'";';
		} else {
			echo 'var anggota_id = "";';
		}
		echo '$("#anggota_id").val(anggota_id);';
	?>

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
			]]
		});




}); // ready

function clearSearch(){
	window.location.href = '<?php echo site_url("lap_kas_anggota"); ?>';
}

function cetak () {
	<?php 
		if(isset($_GET['anggota_id'])) {
			echo 'var anggota_id = "'.$_GET['anggota_id'].'";';
		} else {
			echo 'var anggota_id = $("#anggota_id").val();';
		}
	?>
	var win = window.open('<?php echo site_url("lap_kas_anggota/cetak_laporan/?anggota_id=' + anggota_id +'"); ?>');
	if (win) {
		win.focus();
	} else {
		alert('Popup jangan di block');
	}
	//$('#fmCari').attr('action', '<?php echo site_url('lap_kas_anggota/cetak_laporan'); ?>');
	//$('#fmCari').submit();
}

function cetak2 () {
	<?php 
		if(isset($_GET['anggota_id'])) {
			echo 'var anggota_id = "'.$_GET['anggota_id'].'";';
		} else {
			echo 'var anggota_id = $("#anggota_id").val();';
		}
	?>
	var win = window.open('<?php echo site_url("lap_kas_anggota/cetak_laporan_ringkas/?anggota_id=' + anggota_id +'"); ?>');
	if (win) {
		win.focus();
	} else {
		alert('Popup jangan di block');
	}
	//$('#fmCari').attr('action', '<?php echo site_url('lap_kas_anggota/cetak_laporan_ringkas'); ?>');
	//$('#fmCari').submit();
}

function doSearch() {
	$('#fmCari').submit();
}
</script>