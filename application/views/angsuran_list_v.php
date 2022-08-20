<!-- Styler -->
<style type="text/css">

.datagrid-header-row * {
	font-weight: bold;
}
.messager-window * a:focus, .messager-window * span:focus {
	color: blue;
	font-weight: bold;
}
.daterangepicker * {
	font-family: "Source Sans Pro","Arial","Helvetica","sans-serif";
	box-sizing: border-box;
}
.glyphicon	{font-family: "Glyphicons Halflings"}

.form-control {
	height: 20px;
	padding: 4px;
}	
</style>
<!-- buaat tanggal sekarang -->
<?php 
$tanggal = date('Y-m-d H:i');
$tanggal_arr = explode(' ', $tanggal);
$txt_tanggal = jin_date_ina($tanggal_arr[0]);
$txt_tanggal .= ' - ' . $tanggal_arr[1];

$tagihan = $row_pinjam->ags_per_bulan * $row_pinjam->lama_angsuran;
$dibayar = $hitung_dibayar->total;
$jml_denda=$hitung_denda->total_denda;
$sisa_bayar = $tagihan - $dibayar;
$total_bayar = $sisa_bayar + $jml_denda;
?>

<!-- menu atas -->
<div class="callout callout-danger">
<code>Klik <strong>Validasi Lunas</strong> untuk melakukan Pelunasan dan Pembayaran Tagihan Denda</code>
</div>

<?php
	echo '<a href="'.site_url('angsuran_lunas').'/index/'.$row_pinjam->id.'" class="btn btn-sm btn-success"><i class="fa fa-check-square-o"></i> Validasi Lunas</a>';
	echo ' <a href="'.site_url('angsuran_detail').'/index/'.$row_pinjam->id.'" class="btn btn-sm btn-primary"><i class="fa fa-file-o"></i> Detail</a>';
?> 
<a href="javascript:void(0)" class="btn btn-sm btn-default" title="Bantuan"  plain="false" onclick="alur()"> <i class="fa fa-question"></i></a>

<p></p>

