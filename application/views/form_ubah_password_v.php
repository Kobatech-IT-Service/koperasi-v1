<div class="row">
	<div class="col-md-12">
		<div class="box box-solid box-primary">
			<div class="box-header">
				<h3 class="box-title">Ubah Password</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div>
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