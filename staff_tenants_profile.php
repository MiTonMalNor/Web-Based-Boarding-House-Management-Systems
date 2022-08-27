<?php include('db_connect.php');?>

<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">
				
			</div>
		</div>
		<div class="row">
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>Tenants Profile</b>
						
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Name</th>
									<th class="text-center">Email</th>
									<th class="text-center">Contact Number</th>
									<th class="text-center">Address</th>
									<th class="text-center">Gender</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$room = $conn->query("SELECT tp.*,concat(tp.fullname) as name FROM tenants_profile tp inner join tenants t WHERE tp.fullname = t.name order by tp.id desc;");
								while($row=$room->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="text-center">
										<?php echo ucwords($row['fullname']) ?>
									</td>
									<td class="text-center">
										 <p><?php echo $row['email'] ?></p>
									</td>
                                    <td class="text-center">
										<?php echo ucwords($row['contact']) ?>
									</td>
                                    <td class="text-center">
										<?php echo ucwords($row['address']) ?>
									</td>
                                    <td class="text-center">
										<?php echo ucwords($row['gender']) ?>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-outline-success edit_tenants_profile" type="button" data-id="<?php echo $row['id'] ?>" data-gender="<?php echo $row['gender'] ?>">Edit</button>
										<button class="btn btn-sm btn-outline-danger delete_tenants_profile" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
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
	td p{
		margin: unset
	}
	img{
		max-width:100px;
		max-height: :150px;
	}
</style>
<script>
	$(document).ready(function(){
		$('table').dataTable()
	})
	
	$('#new_tenants_profile').click(function(){
		uni_modal("New Tenant","staff_manage_tenants_profile.php","mid-large")
		
	})

	$('.view_payment').click(function(){
		uni_modal("Tenants Payments","view_payment.php?id="+$(this).attr('data-id'),"large")
		
	})
	$('.edit_tenants_profile').click(function(){
		uni_modal("Manage Tenant Details","manage_tenants_profile.php?id="+$(this).attr('data-id'),"mid-large")
		
	})
	$('.delete_tenants_profile').click(function(){
		_conf("Are you sure to delete this Tenant?","delete_tenants_profile",[$(this).attr('data-id')])
	})
	
	function delete_tenants_profile($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_tenants_profile',
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
</script>