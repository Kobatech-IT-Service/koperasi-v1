<div class="row">
	<div class="col-md-12">
		<div class="box box-solid box-primary">
			<div class="box-header">
				<h3 class="box-title">Biaya dan Administrasi</h3>
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
		                    Data berhasil disimpan.
		                </div>
					</div>
				<?php } ?>

				<?php if($tersimpan == 'N') { ?>
					<div class="box-body">
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
					
			echo '
			<table width="70%">
			<tr> 
				<td>';
				// tipe bunga
				$options = array(
					'A'  => 'A: Persen Bunga dikali angsuran bln',
					'B'  => 'B: Persen Bunga dikali total pinjaman'
					//'C'  => 'C: Bunga Menurun = Persen Bunga dikali sisa pinjaman'
					);
				echo form_label('Tipe Pinjaman Bunga', 'pinjaman_bunga_tipe');
				echo form_dropdown('pinjaman_bunga_tipe', $options, $pinjaman_bunga_tipe, 'id="pinjaman_bunga_tipe" class="form-control"');
				echo '
				</td>
				<td>';

			//dana cadangan 
				$data = array(
					'name'        	=> 'dana_cadangan',
					'id'				=> 'dana_cadangan',
					'class'			=> 'form-control',
					'value'       	=> $dana_cadangan,
					'maxlength'   	=> '255',
					'style'       	=> 'width: 50%'
					);
				echo form_label('Dana Cadangan (%)', 'dana_cadangan');
				echo form_input($data);
				echo '
				</td>
				<td>';

				$data = array(
					'name'        	=> 'jasa_usaha',
					'id'				=> 'jasa_usaha',
					'class'			=> 'form-control',
					'value'       	=> $jasa_usaha,
					'maxlength'   	=> '255',
					'style'       	=> 'width: 50%'
					);
				echo form_label('Jasa Usaha (%)', 'jasa_usaha');
				echo form_input($data);
				echo '
				</td>
			</tr>';				

			echo '
			<tr>
				<td>';
				//bunga pinjman
				$data = array(
					'name'        => 'bg_pinjam',
					'id'			  => 'bg_pinjam',
					'class'		  => 'form-control',
					'value'       => $bg_pinjam,
					'maxlength'   => '255',
					'style'       => 'width: 50%'
					);
				echo form_label('Suku Bunga Pinjaman (%)', 'bg_pinjam');
				echo form_input($data);
				echo '
				</td>
				<td>';

			//dana cadangan 
			$data = array(
				'name'        => 'jasa_anggota',
				'id'			=> 'jasa_anggota',
				'class'		=> 'form-control',
				'value'       => $jasa_anggota,
				'maxlength'   => '255',
				'style'       => 'width: 50%'
				);
			echo form_label('Jasa Anggota (%)', 'jasa_anggota');
			echo form_input($data);
			echo '
				</td>
				<td>';
			$data = array(
				'name'        => 'jasa_modal',
				'id'			=> 'jasa_modal',
				'class'		=> 'form-control',
				'value'       => $jasa_modal,
				'maxlength'   => '255',
				'style'       => 'width: 50%'
				);
			echo form_label('Jasa Modal Anggota (%)', 'jasa_modal');
			echo form_input($data);
			echo '
				</td>
			</tr>';
			

			//biaya admin
			echo '
			<tr>
				<td>';
			$data = array(
				'name'   		   => 'biaya_adm',
				'id'					=> 'biaya_adm',
				'class'				=> 'form-control',
				'value'      		=> $biaya_adm,
				'maxlength'   		=> '255',
				'style'      		=> 'width: 50%'
				);
			echo form_label('Biaya Administrasi (Rp)', 'biaya_adm');
			echo form_input($data);
			echo '
				</td>
				<td>';
			
			//dana pengurus 
			$data = array(
				'name'        => 'dana_pengurus',
				'id'			=> 'dana_pengurus',
				'class'		=> 'form-control',
				'value'       => $dana_pengurus,
				'maxlength'   => '255',
				'style'       => 'width: 50%'
				);
			echo form_label('Dana Pengurus (%)', 'dana_pengurus');
			echo form_input($data);
			echo '
				</td>
				<td>';
			//pjk pph 
			$data = array(
				'name'        => 'pjk_pph',
				'id'			=> 'pjk_pph',
				'class'		=> 'form-control',
				'value'       => $pjk_pph,
				'maxlength'   => '255',
				'style'       => 'width: 50%'
				);
			echo form_label('Pajak PPh (%)', 'pjk_pph');
			echo form_input($data);
			echo '
				</td>
			</tr>';

			//biaya denda
			echo '
			<tr>
				<td>';
			$data = array(
				'name'        => 'denda',
				'id'			=> 'denda',
				'class'		=> 'form-control',
				'value'       => $denda,
				'maxlength'   => '255',
				'style'       => 'width: 50%'
				);
			echo form_label('Biaya Denda (Rp)', 'denda');
			echo form_input($data);
			echo '
				</td>
				<td>';

			//dana karyawan 
			$data = array(
				'name'        => 'dana_karyawan',
				'id'			=> 'dana_karyawan',
				'class'		=> 'form-control',
				'value'       => $dana_karyawan,
				'maxlength'   => '255',
				'style'       => 'width: 50%'
				);
			echo form_label('Dana Karyawan (%)', 'dana_karyawan');
			echo form_input($data);
			echo '
				</td>
				<td></td>
			</tr>';

			//jumlah denda hari
			echo '<tr><td>';
			$data = array(
				'name'        => 'denda_hari',
				'id'			=> 'denda_hari',
				'class'		=> 'form-control',
				'value'       => $denda_hari,
				'maxlength'   => '25',
				'style'       => 'width: 50%'
				);
			echo form_label('Tempo Tanggal Pembayaran', 'denda_hari');
			echo form_input($data);
			echo '
				</td>
				<td>';
			
			//dana pendidikan
			$data = array(
				'name'        => 'dana_pend',
				'id'			=> 'dana_pend',
				'class'		=> 'form-control',
				'value'       => $dana_pend,
				'maxlength'   => '25',
				'style'       => 'width: 50%'
				);
			echo form_label('Dana Pendidikan (%)', 'dana_pend');
			echo form_input($data);
			echo '
				</td>
				<td></td>
			</tr>';
			//dana sosial 
			echo '
			<tr>
				<td></td>
				<td>';
			$data = array(
				'name'        => 'dana_sosial',
				'id'			=> 'dana_sosial',
				'class'		=> 'form-control',
				'value'       => $dana_sosial,
				'maxlength'   => '255',
				'style'       => 'width: 50%'
				);
			echo form_label('Dana Sosial (%)', 'dana_sosial');
			echo form_input($data);
			echo '
				</td>
				<td></td>
			</tr>

		</table>';

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
			</div><!-- /.box-body -->
		</div>
	</div>
</div>