<!-- detail data anggota -->
<div class="card card-solid card-primary">
	<div class="card-header" title="Detail Pinjaman" data-toggle="" data-original-title="Detail Pinjaman">
		<h3 class="card-title"> Detail Pinjaman </h3> 
		<div class="card-tools pull-right">
			<button class="btn btn-primary btn-xs" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div>
	</div>
	<div class="card-body">
		<table style="font-size: 13px; width:100%">
			<tr>
				<td style="width:10%; text-align:center;">
					<?php
					$photo_w = 3 * 30;
					$photo_h = 4 * 30;
					if($data_anggota->file_pic == '') {
						echo '<img src="'.base_url().'assets/theme_admin/img/photo.jpg" alt="default" width="'.$photo_w.'" height="'.$photo_h.'" />';
					} else {
						echo '<img src="'.base_url().'uploads/anggota/' . $data_anggota->file_pic . '" alt="Foto" width="'.$photo_w.'" height="'.$photo_h.'" />';
					}
					?>
				</td> 
				<td>
					<table style="width:100%">
					<tr>
						<td><label class="text-green">Data Anggota</label></td>
					</tr>
					<tr>
						<td> ID Anggota</td>
						<td> : </td>
						<td> <?php echo 'AG' . sprintf('%04d', $row_pinjam->anggota_id) . '' ?></td>
					</tr>
					<tr>
						<td> Nama Anggota </td>
						<td> : </td>
						<td> <?php echo $data_anggota->nama; ?></td>
					</tr>
					<tr>
						<td> Dept </td>
						<td> : </td>
						<td> <?php echo $data_anggota->departement; ?></td>
					</tr>
					<tr>
						<td> Tempat, Tanggal Lahir  </td>
						<td> : </td>
						<td> <?php echo $data_anggota->tmp_lahir .', '. jin_date_ina ($data_anggota->tgl_lahir); ?></td>
					</tr>
					<tr>
						<td> Kota Tinggal</td> 
						<td> : </td>
						<td> <?php echo $data_anggota->kota; ?></td>
					</tr>
					</table>
				</td>
				<td>
					<table style="width:100%">
					<tr>
						<td><label class="text-green">Data Pinjaman</label></td>
					</tr>
					<tr>
						<td> Kode Pinjam</td>
						<td> : </td>
						<td> <?php echo 'TPJ' . sprintf('%05d', $row_pinjam->id) . '' ?> </td>
					</tr>
					<tr>
						<td> Tanggal Pinjam</td>
						<td> : </td>
						<td> <?php 
								$tanggal_arr = explode(' ', $row_pinjam->tgl_pinjam);
								$txt_tanggal_p = jin_date_ina($tanggal_arr[0], 'full');
								echo  $txt_tanggal_p; 
							  ?>
						</td>
					</tr>
					<tr>
						<td> Tanggal Tempo</td>
						<td> : </td>
						<td> <?php 
								$tanggal_arr = explode(' ', $row_pinjam->tempo);
								$txt_tanggal_t = jin_date_ina($tanggal_arr[0], 'full');
								echo  $txt_tanggal_t; 
							  ?>
						</td>
					</tr>
					<tr>
						<td> Lama Pinjaman</td> 
						<td> : </td>
						<td> <?php echo $row_pinjam->lama_angsuran; ?> Bulan</span></td>
					</tr>
					</table>
				</td>
				<td>
					<table style="width:100%">
					<tr>
						<td>
							<label></label>
						</td>
					</tr>
					<tr>
						<td> Pokok Pinjaman</td>
						<td> : </td>
						<td class="h_kanan"> <?php echo number_format(nsi_round($row_pinjam->jumlah))?></td>
					</tr>
					<tr>
						<td> Angsuran Pokok </td>
						<td> : </td>
						<td class="h_kanan"> <?php echo number_format($row_pinjam->pokok_angsuran); ?></td>
					</tr>
					<tr>
						<td> Biaya dan Bunga</td>
						<td> : </td>
						<td class="h_kanan"> <?php echo number_format(($row_pinjam->biaya_adm) + ($row_pinjam->bunga_pinjaman)); ?></td>
					</tr>
					<tr>
						<td> Jumlah Angsuran </td> 
						<td> : </td>
						<td class="h_kanan"><?php echo number_format(nsi_round($row_pinjam->ags_per_bulan)); ?></td>
					</tr>
					</table>
				</td>			
			</tr>
		</table>
	</div>

	<div class="card card-solid bg-light-blue">
	<table width="100%" style="font-size: 17px;">
		<tr>
			<td><strong> Rangkuman </strong> &raquo; </td>
			<td> Sisa Angsuran : <span id="det_sisa_ags"> <?php echo $row_pinjam->lama_angsuran - $sisa_ags; ?> </span> Bulan </td>
			<td> Dibayar : Rp. <span id="det_sudah_bayar"> <?php echo number_format(nsi_round($dibayar)); ?></span> </td>
			<td> Denda : Rp. <span id="det_jml_denda"> <?php echo  number_format(nsi_round($jml_denda)); ?> </span> </td>
			<td> Sisa Tagihan Rp. <span id="total_bayar"> <?php echo  number_format(nsi_round($total_bayar)); ?> </span> </td>
			<td> Status Pelunasan : <span id="ket_lunas"> <?php echo $row_pinjam->lunas; ?> </span> </td>
		</code>
		</tr>
	</table>
	</div>
