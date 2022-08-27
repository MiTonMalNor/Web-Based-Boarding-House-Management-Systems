<?php 
include 'db_connect.php'; 
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM tenants_profile where id= ".$_GET['id']);
foreach($qry->fetch_array() as $k => $val){
	$$k=$val;
}
}
?>
<div class="container-fluid">
	<form action="" id="manage-tenants_profile">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="row form-group">
			<div class="col-md-4">
				<label for="" class="control-label">Fullname</label>
				<input type="text" class="form-control" name="fullname"  value="<?php echo isset($fullname) ? $fullname :'' ?>" required>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">Email</label>
				<input type="email" class="form-control" name="email"  value="<?php echo isset($email) ? $email :'' ?>" required>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">Contact Number</label>
				<input type="text" class="form-control" name="contact"  value="<?php echo isset($contact) ? $contact :'' ?>" required>
			</div>
		</div>
		<div class="form-group row">
			
            <div class="col-md-4">
				<label for="" class="control-label">Address</label>
				<input type="text" class="form-control" name="address"  value="<?php echo isset($address) ? $address :'' ?>" required>
			</div>
            <div class="col-md-4">
            <label class="control-label">Gender</label>
				<select name="gender" id="genderr" class="custom-select select2" value="<?php echo isset($gender) ? $gender :'' ?>" required>
				<option value=""> </option>
				<option value="male">Male</option>
				<option value="female">Female</option>
				</select>
            </div>
		</div>
	</form>
</div>
<script>

	$('.select2').select2({
    placeholder:"Please Select Here",
    width:"100%"
   })
	
	$('#manage-tenants_profile').submit(function(e){
		e.preventDefault()
		start_load()
		$('#msg').html('')
		$.ajax({
			url:'ajax.php?action=save_tenants_profile',
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
				}
			}
		})
	})
</script>