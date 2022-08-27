<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();
if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'login2'){
	$login = $crud->login2();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'logout2'){
	$logout = $crud->logout2();
	if($logout)
		echo $logout;
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}
if($action == 'save_ebill'){
	$save = $crud->save_ebill();
	if($save)
		echo $save;
}
if($action == 'save_wbill'){
	$save = $crud->save_wbill();
	if($save)
		echo $save;
}
if($action == 'save_users'){
	$save = $crud->save_users();
	if($save)
		echo $save;
}
if($action == 'save_new_user'){
	$save = $crud->save_new_user();
	if($save)
		echo $save;
}
if($action == 'delete_new_user'){
	$save = $crud->delete_new_user();
	if($save)
		echo $save;
}

if($action == 'delete_user'){
	$save = $crud->delete_user();
	if($save)
		echo $save;
}
if($action == 'signup'){
	$save = $crud->signup();
	if($save)
		echo $save;
}
if($action == 'update_account'){
	$save = $crud->update_account();
	if($save)
		echo $save;
}
if($action == "save_settings"){
	$save = $crud->save_settings();
	if($save)
		echo $save;
}
if($action == "save_category"){
	$save = $crud->save_category();
	if($save)
		echo $save;
}

if($action == "delete_category"){
	$delete = $crud->delete_category();
	if($delete)
		echo $delete;
}
if($action == "save_room"){
	$save = $crud->save_room();
	if($save)
		echo $save;
}
if($action == "delete_room"){
	$save = $crud->delete_room();
	if($save)
		echo $save;
}
if($action == "save_bed"){
	$save = $crud->save_bed();
	if($save)
		echo $save;
}

if($action == "delete_image"){
	$save = $crud->delete_image();
	if($save)
		echo $save;
}
if($action == "delete_bed"){
	$save = $crud->delete_bed();
	if($save)
		echo $save;
}
if($action == "save_tenant"){
	$save = $crud->save_tenant();
	if($save)
		echo $save;
}
if($action == "save_ptenants"){
	$save = $crud->save_ptenants();
	if($save)
		echo $save;
}
if($action == "delete_tenant"){
	$save = $crud->delete_tenant();
	if($save)
		echo $save;
}
if($action == "save_tenants_profile"){
	$save = $crud->save_tenants_profile();
	if($save)
		echo $save;
}
if($action == "save_prospective_tenants_as_tenants"){
	$save = $crud->save_prospective_tenants_as_tenants();
	if($save)
		echo $save;
}

if($action == "delete_tenants_profile"){
	$save = $crud->delete_tenants_profile();
	if($save)
		echo $save;
}
if($action == "delete_prospective_tenants"){
	$save = $crud->delete_prospective_tenants();
	if($save)
		echo $save;
}
if($action == "save_signup"){
	$save = $crud->save_signup();
	if($save)
		echo $save;
}
if($action == "delete_signup"){
	$save = $crud->delete_signup();
	if($save)
		echo $save;
}
if($action == "get_tdetails"){
	$get = $crud->get_tdetails();
	if($get)
		echo $get;
}

if($action == "save_payment"){
	$save = $crud->save_payment();
	if($save)
		echo $save;
}
if($action == "delete_payment"){
	$save = $crud->delete_payment();
	if($save)
		echo $save;
}

ob_end_flush();
?>
