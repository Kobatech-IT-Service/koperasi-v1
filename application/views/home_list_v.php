<style type="text/css">
	.row * {
		box-sizing: border-box;
	}
	.kotak_judul {
		 border-bottom: 1px solid #fff; 
		 padding-bottom: 2px;
		 margin: 0;
		 font-weight:300;
	}
</style>
<?php
$tanggal = date('Y-m');
$txt_periode_arr = explode('-', $tanggal);
	if(is_array($txt_periode_arr)) {
		$txt_periode = jin_nama_bulan($txt_periode_arr[1]) . ' ' . $txt_periode_arr[0];
	}

?>

<?php 
$total_tagihan = $jml_pinjaman->jml_total;
$total_denda = $jml_denda->total_denda;
$jml_tot_tagihan = $total_tagihan + $total_denda;

?>

<div class = "container">
<h4 class="page-header">
Selamat Datang
<small>
Hai, <?php echo $this->data['u_name']; ?> Silahkan pilih menu disamping untuk mengoprasikan aplikasi
</small>
</h4>

<div class="row" style="margin: 0 -15px;">
		<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
		<div class="small-box bg-yellow">
			<div class="inner">
				<h2 class="kotak_judul"> Pinjaman Kredit</h2>
				<table>
					<tr>
						<td class="h_kanan"><strong style="font-size: 20px;"><?php echo $peminjam;?></strong></td>
						<td> &nbsp; Transaksi Bulan Ini </td>
					</tr>
					<tr>
						<td class="h_kanan">
							<strong style="font-size: 20px;">
								<?php 
							echo number_format(nsi_round($jml_tot_tagihan));	
				 			?>
							</strong>
						</td>
						<td> &nbsp;Jml Tagihan Tahun Ini</td>
					</tr>
					<tr>
						<td class="h_kanan">
							<strong style="font-size: 20px;"> <?php echo number_format(nsi_round($jml_tot_tagihan - $jml_angsuran->jml_total)); ?></strong>
						</td>
						<td> &nbsp; Sisa Tagihan Tahun Ini </td>
					</tr>
				</table>
			</div>
			<div class="icon">
				<i class="fa fa-money"></i>
			</div>
			<a class="small-box-footer" href="<?php echo base_url(); ?>lap_kas_pinjaman">
				More info
				<i class="fa fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>

	<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
		<div class="small-box bg-green">
			<div class="inner">
				<h2 class="kotak_judul"> Simpanan <?php echo $txt_periode ?> </h2>
				<table>
					<tr>
						<td class="h_kanan"><strong style="font-size: 20px;"><?php echo number_format(nsi_round($jml_simpanan->jml_total)); ?></strong></td>
						<td> &nbsp; Simpanan Anggota</td>
					</tr>
					<tr>
						<td class="h_kanan"><strong style="font-size: 20px;"><?php echo number_format(nsi_round($jml_penarikan->jml_total)); ?></strong></td>
						<td> &nbsp; Penarikan Tunai</td>
					</tr>
					<tr>
						<td class="h_kanan"><strong style="font-size: 20px;"><?php echo number_format(nsi_round($jml_simpanan->jml_total - $jml_penarikan->jml_total)); ?></strong></td>
						<td> &nbsp; Jumlah Simpanan </td>
					</tr>
				</table>
			</div>
			<div class="icon">
				<i class="ion ion-ios7-briefcase-outline"></i>
			</div>
			<a class="small-box-footer" href="<?php echo base_url(); ?>lap_simpanan">
				More info
				<i class="fa fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>

	<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
		<div class="small-box bg-purple">
			<div class="inner">
				<h2 class="kotak_judul"> Kas Bulan <?php echo $txt_periode ?>

				 </h2>
				<table>
					<tr>
						<td class="h_kanan"><strong style="font-size: 20px;">
						<?php 
							$debet = $kas_debet->jml_total;
							echo number_format(nsi_round($debet));			
				 		?> 
				 	</strong></td>
						<td> &nbsp; Debet</td>
					</tr>
					<tr>
						<td class="h_kanan"><strong style="font-size: 20px;">
						<?php 
							$kredit = $kas_kredit->jml_total;
							echo number_format(nsi_round($kredit))
						?> 
						</strong></td>
						<td> &nbsp; Kredit</td>
					</tr>
					<tr>
						<td class="h_kanan"><strong style="font-size: 20px;"><?php echo number_format(nsi_round($debet - $kredit)); ?></strong></td>
						<td> &nbsp; Jumlah </td>
					</tr>
				</table>
			</div>
			<div class="icon">
				<i class="fa fa-book"></i>
			</div>
			<a class="small-box-footer" href="<?php echo base_url(); ?>lap_saldo">
				More info
				<i class="fa fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>

	<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
		<div class="small-box bg-blue">
			<div class="inner">
				<h2 class="kotak_judul"> Data Anggota</h2>
				<table>
					<tr>
						<td class="h_kanan"><strong style="font-size: 20px;"><?php echo $anggota_aktif;?></strong></td>
						<td> &nbsp; Anggota Aktif</td>
					</tr>
					<tr>
						<td class="h_kanan"><strong style="font-size: 20px;"><?php echo $anggota_non;?></strong></td>
						<td> &nbsp; Anggota Tidak Aktif</td>
					</tr>
					<tr>
						<td class="h_kanan"><strong style="font-size: 20px;"><?php echo $anggota_all;?></strong></td>
						<td> &nbsp; Jumlah Anggota</td>
					</tr>
				</table>
			</div>
			<div class="icon">
				<i class="ion ion-person-add"></i>
			</div>
			<a class="small-box-footer" href="<?php echo base_url(); ?>lap_anggota">
				More info
				<i class="fa fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>

		<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
		<div class="small-box bg-red">
			<div class="inner">
				<h2 class="kotak_judul"> Data Peminjam</h2>
				<table>
					<tr>
						<td class="h_kanan"><strong style="font-size: 20px;"><?php echo $peminjam_aktif;?></strong></td>
						<td> &nbsp; Peminjam</td>
					</tr>
					<tr>
						<td class="h_kanan"><strong style="font-size: 20px;"><?php echo $peminjam_lunas;?></strong></td>
						<td> &nbsp; Sudah Lunas</td>
					</tr>
					<tr>
						<td class="h_kanan"><strong style="font-size: 20px;"><?php echo $peminjam_belum;?></strong></td>
						<td> &nbsp; Belum Lunas </td>
					</tr>
				</table>
			</div>
			<div class="icon">
				<i class="fa fa-calendar"></i>
			</div>
			<a class="small-box-footer" href="<?php echo base_url(); ?>pinjaman">
				More info
				<i class="fa fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>

	<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
		<div class="small-box bg-aqua">
			<div class="inner">
				<h2 class="kotak_judul"> Data Pengguna</h2>
				<table>
					<tr>
						<td class="h_kanan"><strong style="font-size: 20px;">
						<?php echo $user_aktif;?>
				 	</strong></td>
						<td> &nbsp; User Aktif</td>
					</tr>
					<tr>
						<td class="h_kanan"><strong style="font-size: 20px;">
						<?php echo $user_non;?>
						</strong></td>
						<td> &nbsp; User Non-Aktif</td>
					</tr>
					<tr>
						<td class="h_kanan"><strong style="font-size: 20px;"><?php echo $user_aktif + $user_non;?></strong></td>
						<td> &nbsp; Jumlah User </td>
					</tr>
				</table>
			</div>
			<div class="icon">
				<i class="fa  fa-users"></i>
			</div>
			<a class="small-box-footer" href="<?php echo base_url(); ?>user">
				More info
				<i class="fa fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
</div>
</div>
