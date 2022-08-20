<div class="row">
	<div class="col-md-12">
		<div class="card card-solid card-primary">
			<div class="card-header">
				<h3 class="card-title">Update Data Koperasi</h3>
				<div class="card-tools pull-right">
					<button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div>
			</div>
			<div class="card-body">
				<?php if($tersimpan == 'Y') { ?>
					<div class="card-body">
						<div class="alert alert-success alert-dismissable">
		                    <i class="fa fa-check"></i>
		                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                    Data berhasil disimpan.
		                </div>
					</div>
				<?php } ?>

				<?php if($tersimpan == 'N') { ?>
					<div class="card-body">
						<div class="alert alert-danger alert-dismissable">
		                    <i class="fa fa-warning"></i>
		                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		                    Data tidak berhasil disimpan, silahkan ulangi beberapa saat lagi.
		                </div>
					</div>
				<?php } ?>

				<div class="form-group">
					<?php 
					echo form_open('');
					//nama sekolah
					$data = array(
		              'name'        => 'nama_lembaga',
		              'id'			=> 'nama_lembaga',
		              'class'		=> 'form-control',
		              'value'       => $nama_lembaga,
		              'maxlength'   => '255',
		              'style'       => 'width: 95%'
	            	);
					echo form_label('Nama Koperasi', 'nama_lembaga');
					echo form_input($data);
					echo '<br>';
					
					//nama ketua
					$data = array(
		              'name'        => 'nama_ketua',
		              'id'			=> 'nama_ketua',
		              'class'		=> 'form-control',
		              'value'       => $nama_ketua,
		              'maxlength'   => '255',
		              'style'       => 'width: 95%'
	            	);
					echo form_label('Nama Pimpinan', 'nama_ketua');
					echo form_input($data);
					echo '<br>';
					
					//hp ketua
					$data = array(
		              'name'        => 'hp_ketua',
		              'id'			=> 'hp_ketua',
		              'class'		=> 'form-control',
		              'value'       => $hp_ketua,
		              'maxlength'   => '255',
		              'style'       => 'width: 95%'
	            	);
					echo form_label('No HP', 'hp_ketua');
					echo form_input($data);
					echo '<br>';

					// alamat
					$data = array(
		              'name'        => 'alamat',
		              'id'			=> 'alamat',
		              'class'		=> 'form-control',
		              'value'       => $alamat,
		              'maxlength'   => '255',
		              'style'       => 'width: 95%'
	            	);
					echo form_label('Alamat', 'alamat');
					echo form_input($data);
					echo '<br>';

					// telepon
					$data = array(
		              'name'        => 'telepon',
		              'id'			=> 'telepon',
		              'class'		=> 'form-control',
		              'value'       => $telepon,
		              'maxlength'   => '255',
		              'style'       => 'width: 95%'
	            	);
					echo form_label('Telepon', 'telepon');
					echo form_input($data);
					echo '<br>';

					// web
					$data = array(
		              'name'        => 'kota',
		              'id'			=> 'kota',
		              'class'		=> 'form-control',
		              'value'       => $kota,
		              'maxlength'   => '255',
		              'style'       => 'width: 95%'
	            	);
					echo form_label('Kota/Kabupaten', 'kota');
					echo form_input($data);
					echo '<br>';

					// email
					$data = array(
		              'name'        => 'email',
		              'id'			=> 'email',
		              'class'		=> 'form-control',
		              'value'       => $email,
		              'maxlength'   => '255',
		              'style'       => 'width: 95%'
	            	);
					echo form_label('Email', 'email');
					echo form_input($data);
					echo '<br>';

					// web
					$data = array(
		              'name'        => 'web',
		              'id'			=> 'web',
		              'class'		=> 'form-control',
		              'value'       => $web,
		              'maxlength'   => '255',
		              'style'       => 'width: 95%'
	            	);
					echo form_label('Website', 'web');
					echo form_input($data);
					echo '<br>';

					// submit
					$data = array(
				    'name' 		=> 'submit',
				    'id' 		=> 'submit',
				    'class' 	=> 'btn btn-primary',
				    'value'		=> 'true',
				    'type'	 	=> 'submit',
				    'content' 	=> 'Update'
					);
					echo '<br>';
					echo form_button($data);


					echo form_close();

					?>
				</div>
			</div><!-- /.card-body -->
		</div>
	</div>
</div>