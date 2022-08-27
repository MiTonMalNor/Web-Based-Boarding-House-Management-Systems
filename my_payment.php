<?php include 'db_connect.php' ?>

<?php 
$tenants =$conn->query("SELECT t.*,concat(t.name) as name,b.bed_no,b.monthly_rate FROM tenants t inner join beds b on b.id= t.bed_id inner join users u WHERE t.name = u.name AND u.id = {$_GET['id']} ");
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

?>
<div class="container-fluid">
	<div class="col-lg-12">
			<div class="col-md-12">
				<div id="details" class="text-center">
				<b>Details</b>
					<hr>
					<p>Outstanding Balance: <b><?php echo number_format($outstanding,2) ?></b></p>
					<p>Payable Months: <b><?php echo $months ?></b></p>
				</div>
			</div>
		</div>
	</div>