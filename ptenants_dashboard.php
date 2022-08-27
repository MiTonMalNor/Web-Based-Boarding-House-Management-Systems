
<?php include('db_connect.php');?>
<?php include 'upload.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<title>Bording House  Management System</title>
	<style>
		body {
			
			justify-content: center;
			align-items: center;
			flex-direction: column;
			min-height: 100vh;
            flex-wrap: wrap;
		}
		
		
	</style>
</head>
<body>
<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row">
			
			<!-- FORM Panel -->
            <div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>					<?php echo "Welcome ". $_SESSION['login_username']."!"  ?></b>
						<span class="float:right"><a class="btn btn-success btn-block btn-sm col-sm-2 float-right" href="javascript:void(0)" id="new_tenant">
					<i class="fa fa-plus"></i> Book Now
				</a></span>
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Room Number</th>
									<th class="text-center">Bed Number</th>								
									<th class="text-center">Monthly Rate</th>
                                    <th class="text-center">Status</th>
									<th class="text-center">Image</th>
								</tr>
							</thead>
							<tbody>
								
                            <?php
                            $i = 1;
                            $bed = $conn->query("SELECT * FROM beds b inner join images i on i.bedName = b.bed_no where b.id not in (SELECT bed_id from tenants where status = 1)");
                            while($row= $bed->fetch_assoc()):
                                $imageURL = $row["file_name"];
								$alt = $row["bedName"];    
                            ?>
                            
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="text-center">
										 <p><?php echo $row['room_id'] ?></p>
									</td>
									<td class="text-center">
										 <p><?php echo $row['bed_no'] ?></p>
									</td>
									<td class="text-center">
										 <p>₱<?php echo number_format($row['monthly_rate'],2) ?></p>
									</td>
                                    <td class="text-center">
										 <p><?php echo $row['status'] ?></p>
									</td>
                                    <td class="text-center">	
                                    <img src="<?php echo $imageURL; ?>" alt="<?php echo $alt; ?>" />
                                    </td>
                                    <?php endwhile; ?>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>


			<!-- FORM Panel -->
				
		</div>
	</div>	

</div>
</body>
</html>
<script>
	$('table').dataTable()
	</script>
<style>
		
	img{
		max-width:500px;
		max-height:1450px;
	}
	
	td{
		vertical-align: middle !important;
	}
	td p {
		margin: unset;
		padding: unset;
		line-height: 1em;
	}
</style>

<script>
	$(document).ready(function(){
		$('table').dataTable()
	})
    $('#new_tenant').click(function(){
		uni_modal("Book Now","manage_ptenants.php","large")
		
	})
	$('.edit_tenant').click(function(){
		viewer_modal("view_image.php?id="+$(this).attr('data-id'))
		
	})

</script>