<?php
/***************** Get Data  ***********/
if(isset($_POST['dummyVar'])){
    require './config.php';
    $data = '';
    $slno = 1;
    $query = "SELECT * FROM `new_connection` INNER JOIN `customer` ON new_connection.connId=customer.connId WHERE new_connection.connStatus='pending' ORDER BY new_connection.connId DESC  ";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        $data .= '<table class="table table-bordered table-head-fixed  table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Address</th>
                            <th>Contact Number</th>
                            <th>E-Mail Id</th>
                            <th>Request Date</th>
                            <th>Employee Name</th>
                            <th style="text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>';
        while($arr = mysqli_fetch_array($res)){
            $dbId = $arr['connId'];
            $dbName = $arr['custName'];
            $dbHNo = $arr['houseNo'];
            $dbAreaName = $arr['areaName'];
            $dbPinCode = $arr['pincode'];
            $dbPhNo = $arr['phNumber'];
            $dbEmail = $arr['email'] == null ? "-":$arr['email'];
            $dbEmpId = $arr['empId'];
            $dbDate = $arr['applyDt'];
            $dbDateFormat = date_format(new DateTime($dbDate),"j F Y");
            $fullAdd = "House No. ".$dbHNo.", ".$dbAreaName.", ".$dbPinCode;
            $data .= '<tr id="tableData" data-widget="expandable-table" aria-expanded="false">
                        <td>'.$slno.'</td>
                        <td>'.$dbName.'</td>
                        <td>'.$fullAdd.'</td>
                        <td>'.$dbPhNo.'</td>
                        <td>'.$dbEmail.'</td>
                        <td>'.$dbDateFormat.'</td>';
            $query2 = "SELECT * FROM `cable_operator` WHERE `empId`=$dbEmpId";
            $res2 = mysqli_query($conn,$query2);
            $count2 = mysqli_num_rows($res2);
            if($count2 >= 1){
                while($arr2 = mysqli_fetch_array($res2)){
                    $dbEmpName = $arr2['empName'];
                    $data .= '<td>'.$dbEmpName.'</td>';
                }
            }
            $data .= '<td class="d-flex align-items-center justify-content-center">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-sm btn-success"
                                data-bs-toggle="modal" data-bs-target="#acceptModal"
                                onclick="acceptData('.$dbId.')">
                                <i class="fas fa-user-check"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger"
                                onclick="rejectData('.$dbId.')">
                                <i class="fas fa-user-times"></i>
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


/************ Data Accept ***********/
if(isset($_POST['connId']) && isset($_POST['stbNo'])){
    require './config.php';
    $connId = $_POST['connId'];
    $sTBNo = $_POST['stbNo'];
    $query = "SELECT * FROM `customer` WHERE `STBNumber`='".$sTBNo."' AND `connId`!= $connId";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count == 0){
        $query2 = "UPDATE `customer` SET `STBNumber`='".$sTBNo."' WHERE `connId`=$connId";
        $res = mysqli_query($conn,$query2);
        if($res){
            date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
            $date = date('Y-m-d H:i:s');
            $query3 = "UPDATE `new_connection` SET `connStatus`='active',`approveDt`='".$date."' WHERE `connId`=$connId";
            $res3 = mysqli_query($conn,$query3);
            if($res3){
                echo 2;
            }
        }
    }
    else{
        echo 1;
    }
}


/****************** Reject Data *************/
if(isset($_POST['delId'])){
    $connid = $_POST['delId'];
    require "./config.php";
    $query = "DELETE FROM `new_connection` WHERE `connId` = $connid";
    $res = mysqli_query($conn,$query);
    if($res){
        echo 1;
    }
}



/************* search data *********/
/************* Search Data *************/
if(isset($_POST['serchText'])){
    $searchText = $_POST['serchText'];
    $data = '';
    $slno = 1;
    require "./config.php";
    $query = "SELECT * FROM `new_connection` INNER JOIN `customer` ON new_connection.connId=customer.connId WHERE `custName` LIKE '%".$searchText."%' OR `email` LIKE '%".$searchText."%' OR `phNumber` LIKE '%".$searchText."%' AND new_connection.connStatus='pending' ORDER BY new_connection.connId DESC";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        $data .= '<table class="table table-bordered table-head-fixed  table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Address</th>
                            <th>Contact Number</th>
                            <th>E-Mail Id</th>
                            <th>Request Date</th>
                            <th>Employee Name</th>
                            <th style="text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>';
        while($arr = mysqli_fetch_array($res)){
            $dbId = $arr['connId'];
            $dbName = $arr['custName'];
            $dbHNo = $arr['houseNo'];
            $dbAreaName = $arr['areaName'];
            $dbPinCode = $arr['pincode'];
            $dbPhNo = $arr['phNumber'];
            $dbEmail = $arr['email'] == null ? "-":$arr['email'];
            $dbEmpId = $arr['empId'];
            $dbDate = $arr['applyDt'];
            $dbDateFormat = date_format(new DateTime($dbDate),"j F Y");
            $fullAdd = "House No. ".$dbHNo.", ".$dbAreaName.", ".$dbPinCode;
            $dbSTS = $arr['connStatus'];
            if($dbSTS == 'pending')
            {
                    $data .= '<tr id="tableData" data-widget="expandable-table" aria-expanded="false">
                                <td>'.$slno.'</td>
                                <td>'.$dbName.'</td>
                                <td>'.$fullAdd.'</td>
                                <td>'.$dbPhNo.'</td>
                                <td>'.$dbEmail.'</td>
                                <td>'.$dbDateFormat.'</td>';
                    $query2 = "SELECT * FROM `cable_operator` WHERE `empId`=$dbEmpId";
                    $res2 = mysqli_query($conn,$query2);
                    $count2 = mysqli_num_rows($res2);
                    if($count2 >= 1){
                        while($arr2 = mysqli_fetch_array($res2)){
                            $dbEmpName = $arr2['empName'];
                            $data .= '<td>'.$dbEmpName.'</td>';
                        }
                    }
                    $data .= '<td class="d-flex align-items-center justify-content-center">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-sm btn-success"
                                        data-bs-toggle="modal" data-bs-target="#acceptModal"
                                        onclick="acceptData('.$dbId.')">
                                        <i class="fas fa-user-check"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger"
                                        onclick="rejectData('.$dbId.')">
                                        <i class="fas fa-user-times"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>';
            }
            else{
                $data .= '<tr>
                            <td colspan="8" class="table-active" style="text-align:center"> Records Not Found</td>
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