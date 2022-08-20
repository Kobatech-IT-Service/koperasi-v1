<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Pengajuan - SisKoMob</title>
	<link rel="shortcut icon" href="<?php echo base_url(); ?>icon.ico" type="image/x-icon" />
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<!-- bootstrap 3.0.2 -->
	<link href="<?php echo base_url(); ?>assets/theme_admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<!-- font Awesome -->
	<link href="<?php echo base_url(); ?>assets/theme_admin/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<!-- Theme style -->
	<link href="<?php echo base_url(); ?>assets/theme_admin/css/AdminLTE.css" rel="stylesheet" type="text/css" />

	<?php 
	foreach($css_files as $file) { ?>
		<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
	<?php } ?>	

	<link href="<?php echo base_url(); ?>assets/extra/bootstrap-table/bootstrap-table.min.css" rel="stylesheet" type="text/css" />
	
	<link href="<?php echo base_url(); ?>assets/theme_admin/css/custome.css" rel="stylesheet" type="text/css" />

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->
</head>
<body>

<div class="container">

	<?php $this->load->view('themes/member_menu_v'); ?>

	<div class="row">
		<div class="box box-primary">
			<div class="box-body" style="min-height: 500px;">
				<div>
					<p style="text-align:center; font-size: 15pt; font-weight: bold;"> Data Pengajuan </p>
				</div>
				<?php if($this->session->flashdata('ajuan_baru') == 'Y') { ?>
				<div class="box-body">
					<div class="alert alert-success alert-dismissable">
						<i class="fa fa-check"></i>
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						Pengajuan berhasil dikirim.
					</div>
				</div>
				<?php } ?>

				<?php if($this->session->flashdata('ajuan_batal') == 'Y') { ?>
				<div class="box-body">
					<div class="alert alert-success alert-dismissable">
						<i class="fa fa-check"></i>
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						Pengajuan berhasil dibatalkan.
					</div>
				</div>
				<?php } ?>

				<?php if($this->session->flashdata('ajuan_batal') == 'N') { ?>
				<div class="box-body">
					<div class="alert alert-warning alert-dismissable">
						<i class="fa fa-warning"></i>
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						Pengajuan tidak berhasil dibatalkan.
					</div>
				</div>
				<?php } ?>

				<table 
					id="tablegrid"
					data-toggle="table"
					data-id-field="id"
					data-url="<?php echo site_url('member/ajax_pengajuan'); ?>" 
					data-sort-name="tgl_input"
					data-sort-order="desc"
					data-pagination="true"
					data-toolbar=""
					data-side-pagination="server"
					data-page-list="[5, 10, 25, 50, 100]"
					data-page-size="10"
					data-smart-display="false"
					data-select-item-name="tbl_terpilih"
					data-striped="true"
					data-search="false"
					data-show-refresh="true"
					data-show-columns="true"
					data-show-toggle="true"
					data-method="post"
					data-content-type="application/x-www-form-urlencoded"
					data-cache="false" >
					<thead>
						<tr>
							<th data-field="id" data-switchable="false" data-visible="false">ID</th>
							<th data-field="tgl_input" data-sortable="false" data-valign="middle" data-align="center" data-halign="center" data-formatter="tgl_input_ft">Tanggal</th>
							<th data-field="jenis" data-sortable="false" data-valign="middle" data-align="center" data-halign="center">Jenis</th>
							<th data-field="nominal" data-sortable="false" data-valign="middle" data-align="right" data-halign="center" data-formatter="nominal_ft">Jumlah</th>
							<th data-field="lama_ags" data-sortable="true" data-valign="middle" data-align="center" data-halign="center" data-formatter="lama_ags_ft">Jml Angsur</th>
							<th data-field="keterangan" data-sortable="false" data-align="left" data-halign="center" data-valign="middle" data-formatter="keterangan_ft">Keterangan</th>
							<th data-field="alasan" data-sortable="true" data-align="left" data-halign="center" data-valign="middle">Alasan</th>
							<th data-field="tgl_update" data-sortable="true" data-valign="middle" data-align="center" data-halign="center" data-formatter="tgl_update_ft">Tanggal Update</th>
							<th data-field="status" data-sortable="false" data-align="center" data-halign="center" data-valign="middle" data-formatter="status_ft">Status</th>
							<th data-field="opsi" data-sortable="false" data-align="center" data-halign="center" data-valign="middle" data-formatter="opsi_ft">Opsi</th>
						</tr>
					</thead>
				</table>

				<?php
					//var_dump($data_simpanan);
				?>

			</div><!--box-p -->
		</div><!--box-body -->
	</div><!--row -->
