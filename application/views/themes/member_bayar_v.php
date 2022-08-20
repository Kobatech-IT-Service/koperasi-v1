<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Lap Pembayaran - SisKoMob</title>
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
					<p style="text-align:center; font-size: 15pt; font-weight: bold;"> Laporan Pembayaran </p>
				</div>
				

				<table 
					id="tablegrid"
					data-toggle="table"
					data-id-field="id"
					data-url="<?php echo site_url('member/ajax_lap_bayar'); ?>" 
					data-sort-name="tgl_bayar"
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
							<th data-field="tgl_bayar" data-sortable="false" data-valign="middle" data-align="center" data-halign="center">Tanggal</th>
							<th data-field="ket_bayar" data-sortable="false" data-valign="middle" data-align="center" data-halign="center">Jenis</th>
							<th data-field="angsuran_ke" data-sortable="false" data-valign="middle" data-align="center" data-halign="center">Angsuran Ke</th>
							<th data-field="denda_rp" data-sortable="false" data-valign="middle" data-align="right" data-halign="center">Denda</th>
							<th data-field="jumlah_bayar" data-sortable="false" data-valign="middle" data-align="right" data-halign="center">Jumlah Bayar</th>
							<th data-field="keterangan" data-sortable="false" data-align="left" data-halign="center" data-valign="middle">Keterangan</th>
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

</script>

</body>
</html>