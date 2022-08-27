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
						<b>List of Tenants</b>
						
				</a></span>
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Name</th>
									<th class="text-center">Room Rented</th>
									<th class="text-center">Bed Rented</th>
									<th class="text-center">Date In</th>
									<th class="text-center">Monthly Rate</th>
									<th class="text-center">Outstanding Balance</th>
									<th class="text-center">Last Payment</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								
								<?php 
								$i = 1;
								$tenant = $conn->query("SELECT t.*,concat(t.name) as name,b.monthly_rate,b.bed_no,b.room_id FROM tenants t inner join beds b on b.id = t.bed_id where t.status = 1 order by b.bed_no desc;");
								
								while($row=$tenant->fetch_assoc()):
									$months = abs(strtotime(date('Y-m-d')." 23:59:59") - strtotime($row['date_in']." 23:59:59"));
									$months = floor(($months) / (30*60*60*24));
									$payable = $row['monthly_rate'] * $months;
									$paid = $conn->query("SELECT SUM(amount) as paid FROM payments where tenant_id =".$row['id']);
									$last_payment = $conn->query("SELECT * FROM payments where tenant_id =".$row['id']." order by unix_timestamp(date_created) desc limit 1");
									$paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid'] : 0;
									$dateIn = $row['date_in']; 
									$last_payment = $last_payment->num_rows > 0 ? date("Y-m-d",strtotime($last_payment->fetch_array()['date_created'])) : 'N/A';
									$outstanding = $payable - $paid;
									$countID = $conn->query("SELECT count(id) as numTenants FROM tenants");
									$amount = $conn->query("SELECT ebill_amount as amount FROM electricity_bill where date(due_date) order by id desc");
									$countID = $countID->num_rows > 0 ? $countID->fetch_array()['numTenants'] : 0;
									$amount = $amount->num_rows > 0 ? $amount->fetch_array()['amount'] : 0;
									$etotal = $amount / $countID;
									$payables = $row['monthly_rate'];
									$total =$payables + $etotal;
									$countIDs = $conn->query("SELECT count(id) as numTenants FROM tenants");
									$wamount = $conn->query("SELECT wbill_amount as amount FROM water_bill where date(due_date) order by id desc");
									$countIDs = $countIDs->num_rows > 0 ? $countIDs->fetch_array()['numTenants'] : 0;
									$wamount = $wamount->num_rows > 0 ? $wamount->fetch_array()['amount'] : 0;
									$wtotal = $wamount / $countIDs;
									$ftotal =$payables + $etotal + $wtotal;
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
										 <p>₱<?php echo number_format($ftotal,2) ?></p>
									</td>
									<td class="text-center">
										 <p>₱<?php echo number_format($outstanding,2) ?></p>
									</td>
									<td class="text-center">
										 <p><?php echo  $last_payment ?></p>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-outline-primary view_payment" type="button" data-id="<?php echo $row['id'] ?>" >View</button>
										<button class="btn btn-sm btn-outline-danger delete_tenant" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
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
		uni_modal("Assign Bed","staff_manage_bed_assignment.php","mid-large")
		
	})

	$('.view_payment').click(function(){
		uni_modal2("Tenants Payments","staff_view_payment.php?id="+$(this).attr('data-id'),"large")
		
	})
	$('.edit_tenant').click(function(){
		uni_modal("Manage Tenant Details","staff_manage_bed_assignment.php?id="+$(this).attr('data-id'),"mid-large")
		
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