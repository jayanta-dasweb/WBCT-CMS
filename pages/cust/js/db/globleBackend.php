<?php
/************* get user details ***********/
if (isset($_POST['custIdForGetDet'])) {
    require 'config.php';
	$id=$_POST['custIdForGetDet'];
	$query="select * from `customer` WHERE `custId` = $id";
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



/************* get user details ***********/
if (isset($_POST['custIdForGetSTBDet'])) {
    require './config.php';
	$id=$_POST['custIdForGetSTBDet'];
	$query="SELECT * FROM `new_connection` JOIN `customer` ON customer.connId=new_connection.connId WHERE customer.custId = $id";
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

/******** Admin's Session Destroy (Cust Sign Out) *********/
if(isset($_POST['dummyVariableCustSignOut'])){
	session_start();
	if(isset($_SESSION['custSessionId']) && !empty($_SESSION['custSessionId'])) 
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


/************** compair tday's date with expire date ********/
if(isset($_POST['custIDForGetExDate'])){
    require './config.php';
    $custId = $_POST['custIDForGetExDate'];
    $month = date("m");
    $day = date("d");
    $year = date("Y");
	$no =0;
    $query = "SELECT * FROM `payment` WHERE `custId` = $custId ";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        while($arr = mysqli_fetch_array($res)){
            $dbPayId = $arr['payId'];
			if($dbPayId > $no){
				$no = $dbPayId;
			}
        }
		$query2 = "SELECT * FROM `payment` WHERE `payId` = $no";
		$res2 = mysqli_query($conn,$query2);
		$count = mysqli_num_rows($res2);
		if($count >= 1){
			while($arr2= mysqli_fetch_array($res2)){
				$dbDate = $arr2['expiredDt'];
				if($dbDate != NULL){
					$exMonth = date_format(new DateTime($dbDate),"m");
					$exDay = date_format(new DateTime($dbDate),"d");
					$exYear = date_format(new DateTime($dbDate),"Y");
					if(($exMonth <= $month) && ($exDay <= $day) && ($exYear <= $year)){
						echo 1;
					}
					else{
						echo 2;
					}
				}
				else{
					echo 2;
				}
			}
		}
        
    }
}


?>