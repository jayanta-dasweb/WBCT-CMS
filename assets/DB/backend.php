<?php

// admin, employee signIn
if(isset($_POST['CORole']) && isset($_POST['COfloatingInput']) && isset($_POST['COfloatingPassword']))
{
    $role = $_POST['CORole'];
    $phNumber = $_POST['COfloatingInput'];
    $psw = $_POST['COfloatingPassword'];
    require_once "./config.php";

    $query = "SELECT * from `cable_operator` WHERE role = '$role' AND `phNumber`=$phNumber";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count != 0){
        while ($arr = mysqli_fetch_array($res)) {
            $dBid = $arr['empId'];
            $dBpsw = $arr['psw'];
            $dBphNo = $arr['phNumber'];

            if($dBphNo != $phNumber && $psw != $dBpsw){
                echo 1;
            }
            else if($dBphNo != $phNumber){
                echo 2;
            }
            else if($psw != $dBpsw){
                echo 3;
            }
            else{
                if($role == "admin"){
                    session_start();
                    $_SESSION['adminId'] = $dBid;
                    if(isset($_SESSION['adminId']) && !empty($_SESSION['adminId'])) 
                    {
                        echo 4;
                    }
                }
                else{
                    session_start();
                    $_SESSION['employeeId'] = $dBid;
                    if(isset($_SESSION['employeeId']) && !empty($_SESSION['employeeId'])) 
                    {
                        echo 5;
                    }
                }
            }
        }
    }
    else{
        echo 6;
    }
    mysqli_close($conn);
}

/********************* Ph Number validation for Emp or Admin Psw Forgottan  ********/
if(isset($_POST['COfloatingInputForPhNo']) && isset($_POST['COfloatingInputForName']))
{
    $phNo = $_POST['COfloatingInputForPhNo'];
    $name = ucwords(strtolower($_POST['COfloatingInputForName']));
    require_once "./config.php";
    $query = 'SELECT * FROM `cable_operator` WHERE `phNumber`="'.$phNo.'"';
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count != 0){
        while($arr=mysqli_fetch_array($res)){
            $dbId = $arr['empId'];
            $empName = $arr['empName'];
            $phNumber = $arr['phNumber'];
            if(($empName != $name) && ($phNumber != $phNo)){
                echo 1;
            }
            else if($empName != $name){
                echo 2;
            }
            else if($phNumber != $phNo){
                echo 3;
            }
            else{
                echo 4;
            }
        }
    }
    else{
        echo 5;
    }
    mysqli_close($conn);
}

/******* function for get ph no ******/
function getAdminOrEmpPhNumberFun()
{
    if(isset($_POST['phNoForOTP']) && isset($_POST['empOrAdminName'])){
        $phNumber = $_POST['phNoForOTP'];
        $name = $_POST['empOrAdminName'];
        $data = array();
        require_once "./config.php";
        $query = 'SELECT * FROM `cable_operator` WHERE `empName`="'.$name.'" AND `phNumber`="'.$phNumber.'"';
        $res = mysqli_query($conn,$query);
        $count = mysqli_num_rows($res);
        if($count != 0){
            while($arr=mysqli_fetch_array($res)){
                $dbId = $arr['empId'];
                $data['ph'] = $phNumber;
                $data['id'] = $dbId;
            }
        }
        return $data;
    }
    mysqli_close($conn);
}


/******** Send Textlocal OTP To Reg Emp's Or Admin's Ph number For reset Password (function)****/
function sedOTPFun()
{
    # code..
    $dataArray = getAdminOrEmpPhNumberFun();
    $phNo = $dataArray['ph'];
    $id = $dataArray['id'];
    require('textlocal.class.php');

	$Textlocal = new Textlocal(false, false, 'NmI3MzcxNTgzNTMxNDY2NzRlMzg0ZDQ1NGMzMjMwNjk=');
	$numbers = array($phNo);
	$sender = 'MSTFZR ';
	$otp=mt_rand(1000,9999);
	$message = "$otp is OTP for your WBCT-CMS password reset. Do not share this OTP with anyone. MSTFZR";
	$res = $Textlocal->sendSms($numbers, $message, $sender);
    include "./config.php";
	$query="UPDATE `cable_operator` SET `otp`='$otp' WHERE empId='$id'";
	$res=mysqli_query($conn,$query);
	if (isset($res)) {
        $successMsg = 1;
		return $otp.'.'.$successMsg.'.'.$id;
	}
    mysqli_close($conn);

}

