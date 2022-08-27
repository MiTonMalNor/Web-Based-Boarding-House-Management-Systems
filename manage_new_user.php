<?php 
include 'db_connect.php'; 
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM users where id= ".$_GET['id']);
foreach($qry->fetch_array() as $k => $val){
	$$k=$val;
}
}
?>
<div class="container-fluid">
	<form action="" id="manage-new_user">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="row form-group">
        <div class="col-md-5">
			<label class="control-label">Tenant ID</label>
			<input type="number" class="form-control text-left" name="tenant_id" step="any" value="<?php echo isset($tenant_id) ? $tenant_id:'' ?>" required>
			</div>
			<div class="col-md-5">
				<label for="" class="control-label">Name</label>
				<input type="text" class="form-control" name="name"  value="<?php echo isset($name) ? $name :'' ?>" required>
			</div>
            </div>
		<div class="row form-group">
        <div class="col-md-5">
				<label for="" class="control-label">Username</label>
				<input type="email" class="form-control" name="username"  value="<?php echo isset($username) ? $username :'' ?>" required>
			</div>
            <div class="col-md-5">
			<label for="password">Password</label>
			<input type="password" name="password" id="password" class="form-control" value="" autocomplete="off">
			<?php if(isset($meta['id'])): ?>
			<small><i>Leave this blank if you dont want to change the password.</i></small>
		<?php endif; ?>
		</div>
            <div class="col-md-5">
								<label class="control-label">User Type</label>
								<select name="type" id="type" class="custom-select select2" required>
									<option value=""> </option>
									<option value="4">Prospective Tenants</option>
									<option value="3">Tenant</option>
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
	
	$('#manage-new_user').submit(function(e){
		e.preventDefault()
		start_load()
		$('#msg').html('')
		$.ajax({
			url:'ajax.php?action=save_new_user',
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