</div>
<!-- Data Grid -->
<table   id="dg" 
class="easyui-datagrid" 
title="Data Pembayaran Angsuran" 
style="width:auto; height: auto;" 
url="<?php echo site_url('angsuran/ajax_list') . '/' . $master_id; ?>" 
pagination="true" rownumbers="true" 
fitColumns="true" singleSelect="true" collapsible="true"
sortName="tgl_bayar" sortOrder="desc"
toolbar="#tb"
striped="true">
<thead>
	<tr>
		<th data-options="field:'id',halign:'center', align:'center'" hidden="true">ID</th>
		<th data-options="field:'id_txt', width:'14', halign:'center', align:'center'">Kode </th>
		<th data-options="field:'tgl_bayar_txt', width:'35', halign:'center', align:'center'">Tanggal Bayar</th>
		<th data-options="field:'tgl_bayar',halign:'center', align:'center'" hidden="true">Tanggal</th>
		<th data-options="field:'tgl_tempo', width:'35', halign:'center', align:'center'">Tanggal Tempo</th>
		<th data-options="field:'pinjam_id',halign:'center', align:'center'" hidden="true">ID</th>
		<th data-options="field:'angsuran_ke', width:'12', halign:'center', align:'center'">Angsuran <br> Ke</th>
		<th data-options="field:'jumlah_bayar', width:'20', halign:'center', align:'right'">Jumlah Bayar</th>
		<th data-options="field:'denda', width:'20', halign:'center', align:'right'"> Denda</th>
		<th data-options="field:'terlambat', width:'20', halign:'center', align:'center'"> Terlambat</th>
		<th data-options="field:'kas_id', halign:'center', align:'right'" hidden="true"> Kas</th>
		<th data-options="field:'user', width:'20', halign:'center', align:'center'"> User Name</th>
		<th data-options="field:'ket', width:'15', halign:'center', align:'left'" hidden="true">Keterangan</th>
		<th data-options="field:'nota', width:'10', halign:'center', align:'center'"> Cetak</th>
	</tr>
</thead>
</table>

<!-- Toolbar -->
<div id="tb" style="">
	<div style="vertical-align: middle; display: inline; padding-top: 15px;">
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="create()">Bayar </a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="update()">Edit</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" plain="true" onclick="hapus()">Hapus</a>
	</div>
	<div class="pull-right" style="vertical-align: middle;">
		<div id="filter_tgl" class="input-group" style="display: inline;">
			<button class="btn btn-default" id="daterange-btn">
				<i class="fa fa-calendar"></i> <span id="reportrange"><span>Pilih Tanggal</span></span>
				<i class="fa fa-caret-down"></i>
			</button>
		</div>
		<span>Cari :</span>
		<input name="kode_transaksi" id="kode_transaksi" size="25" placeholder="[Kode Transaksi]"style="line-height:26px;border:1px solid #ccc">

		<a href="javascript:void(0);" id="btn_filter" class="easyui-linkbutton" iconCls="icon-search" plain="false" onclick="doSearch()">Cari</a>
		<a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-clear" plain="false" onclick="clearSearch()">Hapus Filter</a>
	</div>
</div>


