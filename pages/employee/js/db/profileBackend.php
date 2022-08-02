<?php
/*************** Get Data ***********/
if(isset($_POST['empId'])){
    require './config.php';
    $id = $_POST['empId'];
    $data = '';
    $query = "SELECT * FROM `cable_operator` WHERE `empId` = $id";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        while($arr = mysqli_fetch_array($res)){
            $dbempName = $arr['empName'];
            $dbId = $arr['empId'];
            $dbphNo = $arr['phNumber'];
            $phno = substr($dbphNo, -3);
            $data .= '<table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th scope="row">Name</th>
                                <td>'.$dbempName .'</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#nameUpdateModal" onclick="editName('.$dbId.')">
                                        <i class="fas fa-user-edit"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Ph Number</th>
                                <td>XXXXXX'.$phno.'</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#phNoUpdateModal" onclick="editPhNo('.$dbId.')">
                                        <i class="fas fa-user-edit"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Password</th>
                                <td style="font-size: 12px;" class="d-flex align-items-center ">
                                    <i class="fas fa-circle"></i>
                                    <i class="fas fa-circle ml-1"></i>
                                    <i class="fas fa-circle ml-1"></i>
                                    <i class="fas fa-circle ml-1"></i>
                                    <i class="fas fa-circle ml-1"></i>
                                    <i class="fas fa-circle ml-1"></i>
                                    <i class="fas fa-circle ml-1"></i>
                                    <i class="fas fa-circle ml-1"></i>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#pswUpdateModal" onclick="editPsw('.$dbId.')">
                                        <i class="fas fa-user-edit"></i>
                                    </button>
                                </td>
                            </tr>

                        </tbody>
                    </table>';
        }
        echo $data;
    }
}

/************** Get Nmae *************/
if(isset($_POST['editEmpNameId'])){
    require './config.php';
    $id = $_POST['editEmpNameId'];
    $query = "SELECT * FROM `cable_operator` WHERE `empId` = $id";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        while($arr = mysqli_fetch_array($res)){
            echo $dbEmpName = $arr['empName'];
        }
    }
}

/************** update Name  **********/
if(isset($_POST['name']) && isset($_POST['empIdForNameUpdate'])){
    require './config.php';
    $id = $_POST['empIdForNameUpdate'];
    $name = ucwords(strtolower($_POST['name']));
    $query = "UPDATE `cable_operator` SET `empName`='$name' WHERE `empId` = $id";
    $res = mysqli_query($conn,$query);
    if($res){
        echo 1;
    }
}


/****************** SEND OTP TO REG. MOBIILE NO. **********/
if(isset($_POST['editPhNoId'])){
    require './config.php';
    $id = $_POST['editPhNoId'];
    $phNumber = '';
    $query = "SELECT * FROM `cable_operator` WHERE `empId` = $id";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        while($arr = mysqli_fetch_array($res)){
            $phNumber = $arr['phNumber'];
        }
        require('textlocal.class.php');

        $Textlocal = new Textlocal(false, false, 'NmI3MzcxNTgzNTMxNDY2NzRlMzg0ZDQ1NGMzMjMwNjk=');
        $numbers = array($phNumber);
        $sender = 'MSTFZR ';
        $otp=mt_rand(1000,9999);
        $message = "$otp is OTP for your WBCT-CMS password reset. Do not share this OTP with anyone. MSTFZR";
        $res = $Textlocal->sendSms($numbers, $message, $sender);
        $query2 = "UPDATE `cable_operator` SET `otp`='$otp' WHERE `empId` = $id ";
        $res2 = mysqli_query($conn,$query2);
        if (isset($res2)) {
            echo 1;
        }
    }
    mysqli_close($conn);
}


/******************** verify OTP ************/
if(isset($_POST['enterOTP']) && isset($_POST['empIdForVarifyOTP'])){
    require './config.php';
    $id = $_POST['empIdForVarifyOTP'];
    $otp = $_POST['enterOTP'];
    $query = "SELECT * FROM `cable_operator` WHERE `otp` = $otp AND `empId` = $id";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        echo 2;
    }
    else{
        echo 1;
    }
}


