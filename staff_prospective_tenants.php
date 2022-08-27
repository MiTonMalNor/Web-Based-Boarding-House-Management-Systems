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
						<b>List of People Who Signed Up</b>
						<span class="float:right"><a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="javascript:void(0)" id="new_tenants_profile">
						<i class="fa fa-plus"></i> Add in Tenants Profile
						</a></span>

					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Fullame</th>
									<th class="text-center">Email</th>
									<th class="text-center">Contact Number</th>
									<th class="text-center">Address</th>
									<th class="text-center">Gender</th>
									<th class="text-center">Username</th>
									<th class="text-center">Password</th>
									
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$room = $conn->query("SELECT pt.*,concat(pt.fullname) as name FROM prospective_tenants pt WHERE pt.fullname not in (SELECT fullname FROM tenants_profile) AND pt.email not in (SELECT email FROM tenants_profile) order by pt.id desc;");
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
										<?php echo ucwords($row['username']) ?>
									</td>
                                    <td class="text-center">
										<?php echo ucwords($row['password']) ?>
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
		uni_modal("Add in Tenants Profile","staff_manage_tenants_profile.php","mid-large")
		
	})

	$('.edit_prospective_tenants').click(function(){
		uni_modal("Add in Tenants Profile","staff_manage_prospective_tenants.php?id="+$(this).attr('data-id'),"mid-large")
		
	})
	$('.delete_prospective_tenants').click(function(){
		_conf("Are you sure to delete this Tenant?","delete_prospective_tenants",[$(this).attr('data-id')])
	})
	
	function delete_prospective_tenants($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_prospective_tenants',
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