<!-- Dialog Form  Alur -->
<div id="alur" class="easyui-dialog" show= "blind" hide= "blind" modal="true" resizable="false" style="width:500px; height:385px; padding-top: 10px" closed="true" style="display: none;">
	<div class="card card card-solid card-primary">
	<div class="card-body">
	<table>
		<tr>
			<td colspan="3"><strong> A. Pembayaran Angsuran </strong></td>
		</tr>
		<tr>
			<td></td>
			<td valign="top"> - </td> 
			<td>Admin mencatat <code> Pembayaran Angsuran </code> sesuai Jumlah Angsuran setiap anggota </td>
		</tr>
		<tr>
			<td></td>
			<td valign="top"> - </td>
			<td> Anggota akan dikenakan <code>Denda </code> apabila terlambat melakukan pembayaran sesuai jatuh tempo </td>
		</tr>
		<tr>
			<td></td>
			<td valign="top"> - </td>
			<td> Batas maksimal pembayaran adalah pada tanggal 15 (Lima Belas) setiap bulan, <code>Tanggal Dapat diubah pada menu Setting &raquo; Suku Bunga</code></td>
		</tr>
		<tr>
			<td colspan="3"><strong> B. Pelunasan Cepat</strong></td>
		</tr>
		<tr>
			<td></td>
			<td valign="top"> - </td>
			<td> Anggota dinyatakan <code> LUNAS </code> apabila telah membayar sejumlah tagihan yang dibebankan dan tidak memiliki tagihan <code> Denda </code> atau tagihan lainnya</td>
		</tr>
		<tr>
			<td></td>
			<td valign="top"> - </td>
			<td> Pelunasan dapat dilakukan walau Anggota masih memiliki kewajiban angsuran atau kurang dari tanggal jatuh tempo</td>
		</tr>
		<tr>
			<td></td>
			<td valign="top"> - </td>
			<td> Jika Anggota telah menyelesaikan angsuran, Admin diharuskan melakukan <code> Validasi Pelunasan</code> untuk menghitung sisa pembayaran dan denda yang dibebankan kepada anggota </td>
		</tr>
		<tr>
			<td></td>
			<td valign="top"> - </td>
			<td> Anggota dapat melakukan peminjaman selanjutnya jika tidak mempunyai tagihan dipinjaman sebelumnya   </td>
		</tr>
	</table>
	</div><!-- /.card-body -->
	</div>
</div>

<!-- Dialog form input anguran -->
<div id="dialog-form" class="easyui-dialog" modal="true" show="blind" hide= "blind" resizable="false" style="width:400px; height:400px; padding: 20px 20px" closed="true" buttons="#dialog-buttons" style="display: none;">
	<form id="form" method="post" novalidate>
		<table>
			<tr style="height:35px">
				<td> Tanggal Transaksi </td>
				<td> : </td>
				<td>
					<div class="input-group date dtpicker col-md-5" style="z-index: 9999 !important;">
						<input type="text" name="tgl_transaksi_txt" id="tgl_transaksi_txt" style="width:150px; height:25px" required="true" readonly="readonly" />
						<input type="hidden" name="tgl_transaksi" id="tgl_transaksi" />
						<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
					</div>
				</td>	
			</tr>
			<tr style="height:30px">
				<td> Nomor Pinjam </td>
				<td> : </td>
				<td> <div class="inputform"><?php echo 'TPJ' . sprintf('%05d', $master_id) . '' ?></div>
					<input type="hidden" id="pinjam_id" name="pinjam_id" value="<?php echo  $master_id; ?>" readonly="true" /></td>
			</tr>
			<tr style="height:30px">
				<td> Angsuran Ke </td>
				<td> : </td>
				<td> <span id="angsuran_ke" class="inputform"></span> </td>
			</tr>
			<tr style="height:30px">
				<td> Sisa Angsuran </td>
				<td> : </td>
				<td> <span id="sisa_ags" class="inputform"></span></td>
			</tr>
			<tr style="height:30px">
				<td> Jumlah Angsuran</td>
				<td> : </td>
				<td> <div class="inputform"><?php echo number_format((nsi_round($row_pinjam->ags_per_bulan))); ?></div>
					<input type="hidden" id="angsuran" name="angsuran" value="<?php echo ($row_pinjam->ags_per_bulan); ?>" readonly="readonly" />
				</td>
			</tr>
			<tr style="height:30px">
				<td> Sisa Tagihan</td>
				<td> :</td>
				<td> <span id="sisa_tagihan" class="inputform"></span></td>
			</tr>	
			<tr style="height:30px">
				<td> Denda</td>
				<td> :</td>
				<td> <span id="denda" class="inputform"></span><input type="hidden" id="denda_val" name="denda_val" value="" /></td>
			</tr>	
				<input type="hidden" id="jml_bayar" name="jml_bayar" class="easyui-validatecard" required="true" />
				<input type="hidden" id="jml_kas" name="jml_kas" class="easyui-validatecard" required="true" />
				<input type="hidden" id="total_tagihan" name="total_tagihan" value="" />
			<tr style="height:30px">
				<td> Simpan Ke Kas</td>
				<td> :</td>
				<td>
					<select id="kas_id" name="kas_id" style="width:200px; height:23px" class="easyui-validatecard" required="true">
						<option value="0"> -- Pilih Kas --</option>			
						<?php	
						foreach ($kas_id as $row) {
							echo '<option value="'.$row->id.'">'.$row->nama.'</option>';
						}
						?>
					</select>
					<input type="hidden" id="aksi" name="aksi" value="" />
					<input type="hidden" id="id_bayar" name="id_bayar" value="" />
				</td>
			</tr>
			<tr style="height:35px">
				<td> Keterangan</td>
				<td> :</td>
				<td> <input id="ket" name="ket" style="width:190px; height:20px" ></td>	
			</tr>
		</table>
	</form>
