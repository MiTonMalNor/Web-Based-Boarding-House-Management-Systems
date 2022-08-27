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
						<b>My Outstanding Balance</b>
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							
							<thead>
								
								<tr>

									<th class="text-center">Action</th>
									
								</tr>
							</thead>
							<tbody>
								
								<?php 
								$i = 1;
								$tenant = $conn->query("SELECT * from users where id =".$_SESSION['login_id']);
								
								while($row=$tenant->fetch_assoc()):
									
								?>

								<tr>
									
									<td class="text-center">
									<button class="btn btn-sm btn-outline-primary my_payment" type="button" data-id="<?php echo $row['id'] ?>" >View</button>
									</td>
									
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
			<div class="col-md-12" style = "padding:1em;">
				<div class="card">
					<div class="card-header">
						<b>List of Invoices</b>
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Date Created</th>
									<th class="text-center">Invoice No.</th>
									<th class="text-center">Amount</th>
									<th class="text-center">Due Date</th>
									<th class="text-center">Status</th>
									
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$invoices = $conn->query("SELECT p.*,concat(t.name) as name FROM payments p inner join tenants t on t.id = p.tenant_id inner join users u where p.tenant_id = u.id AND p.tenant_id =".$_SESSION['login_id']." AND t.status = 1 AND p.status = 'open' order by date(p.date_created) desc; ");
								while($row=$invoices->fetch_assoc()):
									
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="text-center">
										<?php echo date('M d, Y',strtotime($row['date_created'])) ?>
									</td>
									<td class="text-center">
										 <p><?php echo ucwords($row['invoice']) ?></p>
									</td>
									<td class="text-center">
										 <p>₱<?php echo number_format($row['InvoiceAmount'],2) ?></p>
									</td>
									<td class="text-center">
										<?php echo date('M d, Y',strtotime($row['due_date'])) ?>
									</td>
									<td class="text-center">
										 <p><?php echo ucwords($row['status']) ?></p>
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
	

	$('.my_payment').click(function(){
		uni_modal2("My Outstanding Balance","my_payment.php?id="+$(this).attr('data-id'))
		
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