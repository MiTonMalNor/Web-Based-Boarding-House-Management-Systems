
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
			<div class="col-md-4">
			
				<div class="card">
					<div class="card-header">
						    Upload Photo
				  	</div>
					<div class="card-body">
                    <?php if(!empty($statusMsg)){ ?>
                        <p class="status_msg"><?php echo $statusMsg; ?></p>
                        <?php } ?>
                        <div class="col-md-13">
            <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">		
								<label class="control-label">Bed Number</label>
								<select name="bedName" id="" class="custom-select select2" required>
								<option value="">
									<?php 
									$rooms = $conn->query("SELECT * FROM beds WHERE bed_no not in (SELECT bedName FROM images) order by bed_no asc;");
									if($rooms->num_rows > 0):
									while($row= $rooms->fetch_assoc()) :
									?>
									<option value="<?php echo $row['bed_no'] ?>"> <?php echo $row['bed_no'] ?></option>
								<?php endwhile; ?>
								<?php else: ?>
									<option selected="" value="" disabled="">Please select room number</option>
								<?php endif; ?>
								</select>
						</div>
                        <div class="form-group">
                        <input type="file" name="images[]" class="form-control" multiple>    
                        </div>

					<div class="card-footer">
						<div class="row">
							<div class="col-md-12">
								
                                <input type="submit" name="submit" value="Upload" class="btn btn-sm btn-info col-sm-3 offset-md-3">
								<button class="btn btn-sm btn-default col-sm-4" type="reset" > Discard Image</button>
							</div>
						</div>
					</div>

			</form>
			</div>
            </div>
						</div>
					</div>


			<!-- FORM Panel -->

			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
					<b>Uploaded Photos</b>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<thead>
									<th class="text-center">#</th>
                                    <th class="text-center">Bed Number</th>
                                    <th class="text-center">Image</th>
									<th class="text-center">Action</th>
							</thead>
							<tbody>
									
								<?php include 'dbConfig.php';
								$i =1;
								$query = $db->query("SELECT * FROM images ORDER BY bedName ASC");
								if($query->num_rows > 0){
								while($row = $query->fetch_assoc()){
								$imageURL = $row["file_name"];
								$alt = $row["bedName"];
								?>
								<div class="alb">

								<tr>
								<td class="text-center"><b><?php echo $i++?></b></td>
                                    <td class="text-center">
                                        <p><?php echo $row['bedName'] ?></b></p>
                                        
                                    </td>
								<td class="text-center">	
								<img src="<?php echo $imageURL; ?>" alt="<?php echo $alt; ?>" />
								</td>
								<td class="text-center">
										<button class="btn btn-sm btn-danger delete_image" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
									</td>	
								</tr>

								</div>
								<?php }
								}else{ ?>
								<p>No image(s) found...</p>
								<?php } ?>

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>	

</div>
</body>
</html>
<script>
	$('table').dataTable()
	$('.delete_image').click(function(){
		_conf("Are you sure to delete this bed?","delete_image",[$(this).attr('data-id')])
	})
	function delete_image($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_image',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}else if(resp==2){
					$('#msg').html('<div class="alert alert-danger">Data not Deleted.</div>')
					end_load()
				}
			}
		})
	}
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
