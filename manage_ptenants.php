<?php 
include 'db_connect.php'; 

?>
<div class="container-fluid">
	<form action="" id="manage-ptenants">

		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>" disabled>
	<div class="row form-group">
            <div class="col-md-4">
                                <label class="control-label">Full name</label>
                                <input class="form-control" name="fullname" type="text" placeholder="Please enter your name again..." step="any" required/>
                            </div>
			<div class="col-md-4">
				<label for="" class="control-label">Bed</label>
				<select name="bed_id" id="" class="custom-select select2" required>
					<option value="">
					<?php 
					$bed = $conn->query("SELECT * FROM beds where id not in (SELECT bed_id from tenants where status = 1);".(isset($bed_id)? " or id = $bed_id": "" )." ");
					while($row= $bed->fetch_assoc()):
					?>
					<option value="<?php echo $row['id'] ?>" <?php echo isset($bed_id) && $bed_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['bed_no'] ?></option>
					<?php endwhile; ?>
				</select>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">Registration Date</label>
				<input type="date" class="form-control" name="date_in"  value="<?php echo isset($date_in) ? date("Y-m-d",strtotime($date_in)) :'' ?>" required>
			</div>
		</div>

	</form>
</div>
<script>
	$('.select2').select2({
    placeholder:"Please Select Here",
    width:"100%"
   })
	$('#manage-ptenants').submit(function(e){
		e.preventDefault()
		start_load()
		$('#msg').html('')
		$.ajax({
			url:'ajax.php?action=save_ptenants',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully saved.",'success')
						setTimeout(function(){
							location.reload()
						},1000)
				}else if(resp==2){
					$('#msg').html('<div class="alert alert-danger">Tenant already exist.</div>')
					end_load()
				}
			}
		})
	})
</script>