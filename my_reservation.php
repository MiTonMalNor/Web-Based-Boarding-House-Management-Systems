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

						<b>My Reservation Information</b>
						
					</div>
					<div class="card-body">

						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Name</th>
									<th class="text-center">Chosen Room</th>
									<th class="text-center">Chosen Bed</th>
									<th class="text-center">Schedule Date In</th>
									<th class="text-center">Status</th>
								</tr>
							</thead>
							<tbody>
								
								<?php
								$i = 1;
								$_SESSION['login_username']; 
								
								$tenant = $conn->query("SELECT pt.*,concat(pt.fullname) as name,b.monthly_rate,b.bed_no,b.room_id FROM ptenants pt inner join beds b on b.id = pt.bed_id inner join users u WHERE pt.fullname = u.name AND u.id = ".$_SESSION['login_id']."  AND pt.fullname not in (SELECT name FROM tenants) AND pt.bed_id not in (SELECT bed_id FROM tenants) order by b.bed_no desc;");
								
								while($row=$tenant->fetch_assoc()):
                                 $dateIn = $row['date_in']; 	
								?>

								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="text-center">
										<?php echo ucwords($row['name']) ?>
									</td>
                                    <td class="text-center">
										 <p><?php echo $row['room_id'] ?></p>
									</td>
									<td class="text-center">
										 <p><?php echo $row['bed_no'] ?></p>
									</td>
									<td class="text-center">
										<p><?php echo  $dateIn ?></p>
									</td>
									<td class="text-center">
										<p><?php echo $row['status'] ?></p>
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
		max-height:150px;
	}
</style>
<script>
	$(document).ready(function(){
		$('table').dataTable()
	})
	
	$('#new_tenant').click(function(){
		uni_modal("Assign Bed","manage_bed_assignment.php","mid-large")
		
	})

	$('.view_payment').click(function(){
		uni_modal2("Tenants Payments","view_payment.php?id="+$(this).attr('data-id'),"large")
		
	})
	$('.edit_tenant').click(function(){
		uni_modal("Manage Tenant Details","manage_bed_assignment.php?id="+$(this).attr('data-id'),"mid-large")
		
	})

	$('.delete_tenant').click(function(){
		_conf("Are you sure to delete this Tenant?","delete_tenant",[$(this).attr('data-id')])
	})
	
	function delete_tenant($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_tenant',
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