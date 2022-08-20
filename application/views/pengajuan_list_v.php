<style type="text/css">
	.modal-body { background-color: #fff;}
	.img-rounded { border: 1px solid #ccc !important;}
	.center-block { float: none; }
	td.bs-checkcard {vertical-align: middle !important;}
	.btn {margin-top: 2px; margin-bottom: 2px;}
	.select2-choices {
		min-height: 150px;
		max-height: 150px;
		overflow-y: auto;
	}
</style>
<div class = "container">
	<div class="row">
		<div class="card card-primary">
			<div class="card-body" style="min-height: 500px;">
				<div>
					<p style="text-align:center; font-size: 15pt; font-weight: bold;"> Data Pengajuan </p>
				</div>

				<div id="tb">
					<div id="filter_tgl" class="input-group" style="display: inline;">
						<button class="btn btn-default" id="daterange-btn">
							<i class="fa fa-calendar"></i> <span id="reportrange"><span>Tanggal</span></span>
							<i class="fa fa-caret-down"></i>
						</button>
						<select id="fr_jenis" name="fr_jenis"  autocomplete="false"  class="select2_jenis" style="display: inline-block; width: 150px; line-height: 20px; vertical-align: middle;" multiple="multiple">
							<option value="Biasa">Biasa</option>
							<option value="Darurat">Darurat</option>
							<option value="Barang">Barang</option>
						</select>
						<select id="fr_status" name="fr_status" class="select2_status" autocomplete="false"  style="display: inline-block; width: 150px; line-height: 20px; vertical-align: middle;" multiple="multiple">
							<option value="0">Menunggu Konfirmasi</option>
							<option value="1">Disetujui</option>
							<option value="2">Ditolak</option>
							<option value="3">Sudah Terlaksana</option>
							<option value="4">Batal</option>
						</select>
						<!--<input type="text" id="fr_bulan" name="fr_bulan" value="" style="display: inline-block; width: 50px; line-height: 20px; vertical-align: middle; background-color:#ddd;" readonly="true" title="Filter Untuk Per Tanggal 21 Sampai 20" />-->
						<a href="javascript:void(0);" id="fm_filter" class="btn btn-primary"><i class="fa fa-filter"></i> FILTER</a>
						<a href="javascript:void(0);" id="fm_cetak" class="btn bg-purple" onclick="cetak_laporan();"><i class="fa fa-print"></i> CETAK</a>
					</div>

				</div>

				<table 
					id="tablegrid"
					data-toggle="table"
					data-id-field="id"
					data-url="<?php echo site_url('pengajuan/ajax_pengajuan'); ?>" 
					data-query-params="queryParams"
					data-sort-name="tgl_input"
					data-sort-order="desc"
					data-pagination="true"
					data-toolbar="#tb"
					data-side-pagination="server"
					data-page-list="[5, 10, 25, 50, 100]"
					data-page-size="10"
					data-smart-display="false"
					data-select-item-name="tbl_terpil`ih"
					data-striped="true"
					data-search="false"
					data-method="post"
					data-content-type="application/x-www-form-urlencoded"
					data-cache="false" >
					<thead>
						<tr>
							<th data-field="id" data-switchable="false" data-visible="false">ID</th>
							<th data-field="ajuan_id" data-sortable="true" data-valign="middle" data-align="center" data-halign="center">ID Ajuan</th>
							<th data-field="tgl_input" data-sortable="true" data-valign="middle" data-align="center" data-halign="center" data-formatter="tgl_input_ft">Tanggal<br>Pengajuan</th>
							<th data-field="nama" data-sortable="true" data-valign="middle" data-align="left" data-halign="center" data-formatter="anggota_ft">Anggota</th>
							<th data-field="jenis" data-sortable="true" data-valign="middle" data-align="center" data-halign="center">Jenis</th>
							<th data-field="nominal" data-sortable="true" data-valign="middle" data-align="right" data-halign="center" data-formatter="nominal_ft">Jumlah</th>
							<th data-field="lama_ags" data-sortable="true" data-valign="middle" data-align="center" data-halign="center" data-formatter="lama_ags_ft" title="Jumlah Angsuran">Bln</th>
							<th data-field="keterangan" data-sortable="true" data-align="left" data-halign="center" data-valign="middle" data-formatter="keterangan_ft">Keterangan</th>
							<th data-field="tgl_update" data-sortable="true" data-valign="middle" data-align="center" data-halign="center" data-formatter="tgl_update_ft" data-visible="false">Tanggal Update</th>
							<th data-field="status" data-sortable="true" data-align="center" data-halign="center" data-valign="middle" data-formatter="status_ft">Status</th>
							<th data-field="alasan" data-sortable="true" data-align="left" data-halign="center" data-valign="middle" data-visible="false">Alasan</th>
							<th data-field="sisa_pinjaman" data-sortable="false" data-align="left" data-halign="center" data-valign="middle" data-formatter="sisa_ft">Sisa Pinjaman</th>
							<th data-field="aksi" data-sortable="false" data-align="center" data-halign="center" data-valign="middle" data-formatter="aksi_ft">Aksi</th>
						</tr>
					</thead>
				</table>
				<?php
					//var_dump($data_simpanan);
				?>

			</div><!--card-p -->
		</div><!--card-body -->
	</div><!--row -->


<!-- Modal -->

<div id="modal_aksi" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title">Konfirmasi</h4>
	</div>
      <div class="modal-body">
		<p class="modal_hasil">
			
		</p>
		<div id="div_alasan">
			
		</div>
	</div>
     	<div class="modal-footer">
		<button type="button" class="btn btn-default" id="link_konfirmasi_batal" data-dismiss="modal">Batal</button>
		<a href="javascript:void(0)" class="btn btn-primary" id="link_konfirmasi">OK</a>
	</div>
	</form>
    </div>
  </div>
</div>

</div>


<script type="text/javascript">

	function fm_filter_tgl() {
		$('#daterange-btn').daterangepicker({
			ranges: {
				'Hari ini': [moment(), moment()],
				'Kemarin': [moment().subtract('days', 1), moment().subtract('days', 1)],
				'7 Hari yang lalu': [moment().subtract('days', 6), moment()],
				'30 Hari yang lalu': [moment().subtract('days', 29), moment()],
				'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
				'Bulan kemarin': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')],
				'Tahun ini': [moment().startOf('year').startOf('month'), moment().endOf('year').endOf('month')],
				'Tahun kemarin': [moment().subtract('year', 1).startOf('year').startOf('month'), moment().subtract('year', 1).endOf('year').endOf('month')]
			},
			showDropdowns: true,
			format: 'YYYY-MM-DD',
			startDate: moment().startOf('year').startOf('month'),
			endDate: moment().endOf('year').endOf('month')
		},
		function(start, end) {
			$('#reportrange span').html(start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY'));
			//doSearch();
		});
	}

	function nominal_ft(value, row, index) {
		var nsi_out = '';
		if(row.status == 0) {
	    	nsi_out += '<a id="nominal_'+row.id+'" href="javascript:void(0);" class="" data-type="text" data-name="nominal" data-pk="'+row.id+'" data-url="<?php echo site_url('pengajuan/edit'); ?>" data-title="Masukan Nominal baru">'+value+'</a>';

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

	function keterangan_ft(value, row, index) {
		var nsi_out = '';
		if(row.status == 0) {
	    	nsi_out += '<a href="javascript:void(0);" class="editable" data-type="text" data-name="keterangan" data-pk="'+row.id+'" data-url="<?php echo site_url('pengajuan/edit'); ?>" data-title="Masukan Keterangan baru">'+value+'</a>';
	    } else {
	    	nsi_out += value;
	    }
		return nsi_out;
	}

	function sisa_ft(value, row, index) {
		var nsi_out = '';
		if(row.jenis != 'Darurat') {
			nsi_out += '<span class="text-muted">Sisa Jml Pinjaman:</span> '+row.sisa_jml;
			nsi_out += '<br><span class="text-muted">Sisa Jml Angsuran:</span> '+row.sisa_ags;
			nsi_out += '<br><span class="text-muted">Sisa Tagihan:</span> '+row.sisa_tagihan;
		}
		return nsi_out;
	}

	function status_ft(value, row, index) {
		var nsi_out = '';
		if(value == 0) {
			nsi_out += '<span class="text-primary"><i class="fa fa-question-circle"></i> Menunggu Konfirmasi';
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

	function anggota_ft(value, row, index) {
		nsi_out = '';
		nsi_out += '<a title="Lihat History Pinjaman Anggota" href="<?php echo site_url('lap_kas_anggota'); ?>/?anggota_id='+row.anggota_id+'">'+row.identitas+'</a><br>';
		nsi_out += '<strong>'+row.nama+'</strong><br>';
		nsi_out += row.departement;
		return nsi_out;
	}

	function lama_ags_ft(value, row, index) {
		var nsi_out = '';
		if(row.status == 0) {
	    	nsi_out += '<a id="lama_ags_'+row.id+'" href="javascript:void(0);" class="editable" data-type="select" data-name="lama_ags" data-pk="'+row.id+'" data-url="<?php echo site_url('pengajuan/edit'); ?>" data-title="Pilih Lama Angsuran baru">'+value+'</a>';
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
	function tgl_input_ft(value, row, index) {
		return '<span title="'+row.tgl_input+'">'+row.tgl_input_txt+'</span>';
	}
	function tgl_update_ft(value, row, index) {
		return '<span title="'+row.tgl_update+'">'+row.tgl_update_txt+'</span>';
	}

	function aksi_ft(value, row, index) {
		var nsi_out = '';
		<?php if($this->session->userdata('level') != 'operator') { ?>
			var link_diterima = '<a data-data_aksi="Setuju" data-data_id="'+row.id+'" class="a_diterima btn btn-sm btn-success" href="javascript:void(0);"><i class="fa fa-check-circle"></i> Setujui</a>';
			var link_ditolak = '<a data-data_aksi="Tolak" data-data_id="'+row.id+'" class="a_ditolak btn btn-sm btn-warning" href="javascript:void(0);"><i class="fa fa-times-circle"></i> Tolak</a>';
			var link_pending = '<a data-data_aksi="Pending" data-data_id="'+row.id+'" class="a_dipending btn btn-sm btn-primary" href="javascript:void(0);"><i class="fa fa-question-circle"></i> Pending</a>';
			var link_batal = '<a data-data_aksi="Batal" data-data_id="'+row.id+'" class="a_dibatal btn btn-sm btn-danger" href="javascript:void(0);"><i class="fa fa-trash-o"></i> Batal</a>';

			if(row.status == 0) {
				nsi_out += link_diterima + ' ' + link_ditolak;
			}
			if(row.status == 1) {
				nsi_out += link_ditolak + ' ' + link_pending;
			}
			if(row.status == 2) {
				nsi_out += link_diterima + ' ' + link_pending;
			}
			if(row.status != 4 && row.status == 0) {
				nsi_out += ' ' + link_batal;
			}
		<?php } ?>
		<?php if($this->session->userdata('level') != 'pinjaman') { ?>
			var link_terlaksana = ' <a data-data_aksi="Terlaksana" data-data_id="'+row.id+'" class="a_dilaksanakan btn btn-sm btn-info" href="javascript:void(0);"><i class="fa fa-rocket"></i> Sudah Dilaksanakan</a>';
			var link_belum = ' <a data-data_aksi="Belum" data-data_id="'+row.id+'" class="a_belum btn btn-sm btn-default" href="javascript:void(0);"><i class="fa fa-rocket"></i> Belum Dilaksanakan</a>';
			if(row.status == 1) {
				nsi_out += link_terlaksana;
			}
			if(row.status == 3) {
				nsi_out += link_belum;
			}
		<?php } ?>
		<?php if($this->session->userdata('level') == 'admin') { ?>
			nsi_out += ' <a data-data_aksi="Hapus" data-data_id="'+row.id+'" class="a_hapus btn btn-sm btn-danger" href="javascript:void(0);"><i class="fa fa-times-circle"></i> Hapus</a>';
		<?php } ?>
		nsi_out += ' <a href="<?php echo site_url('cetak_pengajuan/cetak');?>/'+row.id+'" target="_blank" class="btn btn-sm bg-purple"><i class="fa fa-print"></i> Cetak</a>';
		return  nsi_out;
	}


	$(function() {

		$('#fr_bulan').datepicker({
			format: "yyyy-mm",
			weekStart: 1,
			startView: 1,
			minViewMode: 1,
			language: "id",
			autoclose: true,
			clearBtn: true,
			todayHighlight: true
		});

		var $table = $('#tablegrid');

		$table.on('load-success.bs.table', function(event) {
			$('.editable').editable();
		});

		$table.on('click', '.a_diterima, .a_ditolak, .a_dipending, .a_hapus, .a_dilaksanakan, .a_belum, .a_dibatal', function(event) {
			var data_id = $(this).data('data_id');
			var data_aksi = $(this).data('data_aksi');

			$('#link_konfirmasi').show();
			$('#link_konfirmasi_batal').text('Batal');
			$('.modal_hasil').html('Apakah Yakin Ingin <strong>'+data_aksi+'</strong> Ajuan ini?');
			var fm_tgl_cair = '';
			if(data_aksi == 'Setuju') {
				data_default_tgl_cair = '<?php echo date('Y-m-d'); ?>';
				fm_tgl_cair = '<div id="div_tgl_cair" class="form-group">'+
										'<label>Tanggal Pencairan:</label>'+
										'<div class="input-group">'+
											'<div class="input-group-addon">'+
												'<i class="fa fa-calendar"></i>'+
											'</div>'+
											'<input name="tgl_cair" id="tgl_cair" type="text" class="datepicker form-control" style="width:100px;" value="'+data_default_tgl_cair+'">'+
										'</div>'+
									'</div>';
			}
			if(data_aksi == 'Hapus' || data_aksi == 'Batal' || data_aksi == 'Terlaksana' || data_aksi == 'Belum') {
				$('#div_tgl_cair').remove();
				$('#div_alasan_input').remove();
			} else {
				$('#div_alasan').show();
				$('#div_alasan').html('<div id="div_alasan_input" class="form-group"><label>Alasan:</label><input type="text" name="alasan" id="alasan" class="form-control" value=""></input></div>' + fm_tgl_cair);
			}
			$('#modal_aksi').modal('show');
			
			$('.modal-backdrop.fade.in').css('z-index', '1039');
			$('.modal-backdrop.fade.in').css('background-color', '#000');
			$('#link_konfirmasi').data('data_id', data_id);
			$('#link_konfirmasi').data('data_aksi', data_aksi);
			$('#link_konfirmasi').text('OK '+data_aksi);
			$('.datepicker').datepicker({
				format: "yyyy-mm-dd",
				weekStart: 1,
				language: "id",
				calendarWeeks: true,
				autoclose: true,
				todayHighlight: true
			});
		});


		$('#link_konfirmasi').click(function(event) {
			var data_id = $(this).data('data_id');
			var data_aksi = $(this).data('data_aksi');
			var data_alasan = $('#alasan').val();
			var data_tgl_cair = $('#tgl_cair').val();
			$.ajax({
				url: '<?php echo site_url('pengajuan/aksi'); ?>',
				type: 'POST',
				dataType: 'html',
				data: {id: data_id, aksi: data_aksi, tgl_cair: data_tgl_cair, alasan: data_alasan},
			})
			.done(function(data) {
				if(data == 'OK') {
					$('.modal_hasil').html('<div class="alert alert-success">Pengajuan Telah Sukses <strong>' + data_aksi + '</strong></div>');
					$('#link_konfirmasi').hide('slow');
					$('#div_alasan').hide('fast');
					$('#link_konfirmasi_batal').text('Tutup');
					$table.bootstrapTable('refresh');
				} else {
					$('.modal_hasil').html('<div class="alert alert-danger">Gagal, silahkan ulangi kembali. Kemungkinan data error atau sudah tidak ada.</div>');
				}
			})
			.fail(function() {
				alert('Error, Silahkan ulangi');
			});
		});

		// $(".datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
		fm_filter_tgl();
		$('.select2_jenis').select2({
			placeholder: "Semua Jenis"
		});
		$('.select2_status').select2({
			placeholder: "Semua Status"
		});
		$('#fm_filter').click(function(event) {
			$table.bootstrapTable('refresh');
		});
	});

	function queryParams(params) {
		//console.log(params);
		return {
 			"limit"		: params.limit,
 			"offset"		: params.offset,
 			//"search"		: params.search,
 			"sort"		: params.sort,
 			"order"		: params.order,
 			"fr_jenis"	: $('#fr_jenis').val(),
 			"fr_status"	: $('#fr_status').val(),
 			"fr_bulan"	: $('#fr_bulan').val(),
			"tgl_dari"	: $('input[name=daterangepicker_start]').val(),
			"tgl_sampai": $('input[name=daterangepicker_end]').val()		
		}
	}

	function cetak_laporan () {
		var fr_jenis	= $('#fr_jenis').val();
		var fr_status	= $('#fr_status').val();
		//var fr_bulan	= $('#fr_bulan').val();
		fr_bulan = "";
		var tgl_dari	= $('input[name=daterangepicker_start]').val();
		var tgl_sampai	= $('input[name=daterangepicker_end]').val();

		if(fr_jenis == null) { fr_jenis = '';}
		if(fr_status == null) { fr_status = '';}
		
		var win = window.open('<?php echo site_url("cetak_pengajuan/laporan/?fr_jenis=' + fr_jenis + '&fr_status=' + fr_status + '&fr_bulan=' + fr_bulan + '&tgl_dari=' + tgl_dari + '&tgl_sampai=' + tgl_sampai + '"); ?>');
		if (win) {
			win.focus();
		} else {
			alert('Popup jangan di block');
		}
	}

</script>