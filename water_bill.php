<?php include 'db_connect.php' ?>
<style>
   span.float-right.summary_icon {
    font-size: 3rem;
    position: absolute;
    right: 1rem;
    top: 0;
}
.imgs{
		margin: .5em;
		max-width: calc(100%);
		max-height: calc(100%);
	}
	.imgs img{
		max-width: calc(100%);
		max-height: calc(100%);
		cursor: pointer;
	}
	#imagesCarousel,#imagesCarousel .carousel-inner,#imagesCarousel .carousel-item{
		height: 60vh !important;background: black;
	}
	#imagesCarousel .carousel-item.active{
		display: flex !important;
	}
	#imagesCarousel .carousel-item-next{
		display: flex !important;
	}
	#imagesCarousel .carousel-item img{
		margin: auto;
	}
	#imagesCarousel img{
		width: auto!important;
		height: auto!important;
		max-height: calc(100%)!important;
		max-width: calc(100%)!important;
	}
</style>

<div class="containe-fluid">
	<div class="row mt-3 ml-3 mr-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <b>Water Bill</b>

                    <hr>
                    <div class="row">
                    <div class="col-md-6">
                    <form action="" id="manage-wbill">
                        <div class="card">
                            <div class="card-header">
                                    Water Bill Form
                            </div>
                            <div class="card-body" style="height: 13.8em;">
                                    <div class="form-group" id="msg"></div>
                                    <input type="hidden" name="id">
                                    <div class="form-group">
                                        <label class="control-label">Water Bill Amount</label>
                                        <input type="number" class="form-control" name="wbill_amount" required="">
                                    </div>
                                    <div class="form-grou">
                                        <label for="" class="control-label">Due Date</label>
                                        <input type="date" class="form-control" name="due_date" required>
                                    </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn btn-sm btn-info col-sm-3 offset-md-3"> Save</button>
                                        <button class="btn btn-sm btn-default col-sm-3" type="reset" > Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
			</div>
                        <div class="col-lg-6 mb-2">
                            <div class="card border-primary">
                                <div class="card-body bg-primary" style="height: 16.9em;">
                                    <div class="card-body text-white">
                                        <span class="float-right summary_icon"> <i class="fa fa-water "></i></span>
                                        <h4><b>
                                        </b></h4>
                                        <p style="font-size: 1.5em;"><b>Water Bill this Month:</b></p>
                                        <p style="font-size: 1.5em;"><b> 
                                            ₱<?php 
                                             $wbill = $conn->query("SELECT wbill_amount as amount FROM water_bill where date(due_date) order by id desc"); 
                                             echo $wbill->num_rows > 0 ? number_format($wbill->fetch_array()['amount'],2) : 0;
                                             ?></b></p>

                                    </div>
                                </div>
                                <div class="card-footer" style="height: 3.4em;">
                                    <div class="row">
                                        <div class="col-lg-12">
                                        <a href="index.php?page=wbill_history" class="text-primary float-right"> View History <span class="fa fa-angle-right"></span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                </div>
            </div>      			
        </div>
    </div>
</div>
<script>
	$('#manage-wbill').on('reset',function(e){
		$('#msg').html('')
	})
	$('#manage-wbill').submit(function(e){
		e.preventDefault()
		start_load()
		$('#msg').html('')
		$.ajax({
			url:'ajax.php?action=save_wbill',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully saved",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
				else if(resp==2){
					$('#msg').html('<div class="alert alert-danger">Data not Saved.</div>')
					end_load()
				}
			}
		})
	})
	$('table').dataTable()
</script>