/******** Send OTP To Reg Emp's Or Admin's Ph number For reset Password ****/
if(isset($_POST['phNoForOTP'])){
    $msg= sedOTPFun();
    $char =  ".";
    $str = explode($char, $msg);
    $arr = array(
        "msg"=> $str[1],
        "id"=> $str[2]
    );
    echo json_encode($arr);
}



/********* emp admin's otp verification***********/
if(isset($_POST['typeOTPByEmpOrAdmin']) && isset($_POST['adminEmpId'])){
    $id = $_POST['adminEmpId'];
    $otp = $_POST['typeOTPByEmpOrAdmin'];
    require_once "./config.php";
    $query="SELECT * From `cable_operator` WHERE `empId`=$id";
    $res=mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count != 0){
        while($arr=mysqli_fetch_array($res)){
            $dbOTP = $arr['otp'];
        }
        if($dbOTP == $otp){
            echo 1;
        }
        else{
            echo 2;
        }
    }
    else{
        echo 3;
    }
    mysqli_close($conn);
}

/****** Update Admin or Emp password ********/
if(isset($_POST['hiddenAdminorEmpId']) && isset($_POST['COfloatingInputForPsw'])){
    $id = $_POST['hiddenAdminorEmpId'];
    $psw = $_POST['COfloatingInputForPsw'];
    require_once "./config.php";
    $query="UPDATE `cable_operator` SET `psw`='".$psw."' WHERE `empId` = $id";
    $res=mysqli_query($conn,$query);
    if($res){
        echo 1;
    }
    else{
        echo 2;
    }
    mysqli_close($conn);
}

   

/******** sign up customer With OTP *********/
if(isset($_POST['custNameCustSignUP']) && isset($_POST['phNumberCustSignUP'])){
    require './config.php';
    $phNo = $_POST['phNumberCustSignUP'];
    $name = ucwords(strtolower($_POST['custNameCustSignUP']));
    $email = $_POST['emailCustSignUP'];
    $phno = $_POST['phNumberCustSignUP'];
    $psw = $_POST['custPswCustSignUP'];
    $query = "SELECT * FROM `customer` WHERE `phNumber`=$phNo";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count == 0){
        $query2 = "SELECT * FROM `temp_cust` WHERE `phNumber`=$phNo";
        $res2 = mysqli_query($conn,$query2);
        $count2 = mysqli_num_rows($res2);
        if($count2 == 0){
            require('textlocal.class.php');
            $Textlocal = new Textlocal(false, false, 'NmI3MzcxNTgzNTMxNDY2NzRlMzg0ZDQ1NGMzMjMwNjk=');
            $numbers = array($phNo);
            $sender = 'MSTFZR ';
            $otp=mt_rand(1000,9999);
            $message = "$otp is OTP for your WBCT-CMS password reset. Do not share this OTP with anyone. MSTFZR";
            $res3 = $Textlocal->sendSms($numbers, $message, $sender);
            if($res3){
                $query4 = "INSERT INTO `temp_cust`(`custName`, `phNumber`, `email`,`psw`, `otp`) VALUES ('$name','$phno','$email','$psw','$otp')";
                $res4 = mysqli_query($conn,$query4);
                if($res4){
                    $last_id = mysqli_insert_id($conn);
                    $response = array("custId"=>$last_id, "msg"=>2);
                    echo json_encode($response);
                }
            }
        }
        else{
            echo 1;
        }
    }
    else{
        echo 1;
    }
}


/********* Customer Sign Up otp verification***********/
if(isset($_POST['typeOTPForCustSignUp']) && isset($_POST['custIdForCustSignUp'])){
    $id = $_POST['custIdForCustSignUp'];
    $otp = $_POST['typeOTPForCustSignUp'];
    require_once "./config.php";
    $query="SELECT * From `temp_cust` WHERE `custId`=$id";
    $res=mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count != 0){
        while($arr=mysqli_fetch_array($res)){
            $dbOTP = $arr['otp'];
        }
        if($dbOTP == $otp){
            echo 1;
        }
        else{
            echo 2;
        }
    }
    else{
        echo 3;
    }
    mysqli_close($conn);
}



