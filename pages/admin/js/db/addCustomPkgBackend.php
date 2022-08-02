<?php
/**************** search STB Number ********/
if(isset($_POST['stbNo'])){
    $stbNo = $_POST['stbNo'];
    require './config.php';
    $dbCustId = '';
    $query = "SELECT * FROM `customer` WHERE `STBNumber` = '$stbNo'";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        $arr = mysqli_fetch_array($res);
        echo $dbCustId = $arr['custId'];
    }
}


/**************** Get sub packages *******/
if(isset($_POST['dummyVar3'])){
    $data = '';
    $no = 1;
    require './config.php';
    $query ="SELECT * FROM `package` WHERE `pkgType`='default'";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count > 1){
        while($arr = mysqli_fetch_array($res)){
            $dbPkgName = $arr['pkgName'];
            $id = $arr['pkgId'];
            $data .= '<div class="form-check">
                        <input class="form-check-input" type="checkbox"
                            value='.$id.' id="flexCheckDefaultForSubPkg-'.$no.'" name="subPkg">
                        <label class="form-check-label"
                            for="flexCheckDefaultForSubPkg-'.$no.'">
                            '.$dbPkgName.'
                        </label>
                    </div>';
                    $no++;
        }
    }
    else{
        $data .= '<h6>Data Not Found.</h6>';
    }
    echo $data;
    mysqli_close($conn);
}


/***************** Add Custom pkg **********/
if(isset($_POST['pkgNameCustom']) && isset($_POST['arr2']) && isset($_POST['custId'])){
    $custId = $_POST['custId'];
    $pkgName = $_POST['pkgNameCustom'];
    $pkgNameCpitalWord = ucwords(strtolower($_POST['pkgNameCustom']));
    $subPkgIds = $_POST['arr2'];
    $countSize = sizeof($subPkgIds);
    $sumAmt = 0;
    $lastId = 0;
    $sts = '';
    $sts2 = '';
    $sts3 = '';
    $iDs = array();
    require './config.php';
    foreach ($subPkgIds as $subPkgId) {
        # code...
        array_push($iDs,$subPkgId);
    }
    for ($i=0; $i < $countSize; $i++) { 
        $query = "SELECT * FROM `package` WHERE `pkgId` = $iDs[$i]";
        $res = mysqli_query($conn,$query);
        $count = mysqli_num_rows($res);
        if($count >= 1){
            while($arr = mysqli_fetch_array($res)){
                $dbAmt = $arr['amount'];
                $sumAmt += $dbAmt;
            }
            
        }
    }
    $totalAmt = $sumAmt;
    $query2 ="INSERT INTO `package`(`amount`, `pkgName`, `pkgType`) VALUES ('".$totalAmt."','".$pkgNameCpitalWord."-".$custId."','custom')";
    $res2 = mysqli_query($conn,$query2);
    if($res2){
        $sts = '1';
        $lastId = mysqli_insert_id($conn);
    }

    if($sts == '1'){
        $q = "INSERT INTO `pkg_manage_cust`(`pkgId`, `custId`) VALUES ($lastId,$custId)";
        $r = mysqli_query($conn,$q);
        if($r){
            $sts2 = '1';
        }
    }


    if($sts2 == '1'){
        for ($i=0; $i < $countSize; $i++) { 
            $query3 = "SELECT * FROM `package` WHERE `pkgId` = $iDs[$i]";
            $res3 = mysqli_query($conn,$query3);
            $count3 = mysqli_num_rows($res3);
            if($count3 >= 1){
                while($arr3 = mysqli_fetch_array($res3)){
                    $query4 = "INSERT INTO `custompkgids`(`pkgId`, `pkgIds`) VALUES ($lastId,$iDs[$i])";
                    $res4 = mysqli_query($conn,$query4);
                    if($res4){
                        $sts3 = '1';
                    }
                }
            }
        }
        if($sts3 == '1'){
            echo 1;
        }
    }
}


