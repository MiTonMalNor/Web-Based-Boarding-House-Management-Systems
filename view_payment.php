<?php include 'db_connect.php' ?>

<?php 
$tenants =$conn->query("SELECT t.*,concat(t.name) as name,b.bed_no,b.monthly_rate FROM tenants t inner join beds b on b.id= t.bed_id where t.id = {$_GET['id']} ");
foreach($tenants->fetch_array() as $k => $v){
	if(!is_numeric($k)){
		$$k = $v;
	}
}
$months = abs(strtotime(date('Y-m-d')." 23:59:59") - strtotime($date_in." 23:59:59"));
$months = floor(($months) / (30*60*60*24));
$payable = $monthly_rate * $months;
$paid = $conn->query("SELECT SUM(amount) as paid FROM payments where tenant_id =".$_GET['id']);
$last_payment = $conn->query("SELECT * FROM payments where tenant_id =".$_GET['id']." order by unix_timestamp(date_created) desc limit 1");
$paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid'] : 0;
$last_payment = $last_payment->num_rows > 0 ? date("M d, Y",strtotime($last_payment->fetch_array()['date_created'])) : 'N/A';
$outstanding = $payable - $paid;
									$countID = $conn->query("SELECT count(id) as numTenants FROM tenants");
									$amount = $conn->query("SELECT ebill_amount as amount FROM electricity_bill where date(due_date) order by id desc");
									$countID = $countID->num_rows > 0 ? $countID->fetch_array()['numTenants'] : 0;
									$amount = $amount->num_rows > 0 ? $amount->fetch_array()['amount'] : 0;;
									$etotal = $amount / $countID;
									$countIDs = $conn->query("SELECT count(id) as numTenants FROM tenants");
									$wamount = $conn->query("SELECT wbill_amount as amount FROM water_bill where date(due_date) order by id desc");
									$countIDs = $countIDs->num_rows > 0 ? $countIDs->fetch_array()['numTenants'] : 0;
									$wamount = $wamount->num_rows > 0 ? $wamount->fetch_array()['amount'] : 0;;
									$wtotal = $wamount / $countIDs;
									$ftotal = $etotal + $wtotal;
?>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-md-4">
				<div id="details">
					<large><b>Details</b></large>
					<hr>
					<p>Monthly Rental Rate: ₱<b><?php echo number_format($ftotal,2) ?></b></p>
					<p>Utility Bills: ₱<b><?php echo number_format($ftotal,2) ?></b></p>
					<p>Outstanding Balance: ₱<b><?php echo number_format($outstanding,2) ?></b></p>
					<p>Total Paid: ₱<b><?php echo number_format($paid,2) ?></b></p>
					<p>Rent Started: <b><?php echo date("M d, Y",strtotime($date_in)) ?></b></p>
					<p>Payable Months: <b><?php echo $months ?></b></p>
				</div>
			</div>
			<div class="col-md-8">
				<large><b>Payment List</b></large>
					<hr>
				<table class="table table-condensed table-striped">
					<thead>
						<tr>
							<th>Date</th>
							<th>Invoice</th>
							<th class='text-center'>Amount</th>
							<th class='text-center'>Status</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$payments = $conn->query("SELECT * FROM payments where tenant_id = $id");
						if($payments->num_rows > 0):
						while($row=$payments->fetch_assoc()):
						?>
					<tr>
						<td><?php echo date("M d, Y",strtotime($row['date_created'])) ?></td>
						<td><?php echo $row['invoice'] ?></td>
						<td class='text-center'><?php echo number_format($row['amount'],2) ?></td>
						<td class='text-center'><?php echo ucwords($row['status']) ?></td>
					</tr>
					<?php endwhile; ?>
					<?php else: ?>
					<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<style>
	#details p {
		margin: unset;
		padding: unset;
		line-height: 1.3em;
	}
	td, th{
		padding: 3px !important;
	}
</style>