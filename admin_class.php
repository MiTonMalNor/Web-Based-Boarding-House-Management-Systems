<?php
session_start();
ini_set('display_errors', 1);
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
		
			extract($_POST);		
			$qry = $this->db->query("SELECT * FROM users where username = '".$username."' and password = '".md5($password)."' ");
			if($qry->num_rows > 0){
				foreach ($qry->fetch_array() as $key => $value) {
					if($key != 'passwors' && !is_numeric($key))
						$_SESSION['login_'.$key] = $value;
				}
				if($_SESSION['login_type'] != (1 || 2 || 3 || 4)){
					foreach ($_SESSION as $key => $value) {
						unset($_SESSION[$key]);
					}
					return 2 ;
					exit;
				}
					return 1;
			}else{
				return 3;
			}
	}
	function login2(){
		
			extract($_POST);
			if(isset($email))
				$username = $email;
		$qry = $this->db->query("SELECT * FROM users where username = '".$username."' and password = '".md5($password)."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
			if($_SESSION['login_alumnus_id'] > 0){
				$bio = $this->db->query("SELECT * FROM alumnus_bio where id = ".$_SESSION['login_alumnus_id']);
				if($bio->num_rows > 0){
					foreach ($bio->fetch_array() as $key => $value) {
						if($key != 'passwors' && !is_numeric($key))
							$_SESSION['bio'][$key] = $value;
					}
				}
			}
			if($_SESSION['bio']['status'] != 1){
					foreach ($_SESSION as $key => $value) {
						unset($_SESSION[$key]);
					}
					return 2 ;
					exit;
				}
				return 1;
		}else{
			return 3;
		}
	}
	
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}
	function logout2(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../index.php");
	}

	function save_user(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		if(!empty($password))
		$data .= ", password = '".md5($password)."' ";
		$data .= ", type = '$type' ";
		
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set ".$data);
		}else{
			$save = $this->db->query("UPDATE users set ".$data." where id = ".$id);
		}
		if($save){
			return 1;
		}
	}
	function save_users(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		if(!empty($password))
		$data .= ", password = '".md5($password)."' ";
		$data .= ", type = '$type' ";
		
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set $data");
		}else{
			$save = $this->db->query("UPDATE users set $data where id = $id");
		}
		if($save){
			return 1;
		}

		
	}
	function delete_user(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM users where id = ".$id);
		if($delete)
			return 1;
	}
	function signup(){
		extract($_POST);
		$data = " name = '".$firstname.' '.$lastname."' ";
		$data .= ", username = '$email' ";
		$data .= ", password = '".md5($password)."' ";
		$chk = $this->db->query("SELECT * FROM users where username = '$email' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
			$save = $this->db->query("INSERT INTO users set ".$data);
		if($save){
			$uid = $this->db->insert_id;
			$data = '';
			foreach($_POST as $k => $v){
				if($k =='password')
					continue;
				if(empty($data) && !is_numeric($k) )
					$data = " $k = '$v' ";
				else
					$data .= ", $k = '$v' ";
			}
			if($_FILES['img']['tmp_name'] != ''){
							$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
							$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
							$data .= ", avatar = '$fname' ";

			}
			$save_alumni = $this->db->query("INSERT INTO alumnus_bio set $data ");
			if($data){
				$aid = $this->db->insert_id;
				$this->db->query("UPDATE users set alumnus_id = $aid where id = $uid ");
				$login = $this->login2();
				if($login)
				return 1;
			}
		}
	}
	function update_account(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		if(!empty($password))
		$data .= ", password = '".md5($password)."' ";
		$chk = $this->db->query("SELECT * FROM users where username = '$username' and id != '{$_SESSION['login_id']}' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
			$save = $this->db->query("UPDATE users set $data where id = '{$_SESSION['login_id']}' ");
		if($save){
			$data = '';
			foreach($_POST as $k => $v){
				if($k =='password')
					continue;
				if(empty($data) && !is_numeric($k) )
					$data = " $k = '$v' ";
				else
					$data .= ", $k = '$v' ";
			}

			if($data){
				foreach ($_SESSION as $key => $value) {
					unset($_SESSION[$key]);
				}
				$login = $this->login2();
				if($login)
				return 1;
			}
		}
	}
	function update_accounts(){
		extract($_POST);
		$data .= ", username = '$username' ";
		if(!empty($password))
		$data .= ", password = '".md5($password)."' ";
		$chk = $this->db->query("SELECT * FROM users where username = '$username' and id != '{$_SESSION['login_id']}' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
			$save = $this->db->query("UPDATE users set $data where id = '{$_SESSION['login_id']}' ");
		if($save){
			$data = '';
			foreach($_POST as $k => $v){
				if($k =='password')
					continue;
				if(empty($data) && !is_numeric($k) )
					$data = " $k = '$v' ";
				else
					$data .= ", $k = '$v' ";
			}
			if($_FILES['img']['tmp_name'] != ''){
							$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
							$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
							$data .= ", avatar = '$fname' ";

			}
			$save_alumni = $this->db->query("UPDATE alumnus_bio set $data where id = '{$_SESSION['bio']['id']}' ");
			if($data){
				foreach ($_SESSION as $key => $value) {
					unset($_SESSION[$key]);
				}
				$login = $this->login2();
				if($login)
				return 1;
			}
		}
	}

	function save_settings(){
		extract($_POST);
		$data = " name = '".str_replace("'","&#x2019;",$name)."' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", address = '$address' ";
		$data .= ", about_content = '".htmlentities(str_replace("'","&#x2019;",$about))."' ";
		if($_FILES['img']['tmp_name'] != ''){
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
						$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
		$data .= ", cover_img = '$fname' ";

		}
		
		// echo "INSERT INTO system_settings set ".$data;
		$chk = $this->db->query("SELECT * FROM system_settings");
		if($chk->num_rows > 0){
			$save = $this->db->query("UPDATE system_settings set ".$data);
		}else{
			$save = $this->db->query("INSERT INTO system_settings set ".$data);
		}
		if($save){
		$query = $this->db->query("SELECT * FROM system_settings limit 1")->fetch_array();
		foreach ($query as $key => $value) {
			if(!is_numeric($key))
				$_SESSION['system'][$key] = $value;
		}

			return 1;
				}
	}

	function save_room(){
		extract($_POST);
		$data = " room_no = '$room_no' ";
		$data .= ", description = '$description' ";
		$chk = $this->db->query("SELECT * FROM rooms where room_no = '$room_no' ")->num_rows;
		if($chk > 0 ){
			return 2;
			exit;
		}
			if(empty($id)){
				$save = $this->db->query("INSERT INTO rooms set $data");
			}else{
				$save = $this->db->query("UPDATE rooms set $data where id = $id");
			}
		if($save)
			return 1;
	}
	function delete_room(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM rooms where id = ".$id);
		if($delete){
			return 1;
		}
	}
	function save_ebill(){
		extract($_POST);
		$data = " ebill_amount = '$ebill_amount' ";
		$data .= ", due_date = '$due_date' ";

			if(empty($id)){
				$save = $this->db->query("INSERT INTO electricity_bill set $data");
			}else{
				$save = $this->db->query("UPDATE electricity_bill set $data where id = $id");
			}
		if($save)
			return 1;
	}
	function save_wbill(){
		extract($_POST);
		$data = " wbill_amount = '$wbill_amount' ";
		$data .= ", due_date = '$due_date' ";

			if(empty($id)){
				$save = $this->db->query("INSERT INTO water_bill set $data");
			}else{
				$save = $this->db->query("UPDATE water_bill set $data where id = $id");
			}
		if($save)
			return 1;
	}
	function save_bed(){
		extract($_POST);
	    $data = "bed_no = '$bed_no' ";
		$data .= ", room_id = '$room_id' ";
		$data .= ", daily_rate = '$daily_rate' ";
		$data .= ", monthly_rate = '$monthly_rate'";
		$data .= ", status = '$status' ";

		$chk = $this->db->query("SELECT * FROM beds where bed_no = '$bed_no' ")->num_rows;
		if($chk > 0 ){
			return 2;
			exit;
		}

			if(empty($id)){
				$save = $this->db->query("INSERT INTO beds set $data");
			}else{
				$save = $this->db->query("UPDATE beds set $data where id = $id");
			}
		if($save)
			return 1;
			
	}
	function delete_bed(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM beds where id = ".$id);
		if($delete){
			return 1;
		}
	}
	function delete_image(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM images where id = ".$id);
		if($delete){
			return 1;
		}
	}
	function save_tenant(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", bed_id = '$bed_id' ";
		$data .= ", date_in = '$date_in' ";
		$chk = $this->db->query("SELECT * FROM tenants where bed_id = '$bed_id' ")->num_rows;
		if($chk > 0 ){
			return 2;
			exit;
		}
			if(empty($id)){
				
				$save = $this->db->query("INSERT INTO tenants set $data");

			}else{
				$save = $this->db->query("UPDATE tenants set $data where id = $id");
			}
			
		if($save)
			return 1;
	}
	
	function delete_tenant(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM tenants where id = ".$id);
		if($delete){
			return 1;
		}
	}
	function save_ptenants(){
		extract($_POST);
		$data = " fullname = '$fullname' ";
		$data .= ", bed_id = '$bed_id' ";
		$data .= ", date_in = '$date_in' ";
		
			if(empty($id)){
				
				$save = $this->db->query("INSERT INTO ptenants set $data");
				
			}else{
				$save = $this->db->query("UPDATE ptenants set $data where id = $id");
			}
			
		if($save)
			return 1;
	}
	function save_tenants_profile(){
		extract($_POST);
		$data = " fullname = '$fullname' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", address = '$address' ";
		$data .= ", gender = '$gender' ";
			
		if(empty($id)){
				$save = $this->db->query("INSERT INTO tenants_profile set $data");
			}else{
				$save = $this->db->query("UPDATE tenants_profile set $data where id = $id");
			}
		if($save)
			return 1;
	}
	
	function delete_tenants_profile(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM tenants_profile where id = ".$id);
		if($delete){
			return 1;
		}
	}
	function save_prospective_tenants_as_tenants(){
		extract($_POST);
		$data = " fullname = '$fullname' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", address = '$address' ";
		$data .= ", gender = '$gender' ";
			
		if(empty($id)){
				$save = $this->db->query("INSERT INTO tenants_profile set $data");
			}else{
				$save = $this->db->query("UPDATE tenants_profile set $data where id = $id");
			}
		if($save)
			return 1;
	}
	function delete_prospective_tenants(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM prospective_tenants where id = ".$id);
		if($delete){
			return 1;
		}
	}
	function save_new_user(){
		extract($_POST);
		$data = " tenant_id = '$tenant_id' ";
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		$data .= ", password = '$password' ";
		$data .= ", type = '$type' ";
			if(empty($id)){
				
				$save = $this->db->query("INSERT INTO users set $data");
			}else{
				$save = $this->db->query("UPDATE users set $data where id = $id");
			}
		if($save)
			return 1;
	}
	function delete_new_user(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM users where id = ".$id);
		if($delete){
			return 1;
		}
	}
	function save_signup(){
		extract($_POST);
		$data = " fullname = '$fullname' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", address = '$address' ";
		$data .= ", gender = '$gender' ";
		$data .= ", username = '$username' ";
		$data .= ", password = '$password' ";
		$chk = $this->db->query("SELECT * FROM prospective_tenants where username = '$username' ")->num_rows;
		if($chk > 0 ){
			return 2;
			exit;
		}
			if(empty($id)){
				$save = $this->db->query("INSERT INTO prospective_tenants set $data");
			}else{
				$save = $this->db->query("UPDATE prospective_tenants set $data where id = $id");
			}
		if($save)
			return 1;
	}

	function delete_signup(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM prospective_tenants where id = ".$id);
		if($delete){
			return 1;
		}
	}

	function get_tdetails(){
		extract($_POST);
		$data =array();
		$tenants =$this->db->query("SELECT t.*,concat(name) as name,h.bed_no,h.monthly_rate FROM tenants t inner join electricity_bill eb inner join water_bill wb inner join beds h on h.id = t.bed_id where t.id = {$id} ");
		foreach($tenants->fetch_array() as $k => $v){
			if(!is_numeric($k)){	
				$$k = $v;
			}
		}
		$months = abs(strtotime(date('Y-m-d')." 23:59:59") - strtotime($date_in." 23:59:59"));
		$months = floor(($months) / (30*60*60*24));

		$countID = $this->db->query("SELECT count(id) as numTenants FROM tenants");
		$countID = $countID->num_rows > 0 ? $countID->fetch_array()['numTenants'] : 0;
		$amount = $this->db->query("SELECT ebill_amount as eamount FROM electricity_bill where date(due_date) order by id desc");
		$amount = $amount->num_rows > 0 ? $amount->fetch_array()['eamount'] : 0;
		$etotal = $amount / $countID;

		$countIDs = $this->db->query("SELECT count(id) as numTenants FROM tenants");
		$countIDs = $countIDs->num_rows > 0 ? $countIDs->fetch_array()['numTenants'] : 0;
		$wamount = $this->db->query("SELECT wbill_amount as wamount FROM water_bill where date(due_date) order by id desc");
		$wamount = $wamount->num_rows > 0 ? $wamount->fetch_array()['wamount'] : 0;
		$wtotal = $wamount / $countIDs;

		$data['months'] = $months;
		$payable= abs($monthly_rate * $months);
		$data['payable'] = number_format($payable,2);
		$paid = $this->db->query("SELECT SUM(amount) as paid FROM payments where id != '$pid' and tenant_id =".$id);
		$last_payment = $this->db->query("SELECT * FROM payments where id != '$pid' and tenant_id =".$id." order by unix_timestamp(date_created) desc limit 1");
		$paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid'] : 0;
		$data['paid'] = number_format($paid,2);
		$data['last_payment'] = $last_payment->num_rows > 0 ? date("M d, Y",strtotime($last_payment->fetch_array()['date_created'])) : 'N/A';
		$data['outstanding'] = number_format($payable - $paid,2);
		$data['utility_bills'] = number_format($etotal + $wtotal,2);
		$data['monthly_rate'] = number_format($monthly_rate,2);
		$data['name'] = ucwords($name);
		$data['rent_started'] = date('M d, Y',strtotime($date_in));

		return json_encode($data);
	}
	
	function save_payment(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','ref_code')) && !is_numeric($k)){
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO payments set $data");
			$id=$this->db->insert_id;
		}else{
			$save = $this->db->query("UPDATE payments set $data where id = $id");
		}

		if($save){
			return 1;
		}
	}
	function delete_payment(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM payments where id = ".$id);
		if($delete){
			return 1;
		}
	}
}