<?php 
// Pengajuan
$jml_ajuan = count($notif_pengajuan);
$link_pengajuan = site_url('pengajuan');
if($jml_ajuan > 0) {
	?>
	   <li class="nav-item ">
        <a class="nav-link"  href="<?php echo $link_pengajuan; ?>">
          <i class="far fa-envelope"></i>
          <span class="badge badge-danger navbar-badge"><?php echo $jml_ajuan; ?></span>
        </a>
        
      </li>
<?php
} else { ?>
   <li class="nav-item ">
        <a class="nav-link"  href="<?php echo $link_pengajuan; ?>">
          <i class="far fa-envelope"></i>
          
        </a>
        
      </li>

	<?php
} ?>

<?php 
// Jatuh tempo
$jml = count($notif_tempo);
$txt_sis = array();
foreach ($notif_tempo as $row) {
	if($row->tempo != 0) {
		//$jml++;
		$tgl_tempo = explode(' ', $row->tempo);
		$tgl_tempo = jin_date_ina($tgl_tempo[0], 'p');
		$txt_sis[] = '
		
		
			Jatuh tempo pada tgl <span class="badge bg-blue">'.
			$tgl_tempo.'</span><br /> 
			Sisa Senilai <span class="badge bg-purple">'.number_format(nsi_round(($row->tagihan + $row->jum_denda) - $row->jum_bayar)).'</span>
		
				<h5><strong>nama : '.$row->nama.'</strong> <i><span style="font-size: 8px;"></span></i></h5>
			';
	}
}

?>


<li class="nav-item dropdown">

		<?php
		if($jml > 0) {
		  	?>
		 <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge"><?= $jml ?></span>
        </a>
		    
	
	<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Anda Mendapat <span class="badge bg-red"><?php echo $jml; ?></span> Notifikasi</span>
          <div class="dropdown-divider"></div>
          <?php
				foreach ($txt_sis as $row) {
		  ?>
				<a href="<?= site_url() ?>bayar" class="dropdown-item">
               	
				<div style="padding: 0 5px;">
				 <?= $row ?>
				 </div>
				</a> 
				    
          <?php 
				}
          ?>
          
         
        
    </div>
	

	<?php } else {
	    
	    ?>
	     <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          
        </a>
		
	
	<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Notifikasi</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> Saat ini tidak ada Notifikasi
            
          </a>
        
    </div>
        


<script type="text/javascript">
	$(document).ready(function() {
		$(".slimScrollDiv").height(100);
	});

</script>

	<?php
		}
		?>
</li>