<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Member-Koperasi</title>
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
<body class="">

<div class="container">

	<?php $this->load->view('themes/member_menu_v'); ?>

	<div class="row">
		<div class="box box-primary">
			<div class="box-body">
				<div>
					<p style="text-align:center; font-size: 15pt; font-weight: bold;"> Laporan Data Kas Anggota </p>
				</div>
				<table  class="table table-bordered table-reponsive">
					<tr class="header_kolom">
						<th style="width:5%; vertical-align: middle; text-align:center">Photo</th>
						<th style="width:25%; vertical-align: middle; text-align:center"> Identitas  </th>
					</tr>
			<?php

				//pinjaman
				$pinjaman = $this->lap_kas_anggota_m->get_data_pinjam($user_id);
				$pinjam_id = @$pinjaman->id;
				$anggota_id = @$pinjaman->anggota_id;

				$jml_pj = $this->lap_kas_anggota_m->get_jml_pinjaman($anggota_id);
				$pj_anggota= @$jml_pj->total;

				//denda
				$denda = $this->lap_kas_anggota_m->get_jml_denda($pinjam_id);
				$tagihan= @$pinjaman->tagihan + $denda->total_denda;
				//dibayar
				$dibayar = $this->lap_kas_anggota_m->get_jml_bayar($pinjam_id);
				$sisa_tagihan = $tagihan - $dibayar->total;

				$peminjam_tot = $this->lap_kas_anggota_m->get_peminjam_tot($user_id);
				$peminjam_lunas = $this->lap_kas_anggota_m->get_peminjam_lunas($user_id);

				$tgl_tempo = explode(' ', @$pinjaman->tempo);
				$tgl_tempo_txt = jin_date_ina($tgl_tempo[0],'p');
				$tgl_tempo_r = $tgl_tempo[0];

				$tgl_tempo_rr = explode('-', $tgl_tempo_r);
				$thn = $tgl_tempo_rr[0];
				$bln = @$tgl_tempo_rr[1];

				if ((@$pinjaman->lunas == 'Belum') && (date('m') > $bln )){
					$data = 'Macet';
				} else {
					$data = 'Lancar';
				}

				//photo
				$photo_w = 3 * 20;
				$photo_h = 4 * 20;
				if($row->file_pic == '') {
					$photo ='<img src="'.base_url().'assets/theme_admin/img/photo.jpg" alt="default" width="'.$photo_w.'" height="'.$photo_h.'" />';
				} else {
					$photo= '<img src="'.base_url().'uploads/anggota/' . $row->file_pic . '" alt="Foto" width="'.$photo_w.'" height="'.$photo_h.'" />';
				}

				//jk
				if ($row->jk == "L") {
					$jk="Laki-Laki";
				} else {
					$jk="Perempuan"; 
				}

				//jabatan
				if ($row->jabatan_id == "1") {
					$jabatan="Pengurus"; 
				} else {
					$jabatan="Anggota"; 
				}

				$isi = '';
				if($data_pengajuan) {
					$status = '';
					if($data_pengajuan->status == 0) {
						$status = '<span class="text-primary"><i class="fa fa-question-circle"></i> Menunggu Konfirmasi</span>';
					}
					if($data_pengajuan->status == 1) {
						$status = '<span class="text-success"><i class="fa fa-check-circle"></i> Disetujui - Tgl Cair: '.jin_date_ina($data_pengajuan->tgl_cair, 'full').'</span>';
					}
					if($data_pengajuan->status == 2) {
						$status = '<span class="text-danger"><i class="fa fa-times-circle"></i> Ditolak</span>';
					}
					if($data_pengajuan->status == 3) {
						$status = '<span class="text-success"><i class="fa fa-rocket"></i> Terlaksana</span>';
					}
					if($data_pengajuan->status == 4) {
						$status = '<span class="text-warning"><i class="fa fa-trash-o"></i> Batal</span>';
					}

					$isi .= '<div class="alert alert-info">Pengajuan Pinjaman Mutakhir: <strong>'.jin_date_ina($data_pengajuan->tgl_update, 'full', true).'</strong> Nominal: <strong>'.number_format($data_pengajuan->nominal).'</strong> Status: <strong>'.$status.'</strong></div>';
				} else {
					$isi .= '<div class="alert alert-info">Belum ada Pengajuan Pinjaman</div>';
				}

			 	echo '
					<tr>
						<td class="h_tengah" style="vertical-align: middle "> '.$photo.'</td>
						<td> 
							<table class="table table-responsive">
								<tr><td> ID Anggota : '.'AG'.sprintf('%04d', $user_id).' </td></tr>
								<tr><td> Nama : <b>'.strtoupper($row->nama).'</b> </td></tr>
								<tr><td> Jenis Kelamin : '.$jk.' </td></tr>
								<tr><td> Jabatan : '.$jabatan.' </td></tr>
								<tr><td> Alamat  : '.$row->alamat.' Telp.'.$row->notelp.' </td></tr>
							</table>
						</td>
						</tr>
						</table>
						<br>

						'.$isi.'

						<h3>Saldo Simpanan</h3>
						<table class="table table-responsive">
						';

						$simpanan_arr = array();
						$simpanan_row_total = 0; 
						$simpanan_total = 0; 
						foreach ($data_jns_simpanan as $jenis) {
							$simpanan_arr[$jenis->id] = $jenis->jns_simpan;
							$nilai_s = $this->lap_kas_anggota_m->get_jml_simpanan($jenis->id, $user_id);
							$nilai_p = $this->lap_kas_anggota_m->get_jml_penarikan($jenis->id, $user_id);
							
							$simpanan_row=$nilai_s->jml_total - $nilai_p->jml_total;
							$simpanan_row_total += $simpanan_row;
							$simpanan_total += $simpanan_row_total;


							echo'
									<tr>
										<td style="width:150px;">'.$jenis->jns_simpan.'</td>
										<td style="width:150px;" class="h_kanan">'. number_format($simpanan_row).'</td>
										<td> </td>
									</tr>';
							}
							echo '<tr>
										<td><strong> Jumlah Simpanan </strong></td>
										<td class="h_kanan"><strong> '.number_format($simpanan_row_total).'</strong></td>
										<td> </td>
									</tr>
									</table>';
							echo '		
							<br>
							<h3>Tagihan Kredit</h3>
								<table class="table table-responsive"> 
									<tr>
										<td style="width:150px;"> Pokok Pinjaman</td>
										<td style="width:150px;" class="h_kanan">'.number_format(@nsi_round($pinjaman->jumlah)).'</td>
										<td> </td>
									</tr>
									<tr>
										<td> Tagihan + Denda </td> 
										<td class="h_kanan"> '.number_format(nsi_round($tagihan)).' </td>
										<td> </td>
									</tr>
									<tr>
										<td> Dibayar </td>
										<td class="h_kanan"> '.number_format(nsi_round($dibayar->total)).'</td>
										<td> </td>
									</tr>
									<tr>
										<td><strong> Sisa Tagihan</strong></td>
										<td class="h_kanan"> <strong>'.number_format(nsi_round($sisa_tagihan)).'</strong></td>
										<td> </td>
									</tr>
								</table>
							
								<br>
								<h3>Keterangan</h3>
								<table class="table table-responsive"> 
									<tr>
										<td style="width:150px;"> Jumlah Pinjaman </td>
										<td style="width:150px;" class="h_kanan">'.$peminjam_tot.'</td>
										<td> </td>
									</tr>
									<tr>
										<td> Pinjaman Lunas </td>
										<td class="h_kanan">'.$peminjam_lunas.'</td>
										<td> </td>
									</tr>
									<tr>
										<td> Pembayaran</td>
										<td class="h_kanan"> <code>'.$data.'</code></td>
										<td> </td>
									</tr>
									<tr>
										<td> Tanggal Tempo</td>
										<td class="h_kanan"> <code>'.$tgl_tempo_txt.'</code></td>
										<td> </td>
									</tr>
								</table>
							';
			?>
			<br>

			</div><!--box-p -->
		</div><!--box-body -->
	</div><!--row -->
</div>


	<!-- jQuery 2.0.2 -->
	<script src="<?php echo base_url(); ?>assets/theme_admin/js/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="<?php echo base_url(); ?>assets/theme_admin/js/bootstrap.min.js" type="text/javascript"></script>


<script type="text/javascript">

</script>

</body>
</html>