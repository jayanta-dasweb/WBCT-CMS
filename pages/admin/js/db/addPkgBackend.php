<?php
/*********** Get data ************/
if(isset($_POST['dummyVar'])){
    $data = '';
    $slNo = 1;
    require "./config.php";
    $query = "SELECT * FROM `pkg_manage_co` JOIN `package` ON pkg_manage_co.pkgId = package.pkgId WHERE package.pkgType='default'";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count != 0){
        $data .= '<table class="table table-bordered table-head-fixed table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Package Name</th>
                <th>Total Amount + 18% GST</th>
                <th>Date Of Create</th>
                <th style="text-align: center;">Action</th>
            </tr>
        </thead>
        <tbody>';
        while($arr = mysqli_fetch_array($res)){
            $id = $arr['pkgId'];
            $dbPkgName = $arr['pkgName'];
            $dbPkgAmt = $arr['amount'] == null? 0 : $arr['amount'];
            $dbDate = $arr['date'];
            $dbDateFormat = date_format(new DateTime($dbDate),"j F Y");
            $data .= '<tr id="tableData">
                            <td>'.$slNo++.'</td>
                            <td>'.$dbPkgName.'</td>
                            <td>&#8377; '.$dbPkgAmt.'</td>
                            <td>'.$dbDateFormat.'</td>
                            <td class="d-flex align-items-center justify-content-center">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-sm btn-success" onclick="editData('.$id.')" 
                                    data-bs-toggle="modal" data-bs-target="#updateModal">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteData('.$id.')">
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


/************ Add data  *************/
if (isset($_POST['createById']) && isset($_POST['createPkgName'])) {
    # code...
    $id = $_POST['createById'];
    $pkgName = $_POST['createPkgName'];
    $pkgNameCapitalEachWordFirstLetter = ucwords(strtolower($_POST['createPkgName']));
    $pkgNameFilter = strtolower(str_replace(' ', '', $pkgName));
    $sts = false;
    require "./config.php";
    $query = "SELECT * FROM `package`";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        while($arr = mysqli_fetch_array($res)){
            $dbPkgName = $arr['pkgName'];
            $dbPkgNameFilter = strtolower(str_replace(' ', '', $dbPkgName));
            if($dbPkgNameFilter == $pkgNameFilter){
                $sts = true;
                break;
            }
            else{
                $sts = false;
            }
        }
        if($sts == true){
            echo 1;
        }
        else{
            $query2 = "INSERT INTO `package`(`pkgName`,`pkgType`) VALUES ('".$pkgNameCapitalEachWordFirstLetter."','default')";
            $res2 = mysqli_query($conn, $query2);
            if($res2){
                $last_pkgId = mysqli_insert_id($conn);
                $query3 = "INSERT INTO `pkg_manage_co`(`pkgId`, `empId`) VALUES ($last_pkgId,$id)";
                $res3 = mysqli_query($conn,$query3);
                if($res3){
                    echo 2;
                }
            }
        }
    }
    else{
        $query4 = "INSERT INTO `package`(`pkgName`,`pkgType`) VALUES ('".$pkgNameCapitalEachWordFirstLetter."','default')";
        $res4 = mysqli_query($conn, $query4);
        if($res4){
            $last_pkgId2 = mysqli_insert_id($conn);
            $query5 = "INSERT INTO `pkg_manage_co`(`pkgId`, `empId`) VALUES ($last_pkgId2,$id)";
            $res5 = mysqli_query($conn,$query5);
            if($res5){
                echo 2;
            }
        }
    }
}

/******************** get pkg name for edit ***********/
if(isset($_POST['idForGetPkgName'])){
    $id = $_POST['idForGetPkgName'];
    require "./config.php";
    $query = "SELECT * FROM `package` WHERE `pkgId` = $id";
    $res = mysqli_query($conn, $query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        while($arr = mysqli_fetch_array($res)){
            echo $dbPkgName = $arr['pkgName'];
        }
    }
}

/************** final update data ******/
if(isset($_POST['updateId']) && isset($_POST['updatePkgName'])){
    $id = $_POST['updateId'];
    $pkgName = $_POST['updatePkgName'];
    $pkgNameCapitalEachWordFirstLetter = ucwords(strtolower($_POST['updatePkgName']));
    $pkgNameFilter = strtolower(str_replace(' ', '', $pkgName));
    $sts = false;
    require "./config.php";
    $query = "SELECT * FROM `package` WHERE `pkgId` != $id";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        while($arr = mysqli_fetch_array($res)){
            $dbPkgName = $arr['pkgName'];
            $dbPkgNameFilter = strtolower(str_replace(' ', '', $dbPkgName));
            if($dbPkgNameFilter == $pkgNameFilter){
                $sts = true;
                break;
            }
            else{
                $sts = false;
            }
        }
        if($sts == true){
            echo 1;
        }
        else{
            $query2 = "UPDATE `package` SET `pkgName`='".$pkgNameCapitalEachWordFirstLetter."' WHERE `pkgId` = $id";
            $res2 = mysqli_query($conn, $query2);
            if($res2){
                echo 2;
            }
        }
    }
    else{
        $query4 = "UPDATE `package` SET `pkgName`='".$pkgNameCapitalEachWordFirstLetter."' WHERE `pkgId` = $id";
        $res4 = mysqli_query($conn, $query4);
        if($res4){
            echo 2;
        }
    }
}

/****************** Delete Data *************/
if(isset($_POST['delId'])){
    $id = $_POST['delId'];
    require "./config.php";
    $query = "DELETE FROM `package` WHERE `pkgId` = $id";
    $res = mysqli_query($conn,$query);
    if($res){
        echo 1;
    }
}



/***************** search data ************/
if(isset($_POST['serchText'])){
    $searchText = $_POST['serchText'];
    $data = '';
    $slNo = 1;
    require "./config.php";
    $query = "SELECT * FROM `pkg_manage_co` JOIN `package` ON pkg_manage_co.pkgId = package.pkgId WHERE package.pkgName LIKE '%".$searchText."%' OR package.amount LIKE '%".$searchText."%' OR pkg_manage_co.date LIKE '%".$searchText."%' AND WHERE package.pkgType='default'";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count != 0){
        $data .= '<table class="table table-bordered table-head-fixed table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Package Name</th>
                <th>Total Amount</th>
                <th>Date Of Create</th>
                <th style="text-align: center;">Action</th>
            </tr>
        </thead>
        <tbody>';
        while($arr = mysqli_fetch_array($res)){
            $id = $arr['pkgId'];
            $dbPkgName = $arr['pkgName'];
            $dbPkgAmt = $arr['amount'] == null? 0 : $arr['amount'];
            $dbDate = $arr['date'];
            $dbDateFormat = date_format(new DateTime($dbDate),"j F Y");
            $data .= '<tr id="tableData">
                            <td>'.$slNo++.'</td>
                            <td>'.$dbPkgName.'</td>
                            <td>'.$dbPkgAmt.'</td>
                            <td>'.$dbDateFormat.'</td>
                            <td class="d-flex align-items-center justify-content-center">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-sm btn-success" onclick="editData('.$id.')" 
                                    data-bs-toggle="modal" data-bs-target="#updateModal">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteData('.$id.')">
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



?>