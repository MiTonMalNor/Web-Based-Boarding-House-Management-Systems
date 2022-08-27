
<?php include('db_connect.php');?>

<div class="container-fluid">
	
	<div class="col-lg-15">
		<div class="row">

			<!-- Table Panel -->
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
						<b>Beds List</b>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>    
                                    <th class="text-center">#</th>
                                    <th class="text-center">Bed Number</th>
                                    <th class="text-center">Room Number</th>
                                    <th class="text-center">Daily Rate</th>
                                    <th class="text-center">Monthly Rate</th>
                                    <th class="text-center">Status</th>									
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$bed = $conn->query("SELECT * FROM beds order by id asc");
								while($row=$bed->fetch_assoc()):
								?>
								
								<tr>
									<td class="text-center"><b><?php echo $i++?></b></td>
                                    <td class="text-center">
                                        <p><?php echo $row['bed_no'] ?></b></p>
                                        
                                    </td>
									<td class="text-center">
										<p><?php echo $row['room_id'] ?></b></p>
                                        
									</td>
                                    <td class="text-center">
                                        <p>₱<?php echo $row['daily_rate'] ?></b></p>
                                        
                                    </td>
									<td class="text-center">
                                        <p>₱<?php echo $row['monthly_rate'] ?></b></p>
                                        
                                    </td>
                                    <td class="text-center">
                                        <p><?php echo $row['status'] ?></b></p>
                                    </td>
									<td class="text-center">
										<button class="btn btn-sm btn-success edit_bed" type="button" data-id="<?php echo $row['id'] ?>"  data-bed_no="<?php echo $row['bed_no']?>" data-room_id="<?php echo $row['room_id']?>" data-daily_rate="<?php echo $row['daily_rate'] ?>" data-monthly_rate="<?php echo $row['monthly_rate'] ?>" data-status="<?php echo $row['status'] ?>">Edit</button>
										<button class="btn btn-sm btn-danger delete_bed" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->

            <!-- FORM Panel -->
			<div class="col-md-3">
			<form action="" id="manage-bed">
				<div class="card">
					<div class="card-header">
						    Bed Form
				  	</div>
					<div class="card-body">
					<div class="form-group" id="msg"></div>
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">Bed Number</label>
								<input type="text" class="form-control" name="bed_no" required>
							</div>
							<div class="form-group">		
								<label class="control-label">Room Number</label>
								<select name="room_id" id="" class="custom-select select2" required>
								<option value="">
									<?php 
									$rooms = $conn->query("SELECT * FROM rooms order by id asc");
									if($rooms->num_rows > 0):
									while($row= $rooms->fetch_assoc()) :
									?>
									<option value="<?php echo $row['room_no'] ?>"> <?php echo $row['room_no'] ?></option>
								<?php endwhile; ?>
								<?php else: ?>
									<option selected="" value="" disabled="">Please select room number</option>
								<?php endif; ?>
								</select>
							</div>
								<div class="form-group">
								<label class="control-label">Daily Rate</label>
								<input type="number" class="form-control text-left" name="daily_rate" step="any" required="">
								</div>
								<div class="form-group">
								<label class="control-label">Monthly Rate</label>
								<input type="number" class="form-control text-left" name="monthly_rate" step="any" required="">
								</div>
								<div class="form-group">
								<label class="control-label">Status</label>
								<select name="status" id="statuss" class="custom-select select2" required>
									<option value=""> </option>
									<option value="available">Available</option>
									<option value="occupied">Occupied</option>
								</select>
								</div>
								
							</div>
					</div>
							
					<div class="card-footer">
						<div class="row">
							<div class="col-md-8">
								<button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
								<button class="btn btn-sm btn-default col-sm-3" type="button" onclick="$('#manage-bed').get(0).reset()"> Cancel</button>
							</div>
						</div>
					</div>
				
			</form>
			</div>

			<!-- FORM Panel -->
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
	$('.select2').select2({
    placeholder:"Please Select Here",
    width:"100%"
   })
	$('#manage-bed').on('reset',function(e){
		$('#msg').html('')
	})
	$('#manage-bed').submit(function(e){
		e.preventDefault()
		start_load()
		$('#msg').html('')
		$.ajax({
			url:'ajax.php?action=save_bed',
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
					$('#msg').html('<div class="alert alert-danger">Bed number already exist.</div>')
					end_load()
				}
			}
		})
	})
	$('.edit_bed').click(function(){
		start_load()
		var cat = $('#manage-bed')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='bed_no']").val($(this).attr('data-bed_no'))
		cat.find("[name='room_id']").val($(this).attr('data-room_id'))
		cat.find("[name='daily_rate']").val($(this).attr('data-daily_rate'))
		cat.find("[name='monthly_rate']").val($(this).attr('data-monthly_rate'))
		cat.find("[name='status']").val($(this).attr('data-status'))
		end_load()
	})
	$('.delete_bed').click(function(){
		_conf("Are you sure to delete this bed?","delete_bed",[$(this).attr('data-id')])
	})
	function delete_bed($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_bed',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}else if(resp==2){
					$('#msg').html('<div class="alert alert-danger">Data not Deleted.</div>')
					end_load()
				}
			}
		})
	}
	$('table').dataTable()
</script>