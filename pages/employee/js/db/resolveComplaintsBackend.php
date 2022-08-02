<?php

/************* Get data ********/
if(isset($_POST['dummyVar'])){
    $data = '';
    $slno = 1;
    $id = $_POST['dummyVar'];
    require './config.php';
    $query = "SELECT customer.phNumber As phNo , customer.* , complaints.* , cable_operator.* FROM `customer` JOIN `complaints` ON customer.custId=complaints.custId JOIN `cable_operator` ON cable_operator.empId=complaints.empId  WHERE complaints.status = 'resolved' AND complaints.empId = $id ORDER BY complaints.complaintsId DESC";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        $data .= '<table class="table table-bordered table-head-fixed  table-hover">
                    <thead>
                        <tr>
                            <th>Complaint Number</th>
                            <th>Date</th>
                            <th>Customer Name</th>
                            <th>Contact Number</th>
                            <th>Employee Name</th>
                            <th>Complaint</th>
                        </tr>
                    </thead>
                    <tbody>';
        
        while($arr = mysqli_fetch_array($res)){
            $dbId = $arr['complaintsId'];
            $dbComplaintNo = $arr['complaintNo'];
            $dbName = $arr['custName'];
            $dbPhNo = $arr['phNo'];
            $dbDate = $arr['complaintsDt'];
            $dbDateFormat = date_format(new DateTime($dbDate),"j F Y");
            $dbEmpName = $arr['empName'];

            $data .= '<tr id="tableData" data-widget="expandable-table" aria-expanded="false">
                            <td>'.$dbComplaintNo.'</td>
                            <td>'.$dbDateFormat.'</td>
                            <td>'.$dbName.'</td>
                            <td>'.$dbPhNo.'</td>
                            <td>'.$dbEmpName.'</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary"
                                    data-bs-toggle="modal" data-bs-target="#showComplaintModal" onclick="showComplaintDetail('.$dbId.')">
                                    <i class="fas fa-comment-dots"></i>
                                </button>
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




/************ get complaints details *********/
if(isset($_POST['IdForGetComplaintDetail'])){
    require './config.php';
    $data = '';
    $id = $_POST['IdForGetComplaintDetail'];
    $query = "SELECT * FROM `complaints` JOIN `customer` ON complaints.custId = customer.custId WHERE complaints.complaintsId = $id";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= $count){
        while($arr = mysqli_fetch_array($res)){
            $dbHNo = $arr['houseNo'];
            $dbAreaName = $arr['areaName'];
            $dbPinCode = $arr['pincode'];
            $dbComplaintSub = $arr['subject'];
            $dbComplaintDes = $arr['description'];
            $fullAdd = "House No. ".$dbHNo.", ".$dbAreaName.", ".$dbPinCode;
            $data .= '<div id="Address" class="mb-2">
                        <h6><b>Address :-</b></h6>
                        <p id="addressText" class="mt-1">
                            '.$fullAdd.'
                        </p>
                    </div>
                    <div id="subject" class="mt-2 mb-2">
                        <h6><b>Subject :-</b></h6>
                        <p id="subjectText" class="mt-1">
                            '.$dbComplaintSub.'
                        </p>
                    </div>
                    <div id="Des" class="mt-2 mb-2">
                        <h6><b>Description :-</b></h6>
                        <p id="desText" class="mt-1">
                            '.$dbComplaintDes.'
                        </p>
                    </div>';
            
        }
        echo $data;
    }
    mysqli_close($conn);
}


/************* search data ********/
if(isset($_POST['serchText'])){
    $searchText = $_POST['serchText'];
    $id = $_POST['sessionId'];
    $data = '';
    $slno = 1;
    require './config.php';
    $query = "SELECT customer.phNumber As phNo , customer.* , complaints.empId AS emplId, complaints.* , cable_operator.* FROM `customer` JOIN `complaints` ON customer.custId=complaints.custId JOIN `cable_operator` ON cable_operator.empId=complaints.empId  WHERE customer.custName LIKE '%".$searchText."%' OR customer.phNumber LIKE '%".$searchText."%' OR complaints.complaintNo  LIKE '%".$searchText."%' OR cable_operator.empName LIKE '%".$searchText."%' AND complaints.status = 'resolved' AND complaints.empId = $id ORDER BY complaints.complaintsId DESC";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        $data .= '<table class="table table-bordered table-head-fixed  table-hover">
                    <thead>
                        <tr>
                            <th>Complaint Number</th>
                            <th>Date</th>
                            <th>Customer Name</th>
                            <th>Contact Number</th>
                            <th>Employee Name</th>
                            <th>Complaint</th>
                        </tr>
                    </thead>
                    <tbody>';
        
        while($arr = mysqli_fetch_array($res)){
            $dbId = $arr['complaintsId'];
            $dbempId = $arr['emplId'];
            $dbComplaintNo = $arr['complaintNo'];
            $dbName = $arr['custName'];
            $dbPhNo = $arr['phNo'];
            $dbDate = $arr['complaintsDt'];
            $dbDateFormat = date_format(new DateTime($dbDate),"j F Y");
            $dbEmpName = $arr['empName'];
            $dbSTS = $arr['status'];

            if(($dbEmpId == $id) && ($dbSTS == 'resolved')){
                    $data .= '<tr id="tableData" data-widget="expandable-table" aria-expanded="false">
                    <td>'.$dbComplaintNo.'</td>
                    <td>'.$dbDateFormat.'</td>
                    <td>'.$dbName.'</td>
                    <td>'.$dbPhNo.'</td>
                    <td>'.$dbEmpName.'</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-primary"
                            data-bs-toggle="modal" data-bs-target="#showComplaintModal" onclick="showComplaintDetail('.$dbId.')">
                            <i class="fas fa-comment-dots"></i>
                        </button>
                    </td>
                </tr>';
            }
            else{
                $data .= "<tr'>
                            <td colspan='6' class='table-active' style='text-align:center'>Records Not Found</td>
                    </tr>";
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