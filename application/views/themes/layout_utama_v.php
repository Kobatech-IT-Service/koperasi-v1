<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?php echo $judul_browser;?> - KOPERASI</title>
	<link rel="shortcut icon" href="<?php echo base_url(); ?>icon.ico" type="image/x-icon" />
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<!-- bootstrap 3.0.2 
	<link href="<?php echo base_url(); ?>assets/theme_admin/css/bootstrap.css" rel="stylesheet" type="text/css" />-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!-- font Awesome -->
	<link href="<?php echo base_url(); ?>assets/theme_admin/fontawsome/css/all.min.css" rel="stylesheet" type="text/css" />
	
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Ionicons -->
	<link href="<?php echo base_url(); ?>assets/theme_admin/css/ionicons.min.css" rel="stylesheet" type="text/css" />
	<!-- Theme style -->
	<link href="<?php echo base_url(); ?>assets/theme_admin/css/adminlte.css" rel="stylesheet" type="text/css" />

	<?php 
	foreach($css_files as $file) { ?>
		<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
	<?php } ?>
	
	
	<link href="<?php echo base_url(); ?>assets/theme_admin/css/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" />	

	<link href="<?php echo base_url(); ?>assets/theme_admin/css/custome.css" rel="stylesheet" type="text/css" />	

	<!-- jQuery 2.0.2 -->
	<script src="<?php echo base_url(); ?>assets/theme_admin/js/jquery.min.js"></script>
	
	<!-- Bootstrap -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	
	<script src="<?php echo base_url(); ?>assets/theme_admin/js/jqClock.min.js" type="text/javascript"></script>

	<?php foreach($js_files as $file) { ?>
		<script src="<?php echo $file; ?>"></script>
	<?php } ?>

	<!-- AdminLTE App -->
	<script src="<?php echo base_url(); ?>assets/theme_admin/js/adminlte.js" type="text/javascript"></script>

	<?php foreach($js_files2 as $file) { ?>
		<script src="<?php echo $file; ?>"></script>
	<?php } ?>
	<!-- Waktu -->
	<script type="text/javascript">
    $(document).ready(function(){    
      $(".jam").clock({"format":"24","calendar":"false"});
    });    
  </script>
	
</head>
<body class="skin-blue">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light" style = "background-color:#17a2b83b;">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      
    </ul>


    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
   
      
		<?php
		
		if (! empty ($notif_v)) {
			echo $notif_v;
		}
		?>	
      <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <?php echo $u_name; ?>
              <i class="far fa-user"></i>
              
            </a>
            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
              <a href="<?php echo base_url();?>ubah_password" class="dropdown-item">
               Ubah Password
              </a>
              <a href="<?php echo base_url();?>login/logout" class="dropdown-item">
               Logout
              </a>
             </div>
        </li>
      
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <!-- Sidebar user panel -->
				<!-- sidebar menu: : style can be found in sidebar.less -->
				<?php $sub_view['level'] = $this->session->userdata('level'); ?>
				<?php $this->load->view('menu_v', $sub_view); ?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo $judul_utama;?> 
					<small> <?php echo $judul_sub;?> </small></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li> 
    				<i class="fa fa-calendar"></i> <?php echo date('d F Y'); ?> &nbsp; 
    				<i class="fa fa-clock-o"></i> <span  class="jam"></span>
    			</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <?php
		if (! empty ($isi)){
			echo $isi;
		}
		?>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="https://kobatech.id">KOBATECH.ID</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
</body>
</html>