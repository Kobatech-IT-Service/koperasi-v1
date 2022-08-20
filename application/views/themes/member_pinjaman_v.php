<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Lap Pinjaman - SisKoMob</title>
	<link rel="shortcut icon" href="<?php echo base_url(); ?>icon.ico" type="image/x-icon" />
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<!-- bootstrap 3.0.2 -->
	<link href="<?php echo base_url(); ?>assets/theme_admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<!-- font Awesome -->
	<link href="<?php echo base_url(); ?>assets/theme_admin/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<!-- Theme style -->
	<link href="<?php echo base_url(); ?>assets/theme_admin/css/AdminLTE.css" rel="stylesheet" type="text/css" />

	
	<link href="<?php echo base_url(); ?>assets/extra/bootstrap-table/bootstrap-table.min.css" rel="stylesheet" type="text/css" />
	
	<link href="<?php echo base_url(); ?>assets/theme_admin/css/custome.css" rel="stylesheet" type="text/css" />

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->
</head>
<body>

<div class="container">

	<?php $this->load->view('themes/member_menu_v'); ?>

	<div class="row">
		<div class="box box-primary">
			<div class="box-body" style="min-height: 500px;">
				<div>
					<p style="text-align:center; font-size: 15pt; font-weight: bold;"> Laporan Pinjaman </p>
				</div>
				

				<table 
					id="tablegrid"
					data-toggle="table"
					data-id-field="id"
					data-url="<?php echo site_url('member/ajax_lap_pinjaman'); ?>" 
					data-sort-name="tgl_pinjam"
					data-sort-order="desc"
					data-pagination="true"
					data-toolbar=""
					data-side-pagination="server"
					data-page-list="[5, 10, 25, 50, 100]"
					data-page-size="10"
					data-smart-display="false"
					data-select-item-name="tbl_terpilih"
					data-striped="true"
					data-search="false"
					data-show-refresh="true"
					data-show-columns="true"
					data-show-toggle="true"
					data-method="post"
					data-content-type="application/x-www-form-urlencoded"
					data-cache="false" >
					<thead>
						<tr>
							<th data-field="id" data-switchable="false" data-visible="false">ID</th>
							<th data-field="tgl_pinjam" data-sortable="false" data-valign="middle" data-align="center" data-halign="center">Tanggal</th>
							<th data-field="lama_angsuran" data-sortable="false" data-valign="middle" data-align="center" data-halign="center">Lama Angsuran</th>
							<th data-field="jumlah" data-sortable="false" data-valign="middle" data-align="right" data-halign="center">Jumlah</th>
							<th data-field="bunga_pinjaman" data-sortable="false" data-valign="middle" data-align="right" data-halign="center">Bunga</th>
							<th data-field="biaya_adm" data-sortable="false" data-valign="middle" data-align="right" data-halign="center">Administrasi</th>
							<th data-field="ags_per_bulan" data-sortable="false" data-valign="middle" data-align="right" data-halign="center">Angsuran Per Bulan</th>
							<th data-field="tagihan" data-sortable="false" data-valign="middle" data-align="right" data-halign="center">Tagihan</th>
							<th data-field="tempo" data-sortable="false" data-valign="middle" data-align="center" data-halign="center">Tempo</th>
							<th data-field="lunas" data-sortable="false" data-valign="middle" data-align="center" data-halign="center">Lunas</th>
							<th data-field="keterangan" data-sortable="false" data-align="left" data-halign="center" data-valign="middle">Keterangan</th>
							<th data-field="opsi" data-sortable="false" data-align="center" data-halign="center" data-valign="middle" data-formatter="opsi_ft">Opsi</th>
						</tr>
					</thead>
				</table>

				<?php
					//var_dump($data_simpanan);
				?>

			</div><!--box-p -->
		</div><!--box-body -->
	</div><!--row -->
</div>


	<!-- jQuery 2.0.2 -->
	<script src="<?php echo base_url(); ?>assets/theme_admin/js/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="<?php echo base_url(); ?>assets/theme_admin/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/extra/bootstrap-table/bootstrap-table.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/extra/bootstrap-table/extensions/filter-control/bootstrap-table-filter-control.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/extra/bootstrap-table/bootstrap-table-id-ID.js" type="text/javascript"></script>


<script type="text/javascript">
function opsi_ft(value, row, index) {
	var nsi_out = '';
	nsi_out += '<a href="<?php echo site_url('member/pinjaman_detil')?>/'+row.id+'" class="btn btn-xs btn-primary">Detail</a>';
	return nsi_out;
}
</script>

</body>
</html>