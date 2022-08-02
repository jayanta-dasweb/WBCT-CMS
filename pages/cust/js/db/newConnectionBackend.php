<?php
/********* get user  Data *******/
if (isset($_POST['phNoForGetUserDet'])) {
    require './config.php';
	$phNumber = $_POST['phNoForGetUserDet'];
    $query = "SELECT * FROM `customer` WHERE `phNumber`=$phNumber";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        while($arr = mysqli_fetch_array($res)){
            $dbPhnumber = $arr['phNumber'];
            if($dbPhnumber == $phNumber){
                    $query2="SELECT * FROM `customer` WHERE `phNumber`=$phNumber";
                    if(!$res2 = mysqli_query($conn,$query2)){
                        exit();
                    }
                    $response=array();
                    if(mysqli_num_rows($res2) >= 1){
                        while ($arr2 = mysqli_fetch_assoc($res2)) {
                            # code...
                            $response=$arr2;
                        }
                    }
                    else{
                        $response['status']=200;
                        $response['message']="Data not found!";
                    }
                    echo json_encode($response);
                }
            }
        }
        else{
            $query3 = "SELECT * FROM `temp_cust` WHERE `phNumber`=$phNumber";
            $res3 = mysqli_query($conn,$query3);
            $count3 = mysqli_num_rows($res3);
            if($count3 >= 1){
                while($arr3 = mysqli_fetch_array($res3)){
                    $dbPhNumber2 = $arr3['phNumber'];
                    if($dbPhNumber2 == $phNumber)
                    {
                        $query4 = "SELECT * FROM `temp_cust` WHERE `phNumber`=$phNumber";
                            if(!$res4 = mysqli_query($conn,$query4)){
                                exit();
                            }
                            $response2 = array();
                            if(mysqli_num_rows($res4)>0){
                                while ($arr4 = mysqli_fetch_assoc($res4)) {
                                    # code...
                                    $response2 = $arr4;
                                }
                            }
                            else{
                                $response2['status']=200;
                                $response2['message']="Data not found!";
                            }
                            echo json_encode($response2);
                    }
            }
        }
    }
    mysqli_close($conn);
}


/********************** First Stage Check  *************/
if(isset($_POST['phNoForFirstStage'])){
    require './config.php';
    $phNumber = $_POST['phNoForFirstStage'];
    $query = "SELECT * FROM `temp_cust` Where `phNumber` = $phNumber AND `empId` IS NOT NULL";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        echo 1;
    }
    else{
        $query2 = "SELECT * FROM `customer` WHERE `phNumber`= $phNumber";
        $res2 = mysqli_query($conn,$query2);
        $count2 = mysqli_num_rows($res2);
        if($count2 >= 1){
            echo 22;
        }
        echo 2;
    }
}




/********************** Second Stage Check  *************/
if(isset($_POST['phNoForSecondStage'])){
    require './config.php';
    $phNumber = $_POST['phNoForSecondStage'];
    $query = "SELECT * FROM `customer` Where `phNumber` = $phNumber";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        echo 1;
    }
    else{
        echo 2;
    }
}



/********************** Third Stage Check  *************/
if(isset($_POST['phNoForThirdStage'])){
    require './config.php';
    $phNumber = $_POST['phNoForThirdStage'];
    $query = "SELECT * FROM `new_connection` JOIN `customer` ON new_connection.connId=customer.connId WHERE new_connection.connStatus='active' AND customer.phNumber=$phNumber";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        echo 1;
    }
    else{
        echo 2;
    }
}




/**************** Check Fourth steg ************/
if(isset($_POST['phNoForFourthStage'])){
    require './config.php';
    $phNumber = $_POST['phNoForFourthStage'];
    $query = "SELECT * FROM `customer` JOIN `payment` ON customer.custId=payment.custId WHERE payment.payStatus='pending' AND customer.phNumber=$phNumber";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        echo 1;
    }
    else{
        echo 2;
    }
}


