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
						<b>My Boarding Information</b>

					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">Room No.</th>
									<th class="text-center">Bed No.</th>
                                    <th class="text-center">Monthly Rate</th>
									<th class="text-center">Date Started</th>

								</tr>
							</thead>
							<tbody>

								<?php 
								$_SESSION['login_id'];
								$i = 1;
								$invoices = $conn->query("SELECT t.*,concat(t.name) as name,b.monthly_rate,b.bed_no,b.room_id FROM tenants t inner join beds b on b.id = t.bed_id inner join users u WHERE t.name = u.name AND u.id = ".$_SESSION['login_id']." AND t.status = 1 order by b.bed_no desc;");
								while($row=$invoices->fetch_assoc()):
                                $dateIn = $row['date_in']; 
								?>

								<tr>
								<td class="text-center">
										 <p><?php echo ucwords($row['room_id'])?></p>
									</td>									
									<td class="text-center">
										 <p><?php echo ucwords($row['bed_no']) ?></p>
									</td>
                                    <td class="text-center">
										 <p>₱<?php echo number_format($row['monthly_rate'],2) ?></p>
									</td>
									<td class="text-center">
                                        <p><?php echo  $dateIn ?></p>
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
