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
						<b>List of Invoices</b>
						<span class="float:right"><a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="javascript:void(0)" id="new_invoice">
					<i class="fa fa-plus"></i> New Entry
				</a></span>
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Invoice No.</th>
									<th class="text-center">Date</th>
									<th class="text-center">Tenant</th>
									<th class="text-center">Invoice Amount</th>
									<th class="text-center">Amount Paid</th>
									<th class="text-center">Status</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$invoices = $conn->query("SELECT p.*,concat(t.name) as name FROM payments p inner join tenants t on t.id = p.tenant_id where t.status = 1 order by date(p.date_created) desc ");
								while($row=$invoices->fetch_assoc()):
									
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="text-center">
										 <p> <b><?php echo ucwords($row['invoice']) ?></b></p>
									</td>
									<td class="text-center">
										<?php echo date('M d, Y',strtotime($row['date_created'])) ?>
									</td>
									<td class="text-center">
										 <p><?php echo ucwords($row['name']) ?></p>
									</td>
									<td class="text-center">
										 <p> <b><?php echo ucwords($row['InvoiceAmount']) ?></b></p>
									</td>
									<td class="text-center">
										 <p> <b>₱<?php echo number_format($row['amount'],2) ?></b></p>
									</td>
									<td class="text-center">
										 <p> <b><?php echo ucwords($row['status']) ?></b></p>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-outline-success col-md-5 offset-sm-1 edit_invoice" type="button" data-id="<?php echo $row['id'] ?>" >Edit</button>
										
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
	
	$('#new_invoice').click(function(){
		uni_modal("Create New Invoice","staff_manage_invoices.php","mid-large")
		
	})
	$('.edit_invoice').click(function(){
		uni_modal("Manage Invoice Details","staff_manage_invoices.php?id="+$(this).attr('data-id'),"mid-large")
		
	})
	$('.delete_invoice').click(function(){
		_conf("Are you sure to delete this invoice?","delete_invoice",[$(this).attr('data-id')])
	})
	
	function delete_invoice($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_payment',
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