</div>

<!-- Dialog Button -->
<div id="dialog-buttons">
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="save()">Simpan</a>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-form').dialog('close')">Batal</a>
</div>

<script type="text/javascript">
	/////// READY-START
	$(document).ready(function() {
		create();
		$(".dtpicker").datetimepicker({
			language:  'id',
			weekStart: 1,
			autoclose: true,
			todayBtn: true,
			todayHighlight: true,
			pickerPosition: 'bottom-right',
			format: "dd MM yyyy - hh:ii",
			linkField: "tgl_transaksi",
			linkFormat: "yyyy-mm-dd hh:ii"
		}).on('changeDate', function(ev){
			hitung_denda();
		});

		$("#kode_transaksi").keyup(function(event){
			if(event.keyCode == 13){
				$("#btn_filter").click();
			}
		});

		$("#kode_transaksi").keyup(function(e){
			var isi = $(e.target).val();
			$(e.target).val(isi.toUpperCase());
		});
		fm_filter_tgl();
	}); 
	/////// READY-END

	function hitung_denda() {
		$('#denda').html('<img src="<?php echo base_url();?>assets/theme_admin/img/loading.gif" />');
		$('#denda_val').val('0');
		val_tgl_bayar 	= $('#tgl_transaksi').val();
		val_aksi 		= $('#aksi').val();
		val_id_bayar 	= $('#id_bayar').val();
		$.ajax({
			type	: "POST",
			url	: "<?php echo site_url('angsuran/get_ags_ke') . '/'.$master_id.''; ?>",
			data 	: { tgl_bayar : val_tgl_bayar, id_bayar : val_id_bayar},
			success	: function(result){
				var result = eval('('+result+')');
				$('#denda').text(result.denda);
				$('#denda_val').val(result.denda);
			}
		});
	}

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
			showDropdowns: true,
			format: 'YYYY-MM-DD',
			startDate: moment().subtract('days', 1),
			endDate: moment()
		},
		function(start, end) {
			$('#reportrange span').html(start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY'));
			doSearch();
		});
	}
	function alur(){
		jQuery('#alur').dialog('open').dialog('setTitle',' <i class="fa  fa-book"></i> Cara Pembayaran');
	}

	function create() {
		$('#aksi').val('add');
		jQuery('#dialog-form').dialog('open').dialog('setTitle','Form Pembayaran Angsuran');
		jQuery('#tgl_transaksi_txt').val('<?php echo $txt_tanggal;?>');
		jQuery('#tgl_transaksi').val('<?php echo $tanggal;?>');
		jQuery('#pinjam_id').val('<?php echo  $master_id; ?>');
		jQuery('#angsuran').val('<?php echo number_format(($row_pinjam->ags_per_bulan)); ?>');
		jQuery('#kas_id option[value="0"]').prop('selected', true);
		url = '<?php echo site_url('angsuran/create'); ?>';
		$("#angsuran_ke").html('<img src="<?php echo base_url();?>assets/theme_admin/img/loading.gif" />');
		$("#sisa_ags").html('<img src="<?php echo base_url();?>assets/theme_admin/img/loading.gif" />');
		$("#sisa_tagihan").html('<img src="<?php echo base_url();?>assets/theme_admin/img/loading.gif" />');
		$.ajax({
			type	: "POST",
			url		: "<?php echo site_url('angsuran/get_ags_ke') . '/'.$master_id.''; ?>",
			success	: function(result){
				var result = eval('('+result+')');
				if((result.sisa_ags == 0) || (result.total_tagihan <= 0)) {
					$('#dialog-form').dialog('close');
					$.messager.show({
						title:'<div><i class="fa fa-warning"></i> Perhatian ! </div>',
						msg: '<div class="text-blue"><i class="fa fa-warning"></i> Klik <code> Validasi Lunas </code> untuk Pelunasan dan membayar Tagihan Denda</div>',
					});
				} else {
					$('#angsuran_ke').text(result.ags_ke);
					$('#sisa_ags').text(result.sisa_ags);
					$('#sisa_tagihan').text(result.sisa_tagihan);
					$('#jml_bayar').val(result.sisa_pembayaran);
					$('#jml_kas').val(result.total_tagihan);
				}
			},
			error : function() {
				alert('Terjadi Kesalahan Kneksi');
			}
		});
		hitung_denda();
	}

	function save(){
		//validasi teks kosong
		var tgl_bayar_txt = $("#tgl_bayar_txt").val();
		var string = $("#form").serialize();
		if(tgl_bayar_txt == 0){
			$.messager.show({
				title:'<div><i class="fa fa-warning"></i> Peringatan ! </div>',
				msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Tanggal harus diisi </div>',
				timeout:2000,
				showType:'slide'
			});
			$("#tgl_bayar_txt").focus();
			return false;
		}

		var kas_id = $("#kas_id").val();
		var string = $("#form").serialize();
		if(kas_id == 0){
			$.messager.show({
				title:'<div><i class="fa fa-warning"></i> Peringatan ! </div>',
				msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Anda belum memilih kas </div>',
				timeout:2000,
				showType:'slide'
			});
			$("#kas_id").focus();
			return false;
		} else {
			$.ajax({
				type	: "POST",
				url: url,
				data	: string,
				success	: function(result){
					var result = eval('('+result+')');
					$.messager.show({
						title:'<div><i class="fa fa-info"></i> Informasi</div>',
						msg: result.msg,
						timeout:2000,
						showType:'slide'
					});
					if(result.ok) {
						jQuery('#dialog-form').dialog('close');
						$('#dg').datagrid('reload');
						det_update();
					}
				}
			});
		}
	}

	function det_update() {
		$('#det_sudah_bayar').html('<img src="<?php echo base_url();?>assets/theme_admin/img/loading.gif" />');
		$('#det_sisa_tagihan').html('<img src="<?php echo base_url();?>assets/theme_admin/img/loading.gif" />');
		$('#det_jml_denda').html('<img src="<?php echo base_url();?>assets/theme_admin/img/loading.gif" />');
		$('#det_sisa_ags').html('<img src="<?php echo base_url();?>assets/theme_admin/img/loading.gif" />');
		$('#total_bayar').html('<img src="<?php echo base_url();?>assets/theme_admin/img/loading.gif" />');
		$('#ket_lunas').html('<img src="<?php echo base_url();?>assets/theme_admin/img/loading.gif" />');

		$.ajax({
			type	: "POST",
			url		: "<?php echo site_url('angsuran/get_ags_ke') . '/'.$master_id.''; ?>",
			success	: function(result){
				var result = eval('('+result+')');
				$('#det_sudah_bayar').text(result.sudah_bayar_det);
				$('#det_sisa_tagihan').text(result.sisa_tagihan_det);
				$('#det_jml_denda').text(result.jml_denda_det);
				$('#det_sisa_ags').text(result.sisa_ags_det);
				$('#total_bayar').text(result.total_bayar_det);
				$('#ket_lunas').text(result.status_lunas);
			},
			error: function() {
				alert('Terjadi Kesalahan Koneksi');
			}
		}); 
	}

	function update(){
		$('#aksi').val('edit');
		var row = $('#dg').datagrid('getSelected');
		if(row) {
			url = '<?php echo site_url('angsuran/update'); ?>/' + row.id;

			$.ajax({
				url: '<?php echo site_url();?>angsuran/cek_sebelum_update',
				type: 'POST',
				dataType: 'json',
				data: {id_bayar: row.id, master_id: <?php echo $master_id; ?>}
			})
			.done(function(result) {
				if(result.success == '1') {
					$('#dialog-form').dialog('open').dialog('setTitle','Edit Data Angsuran');
					$('#form').form('load',row);
					$('#id_bayar').val(row.id);
					$('#tgl_transaksi_txt').val(row.tgl_bayar_txt);
					$('#tgl_transaksi').val(row.tgl_bayar);
					$('#angsuran_ke').text(row.angsuran_ke);
					$('#sisa_ags').text(result.sisa_ags);
					$('#sisa_tagihan').text(result.sisa_tagihan);					
					var denda_txt = row.denda;
					var denda_num = denda_txt.replace(',', '');
					$('#denda_val').val(denda_num);
					$('#denda').html(denda_txt);
				} else {
					$.messager.show({
						title:'<div><i class="fa fa-warning"></i> Peringatan !</div>',
						msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Hanya data transaksi terakhir saja yang boleh diubah (silahkan cek juga list Pelunasan jika ada). </div>',
						timeout:2000,
						showType:'slide'
					});
				}
			})
			.fail(function() {
				alert("Kesalahan koneksi, silahkan ulangi (refresh).");
			});
		} else {
			$.messager.show({
				title:'<div><i class="fa fa-warning"></i> Peringatan !</div>',
				msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Data harus dipilih terlebih dahulu </div>',
				timeout:2000,
				showType:'slide'
			});		
		}
	}


