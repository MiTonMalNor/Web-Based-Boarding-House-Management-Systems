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
						<b>Payments History</b>

					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Invoice No.</th>
									<th class="text-center">Amount Paid</th>
									<th class="text-center">Date</th>

								</tr>
							</thead>
							<tbody>

								<?php 
								$_SESSION['login_id'];
								$i = 1;
								$invoices = $conn->query("SELECT p.*,concat(t.name) as name FROM payments p inner join tenants t on t.id = p.tenant_id inner join users u where p.tenant_id = u.id AND p.tenant_id =".$_SESSION['login_id']." AND t.status = 1 AND p.status = 'paid' order by date(p.date_created) desc; ");
								while($row=$invoices->fetch_assoc()):
								?>

								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="text-center">
										 <p> <b><?php echo ucwords($row['invoice']) ?></b></p>
									</td>
									<td class="text-center">
										 <p><b>₱<?php echo number_format($row['amount'])?></p>
									</td>
									<td class="text-center">
										<?php echo date('M d, Y',strtotime($row['date_created'])) ?>
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
	
	$('.view_payment').click(function(){
		uni_modal("Payments History","view_payment.php?id="+$(this).attr('data-id'),"mid-large")
		
	})
	
</script>