/**************************************
 * forgot Cust password work
 ***************************************/

 /********************* Ph Number validation for Emp or Admin Psw Forgottan  ********/
if(isset($_POST['CustfloatingInputForPhNo']) && isset($_POST['CustfloatingInputForName']))
{
    $phNo = $_POST['CustfloatingInputForPhNo'];
    $name = ucwords(strtolower($_POST['CustfloatingInputForName']));
    require_once "./config.php";
    $query = 'SELECT * FROM `customer` WHERE `phNumber`="'.$phNo.'"';
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        while($arr=mysqli_fetch_array($res)){
            $dbId = $arr['custId'];
            $custName = $arr['custName'];
            $phNumber = $arr['phNumber'];
            if(($custName != $name) && ($phNumber != $phNo)){
                echo 1;
            }
            else if($custName != $name){
                echo 2;
            }
            else if($phNumber != $phNo){
                echo 3;
            }
            else{
                echo 4;
            }
        }
    }
    else{
       $query2 = 'SELECT * FROM `temp_cust` WHERE `phNumber`="'.$phNo.'"';
       $res2 = mysqli_query($conn,$query2);
       $count2 = mysqli_num_rows($res2);
       if($count2 >= 1){
            while($arr2=mysqli_fetch_array($res2)){
                $dbId2 = $arr2['custId'];
                $custName2 = $arr2['custName'];
                $phNumber2 = $arr2['phNumber'];
                if(($custName2 != $name) && ($phNumber2 != $phNo)){
                    echo 1;
                }
                else if($custName2 != $name){
                    echo 2;
                }
                else if($phNumber2 != $phNo){
                    echo 3;
                }
                else{
                    echo 4;
                }
            }
       }
       else{
           echo 5;
       }
    }
    mysqli_close($conn);
}

/******* function for get ph no ******/
function getAdminOrEmpPhNumberFun2()
{
    if(isset($_POST['phNoForOTP2']) && isset($_POST['custName2'])){
        $phNumber = $_POST['phNoForOTP2'];
        $name = $_POST['custName2'];
        $data = array();
        $data2 = array();
        require_once "./config.php";
        $query = 'SELECT * FROM `customer` WHERE `custName`="'.$name.'" AND `phNumber`="'.$phNumber.'"';
        $res = mysqli_query($conn,$query);
        $count = mysqli_num_rows($res);
        if($count >= 1){
            while($arr=mysqli_fetch_array($res)){
                $dbId = $arr['custId'];
                $data['ph'] = $phNumber;
                $data['id'] = $dbId;
            }
            return $data;
        }
        else{
            $query2 = 'SELECT * FROM `temp_cust` WHERE `custName`="'.$name.'" AND `phNumber`="'.$phNumber.'"';
            $res2 = mysqli_query($conn,$query2);
            $count2 = mysqli_num_rows($res2);
            if($count2 >= 1){
                while($arr2=mysqli_fetch_array($res2)){
                    $dbId2 = $arr2['custId'];
                    $data2['ph'] = $phNumber;
                    $data2['id'] = $dbId2;
                }
                return $data2;
            }
        }
    }
    mysqli_close($conn);
}