/*********** Get data ************/
if(isset($_POST['getAllTabId'])){
    $customerid = $_POST['getAllTabId'];
    $data = '';
    $slNo = 1;
    require "./config.php";
    $query = "SELECT * FROM `pkg_manage_cust` JOIN `package` ON pkg_manage_cust.pkgId = package.pkgId WHERE package.pkgType='custom' AND pkg_manage_cust.custId = $customerid";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        $data .= '<table class="table table-bordered table-head-fixed table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Package Name</th>
                <th>Total Amount</th>
                <th>Channels</th>
                <th>Date Of Create</th>
                <th style="text-align: center;">Action</th>
            </tr>
        </thead>
        <tbody>';
        while($arr = mysqli_fetch_array($res)){
            $id = $arr['pkgId'];
            $expld = explode('-',$arr['pkgName']);
            $dbPkgName = $expld[0];
            $dbPkgAmt = $arr['amount'] == null? 0 : $arr['amount'];
            $dbDate = $arr['date'];
            $dbDateFormat = date_format(new DateTime($dbDate),"j F Y");
            $data .= '<tr id="tableData">
                            <td>'.$slNo++.'</td>
                            <td>'.$dbPkgName.'</td>
                            <td>&#8377; '.$dbPkgAmt.'</td>
                            <td> 
                                <a data-bs-toggle="modal" data-bs-target="#allSubPkgsModal" style="cursor:pointer;color:blue;" onclick="getSubPkgsForModal('.$id.')">
                                    View Packages
                                </a> 
                            </td>
                            <td>'.$dbDateFormat.'</td>
                            <td class="d-flex align-items-center justify-content-center">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-sm btn-primary" onclick="editCustPkgData('.$id.')"
                                data-bs-toggle="modal" data-bs-target="#editModal">
                                <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="deleteCustPkgData('.$id.')">
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


/****************** get sub pkg details (in modal) **************/
if(isset($_POST['subPkgId'])){
    $id = $_POST['subPkgId'];
    $data = '';
    $slNo = 1;
    require "./config.php";

    $query = "SELECT * FROM `custompkgids` WHERE `pkgId`=$id";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >=1){
        $data .= '<table class="table table-bordered table-head-fixed table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Package Name</th>
                        <th>Total Amount (Without GST)</th>
                    </tr>
                </thead>
                <tbody>';
        while($arr = mysqli_fetch_array($res)){
            $dbPkgId = $arr['pkgIds'];
            // JOIN `pkg_manage_cust` ON package.pkgId = pkg_manage_cust.pkgId
            $query2 = "SELECT * FROM `package`  WHERE pkgType='default' AND pkgId = $dbPkgId";
            $res2 = mysqli_query($conn,$query2);
            $count2 = mysqli_num_rows($res2);
            if($count2 >= 1){
                while($arr2 = mysqli_fetch_array($res2)){
                    $dbPkgName = $arr2['pkgName'];
                    $dbPkgAmt = $arr2['amount'];
                    $data .= '<tr id="tableData">
                                    <td>'.$slNo++.'</td>
                                    <td>'.$dbPkgName.'</td>
                                    <td>&#8377; '.$dbPkgAmt.'</td>
                                </tr>';
                }
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


/************* get cust pkg name **********/
if(isset($_POST['pkgIdForGetCustPkgName'])){
    require './config.php';
    $id = $_POST['pkgIdForGetCustPkgName'];
    $query = "SELECT `pkgName` FROM `package` WHERE `pkgId`=$id";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        while($arr = mysqli_fetch_array($res)){
            $dbPkgName = $arr['pkgName'];
            $dbPkgNameAfterExplode = explode('-',$dbPkgName);
            $pkgName = $dbPkgNameAfterExplode[0];
            echo $pkgName;
        }
    }
}


/**************** Get sub packages *******/
if(isset($_POST['pkgIdForGetAllSubPkg'])){
    $id = $_POST['pkgIdForGetAllSubPkg'];
    $data = '';
    $no = 1;
    $no1 = 1;
    require './config.php';
    $query = "SELECT custompkgids.pkgIds AS subPkgId, package.pkgId AS mainId, package.pkgName  FROM `package` JOIN `custompkgids` ON custompkgids.pkgIds = package.pkgId WHERE custompkgids.pkgId = $id ORDER BY package.pkgId";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        while($arr = mysqli_fetch_array($res)){
            $dbPkgId1 = $arr['subPkgId'];
            $dbPkgId2 = $arr['mainId'];
            $dbPkgName = $arr['pkgName'];
            if($dbPkgId1 == $dbPkgId2){
                $data .= '<div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        value='.$dbPkgId1.' id="flexCheckDefaultForSubPkgUpdate-'.$no.'" name="subPkg2" checked>
                                    <label class="form-check-label"
                                        for="flexCheckDefaultForSubPkgUpdate-'.$no.'">
                                        '.$dbPkgName.'
                                    </label>
                                </div>';
                                $no++;
                                $no1 = $no++;

            }       
        }
        $query2 = "SELECT * FROM `custompkgids` WHERE `pkgId` = $id";
        $res2 = mysqli_query($conn,$query2);
        $count2 = mysqli_num_rows($res2);
        if($count2 != 0){
            while($arr2 = mysqli_fetch_array($res2)){
                $dbids[] = $arr2['pkgIds'];
                $array = join("','",$dbids);  
            }
            $query3 = "SELECT * FROM `package` WHERE `pkgId` NOT IN ('$array') AND `pkgType`='default'";
                $res3 = mysqli_query($conn,$query3);
                $count3 = mysqli_num_rows($res3);
                if($count3 >= 1){
                    while($arr3 = mysqli_fetch_array($res3)){
                        $dbName = $arr3['pkgName'];
                        $dbPkgId4 = $arr3['pkgId'];
                        $data .= '<div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        value='.$dbPkgId4.' id="flexCheckDefaultForSubPkgUpdate-'.$no1.'" name="subPkg2">
                                    <label class="form-check-label"
                                        for="flexCheckDefaultForSubPkgUpdate-'.$no1.'">
                                        '.$dbName.'
                                    </label>
                                </div>';
                                $no1++;
                    }
                }
            // echo $dbids." ";
        }
    }
    else{
            $data .= '<h6>Data Not Found.</h6>';
    }
    echo $data;
        mysqli_close($conn);
    }


/***************** update Custom pkg **********/
if(isset($_POST['updateCustPkgName']) && isset($_POST['arr3']) && isset($_POST['hiddenCustPkgId']) && isset($_POST['custId2'])){
    $custId = $_POST['custId2'];
    $id = $_POST['hiddenCustPkgId'];
    $pkgName = $_POST['updateCustPkgName'];
    $pkgNameCpitalWord = ucwords(strtolower($_POST['updateCustPkgName']));
    $subPkgIds = $_POST['arr3'];
    $countSize = sizeof($subPkgIds);
    $sumAmt = 0;
    $lastId = 0;
    $sts = '';
    $sts2 = '';
    $sts3 = '';
    $iDs = array();
    require './config.php';
    foreach ($subPkgIds as $subPkgId) {
        # code...
        array_push($iDs,$subPkgId);
    }
    $q = "DELETE FROM `package` WHERE `pkgId` = $id";
    $r = mysqli_query($conn,$q);

    if($r){

        for ($i=0; $i < $countSize; $i++) { 
            $query = "SELECT * FROM `package` WHERE `pkgId` = $iDs[$i]";
            $res = mysqli_query($conn,$query);
            $count = mysqli_num_rows($res);
            if($count >= 1){
                while($arr = mysqli_fetch_array($res)){
                    $dbAmt = $arr['amount'];
                    $sumAmt += $dbAmt;
                }
                
            }
        }
        $totalAmt = $sumAmt;
        $query2 ="INSERT INTO `package`(`amount`, `pkgName`, `pkgType`) VALUES ('".$totalAmt."','".$pkgNameCpitalWord."-".$custId."','custom')";
        $res2 = mysqli_query($conn,$query2);
        if($res2){
            $sts = '1';
            $lastId = mysqli_insert_id($conn);
        }

        if($sts == '1'){
            $q = "INSERT INTO `pkg_manage_cust`(`pkgId`, `custId`) VALUES ($lastId,$custId)";
            $r = mysqli_query($conn,$q);
            if($r){
                $sts2 = '1';
            }
        }


        if($sts2 == '1'){
            for ($i=0; $i < $countSize; $i++) { 
                $query3 = "SELECT * FROM `package` WHERE `pkgId` = $iDs[$i]";
                $res3 = mysqli_query($conn,$query3);
                $count3 = mysqli_num_rows($res3);
                if($count3 >= 1){
                    while($arr3 = mysqli_fetch_array($res3)){
                        $query4 = "INSERT INTO `custompkgids`(`pkgId`, `pkgIds`) VALUES ($lastId,$iDs[$i])";
                        $res4 = mysqli_query($conn,$query4);
                        if($res4){
                            $sts3 = '1';
                        }
                    }
                }
            }
            if($sts3 == '1'){
                echo 1;
            }
        }
    }
}


/****************** Delete Cust Pkg Data *************/
if(isset($_POST['delCustPkgId1'])){
    $id = $_POST['delCustPkgId1'];
    require "./config.php";
    $query = "DELETE FROM `package` WHERE `pkgId` = $id";
    $res = mysqli_query($conn,$query);
    if($res){
        echo 1;
    }
}

/************* search Cust pkg data  **********/
if(isset($_POST['serchText2'])){
    $searchText = $_POST['serchText2'];
    $data = '';
    $slNo = 1;
    require "./config.php";
    $query = "SELECT * FROM `pkg_manage_cust` JOIN `package` ON pkg_manage_cust.pkgId = package.pkgId WHERE package.pkgName LIKE '%".$searchText."%' OR package.amount LIKE '%".$searchText."%' AND package.pkgType='custom'";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count != 0){
        $data .= '<table class="table table-bordered table-head-fixed table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Package Name</th>
                <th>Total Amount</th>
                <th>Channels</th>
                <th>Date Of Create</th>
                <th style="text-align: center;">Action</th>
            </tr>
        </thead>
        <tbody>';
        while($arr = mysqli_fetch_array($res)){
            $id = $arr['pkgId'];
            $expld = explode('-',$arr['pkgName']);
            $dbPkgName = $expld[0];
            $dbPkgAmt = $arr['amount'] == null? 0 : $arr['amount'];
            $dbDate = $arr['date'];
            $dbDateFormat = date_format(new DateTime($dbDate),"j F Y");
            $data .= '<tr id="tableData">
                            <td>'.$slNo++.'</td>
                            <td>'.$dbPkgName.'</td>
                            <td>&#8377; '.$dbPkgAmt.'</td>
                            <td> 
                                <a data-bs-toggle="modal" data-bs-target="#allSubPkgsModal" style="cursor:pointer;color:blue;" onclick="getSubPkgsForModal('.$id.')">
                                    View Packages
                                </a> 
                            </td>
                            <td>'.$dbDateFormat.'</td>
                            <td class="d-flex align-items-center justify-content-center">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-sm btn-primary" onclick="editCustPkgData('.$id.')"
                                data-bs-toggle="modal" data-bs-target="#editModal">
                                <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="deleteCustPkgData('.$id.')">
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