function hapus(){
		var row = $('#dg').datagrid('getSelected');  
		if (row){ 
			$.messager.confirm('Konfirmasi','Apakah Anda akan menghapus data kode bayar : <code>' + row.id_txt + '</code> ?',function(r){  
				if (r){  
					$.ajax({
						type	: "POST",
						url		: "<?php echo site_url('angsuran/delete'); ?>",
						data	: 'id='+row.id+'&master_id=<?php echo $master_id; ?>',
						success	: function(result){
							var result = eval('('+result+')');
							$.messager.show({
								title:'<div><i class="fa fa-info"></i> Informasi</div>',
								msg: result.msg,
								timeout:2000,
								showType:'slide'
							});
							if(result.ok) {
								$('#dg').datagrid('reload');
								det_update();
							}
						},
						error : function (){
							$.messager.show({
								title:'<div><i class="fa fa-warning"></i> Peringatan !</div>',
								msg: '<div class="text-red"><i class="fa fa-ban"></i> Terjadi kesalahan koneksi, silahkan muat ulang !</div>',
								timeout:2000,
								showType:'slide'
							});
						}
					});  
				}  
			});  
		}  else {
			$.messager.show({
				title:'<div><i class="fa fa-warning"></i> Peringatan !</div>',
				msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Data harus dipilih terlebih dahulu </div>',
				timeout:2000,
				showType:'slide'
			});	
		}
		$('.messager-button a:last').focus();
	} 

	function form_select_clear() {
		$('select option')
		.filter(function() {
			return !this.value || $.trim(this.value).length == 0;
		})
		.remove();
		$('select option')
		.first()
		.prop('selected', true);	
	}

	function doSearch(){
		$('#dg').datagrid('load',{
			kode_transaksi: $('#kode_transaksi').val(),
			tgl_dari: 	$('input[name=daterangepicker_start]').val(),
			tgl_sampai: $('input[name=daterangepicker_end]').val()
		});
	}

	function clearSearch(){
		location.reload();
	}
</script>