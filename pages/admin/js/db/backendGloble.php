<?php
/***************** *******************
 * Get admin details using Session Id  
 * *********************************/

/********* get contect  content *******/
if (isset($_POST['id'])) {
    require 'config.php';
	$id=$_POST['id'];
	$query="select * from cable_operator WHERE empId = $id";
	if(!$res=mysqli_query($conn,$query)){
		exit();
	}
	$response=array();
	if(mysqli_num_rows($res)>0){
		while ($arr=mysqli_fetch_assoc($res)) {
			# code...
			$response=$arr;
		}
	}
	else{
		$response['status']=200;
		$response['message']="Data not found!";
	}
	echo json_encode($response);
    mysqli_close($conn);
}
else{
	$response['status']=200;
	$response['message']="Invalid Request!";
}


/******** Admin's Session Destroy (Admin Sign Out) *********/
if(isset($_POST['dummyVariableAdminSignOut'])){
	session_start();
	if(isset($_SESSION['adminId']) && !empty($_SESSION['adminId'])) 
    {
		$sts = session_destroy();
		
		if($sts){
			echo 1;
		}
		else{
			echo 0;
		}
    }
}


/******** Admin's Session Destroy (Admin Sign Out) *********/
if(isset($_POST['dummyVariableEmployeeSignOut'])){
	session_start();
	if(isset($_SESSION['employeeId']) && !empty($_SESSION['employeeId'])) 
    {
		$sts = session_destroy();
		if($sts){
			echo 1;
		}
		else{
			echo 0;
		}
    }
}

/*******get total pending complaints no *****/
if(isset($_POST['totalPendingComplaints'])){
    require 'config.php';
    $query = "SELECT * FROM `complaints` WHERE `status`='pending'";
    $res=mysqli_query($conn,$query);
    echo $count =mysqli_num_rows($res);
	mysqli_close($conn);
}

/*******get total pending connection no *****/
if(isset($_POST['totalPendingConnectionRequest'])){
    require 'config.php';
    $query = "SELECT * FROM `new_connection` WHERE `connStatus`='pending'";
    $res=mysqli_query($conn,$query);
    echo $count =mysqli_num_rows($res);
	mysqli_close($conn);
}


/*******get total pending Recharge Request no *****/
if(isset($_POST['totalPendingRechargeRequest'])){
    require 'config.php';
    $query = "SELECT * FROM `payment` WHERE `payStatus`='pending'";
    $res=mysqli_query($conn,$query);
    echo $count =mysqli_num_rows($res);
	mysqli_close($conn);
}
 
?>
