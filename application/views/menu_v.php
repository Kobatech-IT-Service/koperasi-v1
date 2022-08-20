<a href="<?php echo site_url();?>" class="brand-link" style = "text-align:center;"> 
      
      <span class="brand-text font-weight-light">KOPERASI</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <a href="<?php echo site_url();?>" class="logo">
			<!-- Add the class icon to your logo image or logo icon to add the margining -->
			 <div class="py-4 text-bold" style="text-align:center;"><img height="100" src="<?php echo base_url().'assets/theme_admin/img/logo.png'; ?>"></div>
		</a>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          <li class="nav-item">
            <a href="<?php echo base_url(); ?>home" class="nav-link active">
             <img height="20" src="<?php echo base_url().'assets/theme_admin/img/home.png'; ?>">
              <p>
                Beranda
               
              </p>
            </a>
          </li>
            <li class="nav-item">
            <a href="<?php echo base_url(); ?>anggota" class="nav-link ">
             <img height="20" src="<?php echo base_url().'assets/theme_admin/img/anggota.png'; ?>">
              <p>
                Anggota
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
             	<img height="20" src="<?php echo base_url().'assets/theme_admin/img/uang.png'; ?>">
              <p>
                Simpanan
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
            
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>simpanan" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Setoran Tunai</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>penarikan" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Penarikan Tunai</p>
                </a>
              </li>
           
            </ul>
          </li>
          
         <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
             	<img height="20" src="<?php echo base_url().'assets/theme_admin/img/pinjam.png'; ?>">
              <p>
                Pinjaman
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
            
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>pengajuan" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Pengajuan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>pinjaman" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Pinjaman</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>bayar" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Bayar Angsuran</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="<?php echo base_url(); ?>pelunasan" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pinjaman Lunas</p>
                </a>
              </li>
           
            </ul>
          </li>
          
           <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
             	<img height="20" src="<?php echo base_url().'assets/theme_admin/img/transaksi.png'; ?>">
              <p>
                Transaksi
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
            
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>pemasukan_kas" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pemasukan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>pengeluaran_kas" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pengeluaran</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>transfer_kas" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Transfer</p>
                </a>
              </li>
           
            </ul>
          </li>
          
           <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
             		<img height="20" src="<?php echo base_url().'assets/theme_admin/img/laporan.png'; ?>">
              <p>
                Laporan
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
            
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>lap_anggota" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Lap Anggota</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>lap_kas_anggota" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kas Anggota</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>lap_tempo" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jatuh Tempo</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="<?php echo base_url(); ?>lap_macet" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kredit Macet</p>
                </a>
              </li>
                
              
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>lap_trans_kas" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Transaksi Kas</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="<?php echo base_url(); ?>lap_buku_besar" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Buku Besar</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="<?php echo base_url(); ?>lap_neraca" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Neraca Saldo</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="<?php echo base_url(); ?>lap_simpanan" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kas Simpanan</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="<?php echo base_url(); ?>lap_kas_pinjaman" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kas Pinjaman</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>lap_trans_kas" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Transaksi Kas</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="<?php echo base_url(); ?>lap_saldo" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Saldo Kas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>lap_laba" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Laba Rugi</p>
                </a>
              </li>
                <li class="nav-item">
                <a href="<?php echo base_url(); ?>lap_shu" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>SHU</p>
                </a>
              </li>
              
             </ul>
          </li>
           
           
           <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
             	<img height="20" src="<?php echo base_url().'assets/theme_admin/img/transaksi.png'; ?>">
              <p>
                Master
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
            
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>jenis_simpanan" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jenis Simpanan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>jenis_akun" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jenis Akun</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>jenis_kas" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Kas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>jenis_angsuran" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Lama Angsuran</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>data_barang" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Barang</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>user" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Pengguna</p>
                </a>
              </li>
           
            </ul>
          </li>
          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
             	<img height="20" src="<?php echo base_url().'assets/theme_admin/img/settings.png'; ?>">
              <p>
                Setting
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
            
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>profil" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Identitas Koprasi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>suku_bunga" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Suku Bunga</p>
                </a>
              </li>
          
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>