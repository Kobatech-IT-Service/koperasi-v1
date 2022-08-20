<?php
$a_home 				= $this->uri->segment(2) == 'view' ? 'active' : '';
$a_lap_simpanan 	= $this->uri->segment(2) == 'lap_simpanan' ? 'active' : '';
$a_lap_pinjaman 	= $this->uri->segment(2) == 'lap_pinjaman' ? 'active' : '';
$a_lap_bayar	 	= $this->uri->segment(2) == 'lap_bayar' ? 'active' : '';
$a_ubah_pic		 	= $this->uri->segment(2) == 'ubah_pic' ? 'active' : '';
$a_ubah_pass	 	= $this->uri->segment(2) == 'ubah_pass' ? 'active' : '';
$a_ajuan_list	 	= $this->uri->segment(2) == 'pengajuan' ? 'active' : '';
$a_ajuan_baru	 	= $this->uri->segment(2) == 'pengajuan_baru' ? 'active' : '';

$m_ajuan_arr = array('pengajuan', 'pengajuan_baru');
$open_ajuan = in_array($this->uri->segment(2), $m_ajuan_arr) ? 'active' : '';

$m_lap_arr = array('lap_simpanan', 'lap_pinjaman', 'lap_bayar');
$open_lap = in_array($this->uri->segment(2), $m_lap_arr) ? 'active' : '';

$m_prof_arr = array('ubah_pic', 'ubah_pass');
$open_prof = in_array($this->uri->segment(2), $m_prof_arr) ? 'active' : '';
?>

<!-- Static navbar -->
<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo site_url('member/view'); ?>"> </a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li class="<?php echo $a_home; ?>"><a href="<?php echo site_url('member/view'); ?>">Beranda</a></li>
				<li class="dropdown <?php echo $open_ajuan; ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pengajuan Pinjaman <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li class="<?php echo $a_ajuan_list; ?>"><a href="<?php echo site_url('member/pengajuan'); ?>">Data Pengajuan</a></li>
						<li role="separator" class="divider"></li>
						<li class="<?php echo $a_ajuan_baru; ?>"><a href="<?php echo site_url('member/pengajuan_baru'); ?>">Tambah Pengajuan Baru</a></li>
					</ul>
				</li>				
				<li class="dropdown <?php echo $open_lap; ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Laporan <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li class="<?php echo $a_lap_simpanan; ?>"><a href="<?php echo site_url('member/lap_simpanan'); ?>">Simpanan</a></li>
						<li role="separator" class="divider"></li>
						<li class="<?php echo $a_lap_pinjaman; ?>"><a href="<?php echo site_url('member/lap_pinjaman'); ?>">Pinjaman</a></li>
						<li class="<?php echo $a_lap_bayar; ?>"><a href="<?php echo site_url('member/lap_bayar'); ?>">Pembayaran</a></li>
					</ul>
				</li>				
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown <?php echo $open_prof; ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Profile <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li class="<?php echo $a_ubah_pic; ?>"><a href="<?php echo site_url('member/ubah_pic'); ?>">Ubah Profil</a></li>
						<li class="<?php echo $a_ubah_pass; ?>"><a href="<?php echo site_url('member/ubah_pass'); ?>">Ubah Password</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo site_url('member/logout'); ?>">Logout</a></li>
					</ul>
				</li>              
			</ul>
		</div><!--/.nav-collapse -->
	</div><!--/.container-fluid -->
</nav>