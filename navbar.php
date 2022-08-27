
<style>
	.collapse a{
		text-indent:10px;
	}
	nav#sidebar{
		/*background: url(assets/uploads/<?php echo $_SESSION['system']['cover_img'] ?>) !important*/
	}
</style>

<nav id="sidebar" class='mx-lt-5 bg-light' >
		
		<div class="sidebar-list">
		<?php if($_SESSION['login_type'] == 1): ?>
				<a href="index.php?page=dashboard" class="nav-item nav-dashboard"><span class='icon-field'><i class="fa fa-tachometer-alt "></i></span> Dashboard</a>
				<a href="index.php?page=prospective_tenants" class="nav-item nav-prospective_tenants"><span class='icon-field'><i class="fa fa-user-friends "></i></span> Prospective Tenants</a>
				<a href="index.php?page=ptenants_booking" class="nav-item nav-ptenants_booking"><span class='icon-field'><i class="fa fa-book "></i></span> Booking/Reservation</a>
				<a href="index.php?page=room_management" class="nav-item nav-room_management"><span class='icon-field'><i class="fa fa-home "></i></span> Room Management</a>
				<a href="index.php?page=bed_management" class="nav-item nav-bed_management"><span class='icon-field'><i class="fa fa-bed "></i></span> Bed Management</a>
				<a href="index.php?page=images" class="nav-item nav-images"><span class='icon-field'><i class="fa fa-images "></i></span> Images</a>
				<a href="index.php?page=bed_assignment" class="nav-item nav-bed_assignment"><span class='icon-field'><i class="fa fa-bed "></i></span> <Label> List of Tenants</Label></a>
				<a href="index.php?page=tenants_profile" class="nav-item nav-tenants_profile"><span class='icon-field'><i class="fa fa-user-friends "></i></span> Tenants Profile</a>
				<a href="index.php?page=invoices" class="nav-item nav-invoices"><span class='icon-field'><i class="fa fa-file-invoice "></i></span> Invoices</a>
				<a href="index.php?page=electricity_bill" class="nav-item nav-electricity_bill"><span class='icon-field'><i class=" fa fa-plug"></i></span> Electricity Bill</a>
				<a href="index.php?page=water_bill" class="nav-item nav-water_bill"><span class='icon-field'><i class=" fa fa-water"></i></span> Water Bill</a>
				<a href="index.php?page=reports" class="nav-item nav-reports"><span class='icon-field'><i class="fa fa-list-alt"></i></span> Reports</a>
				<a href="index.php?page=tenantsAndprospect" class="nav-item nav-tenantsAndprospect"><span class='icon-field'><i class="fa fa-users "></i></span> User Accounts</a>
				<a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-desktop "></i></span> Admin & Staff Accounts</a>
				<a href="index.php?page=site_settings" class="nav-item nav-site_settings"><span class='icon-field'><i class="fa fa-cog "></i></span> Site Settings</a>
				
				<!-- <a href="index.php?page=site_settings" class="nav-item nav-site_settings"><span class='icon-field'><i class="fa fa-cogs text-danger"></i></span> System Settings</a> -->
			<?php endif; ?>
			<?php if($_SESSION['login_type'] == 2): ?>
				<a href="index.php?page=staff_dashboard" class="nav-item nav-staff_dashboard"><span class='icon-field'><i class="fa fa-tachometer-alt "></i></span> Dashboard</a>
				<a href="index.php?page=staff_prospective_tenants" class="nav-item nav-staff_prospective_tenants"><span class='icon-field'><i class="fa fa-user-friends "></i></span> Prospective Tenants</a>
				<a href="index.php?page=staff_ptenants_booking" class="nav-item nav-staff_ptenants_booking"><span class='icon-field'><i class="fa fa-book "></i></span> Booking/Reservation</a>
				<a href="index.php?page=staff_room_management" class="nav-item nav-staff_room_management"><span class='icon-field'><i class="fa fa-home "></i></span> Room Management</a>
				<a href="index.php?page=staff_bed_management" class="nav-item nav-staff_bed_management"><span class='icon-field'><i class="fa fa-bed "></i></span> Bed Management</a>
				<a href="index.php?page=staff_image" class="nav-item nav-staff_image"><span class='icon-field'><i class="fa fa-images "></i></span> Images</a>
				<a href="index.php?page=staff_bed_assignment" class="nav-item nav-staff_bed_assignment"><span class='icon-field'><i class="fa fa-bed "></i></span> List of Tenants</a>
				<a href="index.php?page=staff_tenants_profile" class="nav-item nav-staff_tenants_profile"><span class='icon-field'><i class="fa fa-user-friends "></i></span> Tenants Profile</a>
				<a href="index.php?page=staff_invoices" class="nav-item nav-staff_invoices"><span class='icon-field'><i class="fa fa-file-invoice "></i></span> Invoices</a>
				<a href="index.php?page=staff_electricity_bill" class="nav-item nav-staff_electricity_bill"><span class='icon-field'><i class=" fa fa-plug"></i></span> Electricity Bill</a>
				<a href="index.php?page=staff_water_bill" class="nav-item nav-staff_water_bill"><span class='icon-field'><i class=" fa fa-water"></i></span> Water Bill</a>
				<a href="index.php?page=staff_reports" class="nav-item nav-staff_reports"><span class='icon-field'><i class="fa fa-list-alt "></i></span> Reports</a>	
				<a href="index.php?page=staff_tenantsAndprospect" class="nav-item nav-staff_ttenantsAndprospect"><span class='icon-field'><i class="fa fa-users "></i></span> User Accounts</a>
				
			<?php endif; ?>
			<?php if($_SESSION['login_type'] == 3): ?>
				<a href="index.php?page=tenants_dashboard" class="nav-item nav-tenants_dashboard"><span class='icon-field'><i class="fa fa-tachometer-alt "></i></span> Dashboard</a>
				<a href="index.php?page=boardingInfo" class="nav-item nav-boardingInfo"><span class='icon-field'><i class="fa fa-user "></i></span> My Boarding Info</a>
				<a href="index.php?page=myBalance" class="nav-item nav-myBalance"><span class='icon-field'><i class="fa fa-file-invoice "></i></span> My Balance</a>
				<a href="index.php?page=paymentsHistory" class="nav-item nav-paymentsHistory"><span class='icon-field'><i class="fa fa-file-invoice "></i></span> Payments History</a>	
			<?php endif; ?>
			<?php if($_SESSION['login_type'] == 4): ?>
				<a href="index.php?page=ptenants_dashboard" class="nav-item nav-ptenants_dashboard"><span class='icon-field'><i class="fa fa-bed "></i></span> Available Rooms/Beds</a>
				<a href="index.php?page=my_reservation" class="nav-item nav-my_reservation"><span class='icon-field'><i class="fa fa-book "></i></span> My Reservation</a>
			<?php endif; ?>

		</div>

</nav>
<script>
	$('.nav_collapse').click(function(){
		console.log($(this).attr('href'))
		$($(this).attr('href')).collapse()
	})
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>