/**************** Check Fourth steg ************/
if(isset($_POST['phNoForFifthStage'])){
    require './config.php';
    $phNumber = $_POST['phNoForFifthStage'];
    $query = "SELECT * FROM `customer` JOIN `payment` ON customer.custId=payment.custId WHERE payment.payStatus='done' AND customer.phNumber=$phNumber";
    $res = mysqli_query($conn,$query);
    echo $count = mysqli_num_rows($res);
    if($count >= 1){
        $query2 = "DELETE FROM `temp_cust` WHERE `phNumber` = $phNumber";
        $res2 = mysqli_query($conn,$query2);
        if($res2){
            session_start();
            if(isset($_SESSION['custSessionIdTemp']) && !empty($_SESSION['custSessionIdTemp'])) 
            {
                $sts = session_destroy();
                if($sts){
                    echo 1;
                }
            }
        }
    }
    else{
        echo 2;
    }
}





/********* get contect  content *******/
if (isset($_POST['phNoForGetEmpDet'])) {
    require './config.php';
	$phNumber = $_POST['phNoForGetEmpDet'];
    $query = "SELECT * FROM `customer` WHERE `phNumber`=$phNumber";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        while($arr = mysqli_fetch_array($res)){
            $dbPhnumber = $arr['phNumber'];
            if($dbPhnumber == $phNumber){
                    $query2="SELECT customer.*, new_connection.*, cable_operator.phNumber AS empPh, cable_operator.*  FROM `customer` JOIN `new_connection` ON customer.connId=new_connection.connId JOIN `cable_operator` ON new_connection.empId=cable_operator.empId WHERE customer.phNumber = $phNumber";
                    if(!$res2 = mysqli_query($conn,$query2)){
                        exit();
                    }
                    $response=array();
                    if(mysqli_num_rows($res2) >= 1){
                        while ($arr2 = mysqli_fetch_assoc($res2)) {
                            # code...
                            $response=$arr2;
                        }
                    }
                    else{
                        $response['status']=200;
                        $response['message']="Data not found!";
                    }
                    echo json_encode($response);
                }
            }
        }
        else{
            $query3 = "SELECT * FROM `temp_cust` WHERE `phNumber`=$phNumber";
            $res3 = mysqli_query($conn,$query3);
            $count3 = mysqli_num_rows($res3);
            if($count3 >= 1){
                while($arr3 = mysqli_fetch_array($res3)){
                    $dbPhNumber2 = $arr3['phNumber'];
                    if($dbPhNumber2 == $phNumber)
                    {
                        $query4 = "SELECT temp_cust.*, cable_operator.phNumber AS empPh, cable_operator.* FROM `temp_cust` JOIN `cable_operator` ON temp_cust.empId=cable_operator.empId WHERE temp_cust.phNumber = $phNumber";
                            if(!$res4 = mysqli_query($conn,$query4)){
                                exit();
                            }
                            $response2 = array();
                            if(mysqli_num_rows($res4)>0){
                                while ($arr4 = mysqli_fetch_assoc($res4)) {
                                    # code...
                                    $response2 = $arr4;
                                }
                            }
                            else{
                                $response2['status']=200;
                                $response2['message']="Data not found!";
                            }
                            echo json_encode($response2);
                    }
            }
        }
    }
    mysqli_close($conn);
}



/********* get user  Address *******/
if (isset($_POST['phNoForGetUserAddress'])) {
    require './config.php';
	$phNumber = $_POST['phNoForGetUserAddress'];
    $query = "SELECT * FROM `customer` WHERE `phNumber`=$phNumber";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        while($arr = mysqli_fetch_array($res)){
            $dbPhnumber = $arr['phNumber'];
            if($dbPhnumber == $phNumber){
                    $query2="SELECT * FROM `customer` WHERE `phNumber`=$phNumber";
                    if(!$res2 = mysqli_query($conn,$query2)){
                        exit();
                    }
                    $response=array();
                    if(mysqli_num_rows($res2) >= 1){
                        while ($arr2 = mysqli_fetch_assoc($res2)) {
                            # code...
                            $response=$arr2;
                        }
                    }
                    else{
                        $response['status']=200;
                        $response['message']="Data not found!";
                    }
                    echo json_encode($response);
                }
            }
        }
        else{
            $query3 = "SELECT * FROM `temp_cust` WHERE `phNumber`=$phNumber";
            $res3 = mysqli_query($conn,$query3);
            $count3 = mysqli_num_rows($res3);
            if($count3 >= 1){
                while($arr3 = mysqli_fetch_array($res3)){
                    $dbPhNumber2 = $arr3['phNumber'];
                    if($dbPhNumber2 == $phNumber)
                    {
                        $query4 = "SELECT * FROM `temp_cust` WHERE `phNumber`=$phNumber";
                            if(!$res4 = mysqli_query($conn,$query4)){
                                exit();
                            }
                            $response2 = array();
                            if(mysqli_num_rows($res4)>0){
                                while ($arr4 = mysqli_fetch_assoc($res4)) {
                                    # code...
                                    $response2 = $arr4;
                                }
                            }
                            else{
                                $response2['status']=200;
                                $response2['message']="Data not found!";
                            }
                            echo json_encode($response2);
                    }
            }
        }
    }
    mysqli_close($conn);
}