/************ SEnd OTP NEW Ph No. *************/
if(isset($_POST['empIdForSendOTP']) && isset($_POST['newPhNumber'])){
    require './config.php';
    $phNumber = $_POST['newPhNumber'];
    $id = $_POST['empIdForSendOTP'];

    require('textlocal.class.php');

        $Textlocal = new Textlocal(false, false, 'NmI3MzcxNTgzNTMxNDY2NzRlMzg0ZDQ1NGMzMjMwNjk=');
        $numbers = array($phNumber);
        $sender = 'MSTFZR ';
        $otp=mt_rand(1000,9999);
        $message = "$otp is OTP for your WBCT-CMS password reset. Do not share this OTP with anyone. MSTFZR";
        $res = $Textlocal->sendSms($numbers, $message, $sender);
        $query = "UPDATE `cable_operator` SET `otp`='$otp' WHERE `empId` = $id ";
        $res = mysqli_query($conn,$query);
        if (isset($res)) {
            echo 1;
        }
}


/******************** verify OTP for new no  ************/
if(isset($_POST['enterOTP2']) && isset($_POST['empIdForVarifyOTP2'])){
    require './config.php';
    $id = $_POST['empIdForVarifyOTP2'];
    $otp = $_POST['enterOTP2'];
    $query = "SELECT * FROM `cable_operator` WHERE `otp` = $otp AND `empId` = $id";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        echo 2;
    }
    else{
        echo 1;
    }
}

/*************** final Update ph number ***********/
if(isset($_POST['empIdForFinalUpdate']) && isset($_POST['phNumberUpdate'])){
    require './config.php';
    $id = $_POST['empIdForFinalUpdate'];
    $phNo = $_POST['phNumberUpdate'];
    $query = "UPDATE `cable_operator` SET `phNumber`=$phNo WHERE `empId` = $id";
    $res = mysqli_query($conn,$query);
    if($res){
        echo 1;
    }
}



/****************** SEND OTP TO REG. MOBIILE NO. (for psw update) **********/
if(isset($_POST['pswUpdateId'])){
    require './config.php';
    $id = $_POST['pswUpdateId'];
    $phNumber = '';
    $query = "SELECT * FROM `cable_operator` WHERE `empId` = $id";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        while($arr = mysqli_fetch_array($res)){
            $phNumber = $arr['phNumber'];
        }
        require('textlocal.class.php');

        $Textlocal = new Textlocal(false, false, 'NmI3MzcxNTgzNTMxNDY2NzRlMzg0ZDQ1NGMzMjMwNjk=');
        $numbers = array($phNumber);
        $sender = 'MSTFZR ';
        $otp=mt_rand(1000,9999);
        $message = "$otp is OTP for your WBCT-CMS password reset. Do not share this OTP with anyone. MSTFZR";
        $res = $Textlocal->sendSms($numbers, $message, $sender);
        $query2 = "UPDATE `cable_operator` SET `otp`='$otp' WHERE `empId` = $id ";
        $res2 = mysqli_query($conn,$query2);
        if (isset($res2)) {
            echo 1;
        }
    }
    mysqli_close($conn);
}


/****************** verify otp For Update Psw **********/
if(isset($_POST['enterOTPForPsw']) && isset($_POST['empIdForVarifyOTPForPsw'])){
    require './config.php';
    $id = $_POST['empIdForVarifyOTPForPsw'];
    $otp = $_POST['enterOTPForPsw'];
    $query = "SELECT * FROM `cable_operator` WHERE `otp` = $otp AND `empId` = $id";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        echo 2;
    }
    else{
        echo 1;
    }
}

/****** final update psw********/
if(isset($_POST['id']) && isset($_POST['psw'])){
    $id = $_POST['id'];
    $psw = $_POST['psw'];
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



?>