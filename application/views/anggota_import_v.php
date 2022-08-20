<?php
$form_view = true;

if ($this->session->flashdata('import')) {
	if ( ($this->session->flashdata('import')) == 'OK' ) {
		echo '
				<div class="alert alert-success">
					<h4><i class="icon fa fa-check"></i> Import Berhasil!</h4>
					Data import sudah masuk database.
				</div>
		';
	}
	if ( ($this->session->flashdata('import')) == 'NO' ) {
		echo '
				<div class="alert alert-danger">
					<h4><i class="icon fa fa-ban"></i> Ada kesalahan Tehnis!</h4>
					Import tidak berhasil, silahkan ulangi.
				</div>
		';
	}

	if ( ($this->session->flashdata('import')) == 'BATAL' ) {
		echo '
				<div class="alert alert-info">
					<h4><i class="icon fa fa-info"></i> Import Dibatalkan</h4>
					Data import telah dibatalkan. Silahkan upload ulang dengan data yang sudah OK.
				</div>
		';
	}	
}

if (isset($error)) {
	echo '
			<div class="alert alert-danger">
				<h4><i class="icon fa fa-ban"></i> Ada kesalahan!</h4>
				'.$error.'
			</div>
	';
} 

if(isset($header)) {
	$hidden_arr = array();
	//var_dump($header);
	//var_dump($values);

	echo '<h3>';
	echo 'Data Yang akan diimport';
	echo '</h3>';
	echo '<table class="table table-responsive">';
	echo '<thead>';
	echo '<tr>';
	echo '<th>No</th>';
	foreach ($header as $row) {
		echo '<th>'.$row.'</th>';
	}
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
	$no = 1;
	foreach ($values as $kolom) {
		echo '<tr>';
		echo '<td>'.$no.'</td>'; $no++;
		foreach ($kolom as $key => $row) {
			echo '<td>'.$row.'</td>';
			$hidden_arr['A_'.$no][$key] = $row;
		}
		echo '</tr>';
	}
	echo '</tbody>';
	echo '</table>';
	echo '
			<div class="alert alert-info">
				<h4><i class="icon fa fa-info"></i> Info</h4>
				Pastikan data sesuai dengan yang akan diimport, hindari duplikat data, cek kembali pada daftar anggota, apakah data diatas memang belum ada di database.<br>
				Klik BATAL IMPORT untuk memperbaiki data sebelum diimport.
			</div>
		';
	//$hidden = $values;
	echo form_open('anggota/import_db', '', array('val_arr' => $hidden_arr));
	echo '<input name="submit" type="submit" class="btn btn-primary" value="IMPORT DATA ANGGOTA KE DATABASE" />';
	//echo '<a href="'.site_url('anggota/import_db').'" class="btn btn-primary">IMPORT DATA ANGGOTA KE DATABASE</a>';
	echo ' <a href="'.site_url('anggota/import_batal').'" class="btn btn-warning">BATAL IMPORT</a>';
	echo form_close();
	$form_view = false;
}
?>
<?php if($form_view) { ?>
	<?php echo form_open_multipart('');?>

	<input type="file" name="import_anggota" size="20" accept="application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />
	<br /><br />
	<input name="submit" type="submit" class="btn btn-primary" value="Upload" />

	<?php echo form_close(); ?>
<?php } ?>