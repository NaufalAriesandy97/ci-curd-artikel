<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Artikelkan Ajax</title>

    <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">

  	</head>
<body>
	<div class="container">
	<div class="col-md-10 col-md-offset-1">
    <h1 style="font-family: Harrington; font-size: 60px; ">Artikelkan</h1><hr>
    <button class="btn btn-sm btn-success" onclick="add_artikel()"><i class="glyphicon glyphicon-plus"></i> Add Artikel</button>
    <br><br>
    <table id="table_id" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
    	<thead>
    		<tr class="success">
    			<th>No</th>
    			<th>Judul Artikel</th>
	        	<th>Isi Artikel</th>
	        	<th>Penulis</th>
	        	<th width="80px;">Tanggal</th>
	        	<th width="120px;">Aksi</th>
        	</tr>
      	</thead>

      	<tbody>
      	<?php
      		$i = 0;
      		foreach ($artikel as $m)
      		{
              $i++;
        ?>
            <tr>
            	<td align=""><?php echo $i; ?></td>
                <td align=""><?php echo $m->judul; ?></td>
                <td align=""><?php echo substr($m->isi, 0, 50) ?> ...</td>
                <td align=""><?php echo $m->penulis; ?></td>
                <td align=""><?php echo date(' j F Y ',strtotime($m->tanggal));?></td>
                <td>
                	<button class="btn btn-sm btn-danger" onclick="delete_artikel(<?php echo $m->kd_artikel;?>)"><i class="glyphicon glyphicon-trash"></i> Delete</button>
                	<button class="btn btn-sm btn-warning" onclick="edit_artikel(<?php echo $m->kd_artikel;?>)"><i class="glyphicon glyphicon-edit"></i> Edit</button>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    </div>
    </div>

    <script src="<?php echo base_url('assets/jquery/jquery-3.3.1.min.js')?>"></script>
    <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
	<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
	<script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>

	<script type="text/javascript">
	$(document).ready( function ()
	{
		$('#table_id').DataTable();
	} );
 
    var save_method;
    var table;

    function add_artikel()
    {
    	save_method = 'add';
    	$('#form')[0].reset();
    	$('#modal_form').modal('show');
    }

    function edit_artikel(kd_artikel)
    {
    	save_method = 'update';
    	$('#form')[0].reset();
    	$.ajax({
    		url : "<?php echo site_url('index.php/artikel/ajax_edit/')?>/" + kd_artikel,
    		type: "GET",
	        dataType: "JSON",
	        success: function(data)
	        {
	        	$('[name="kd_artikel"]').val(data.kd_artikel);
	            $('[name="judul"]').val(data.judul);
	            $('[name="isi"]').val(data.isi);
	            $('[name="penulis"]').val(data.penulis);
	            $('[name="tanggal"]').val(data.tanggal);

	            $('#modal_form').modal('show');
	            $('.modal-title').text('Edit Artikel');
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	            alert('Error get data from ajax');
	        }
	    });
    }

    function save()
    {
    	var url;
    	if(save_method == 'add')
    	{
    		url = "<?php echo site_url('index.php/artikel/artikel_add')?>";
    	}
    	else
    	{
    		url = "<?php echo site_url('index.php/artikel/artikel_update')?>";
    	}
        $.ajax({
       		url : url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data)
            {
            	$('#modal_form').modal('hide');
            	location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
    }

    function delete_artikel(kd_artikel)
    {
    	if(confirm('Are you sure delete this data?'))
    	{
    		$.ajax({
    			url : "<?php echo site_url('index.php/artikel/artikel_delete')?>/"+kd_artikel,
	            type: "POST",
	            dataType: "JSON",
	            success: function(data)
	            {
	            	location.reload();
	            },
	            error: function (jqXHR, textStatus, errorThrown)
	            {
	            	alert('Error deleting data');
	            }
            });
    	}
    }
  </script>

 <div class="modal fade" id="modal_form" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Input Data Artikel</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="kd_artikel"/>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-2">Judul Artikel</label>
              <div class="col-md-9">
                <input class="form-control" placeholder="judul artikel" name="judul" type="text" autofocus required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-2">Isi Artikel</label>
              <div class="col-md-9">
                <textarea name="isi" placeholder="isi artikel" class="form-control" rows="10" required></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-2">Penulis</label>
              <div class="col-md-9">
                <input class="form-control" placeholder="penulis" name="penulis" type="text" autofocus required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-2">Tanggal Posting</label>
              <div class="col-md-9">
                <input class="form-control datepicker" placeholder="(YYYY-MM-DD)" name="tanggal" type="text" autofocus required>
              </div>
            </div>
          </div>
        </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>