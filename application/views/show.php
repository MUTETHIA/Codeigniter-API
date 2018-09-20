<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Engineer API</title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
	<script src="<?php echo base_url(); ?>jquery/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
	<h1 class="page-header text-center">Engineer First API Developed</h1>
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
			<button class="btn btn-primary" id="add"><span class="glyphicon glyphicon-plus"></span> Add New</button>
			<table class="table table-bordered table-striped" style="margin-top:20px;">
				<thead>
					<tr>
					    <th>Serial</th>
                        <th>First Name</th>
                        <th>Last Name</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody id="tbody">
				</tbody>
			</table>
		</div>
	</div>
	<?php echo $modal; ?>

<script type="text/javascript">
$(document).ready(function(){
	//create a global variable for our base url
	var url = '<?php echo base_url(); ?>';

	//fetch table data
	showTable();

	//show add modal
	$('#add').click(function(){
		$('#addnew').modal('show');
		$('#addForm')[0].reset();
	});

	//submit add form
	$('#addForm').submit(function(e){
		e.preventDefault();
		var user = $('#addForm').serialize();
			$.ajax({
				type: 'POST',
				url: url + 'user/insert',
				data: user,
				success:function(){
					$('#addnew').modal('show');
                     $('#info').html('<div class="alert alert-success">Record successfully saved.</div>');
					showTable();
				}
			});
	});

	//show edit modal
	$(document).on('click', '.edit', function(){
		var id = $(this).data('id');
		$.ajax({
			type: 'POST',
			url: url + 'user/getuser',
			dataType: 'json',
			data: {id: id},
			success:function(response){
				console.log(response);
                $('#fname').val(response.first_name);
                $('#lname').val(response.last_name);
				$('#email').val(response.email);
                $('#phone').val(response.phone);
				$('#userid').val(response.id);
				$('#editmodal').modal('show');
			}
		});
	});

	//update selected user
	$('#editForm').submit(function(e){
		e.preventDefault();
		var user = $('#editForm').serialize();
		$.ajax({
			type: 'POST',
			url: url + 'user/update',
			data: user,
			success:function(){
				$('#editmodal').modal('hide');
				showTable();
			}
		});
	});

	//show delete modal
	$(document).on('click', '.delete', function(){
		var id = $(this).data('id');
		$.ajax({
			type: 'POST',
			url: url + 'user/getuser',
			dataType: 'json',
			data: {id: id},
			success:function(response){
				console.log(response);
				$('#delfname').html(response.fname);
				$('#delid').val(response.id);
				$('#delmodal').modal('show');
			}
		});
	});

	$('#delid').click(function(){
		var id = $(this).val();
		$.ajax({
			type: 'POST',
			url: url + 'user/delete',
			data: {id: id},
			success:function(){
				$('#delmodal').modal('hide');
				showTable();
			}
		});
	});

});

function showTable(){
	var url = '<?php echo base_url(); ?>';
	$.ajax({
		type: 'POST',
		url: url + 'user/show',
		success:function(response){
			$('#tbody').html(response);
		}
	});
}
</script>
</div>
</body>
</html>