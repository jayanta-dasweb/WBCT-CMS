<?php
/****************** Get Data **************/
if(isset($_POST['dummyVar'])){
    require './config.php';
    $id = $_POST['dummyVar'];
    $data = '';
    $slno = 1;
    $query = "SELECT * FROM `customer` JOIN `new_connection` ON customer.connId = new_connection.connId WHERE new_connection.empId = $id  ORDER BY customer.custId DESC";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        $data .= '<table class="table table-bordered table-head-fixed  table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Contact Number</th>
                            <th>E-mail</th>
                            <th>Address</th>
                            <th>Connection</th>
                            <th style="text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>';
        while($arr = mysqli_fetch_array($res)){
            $id = $arr['custId'];
            $dbName = $arr['custName'];
            $dbPhNo = $arr['phNumber'];
            $dbHNo = $arr['houseNo'];
            $dbAreaName = $arr['areaName'];
            $dbPinCode = $arr['pincode'];
            $fullAdd = "House No. ".$dbHNo.", ".$dbAreaName.", ".$dbPinCode;
            $dbEmail = $arr['email'];
            $data .= '<tr id="tableData" data-widget="expandable-table" aria-expanded="false">
                            <td>'.$slno++.'</td>
                            <td>'.$dbName.'</td>
                            <td>'.$dbPhNo.'</td>
                            <td>'.$dbEmail.'</td>
                            <td>'.$fullAdd.'</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary"
                                    data-bs-toggle="modal" data-bs-target="#connDetailsModal" onclick="getConnDetFun('.$id.')">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </td>
                            <td class="d-flex align-items-center justify-content-center">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-sm btn-success"
                                        onclick="editData('.$id.')" data-bs-toggle="modal"
                                        data-bs-target="#editDataModal">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger"
                                        onclick="deleteData('.$id.')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>';
        }
        $data .= '</tbody>
        </table>';
    }
    else{
        $data .= "<div class='w-100 d-flex align-items-center justify-content-center'>
                    <h6>Records Not Found</h6>
                </div>";
    }
    echo $data;
    mysqli_close($conn);
}

/***************** get conn details ************/
if(isset($_POST['idForGetConnDetails'])){
    require './config.php';
    $id = $_POST['idForGetConnDetails'];
    $data = '';
    $query = "SELECT * FROM `customer` JOIN `new_connection` ON customer.custId=new_connection.custId JOIN `cable_operator` ON cable_operator.empId=new_connection.empId  WHERE customer.custId = $id";
    $res = mysqli_query($conn,$query);
    $count= mysqli_num_rows($res);
    if($count >= 1){
        while($arr = mysqli_fetch_array($res)){
            $dbDate = $arr['approveDt'];
            $dbDateFormat = date_format(new DateTime($dbDate),"j F Y");
            $stbNo = $arr['STBNumber'];
            $dbSts = ucwords(strtolower($arr['connStatus']));
            $dbEmpName = $arr['empName'];
            $data.='<div id="connDt" class="mb-2">
                        <b>Date : </b>
                        <span id="connDtText" class="mt-1">
                            '.$dbDateFormat.'
                        </span>
                    </div>
                    <div id="stbNo" class="mb-2 mt-2">
                        <b>STB Number : </b>
                        <span id="stbNoText" class="mt-1">
                            '.$stbNo.'
                        </span>
                    </div>
                    <div id="connSts" class="mb-2 mt-2">
                        <b>Connection Status :</b>
                        <span id="connStsText" class="mt-1">
                            '.$dbSts.'
                        </span>
                    </div>
                    <div id="empName" class="mt-2">
                        <b>Employee Name : </b>
                        <span id="empNameText" class="mt-1">
                            '.$dbEmpName.'
                        </span>
                    </div>';
        }
    }
    else{
        $data .= "<div class='w-100 d-flex align-items-center justify-content-center'>
                    <h6>Records Not Found</h6>
                </div>";
    }
    echo $data;
    mysqli_close($conn);
}



/********* get  Data for update *******/
if (isset($_POST['editIdForUpdate'])) {
    require 'config.php';
	$id=$_POST['editIdForUpdate'];
	$query="SELECT customer.phNumber As phNo , customer.* , new_connection.* , cable_operator.* FROM `customer` JOIN `new_connection` ON customer.custId=new_connection.custId JOIN `cable_operator` ON cable_operator.empId=new_connection.empId  WHERE customer.custId = $id";
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

/************ Get Area  ***********/
if(isset($_POST['editIdForArea'])){
    require './config.php';
    $id = $_POST['editIdForArea'];
    $data = '';
    $selctData ='';
    $query = "SELECT `areaName` FROM `customer` WHERE `custId` = $id";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        while($arr = mysqli_fetch_array($res)){
            $selctData = $arr['areaName']; 
        }
    }
    $query2 = "SELECT * FROM `area`";
    $res2 = mysqli_query($conn,$query2);
    $count2 = mysqli_num_rows($res2);
    if($count2 >= 1){
        while($arr2 = mysqli_fetch_array($res2)){

            $dbAreaName2 = $arr2['areaName'];
            if($dbAreaName2 == $selctData){
                $data .= '<option selected value="'.$dbAreaName2.'">'.$dbAreaName2.'</option>';
            }
            else{
                $data .= '<option value="'.$dbAreaName2.'">'.$dbAreaName2.'</option>';
            }
        }
    }
    else{
        $data .= '<option selected value="">Data Not Found</option>';
    }
    echo $data;
    mysqli_close($conn);
}