</div>


	<!-- jQuery 2.0.2 -->
	<script src="<?php echo base_url(); ?>assets/theme_admin/js/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="<?php echo base_url(); ?>assets/theme_admin/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/extra/bootstrap-table/bootstrap-table.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/extra/bootstrap-table/extensions/filter-control/bootstrap-table-filter-control.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/extra/bootstrap-table/bootstrap-table-id-ID.js" type="text/javascript"></script>

	<?php foreach($js_files as $file) { ?>
		<script src="<?php echo $file; ?>"></script>
	<?php } ?>

<script type="text/javascript">

	$(function() {
		var $table = $('#tablegrid');

		$table.on('load-success.bs.table', function(event) {
			$('.editable').editable();
		});
	});

	function keterangan_ft(value, row, index) {
		var nsi_out = '';
		if(row.status == 0) {
	    	nsi_out += '<a href="javascript:void(0);" class="editable" data-type="text" data-name="keterangan" data-pk="'+row.id+'" data-url="<?php echo site_url('member/edit'); ?>" data-title="Masukan Keterangan baru">'+value+'</a>';
	    } else {
	    	nsi_out += value;
	    }
		return nsi_out;
	}

	function nominal_ft(value, row, index) {
		var nsi_out = '';
		if(row.status == 0) {
	    	nsi_out += '<a id="nominal_'+row.id+'" href="javascript:void(0);" class="editable" data-type="text" data-name="nominal" data-pk="'+row.id+'" data-url="<?php echo site_url('member/edit'); ?>" data-title="Masukan Nominal baru">'+value+'</a>';
				
				$('#nominal_'+row.id).editable({
						success: function(response, newValue) {
							if(!response) return 'Error';
							return {newValue: response}
						}
				});
	    } else {
	    	nsi_out += value;
	    }
		return nsi_out;
	}

	function tgl_input_ft(value, row, index) {
		return '<span title="'+row.tgl_input+'">'+row.tgl_input_txt+'</span>';
	}
	function tgl_update_ft(value, row, index) {
		return '<span title="'+row.tgl_update+'">'+row.tgl_update_txt+'</span>';
	}

	function lama_ags_ft(value, row, index) {
		var nsi_out = '';
		if(row.status == 0 && row.jenis != 'Darurat') {
	    	nsi_out += '<a id="lama_ags_'+row.id+'" href="javascript:void(0);" class="editable" data-type="select" data-name="lama_ags" data-pk="'+row.id+'" data-url="<?php echo site_url('member/edit'); ?>" data-title="Pilih Lama Angsuran baru">'+value+'</a>';
	    	$('#lama_ags_'+row.id).editable({
	    		value: value,
	    		source: [
		    		<?php 
		    		$no = 1;
		    		foreach ($jenis_ags as $row) {
		    			if($no > 1) { echo ','; }
			    		echo '{value: '.$row->ket.', text: \''.$row->ket.'\'}';
			    		$no++;
		    		} ?>
	    		]
	    	});
	    } else {
	    	nsi_out += value;
	    }
		return nsi_out;
	}

	function opsi_ft(value, row, index) {
		var nsi_out = '';
		if(row.status == 0) {
			nsi_out += '<a href="<?php echo site_url('member/pengajuan_batal')?>/'+row.id+'" class="btn btn-xs btn-danger" onclick="return confirm(\'Apakah yakin data ajuan ini akan dibatalkan?\')">Batal</a>';
		}
		return nsi_out;
	}

	function status_ft(value, row, index) {
		var nsi_out = '';
		if(value == 0) {
			nsi_out += '<span class="text-primary"><i class="fa fa-question"></i> Menunggu Konfirmasi';
		}
		if(value == 1) {
			nsi_out += '<span class="text-success"><i class="fa fa-check-circle"></i> Disetujui';
			nsi_out += '<br>Cair: ' + row.tgl_cair_txt;
		}
		if(value == 2) {
			nsi_out += '<span class="text-danger"><i class="fa fa-times-circle"></i> Ditolak';
		}
		if(value == 3) {
			nsi_out += '<span class="text-success"><i class="fa fa-rocket"></i> Terlaksana';
		}
		if(value == 4) {
			nsi_out += '<span class="text-warning"><i class="fa fa-trash-o"></i> Batal';
		}
		nsi_out += '</span>';
		return  nsi_out;
	}
</script>

</body>
</html>