/******** Send Textlocal OTP To Reg Customer's Ph number For reset Password (function)****/
function sedOTPFun2()
{
    # code..
    $dataArray = getAdminOrEmpPhNumberFun2();
    // print_r($dataArray);
    $phNo = $dataArray['ph'];
    $custid = $dataArray['id'];
    include "./config.php";
    require('textlocal.class.php');

	$Textlocal = new Textlocal(false, false, 'NmI3MzcxNTgzNTMxNDY2NzRlMzg0ZDQ1NGMzMjMwNjk=');
	$numbers = array($phNo);
	$sender = 'MSTFZR ';
	$otp=mt_rand(1000,9999);
	$message = "$otp is OTP for your WBCT-CMS password reset. Do not share this OTP with anyone. MSTFZR";
	$res = $Textlocal->sendSms($numbers, $message, $sender);
    if($res){
        $query2 = "SELECT * FROM `customer` WHERE `custId`= $custid AND `phNumber`= $phNo";
        $res2 = mysqli_query($conn,$query2);
        $count2 = mysqli_num_rows($res2);
        if($count2 >= 1){
            $query3 = "UPDATE `customer` SET `otp`='$otp' WHERE custId = $custid ";
            $res3 = mysqli_query($conn,$query3);
            if (isset($res3)) {
                $successMsg = 1;
                return $otp.'.'.$successMsg.'.'.$custid.'.'.$phNo;
            }
        }
        else{
            $query4 = "SELECT * FROM `temp_cust` WHERE `custId`= $custid AND `phNumber`= $phNo";
            $res4 = mysqli_query($conn,$query4);
            $count4 = mysqli_num_rows($res4);
            if($count4 >= 1){
                $query5="UPDATE `temp_cust` SET `otp`='$otp' WHERE custId='$custid'";
                $res5=mysqli_query($conn,$query5);
                if (isset($res5)) {
                    $successMsg2 = 1;
                    return $otp.'.'.$successMsg2.'.'.$custid.'.'.$phNo;
                }
            }
        }
    }
	
    mysqli_close($conn);

}

/******** Send OTP To Reg Cust's Ph number For reset Password ****/
if(isset($_POST['phNoForOTP2'])){
    $msg= sedOTPFun2();
    $char =  ".";
    $str = explode($char, $msg);
    $arr = array(
        "msg"=> $str[1],
        "id"=> $str[2],
        "ph"=> $str[3]
    );
    echo json_encode($arr);
}



/********* cust's otp verification***********/
if(isset($_POST['typeOTPByCust2']) && isset($_POST['custIdHidden']) && isset($_POST['custPhHidden'])){
    $id = $_POST['custIdHidden'];
    $otp = $_POST['typeOTPByCust2'];
    $ph = $_POST['custPhHidden'];
    require_once "./config.php";
    $query="SELECT * From `customer` WHERE `custId`=$id AND `phNumber` = $ph";
    $res=mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        while($arr=mysqli_fetch_array($res)){
            $dbOTP = $arr['otp'];
        }
        if($dbOTP == $otp){
            echo 1;
        }
        else{
            echo 2;
        }
    }
    else{
        $query2 = "SELECT * FROM `temp_cust` WHERE `custId`= $id AND `phNumber`= $ph";
        $res2 = mysqli_query($conn,$query2);
        $count2 = mysqli_num_rows($res2);
        if($count2 >= 1){
            while($arr2=mysqli_fetch_array($res2)){
                $dbOTP2 = $arr2['otp'];
            }
            if($dbOTP2 == $otp){
                echo 1;
            }
            else{
                echo 2;
            }
        }
        else{
            echo 3;
        }
    }
    mysqli_close($conn);
}

/****** Update Customer password ********/
if(isset($_POST['hiddenCustId']) && isset($_POST['CustfloatingInputForPsw']) && isset($_POST['hiddenCustPh'])){
    $id = $_POST['hiddenCustId'];
    $psw = $_POST['CustfloatingInputForPsw'];
    $ph = $_POST['hiddenCustPh']; 
    require_once "./config.php";
    $query = "SELECT * FROM `customer` WHERE `custId`= $id AND `phNumber`= $ph";
        $res = mysqli_query($conn,$query);
        $count = mysqli_num_rows($res);
        if($count >= 1){
            $query2="UPDATE `customer` SET `psw`='".$psw."' WHERE `custId` = $id AND `phNumber` = $ph ";
            $res2=mysqli_query($conn,$query2);
            if($res2){
                echo 1;
            }
            else{
                echo 2;
            }
        }
        else{
            $query3 = "SELECT * FROM `temp_cust` WHERE `custId`= $id AND `phNumber`= $ph";
            $res3 = mysqli_query($conn,$query3);
            $count3 = mysqli_num_rows($res3);
            if($count3 >= 1){
                $query4="UPDATE `temp_cust` SET `psw`='".$psw."' WHERE `custId` = $id AND `phNumber` = $ph";
                $res4=mysqli_query($conn,$query4);
                if($res4){
                    echo 1;
                }
                else{
                    echo 2;
                }
            }
        }
    mysqli_close($conn);
}


