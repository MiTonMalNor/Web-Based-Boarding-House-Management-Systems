<?php 
include 'db_connect.php'; 
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM payments where id= ".$_GET['id']);
foreach($qry->fetch_array() as $k => $val){
    $$k=$val;
}
}
?>
<div class="container-fluid">
    <form action="" id="manage-payment">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div id="msg"></div>
        <div class="form-group">
            <label for="" class="control-label">Invoice No: </label>
            <input type="number" class="form-control" name="invoice"  value="<?php echo isset($invoice) ? $invoice :'' ?>" >
        </div>
        <div class="form-group">
            <label for="" class="control-label">Tenant</label>
            <select name="tenant_id" id="tenant_id" class="custom-select select2">
                <option value=""></option>

            <?php 
            $tenant = $conn->query("SELECT * FROM tenants where status = 1 order by name asc");
            while($row=$tenant->fetch_assoc()):
            ?>
            <option value="<?php echo $row['id'] ?>" <?php echo isset($tenant_id) && $tenant_id == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['name']) ?></option>
            <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group" id="details">
            
        </div>

        <div class="form-group">
            <label for="" class="control-label">Invoice Amount: </label>
            <input type="number" class="form-control text-left" step="any" name="InvoiceAmount"  value="<?php echo isset($InvoiceAmount) ? $InvoiceAmount :'' ?>" >
        </div>        
        <div class="form-group">
            <label for="" class="control-label">Amount Paid: </label>
            <input type="number" class="form-control text-left" step="any" name="amount"  value="<?php echo isset($amount) ? $amount :'' ?>" >
        </div>
        <div class="form-group">
								<label class="control-label">Status</label>
								<select name="status" id="status" class="custom-select select2" required>
									<option value=""> </option>
									<option value="open">Open</option>
									<option value="paid">Paid</option>
								</select>
		</div>
        <div class="form-group">
				<label for="" class="control-label">Due Date</label>
				<input type="date" class="form-control" name="due_date"  value="<?php echo isset($due_date) ? date("Y-m-d",strtotime($due_date)) :'' ?>" required>
		</div>
</div>
    </form>
</div>
<div id="details_clone" style="display: none">
    <div class='d'>
        <large><b>Details</b></large>
        <hr>
        <p>Tenant: <b class="tname"></b></p>
        <p>Monthly Room Rate: ₱<b class="monthly_rate"></b></p>
        <p>Utility Bills: ₱<b class="utility_bills"></b></p>
        <p>Outstanding Balance: ₱<b class="outstanding"></b></p>
        <p>Total Paid: ₱<b class="total_paid"></b></p>
        <p>Rent Started: <b class='rent_started'></b></p>
        <p>Payable Months: <b class="payable_months"></b></p>
        <hr>
    </div>
</div>
<script>
    $(document).ready(function(){
        if('<?php echo isset($id)? 1:0 ?>' == 1)
             $('#tenant_id').trigger('change') 
    })
   $('.select2').select2({
    placeholder:"Please Select Here",
    width:"100%"
   })
   $('#tenant_id').change(function(){
    if($(this).val() <= 0)
        return false;

    start_load()
    $.ajax({
        url:'ajax.php?action=get_tdetails',
        method:'POST',
        data:{id:$(this).val(),pid:'<?php echo isset($id) ? $id : '' ?>'},
        success:function(resp){
            if(resp){
                resp = JSON.parse(resp)
                var details = $('#details_clone .d').clone()
                details.find('.tname').text(resp.name)
                details.find('.monthly_rate').text(resp.monthly_rate)
                details.find('.utility_bills').text(resp.utility_bills)
                details.find('.outstanding').text(resp.outstanding)
                details.find('.total_paid').text(resp.paid)
                details.find('.rent_started').text(resp.rent_started)
                details.find('.payable_months').text(resp.months)
                console.log(details.html())
                $('#details').html(details)
            }
        },
        complete:function(){
            end_load()
        }
    })
   })
    $('#manage-payment').submit(function(e){
        e.preventDefault()
        start_load()
        $('#msg').html('')
        $.ajax({
            url:'ajax.php?action=save_payment',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success:function(resp){
                if(resp==1){
                    alert_toast("Data successfully saved.",'success')
                        setTimeout(function(){
                            location.reload()
                        },1000)
                }else if(resp==2){
					$('#msg').html('<div class="alert alert-danger">Invoice Number Already Exist.</div>')
					end_load()
                    
				}
            }
        })
    })
</script>