<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Ubah Password-SisKoMob</title>
	<link rel="shortcut icon" href="<?php echo base_url(); ?>icon.ico" type="image/x-icon" />
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<!-- bootstrap 3.0.2 -->
	<link href="<?php echo base_url(); ?>assets/theme_admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<!-- font Awesome -->
	<link href="<?php echo base_url(); ?>assets/theme_admin/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<!-- Theme style -->
	<link href="<?php echo base_url(); ?>assets/theme_admin/css/AdminLTE.css" rel="stylesheet" type="text/css" />
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
		<div class="col-md-12">
			<div class="box box-solid box-primary">
				<div class="box-header">
					<h3 class="box-title">Ubah Password</h3>
				</div>
				<div class="box-body">
					<?php if($tersimpan == 'Y') { ?>
					<div class="box-body">
						<div class="alert alert-success alert-dismissable">
							<i class="fa fa-check"></i>
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							Password berhasil diubah.
						</div>
					</div>
					<?php } ?>

					<?php if($tersimpan == 'N') { ?>
					<div class="box-body">
						<div class="alert alert-danger alert-dismissable">
							<i class="fa fa-warning"></i>
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							Password tidak berhasil diubah, silahkan gunakan password yang benar.
						</div>
					</div>
					<?php } ?>

					<div class="form-group">
						<?php 
						echo form_open('');
						//password lama
						$data = array(
							'name'       => 'password_lama',
							'id'			=> 'password_lama',
							'class'		=> 'form-control',
							'value'      => '',
							'maxlength'  => '255',
							'style'      => 'width: 250px'
							);
						echo form_label('Password Lama', 'password_lama');
						echo form_password($data);
						echo form_error('password_lama', '<p style="color: red;">', '</p>');
						echo '<br>';

						//password baru
						$data = array(
							'name'       => 'password_baru',
							'id'			=> 'password_baru',
							'class'		=> 'form-control',
							'value'      => '',
							'maxlength'  => '255',
							'style'      => 'width: 250px'
							);
						echo form_label('Password Baru', 'password_baru');
						echo form_password($data);
						echo form_error('password_baru', '<p style="color: red;">', '</p>');
						echo '<br>';


						//ulangi password baru
						$data = array(
							'name'       => 'ulangi_password_baru',
							'id'			=> 'ulangi_password_baru',
							'class'		=> 'form-control',
							'value'      => '',
							'maxlength'  => '255',
							'style'      => 'width: 250px'
							);
						echo form_label('Ulangi Password Baru', 'ulangi_password_baru');
						echo form_password($data);
						echo form_error('ulangi_password_baru', '<p style="color: red;">', '</p>');
						echo '<br>';
						if (!empty($pesan)) {
							echo '<div class="alert alert-danger alert-dismissable">
							<i class="fa fa-warning"></i>
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							' . $pesan . '.
							</div>';
						}

						// submit
						$data = array(
							'name' 		=> 'submit',
							'id' 		=> 'submit',
							'class' 	=> 'btn btn-primary',
							'value'		=> 'true',
							'type'	 	=> 'submit',
							'content' 	=> 'Ubah Password'
							);
						echo '<br>';
						echo form_button($data);

						echo form_close();

						?>
					</div>
				</div><!-- /.box-body -->
			</div>
		</div>
	</div>

</div>


	<!-- jQuery 2.0.2 -->
	<script src="<?php echo base_url(); ?>assets/theme_admin/js/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="<?php echo base_url(); ?>assets/theme_admin/js/bootstrap.min.js" type="text/javascript"></script>


<script type="text/javascript">

</script>

</body>
</html>