/************** get all area ***********/
if(isset($_POST['dummyVar'])){
    require './config.php';
    $data = '';
    $query = "SELECT * FROM `area`";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        $data .= '<select class="form-select" id="floatingSelectGriForAreaSelect"
        aria-label="Floating label select example">
        <option value="0" selected>Open this select menu</option>';
        while($arr = mysqli_fetch_array($res)){
            $dbAreaName = $arr['areaName'];
            $dbEmpId = $arr['empId'];
            $finalData = $dbEmpId.'%'.$dbAreaName;
            $data .= "<option value='".$finalData."'>$dbAreaName</option>";
        }
        $data .= '</select>
        <label for="floatingSelectGriForAreaSelect">Select Area</label>';
    }
    else{
        $data .= '<p> Data Not Found</p>';
    }
    echo $data;
    mysqli_close($conn);
}


/************* Insert Address data **********/
if(isset($_POST['phNumberForAddSubmit']) && isset($_POST['hNo']) && isset($_POST['empId']) && isset($_POST['areaName']) && isset($_POST['pincode']))
{
    require './config.php';
    $phNumber = $_POST['phNumberForAddSubmit'];
    $houseNumber = $_POST['hNo'];
    $areaName = $_POST['areaName'];
    $pincode = $_POST['pincode'];
    $empId = $_POST['empId'];
    $query = "UPDATE `temp_cust` SET `pincode`=$pincode,`houseNo`=$houseNumber ,`areaName`='$areaName',`empId`=$empId WHERE `phNumber`= $phNumber";
    $res = mysqli_query($conn,$query);
    if($res){
        echo 1;
    }
}


/************** connection request sent Work ***********/
if(isset($_POST['phNoForSendConnReqst']))
{
    $phNumber = $_POST['phNoForSendConnReqst'];
    require './config.php';
    $query = "SELECT * FROM `temp_cust` WHERE `phNumber` = $phNumber";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        while($arr = mysqli_fetch_array($res)){
            $dbEmail = $arr['email']==''? NULL : $arr['email'];
            $dbPincode = $arr['pincode'];
            $dbHouseNo = $arr['houseNo'];
            $dbAreaName = $arr['areaName'];
            $dbPhNumber = $arr['phNumber'];
            $dbCustName = $arr['custName'];
            $dbEmpId = $arr['empId'];
            $dbPsw = $arr['psw'];
            $query2 = "INSERT INTO `customer`(`email`, `pincode`, `houseNo`, `areaName`, `phNumber`, `custName`,`psw`) VALUES ('$dbEmail','$dbPincode','$dbHouseNo','".$dbAreaName."','$dbPhNumber','".$dbCustName."','$dbPsw')";
            $res2 = mysqli_query($conn,$query2);
            if($res2){
                $last_custId = mysqli_insert_id($conn);
                $query3 = "INSERT INTO `new_connection`(`empId`, `custId`,`approveDt`) VALUES ($dbEmpId, $last_custId, NULL)";
                $res3 = mysqli_query($conn,$query3);
                if($res3){
                    $last_connId = mysqli_insert_id($conn);
                    $query4 = "UPDATE `customer` SET `connId`=$last_connId WHERE `custId` = $last_custId";
                    $res4 = mysqli_query($conn,$query4);
                    if($res4){
                        echo 1;
                    }
                }
            }
        }
    }
}


