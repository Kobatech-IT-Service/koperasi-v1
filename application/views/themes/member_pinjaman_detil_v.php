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
					<p style="text-align:center; font-size: 15pt; font-weight: bold;"> Pinjaman Detail </p>
				</div>
				
				<table data-toggle="table">
					<thead>
						<tr>
							<th>Bln ke</th>
							<th>Angsuran Pokok</th>
							<th>Angsuran Bunga</th>
							<th>Biaya Adm</th>
							<th>Jumlah Angsuran</th>
							<th>Tanggal Tempo</th>
						</tr>
					</thead>
					<tbody>

				<?php //var_dump($simulasi_tagihan); 
				if(!empty($simulasi_tagihan)) {
					$no = 1;
					$row = array();
					$jml_pokok = 0;
					$jml_bunga = 0;
					$jml_ags = 0;
					$jml_adm = 0;
					foreach ($simulasi_tagihan as $row) {
						$txt_tanggal = jin_date_ina($row['tgl_tempo']);
						$jml_pokok += $row['angsuran_pokok'];
						$jml_bunga += $row['bunga_pinjaman'];
						$jml_adm += $row['biaya_adm'];
						$jml_ags += $row['jumlah_ags'];

						echo '
							<tr>
								<td class="h_tengah">'.$no.'</td>
								<td class="h_kanan">'.number_format(nsi_round($row['angsuran_pokok'])).'</td>
								<td class="h_kanan">'.number_format(nsi_round($row['bunga_pinjaman'])).'</td>
								<td class="h_kanan">'.number_format(nsi_round($row['biaya_adm'])).'</td>
								<td class="h_kanan">'.number_format(nsi_round($row['jumlah_ags'])).'</td>
								<td class="h_tengah">'.$txt_tanggal.'</td>
							</tr>';
						$no++;
					}
					echo '</tbody>';
					echo '<tfoot>';
					echo '<tr>
								<td class="h_tengah">Jumlah</td>
								<td class="h_kanan">'.number_format(nsi_round($jml_pokok)).'</td>
								<td class="h_kanan">'.number_format(nsi_round($jml_bunga)).'</td>
								<td class="h_kanan">'.number_format(nsi_round($jml_adm)).'</td>
								<td class="h_kanan">'.number_format(nsi_round($jml_ags)).'</td>
								<td></td>
							</tr>';
				}
				?>
					</tfoot>
				</table>

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