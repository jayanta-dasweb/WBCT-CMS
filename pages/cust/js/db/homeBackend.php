<?php
/************* get Cable operator details ***********/
if (isset($_POST['custIdForGetCoDet'])) {
    require './config.php';
	$id=$_POST['custIdForGetCoDet'];
	$query="SELECT * FROM `cable_operator` JOIN `new_connection` ON cable_operator.empId=new_connection.empId WHERE new_connection.custId = $id";
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



/************* get Pkg details  ***********/
if (isset($_POST['custIdForGetPkgDet'])) {
    require './config.php';
	$id=$_POST['custIdForGetPkgDet'];
	$data = '';
	$no =0;
	$query="SELECT * FROM `payment` JOIN `includes` ON payment.payId=includes.payId JOIN `package` ON includes.pkgId=package.pkgId WHERE payment.custId = $id AND `rechargeDt` IS NOT NULL";
	$res = mysqli_query($conn,$query);
	$count = mysqli_num_rows($res);
	if($count >= 2){
		$data .= '<table class="table table-bordered table-success table-striped">
		<thead>
		  <tr>
			<th scope="col">Package Name</th>
			<th scope="col">Amount</th>
		  </tr>
		</thead>
		<tbody>';
		while($arr = mysqli_fetch_array($res)){
			$dbPayId = $arr['payId'];
			if($dbPayId > $no){
				$no = $dbPayId;
			}
		}
		$query2="SELECT * FROM `payment` JOIN `includes` ON payment.payId=includes.payId JOIN `package` ON includes.pkgId=package.pkgId WHERE payment.custId = $id AND payment.payId = $no AND `rechargeDt` IS NOT NULL";
		$res2 = mysqli_query($conn,$query2);
		$count2 = mysqli_num_rows($res2);
		if($count2 >= 1){
			while($arr2 = mysqli_fetch_array($res2)){
				$dbPkgN = $arr2['pkgName'];
            	$dbPkgNameAfterExplode = explode('-',$dbPkgN);
            	$dbPkgName = $dbPkgNameAfterExplode[0];
				$dbAmt = $arr2['billAmt'];
				$data .= '<tr>
							<input type="hidden" id="hiddenLastPayId" value='.$no.'>
							<td id="pkgName">'.$dbPkgName.'</td>
							<td><i class="fas fa-rupee-sign"></i> <span id="amount">'.$dbAmt.'</span></td>
						</tr>';
			}
		}
		$data .= '</tbody>
			</table>';
	}
	if($count == 1){
		$data .= '<table class="table table-bordered table-success table-striped">
		<thead>
		  <tr>
			<th scope="col">Package Name</th>
			<th scope="col">Amount</th>
		  </tr>
		</thead>
		<tbody>';
		while($arr3 = mysqli_fetch_array($res)){
			$dbPayId = $arr3['payId'];
			$dbPkgN3 = $arr3['pkgName'];
            $dbPkgNameAfterExplode3 = explode('-',$dbPkgN3);
            $dbPkgName3 = $dbPkgNameAfterExplode3[0];
			$dbAmt3 = $arr3['billAmt'];
			$data .= '<tr>
						<input type="hidden" id="hiddenLastPayId" value='.$dbPayId.'>
						<td id="pkgName">'.$dbPkgName3.'</td>
						<td><i class="fas fa-rupee-sign"></i> <span id="amount">'.$dbAmt3.'</span></td>
					</tr>';
			}
		$data .= '</tbody>
		</table>';
	}
	echo $data;
}


/************* get Pending Complaints details ***********/
if (isset($_POST['custIdForGetPendingComplaintsDet'])) {
    require 'config.php';
	$id=$_POST['custIdForGetPendingComplaintsDet'];
	$query="SELECT * FROM `complaints` WHERE `custId` = $id AND `status`='pending'";
	$res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    echo $count;
}


/************** compair tday's date with expire date ********/
if(isset($_POST['custIDForGetExDate'])){
    require './config.php';
    $custId = $_POST['custIDForGetExDate'];
    $month = date("m");
    $day = date("d");
    $year = date("Y");
	$no =0;
    $query = "SELECT * FROM `payment` WHERE `custId` = $custId";
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
						$query3 ="UPDATE `new_connection` SET `connStatus`='offline' WHERE `custId` = $custId";
						$res3 = mysqli_query($conn,$query3);
						echo 1;
					}
					else{
						echo 2;
					}
				}else{
					echo 2;
				}
				
			}
		}
        
    }
}





/************ Last Rechrg date **************/
if(isset($_POST['lastPayId']) && isset($_POST['custIdForGetLastRechrgDt'])){
	require './config.php';
	$payId = $_POST['lastPayId'];
	$custId = $_POST['custIdForGetLastRechrgDt'];
	$query = "SELECT `rechargeDt` FROM `payment` WHERE `custId` = $custId AND `payId` = $payId";
	$res = mysqli_query($conn,$query);
	$arr = mysqli_fetch_array($res);
	$dbrechargeDt = $arr['rechargeDt'];
	$date = date_format(new DateTime($dbrechargeDt),"j F Y");
	echo $date;
}

/************ Last Rechrg date **************/
if(isset($_POST['lastPayId2']) && isset($_POST['custIdForGetExDt'])){
	require './config.php';
	$payId = $_POST['lastPayId2'];
	$custId = $_POST['custIdForGetExDt'];
	$query = "SELECT `expiredDt` FROM `payment` WHERE `custId` = $custId AND `payId` = $payId";
	$res = mysqli_query($conn,$query);
	$arr = mysqli_fetch_array($res);
	$dbExDt = $arr['expiredDt'];
	$date = date_format(new DateTime($dbExDt),"j F Y");
	echo $date;
}




?>