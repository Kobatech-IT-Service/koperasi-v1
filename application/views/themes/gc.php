<?php
if(!isset($_SESSION)) { session_start(); } 
ob_start();
$this->load->helper('cookie');
function destroyCookies($prefix){
  if(isset($_COOKIE)){
    foreach($_COOKIE as $i => $v){
      if(preg_match("/^$prefix/", $i)){
        //setcookie($i, '', time()-(1*24*60*60*1000)); unset($_COOKIE[$i]);
        //echo $i.'<br>';
      	delete_cookie($i);
      }
    }

  }
}
destroyCookies('hidden_sorting_');
ob_end_flush();
?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?php echo $this->load->get_section('judul_browser');?> - Koperasi</title>
	<link rel="shortcut icon" href="<?php echo base_url(); ?>icon.ico" type="image/x-icon" />
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

	<?php 
	foreach($css_files as $file): ?>
		<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
	<?php endforeach; ?>

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

	<link href="<?php echo base_url(); ?>assets/theme_admin/css/custome.css" rel="stylesheet" type="text/css" />

	<!-- jQuery 2.0.2 -->
	<script src="<?php echo base_url(); ?>assets/theme_admin/js/jquery.min.js"></script>
	
		<!-- Bootstrap -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	

	<?php foreach($js_files as $file): ?>
		<script src="<?php echo $file; ?>"></script>
	<?php endforeach; ?>


	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	 <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	 <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	 <![endif]-->
</head>
<body class="skin-blue">
	<!-- header logo: style can be found in header.less -->
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
   
      
	    <?php $this->load->view('notifikasi_v'); ?>
      <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <?php echo $this->load->get_section('u_name');?>
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
				<h1>
					<?php echo $this->load->get_section('judul_utama');?> 
					<small> <?php echo $this->load->get_section('judul_sub');?> </small>
				</h1>
			</div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li> 
						<i class="fa fa-calendar"></i> <?php echo date('d M Y'); ?> &nbsp; 
						<i class="fa fa-clock-o"></i> <?php echo date('H:i'); ?>
					<i class="fa fa-clock-o"></i> <span  class="jam"></span>
    			</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
 <!-- Main content -->
    <section class="content">
				<?php echo $this->load->get_section('sebelum_gc_list');?> 
				<?php echo $output; ?>
				<?php echo $this->load->get_section('setelah_gc_list');?> 
		</section>
    <!-- /.content -->
  </div>
</div>

	<!-- Bootstrap -->
	<script src="<?php echo base_url(); ?>assets/theme_admin/js/bootstrap.min.js" type="text/javascript"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo base_url(); ?>assets/theme_admin/js/adminlte.js" type="text/javascript"></script>

</body>
</html>