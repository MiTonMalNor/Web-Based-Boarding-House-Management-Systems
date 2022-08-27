<?php include('db_connect.php');?>

<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<div class="col-md-4">
			<form action="" id="manage-room">
				<div class="card">
					<div class="card-header">
						    Add New Room
				  	</div>
					<div class="card-body">
							<div class="form-group" id="msg"></div>
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">Room No</label>
								<input type="text" class="form-control" name="room_no" required="">
							</div>
							<div class="form-group">
								<label for="" class="control-label">Description</label>
								<textarea name="description" id="" cols="30" rows="4" class="form-control" required></textarea>
							</div>
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-sm btn-info col-sm-3 offset-md-3"> Save</button>
								<button class="btn btn-sm btn-default col-sm-3" type="reset" > Cancel</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			</div>
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
						<b>Room List</b>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center"><b>#</th>
									<th class="text-center"><b>Room</th>
									<th class="text-center"><b>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$room = $conn->query("SELECT * FROM rooms order by id asc");
								while($row=$room->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><b><?php echo $i++ ?></td>
									<td class="">
										<p><b>Room Number:</b> <?php echo $row['room_no'] ?></p>
										<p><small><b>Description:</b> <?php echo $row['description'] ?></small></p>
									</td>
									<td class="text-center">
										<center><button class="btn btn-sm btn-success col-md-5 offset-sm-1 edit_room" type="button" data-id="<?php echo $row['id'] ?>"  data-room_no="<?php echo $row['room_no'] ?>" data-description="<?php echo $row['description'] ?>" >Edit</button></center>
										
									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

</div>
<style>
	
	td{
		vertical-align: middle !important;
	}
	td p {
		margin: unset;
		padding: unset;
		line-height: 1em;
	}
</style>
<script>
	$('#manage-room').on('reset',function(e){
		$('#msg').html('')
	})
	$('#manage-room').submit(function(e){
		e.preventDefault()
		start_load()
		$('#msg').html('')
		$.ajax({
			url:'ajax.php?action=save_room',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully saved",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
				else if(resp==2){
					$('#msg').html('<div class="alert alert-danger">Room number already exist.</div>')
					end_load()
				}
			}
		})
	})
	$('.edit_room').click(function(){
		start_load()
		var cat = $('#manage-room')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='room_no']").val($(this).attr('data-room_no'))
		cat.find("[name='description']").val($(this).attr('data-description'))
		end_load()
	})
	$('.delete_room').click(function(){
		_conf("Are you sure to delete this room?","delete_room",[$(this).attr('data-id')])
	})
	function delete_room($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_room',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
	$('table').dataTable()
</script>