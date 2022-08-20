<!-- Styler -->
<style type="text/css">
td, div {
	font-family: "Arial","​Helvetica","​sans-serif";
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
</style>

<!-- Data Grid -->
<table   id="dg" 
class="easyui-datagrid"
title="Data Pinjaman" 
style="width:auto; height: auto;" 
url="<?php echo site_url('pelunasan/ajax_list'); ?>" 
pagination="true" rownumbers="true" 
fitColumns="true" singleSelect="true" collapsible="true"
sortName="tgl_pinjam" sortOrder="desc"
toolbar="#tb"
striped="true">
<thead>
	<tr>
		<th data-options="field:'id',halign:'center', align:'center'" hidden="true">ID</th>
		<th data-options="field:'id_txt', width:'13', sortable:'true', align:'center'">Kode</th>

		<th data-options="field:'anggota_id_txt', width:'35', halign:'center', align:'left'">Nama Anggota</th>

		<th data-options="field:'departement', width:'15', halign:'center', align:'left'">Dept</th>

		<th data-options="field:'tgl_pinjam_txt', width:'21', halign:'center', align:'center'">Tanggal Pinjam</th>

		<th data-options="field:'tgl_tempo_txt', width:'21', halign:'center', align:'center'">Tanggal Tempo</th>

		<th data-options="field:'lama_angsuran_txt', width:'14', halign:'center', align:'center'">Lama <br> Pinjam</th>

		<th data-options="field:'pinjaman', width:'15', halign:'center', align:'right'">Total <br> Tagihan</th>

		<th data-options="field:'denda', width:'15',  halign:'center', align:'right'">Total <br> Denda</th> 

		<th data-options="field:'dibayar', width:'15', halign:'center', align:'right'">Dibayar</th> 


		<th data-options="field:'kas_id',  halign:'center', align:'right'" hidden="true"> Kas</th>

		<th data-options="field:'bayar', halign:'center', align:'center'">Aksi</th>
	</tr>
</thead>
</table>

<!-- Toolbar -->
<div id="tb" style="height: 35px;">
	<div class="pull-right" style="vertical-align: middle;">
		<div id="filter_tgl" class="input-group" style="display: inline;">
			<button class="btn btn-default" id="daterange-btn">
				<i class="fa fa-calendar"></i> <span id="reportrange"><span>Pilih Tanggal</span></span>
				<i class="fa fa-caret-down"></i>
			</button>
		</div>
		<span>Cari :</span>
		<input name="kode_transaksi" id="kode_transaksi" size="22" placeholder="Kode Transaksi" style="line-height:23px;border:1px solid #ccc">
		<input name="cari_nama" id="cari_nama" size="23" placeholder="Nama Anggota" style="line-height:22px;border:1px solid #ccc">
		<a href="javascript:void(0);" id="btn_filter" class="easyui-linkbutton" iconCls="icon-search" plain="false" onclick="doSearch()">Cari</a>
		<a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-clear" plain="false" onclick="clearSearch()">Hapus Filter</a>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
/*
$('#dg').datagrid('load',{
kode_transaksi: $('#kode_transaksi').val(),
tgl_dari: 	$('input[name=daterangepicker_start]').val(),
tgl_sampai: $('input[name=daterangepicker_end]').val()
});
*/


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
}); //ready


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
		startDate: moment().startOf('year').startOf('month'),
		endDate: moment().endOf('year').endOf('month')
	},
	function(start, end) {
//$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
$('#reportrange span').html(start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY'));
doSearch();
});
}


</script>

<script type="text/javascript">
var url;

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
//alert($('input[name=daterangepicker_start]').val());
$('#dg').datagrid('load',{
	kode_transaksi: $('#kode_transaksi').val(),
	cari_nama: $('#cari_nama').val(),
	tgl_dari: 	$('input[name=daterangepicker_start]').val(),
	tgl_sampai: $('input[name=daterangepicker_end]').val()
});
}

function clearSearch(){
	location.reload();
}

</script>