// customer signIn
if(isset($_POST['custfloatingInput']) && isset($_POST['custfloatingPassword']))
{
    $phNumber = $_POST['custfloatingInput'];
    $psw = $_POST['custfloatingPassword'];
    require_once "./config.php";

    $query = "SELECT * from `customer` WHERE `phNumber`=$phNumber";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        while ($arr = mysqli_fetch_array($res)) {
            $dBid = $arr['custId'];
            $dBpsw = $arr['psw'];
            $dBphNo = $arr['phNumber'];

            if($dBphNo != $phNumber && $psw != $dBpsw){
                echo 1;
            }
            else if($dBphNo != $phNumber){
                echo 2;
            }
            else if($psw != $dBpsw){
                echo 3;
            }
            else{
                
                $query3 = "SELECT customer.*, payment.* FROM `customer` JOIN `payment` ON customer.custId=payment.custId WHERE customer.phNumber = $phNumber";
                $res3 = mysqli_query($conn,$query3);
                $count3 = mysqli_num_rows($res3);
                if($count3 >= 1){
                    while($arr3 = mysqli_fetch_array($res3)){
                        $dbPhNumber = $arr3['phNumber'];
                        $dbPaySts = $arr3['payStatus'];
                        if($dbPhNumber == $phNumber){
                            if($dbPaySts == 'done'){
                                session_start();
                                $_SESSION['custSessionId'] = $dBid;
                                if(isset($_SESSION['custSessionId']) && !empty($_SESSION['custSessionId'])) 
                                {
                                    echo 4;
                                    break;
                                }
                            }
                            if($dbPaySts == 'pending'){
                                session_start();
                                    $_SESSION['custSessionIdTemp'] = $dbPhNumber;
                                    if(isset($_SESSION['custSessionIdTemp']) && !empty($_SESSION['custSessionIdTemp'])) 
                                    {
                                        echo 5;
                                        break;
                                    }
                            }
                        }
                    }
                }
                else{
                    $query4 = "SELECT customer.*, new_connection.* FROM `customer` JOIN `new_connection` ON customer.connId=new_connection.connId WHERE customer.phNumber = $phNumber";
                    $res4 = mysqli_query($conn,$query4);
                    $count4 = mysqli_num_rows($res4);
                    if($count4 >= 1){
                        while($arr4 = mysqli_fetch_array($res4)){
                            $dbPhNumber4 = $arr4['phNumber'];
                            $dbConnSTS = $arr4['connStatus'];
                            if($dbPhNumber4 == $phNumber){
                                    session_start();
                                    $_SESSION['custSessionIdTemp'] = $dbPhNumber4;
                                    if(isset($_SESSION['custSessionIdTemp']) && !empty($_SESSION['custSessionIdTemp'])) 
                                    {
                                        echo 5;
                                        break;
                                    }
                            }
                        }
                    }
                }
            }
        }
    }
    else{
        $query2 = "SELECT * FROM `temp_cust` WHERE `phNumber`= $phNumber";
        $res2 = mysqli_query($conn,$query2);
        $count2 = mysqli_num_rows($res2);
        if($count2 >= 1){
            while($arr2=mysqli_fetch_array($res2)){
                $dBid2 = $arr2['custId'];
                $dBpsw2 = $arr2['psw'];
                $dBphNo2 = $arr2['phNumber'];

                if($dBphNo2 != $phNumber && $psw != $dBpsw2){
                    echo 1;
                }
                else if($dBphNo2 != $phNumber){
                    echo 2;
                }
                else if($psw != $dBpsw2){
                    echo 3;
                }
                else{
                    session_start();
                    $_SESSION['custSessionIdTemp'] = $dBphNo2;
                    if(isset($_SESSION['custSessionIdTemp']) && !empty($_SESSION['custSessionIdTemp'])) 
                    {
                        echo 5;
                    }
                }
            }
        }
        else{
            echo 6;
        }
    }
    mysqli_close($conn);
}






?>