/******** customer's Session Destroy (Cust Sign Out) *********/
if(isset($_POST['dummyVariableCustSignOut'])){
	session_start();
	if(isset($_SESSION['custSessionIdTemp']) && !empty($_SESSION['custSessionIdTemp'])) 
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


/*********** get new conn Status *******/
if(isset($_POST['phNoForGetConnReqstSts']))
{
    $phNumber = $_POST['phNoForGetConnReqstSts'];
    $data ='';
    require './config.php';
    $query = "SELECT * FROM `new_connection` JOIN `customer` ON new_connection.connId=customer.connId WHERE customer.phNumber = $phNumber";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        $data .= '<table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>';
        while($arr = mysqli_fetch_array($res)){
            $dbPhNumber = $arr['phNumber'];
            $dbConnSts = $arr['connStatus'] == 'active' ? 'Accepted' : 'Pending';
            $dbDate = $arr['applyDt'];
            $dbDateFormat = date_format(new DateTime($dbDate),"j F Y");
            if($dbPhNumber == $phNumber){
                $data .= '<tr>
                            <th>'.$dbDateFormat.'</th>
                            <td>'. $dbConnSts.'</td>
                        </tr>';
            }
        }
        $data .= '</tbody>
                </table>';
    }
    echo $data;
    mysqli_close($conn);
}


/******************** get all pkg **********/
if(isset($_POST['phNumberForGetPKg'])){
    $no = 1;
    $data = '';
    require './config.php';
    $query = "SELECT * FROM `package` WHERE `pkgType` = 'defaultcust'";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        $data .= '<p class="mt-3 text-danger"> 
        Here <i class="fas fa-rupee-sign"></i> 200 is installation charge
        </p>
        <table class="table table-bordered table-success table-striped">
                    <thead>
                        <tr>
                            <th scope="col">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp #</th>
                            <th scope="col">Package Name</th>
                            <th scope="col">Amount </th>
                        </tr>
                    </thead>
                    <tbody> ';
        while($arr = mysqli_fetch_array($res)){
            $dbid = $arr['pkgId'];
            $dbAmt = $arr['amount'];
            $finalAmountWithGST = ceil($dbAmt + (18/100*$dbAmt));
            $totalAmt = $finalAmountWithGST + 200;
            $dbPkgN = $arr['pkgName'];
            $dbPkgNameAfterExplode = explode('-',$dbPkgN);
            $dbPkgName = $dbPkgNameAfterExplode[0];
            $array = $dbid."%".$finalAmountWithGST."%".$totalAmt;
            $data .= '<tr>
                        <td class="d-flex justify-content-center h-100">
                            <input class="form-check-input"
                                Style="margin-left: auto !important;" type="radio"
                                name="flexRadioDefault" id="flexRadioDefault1-'.$no.'" value = '.$array.' checked>
                        </td>
                        <td>
                            <label class="form-check-label " for="flexRadioDefault1-'.$no.'">
                                '.$dbPkgName.'
                            </label>
                        </td>
                        <td>
                            <i class="fas fa-rupee-sign"></i> '.$dbAmt.' + 18% GST + <i class="fas fa-rupee-sign"></i> 200 = <i class="fas fa-rupee-sign"></i> '.$totalAmt.'
                        </td>
                    </tr>';
                    $no++;
        }
        $data .= '</tbody>
                </table>';
        $data .= '<p class="fs-4">Total Amount To Be Paid = <i class="fas fa-rupee-sign"></i> '.$totalAmt.'</p>';
    }
    else{
        $data .= "<div class='w-100 d-flex align-items-center justify-content-center'>
                    <h6>Records Not Found</h6>
                </div>";
    }
    echo $data;
    mysqli_close($conn);
}

