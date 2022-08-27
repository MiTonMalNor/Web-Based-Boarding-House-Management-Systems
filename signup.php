<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
ob_start();
if(!isset($_SESSION['system'])){
	$system = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
	foreach($system as $k => $v){
		$_SESSION['system'][$k] = $v;
	}
}
ob_end_flush();
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Boarding House Management System</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
  <title><?php echo $_SESSION['system']['name'] ?></title>

<?php include('./header.php'); ?>
<?php 
if(isset($_SESSION['login_id']))
header("location:index.php?page=signup");

?>
</head>

<div class="topnav-right">
<nav class="navbar navbar-expand-sm bg-dark text-uppercase fixed-top " id="mainNav">
            <div class="container">
                <button class="navbar-toggler text-uppercase font-weight-bold bg-info text-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item mx-0 mx-sm-1"><a class="nav-link py-3 px-0 px-sm-3 rounded" href="main_page.php">Home</a></li>
                        <li class="nav-item mx-0 mx-sm-1"><a class="nav-link py-3 px-0 px-sm-3 rounded" href="login.php">Login</a></li>
                    </ul>
                </div>
            </div>
 </nav>
</div>
<!-- Contact Section-->

        <section class="page-section">
            <div class="container" style="padding-top:3em">
                <!-- Contact Section Heading-->
                <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0 " style="color:dark;"><b>Signup</b></h2>
                <!-- Icon Divider-->
                <div class="divider-custom">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                </div>




                <!-- Contact Section Form-->
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-xl-7">
                        <!-- * * * * * * * * * * * * * * *-->
                        <!-- * * SB Forms Contact Form * *-->
                        <!-- * * * * * * * * * * * * * * *-->
                        <!-- This form is pre-integrated with SB Forms.-->
                        <!-- To make this form functional, sign up at-->
                        <!-- https://startbootstrap.com/solution/contact-forms-->
                        <!-- to get an API token!-->


                        <form action="" id="manage-signup">
                        <div class="form-group" id="msg"></div>
						<input type="hidden" name="id">
                            <!-- Name input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" name="fullname" type="text" placeholder="Enter your name..." step="any" required/>
                                <label class="control-label">Full name</label>
                            </div>
                            <!-- Email address input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" name="email" type="email" placeholder="name@example.com" pattern="^[_a-zA-Z0-9]+(\.[_a-zA-Z0-9]+)*@[a-zA-Z]+(\.[a-zA-Z]+)*(\.[a-zA-Z]{3})$" step="any" required />
                                <label class="control-label">Email address</label>
                            </div>
                            <!-- Phone number input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" name="contact" type="tel" placeholder="09101727020" pattern="(09|\+639|639)\d{9}" step="any" required/>
                                <label class="control-label">Phone number</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" name="address" type="address" placeholder="Enter your address..." step="any" required />
                                <label class="control-label">Address</label>
                            </div>
                            <div class="form-floating mb-3">
                            <div>
                            <label class="control-label" >Gender</label>
                            </div>
                                <select name="gender" name="gender" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example"  required>
                                <option value=""> </option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                </select>
                            </div>
							<div class="form-floating mb-3">
                                <input class="form-control" name="username" type="text" placeholder="Enter your username..." step="any" required />
                                <label class="control-label">Username</label>
                            </div>
							<div class="form-floating mb-3">
                                <input class="form-control" name="password" type="password" placeholder="Enter your password..." step="any"  required />
                                <label class="control-label">Password</label>
                            </div>
                            <!-- Message input-->

                            <!-- Submit success message-->
                            <!---->
                            <!-- This is what your users will see when the form-->
                            <!-- has successfully submitted-->

                            <!-- Submit Button-->

							<div class="col-md-10">
                            <center><button class="btn btn-lg btn-info col-lg-3 offset-lg-3"> Signup</button>
                            <button class="btn btn-lg btn-default col-lg-3" type="reset"> Cancel</button></center>
                            </div>
                        </form>

                            </div>
                        
                    </div>
                </div>
            

        </section>

<script>

	$('#manage-signup').submit(function(e){
		e.preventDefault()
		$('#manage-signup button[type="button"]').attr('disabled',true).html('Signing up...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'ajax.php?action=save_signup',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
		$('#manage-signup button[type="button"]').removeAttr('disabled').html('Signup');

			},
			success:function(resp){
				if(resp == 1){
					location.href ='signup.php';
				}else{
					$('#manage-signup').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
					$('#manage-signup button[type="button"]').removeAttr('disabled').html('Signup');
				}
			}
		})
	})	   
    $('#manage-signup').submit(function(e){
		e.preventDefault()
		start_load()
		$('#msg').html('')
		$.ajax({
			url:'ajax.php?action=save_signup',
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

				}else if(resp==2){
					$('#msg').html('<div class="alert alert-danger">Username already exist.</div>')
					end_load()
				}
			}
		})
	})
</script>
