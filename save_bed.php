<?php 

if(isset($_POST['bed_no']) && 
   isset($_POST['room_id']) &&  
   isset($_POST['daily_rate'])&&  
   isset($_POST['monthly_rate'])&&  
   isset($_POST['status'])){

    include "db_connect.php";

    $bed_no = $_POST['bed_no'];
    $room_id = $_POST['room_id'];
    $daily_rate = $_POST['daily_rate'];
    $monthly_rate = $_POST['monthly_rate'];
    $status = $_POST['status'];


    $data = "bed_no=".$bed_no."&room_id=".$room_id."&daily_rate=".$daily_rate."&monthly_rate=".$monthly_rate."&status=".$status;
    
    if (empty($bed_no)) {
    	$em = "Bed No is required";
    	header("Location: ../bed_management.php?error=$em&$data");
	    exit;
    }else if(empty($room_id)){
    	$em = "Room No is required";
    	header("Location: ../bed_management.php?error=$em&$data");
	    exit;
    }else if(empty($daily_rate)){
    	$em = "Daily Rate is required";
    	header("Location: ../bed_management.php?error=$em&$data");
	    exit;
    }else if(empty($monthly_rate)){
    	$em = "Monthly Rate is required";
    	header("Location: ../bed_management.php?error=$em&$data");
	    exit;
    }else if(empty($status)){
    	$em = "Status is required";
    	header("Location: ../bed_management.php?error=$em&$data");
	    exit;

      if (isset($_FILES['pp']['name']) AND !empty($_FILES['pp']['name'])) {
         
         
         $img_name = $_FILES['pp']['name'];
         $tmp_name = $_FILES['pp']['tmp_name'];
         $error = $_FILES['pp']['error'];
         
         if($error === 0){
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_to_lc = strtolower($img_ex);

            $allowed_exs = array('jpg', 'jpeg', 'png');
            if(in_array($img_ex_to_lc, $allowed_exs)){
               $new_img_name = uniqid($uname, true).'.'.$img_ex_to_lc;
               $img_upload_path = '../upload/'.$new_img_name;
               move_uploaded_file($tmp_name, $img_upload_path);

               // Insert into Database
               $sql = "INSERT INTO beds(bed_no, room_id, daily_rate, monthly_rate, status, pp) 
                 VALUES(?,?,?,?,?,?)";
               $stmt = $conn->prepare($sql);
               $stmt->execute([$bed_no, $room_id, $daily_rate, $monthly_rate, $status, $new_img_name]);

               header("Location: ../bed_management.php?success=Bed has been created successfully");
                exit;
            }else {
               $em = "You can't upload files of this type";
               header("Location: ../bed_management.php?error=$em&$data");
               exit;
            }
         }else {
            $em = "unknown error occurred!";
            header("Location: ../bed_management.php?error=$em&$data");
            exit;
         }

        
      }else {
       	$sql = "INSERT INTO beds(bed_no, room_id, daily_rate, monthly_rate, status) 
           VALUES(?,?,?,?,?)";
         $stmt = $conn->prepare($sql);
         $stmt->execute([$bed_no, $room_id, $daily_rate, $monthly_rate, $status]);

       	header("Location: ../bed_management.php?success=Your account has been created successfully");
   	    exit;
      }
    }


}else {
	header("Location: ../bed_management.php?error=error");
	exit;
}