/********* get user  Data *******/
if (isset($_POST['phNumberForGetUserDetForPay'])) {
    require './config.php';
	$phNumber = $_POST['phNumberForGetUserDetForPay'];
    $query = "SELECT * FROM `customer` WHERE `phNumber`=$phNumber";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        while($arr = mysqli_fetch_array($res)){
            $dbPhnumber = $arr['phNumber'];
            if($dbPhnumber == $phNumber){
                    $query2="SELECT * FROM `customer` WHERE `phNumber`=$phNumber";
                    if(!$res2 = mysqli_query($conn,$query2)){
                        exit();
                    }
                    $response=array();
                    if(mysqli_num_rows($res2) >= 1){
                        while ($arr2 = mysqli_fetch_assoc($res2)) {
                            # code...
                            $response=$arr2;
                        }
                    }
                    else{
                        $response['status']=200;
                        $response['message']="Data not found!";
                    }
                    echo json_encode($response);
                }
            }
        }
        else{
            $query3 = "SELECT * FROM `temp_cust` WHERE `phNumber`=$phNumber";
            $res3 = mysqli_query($conn,$query3);
            $count3 = mysqli_num_rows($res3);
            if($count3 >= 1){
                while($arr3 = mysqli_fetch_array($res3)){
                    $dbPhNumber2 = $arr3['phNumber'];
                    if($dbPhNumber2 == $phNumber)
                    {
                        $query4 = "SELECT * FROM `temp_cust` WHERE `phNumber`=$phNumber";
                            if(!$res4 = mysqli_query($conn,$query4)){
                                exit();
                            }
                            $response2 = array();
                            if(mysqli_num_rows($res4)>0){
                                while ($arr4 = mysqli_fetch_assoc($res4)) {
                                    # code...
                                    $response2 = $arr4;
                                }
                            }
                            else{
                                $response2['status']=200;
                                $response2['message']="Data not found!";
                            }
                            echo json_encode($response2);
                    }
            }
        }
    }
    mysqli_close($conn);
}

/**************************** Store Payment Data **********/
if(isset($_POST['phNumberForProceedToPay']) && isset($_POST['pkgId']) && isset($_POST['amount'])){
    require './config.php';
    $phNumber = $_POST['phNumberForProceedToPay'];
    $pkgId = $_POST['pkgId'];
    $amount = $_POST['amount'];
    $query = "SELECT * FROM `customer` WHERE `phNumber` = $phNumber";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        while($arr = mysqli_fetch_array($res)){
            $dbPhNumber = $arr['phNumber'];
            $dbCustId = $arr['custId'];
            if($dbPhNumber == $phNumber){
                $query2 = "INSERT INTO `payment`(`billAmt`, `expiredDt`, `rechargeDt`, `custId`, `payType`) VALUES ('$amount', NULL , NULL ,$dbCustId ,'newConnection')";
                $res2 = mysqli_query($conn, $query2);
                if($res2){
                    $last_id = mysqli_insert_id($conn);
                    $randNo = rand(10,99);
                    $payNo = 'PAY'.$randNo.$last_id;
                    $query3 = "UPDATE `payment` SET `payNo`='$payNo' WHERE `payId`=$last_id";
                    $res3 = mysqli_query($conn,$query3);
                    if($res3){
                        $query4 = "INSERT INTO `includes`(`pkgId`, `payId`) VALUES ($pkgId,$last_id)";
                        $res4 = mysqli_query($conn,$query4);
                        if($res4){
                            echo 1;
                        }
                    }
                }
            }
        }
    }
}


/****************** payment gatway work *******/
if(isset($_POST['dummyVarForGateWay']) && isset($_POST['totalAmt'])){
    require './config.php';
    $phNumber = $_POST['dummyVarForGateWay'];
    $totalAmt = $_POST['totalAmt'];
    $query = "SELECT * FROM `customer` WHERE `phNumber` = $phNumber";
    $res2 = mysqli_query($conn,$query);
    while($arr2 = mysqli_fetch_array($res2)){
        $dbname = $arr2['custName'];
        $dbEmail = $arr2['email'];
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://test.instamojo.com/api/1.1/payment-requests/');
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER,
                array("X-Api-Key:test_1b94eb73c3863e04f80831d407a",
                    "X-Auth-Token:test_d3abd515b3d8bb68d0824fd93e9"));
    $payload = Array(
        'purpose' => 'Cable TV New Connection',
        'amount' =>  $totalAmt,
        'phone' => $phNumber,
        'buyer_name' => $dbname,
        'redirect_url' => 'http://localhost/wbct-cms/pages/cust/newConnection.php',
        'send_email' => true,
        'send_sms' => true,
        'email' => $dbEmail,
        'allow_repeated_payments' => false
    );
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
    $response = curl_exec($ch);
    curl_close($ch); 
    $res = json_decode($response);
    echo $res->payment_request->longurl;
}


?>