/*************** update data ************/
if(isset($_POST['id'])){
    require './config.php';
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phno = $_POST['phno'];
    $hno = $_POST['hno'];
    $area = $_POST['area'];
    $pincode = $_POST['pincode'];
    $stbno = $_POST['stbno'];
    $sts = '';
    $query = "SELECT `STBNumber` FROM `customer` WHERE `custId` != $id";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        while($arr = mysqli_fetch_array($res)){
            $dbStbNo = $arr['STBNumber'];
            if($dbStbNo == $stbno){
                $sts = '1';
                break;
            }
            else{
                $sts = '0';
            }
        }
    }
    if($sts == '0'){
        $query2 = "UPDATE `customer` SET `email`='$email',`STBNumber`='$stbno',`pincode`='$pincode',`houseNo`='$hno',`areaName`='$area',`phNumber`='$phno',`custName`='$name' WHERE `custId` = $id";
        $res2 = mysqli_query($conn,$query2);
        if($res2){
            $query3 = "SELECT `empId` FROM `area` WHERE `areaName` = '".$area."'";
            $res3 = mysqli_query($conn,$query3);
            $arr3 = mysqli_fetch_array($res3);
            $dbEmpId = $arr3['empId'];
            $query4 = "UPDATE `new_connection` SET `empId`= $dbEmpId WHERE `custId` = $id";
            $res4 = mysqli_query($conn,$query4);
            if($res){
                echo 2;
            }
        }
    }
    if($sts == '1'){
        echo 1;
    }
}


/****************** Delete Data *************/
if(isset($_POST['delId'])){
    $id = $_POST['delId'];
    require "./config.php";
    $query = "DELETE FROM `customer` WHERE `custId` = $id";
    $res = mysqli_query($conn,$query);
    if($res){
        echo 1;
    }
}


/****************** Search  Data **************/
if(isset($_POST['serchText'])){
    $searchText = $_POST['serchText'];
    $sid = $_POST['sessionId'];
    require './config.php';
    $data = '';
    $slno = 1;
    $query = "SELECT customer.*, new_connection.connStatus AS cSTS, new_connection.* FROM `customer` JOIN `new_connection` ON customer.connId = new_connection.connId WHERE customer.custName LIKE '%".$searchText."%' OR customer.phNumber LIKE '%".$searchText."%' OR customer.email LIKE '%".$searchText."%' OR customer.areaName LIKE '%".$searchText."%' OR customer.houseNo LIKE '%".$searchText."%' OR customer.pincode LIKE '%".$searchText."%' AND new_connection.empId = $sid  ORDER BY customer.custId DESC";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        $data .= '<table class="table table-bordered table-head-fixed  table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Contact Number</th>
                            <th>E-mail</th>
                            <th>Address</th>
                            <th>Connection</th>
                            <th style="text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>';
        while($arr = mysqli_fetch_array($res)){
            $id = $arr['custId'];
            $dbName = $arr['custName'];
            $dbPhNo = $arr['phNumber'];
            $dbHNo = $arr['houseNo'];
            $dbAreaName = $arr['areaName'];
            $dbPinCode = $arr['pincode'];
            $fullAdd = "House No. ".$dbHNo.", ".$dbAreaName.", ".$dbPinCode;
            $dbEmail = $arr['email'];
            $dbEmpId = $arr['empId'];
            $dbConSTS = $arr['cSTS'];
            if($dbEmpId == $sid){
                if($dbConSTS == 'active' || $dbConSTS == 'deactive'){
                        $data .= '<tr id="tableData" data-widget="expandable-table" aria-expanded="false">
                        <td>'.$slno++.'</td>
                        <td>'.$dbName.'</td>
                        <td>'.$dbPhNo.'</td>
                        <td>'.$dbEmail.'</td>
                        <td>'.$fullAdd.'</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary"
                                data-bs-toggle="modal" data-bs-target="#connDetailsModal" onclick="getConnDetFun('.$id.')">
                                <i class="fas fa-info-circle"></i>
                            </button>
                        </td>
                        <td class="d-flex align-items-center justify-content-center">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-sm btn-success"
                                    onclick="editData('.$id.')" data-bs-toggle="modal"
                                    data-bs-target="#editDataModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger"
                                    onclick="deleteData('.$id.')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>';
                }
                else{
                    $data .= '<tr>
                            <td colspan="7" class="table-active" style="text-align:center"> Records Not Found</td>
                            </tr>';
                            break;
                }
            }
            else{
                $data .= '<tr>
                            <td colspan="7" class="table-active" style="text-align:center"> Records Not Found</td>
                            </tr>';
                            break;
            }
            
        }
        $data .= '</tbody>
        </table>';
    }
    else{
        $data .= "<div class='w-100 d-flex align-items-center justify-content-center'>
                    <h6>Records Not Found</h6>
                </div>";
    }
    echo $data;
    mysqli_close($conn);
}



?>