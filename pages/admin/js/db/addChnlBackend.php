<?php
/*********** Get data ************/
if(isset($_POST['dummyVar2'])){
    $data = '';
    $slNo = 1;
    require "./config.php";
    $query = "SELECT * FROM `pkg_manage_co` JOIN `package` ON pkg_manage_co.pkgId = package.pkgId WHERE package.pkgType='default' ORDER BY package.pkgId DESC";
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
            $dbPkgName = $arr['pkgName'];
            $dbPkgAmt = $arr['amount'] == null? 0 : $arr['amount'];
            $dbDate = $arr['date'];
            $dbDateFormat = date_format(new DateTime($dbDate),"j F Y");
            $data .= '<tr id="tableData">
                            <td>'.$slNo++.'</td>
                            <td>'.$dbPkgName.'</td>
                            <td>&#8377; '.$dbPkgAmt.'</td>
                            <td> 
                                <a data-bs-toggle="modal" data-bs-target="#allChnlModal" style="cursor:pointer;color:blue;" onclick="getChnlsForModal('.$id.')">
                                    View Channels
                                </a> 
                            </td>
                            <td>'.$dbDateFormat.'</td>
                            <td class="d-flex align-items-center justify-content-center">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteData('.$id.')"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal">
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


/*******************Get pkg Data **************/
if(isset($_POST['dummyVar'])){
    $data = '';
    require "./config.php";
    $query = "SELECT * FROM `package` WHERE `pkgType`='default' ORDER BY `pkgId` DESC";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count != 0){
        $data .= '<select class="form-select selectedId" id="floatingSelect" aria-label="Floating label select example" >
                    <option selected value=0 >Open this select menu</option>';
        while($arr = mysqli_fetch_array($res)){
            $id = $arr['pkgId'];
            $name = $arr['pkgName'];
            $data .= '<option value='.$id.'>'.$name.'</option>';
        }
        $data .= '</select>
                <label for="floatingSelect">Select Package</label>';
    }
    else{
        $data .= '<h6> Records Not Found </h6>';
    }
    echo $data;
    mysqli_close($conn);
}

/************ Add data *********/
if(isset($_POST['pkgId']) && isset($_POST['arr']))
{
    $arrs = $_POST['arr'];
    $id = $_POST['pkgId'];
    $chnlName = array();
    $logo = array();
    $chnlAmt = array();
    $countSize = sizeof($arrs);
    $totalAmt = 0;
    foreach ($arrs as $arr) {
        # code...
        $afterFilterData = explode("%", $arr);
        array_push($chnlName,$afterFilterData[1]);
        array_push($logo,$afterFilterData[2]);
        array_push($chnlAmt,$afterFilterData[3]);
    }
    $sts = '';
    require "./config.php";
    for ($i=0; $i < $countSize; $i++) { 
        # code...
        $totalAmt += $chnlAmt[$i];
        $query = "INSERT INTO `channels`(`pkgId`, `chnlName`, `chnlAmt`, `logo`) VALUES ($id,'".$chnlName[$i]."',$chnlAmt[$i],'".$logo[$i]."')";
        $res = mysqli_query($conn,$query);
        if($res){
            $sts = '1';
        }
        else{
            $sts = '0';
            break;
        }
    }
    if($sts == '1'){
        $query2 = "SELECT * FROM `package` WHERE `pkgId`=$id";
        $res2 = mysqli_query($conn,$query2);
        $count2 = mysqli_num_rows($res2);
        if($count2 >= 1){
            while($arr = mysqli_fetch_array($res2)){
                $dbAmt = $arr['amount'];
            }
            $query3 = "SELECT * FROM `channels` WHERE `pkgId`=$id";
            $res3 = mysqli_query($conn,$query3);
            $count3 = mysqli_num_rows($res3);
            if($count3 > 1){
                $finalAmount = $dbAmt + $totalAmt;
                $query4 = "UPDATE `package` SET `amount`=$finalAmount WHERE `pkgId`=$id";
                $res4 =mysqli_query($conn,$query4);
                if($res4){
                    echo 1;
                    // echo $totalAmt;
                }
            }
            if($count3 == 0){
                $query5 = "UPDATE `package` SET `amount`=$totalAmt WHERE `pkgId`=$id";
                $res5 =mysqli_query($conn,$query5);
                if($res4){
                    echo 1;
                    // echo $totalAmt;
                }
            }
        }
    }
}


/************ get channels for modal *********/
if(isset($_POST['getchnlID'])){
    $id = $_POST['getchnlID'];
    $data = '';
    require "./config.php";
    $query = "SELECT * FROM `channels` WHERE `pkgId`=$id";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        while($arr = mysqli_fetch_array($res)){
            $dbLogo = $arr['logo'];
            $logoPath = '../../dist/img/chnlLogo/'.$dbLogo;
            $dbChnlAmt = $arr['chnlAmt'];
            $dbChnlName = $arr['chnlName'];
            $data .= '<div class="d-flex flex-column box">
                        <div id="subBox2">
                            <img src="'.$logoPath.'" alt="'.$dbChnlName.' Logo" id="chnlLogo2">
                            <p><b>&#8377;'.$dbChnlAmt.'</b></p>
                        </div>
                    </div>';
        }
    }
    else{
        $data .= '<div class="d-flex align-items-center justify-content-center">
                <h4> Data not found</h4>
                </div>';
    }
    echo $data;
}


/************ get channels for delete modal *********/
if(isset($_POST['delIdForGetChnl'])){
    $id = $_POST['delIdForGetChnl'];
    $data = '';
    $no = 1;
    require "./config.php";
    $query = "SELECT * FROM `channels` WHERE `pkgId`=$id";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        while($arr = mysqli_fetch_array($res)){
            $dbLogo = $arr['logo'];
            $logoPath = '../../dist/img/chnlLogo/'.$dbLogo;
            $dbChnlAmt = $arr['chnlAmt'];
            $dbChnlName = $arr['chnlName'];
            // $arr = array("chnlName"=>".$dbChnlName.", "pkgIdForDel"=>$dbChnlAmt);
            $data .= '<li onclick="clikThis('.$no.')">
                        <input type="hidden" value="'.$dbChnlName.'" id="chnlNameForDel'.$no.'">
                        <input type="hidden" value="'.$id.'" id="pkgIdForDel'.$no.'">
                        <input type="hidden" value="'.$dbLogo.'" id="logoPath'.$no.'">
                        <input type="hidden" value="'.$dbChnlAmt.'" id="chnlAmt'.$no.'">
                        <a class="dropdown-item" style="cursor: pointer;">
                            <div
                                class=" w-100 d-flex align-items-center justify-content-between">
                                <img src="'.$logoPath.'"
                                    alt="'.$dbChnlName.' Logo Image" style="height: 61px;">
                                <p><b>&#8377;'.$dbChnlAmt.'</b></p>
                            </div>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>';
                    $no++;
        }
    }
    else{
        $data .= '<li>
        <div class="d-flex align-items-center justify-content-center">
                <h4> Data not found</h4>
                </div>
                </li>';
    }
    echo $data;
}


/****************** Delete Data *************/
if(isset($_POST['chnlNameForD']) && isset($_POST['pkgIdForD'])){
    $id = $_POST['pkgIdForD'];
    $chnlName = $_POST['chnlNameForD'];
    require "./config.php";

    $query ="SELECT * FROM `channels` WHERE `pkgId`=$id";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count > 1){
        $query2 = "SELECT * FROM `package` WHERE `pkgId`=$id";
        $res2 = mysqli_query($conn,$query2);
        $count2 = mysqli_num_rows($res2);
        if($count >= 1){
            while($arr2 = mysqli_fetch_array($res2)){
                $dbAmount = $arr2['amount'];
            }
            $q = "SELECT * FROM `channels` WHERE `pkgId`=$id AND `chnlName` = '".$chnlName."'";
            $r = mysqli_query($conn,$q);
            $c = mysqli_num_rows($r);
            if($c > 0){
                while($arr = mysqli_fetch_array($r)){
                    $dbChnlAmount = $arr['chnlAmt'];
                }
                $amt = $dbAmount-$dbChnlAmount;
                $query3 = "DELETE FROM `channels` WHERE `pkgId` = $id AND `chnlName` = '".$chnlName."'";
                $res3 = mysqli_query($conn,$query3);
                if($res3){
                    $query4 = "UPDATE `package` SET `amount`= $amt WHERE `pkgId` = $id";
                    $res4 = mysqli_query($conn,$query4);
                    if($res4){
                        echo 1;
                    }
                }
            }
        }
    }
    if($count == 1){
        $finalAmount2 = 0;
        $query5 = "DELETE FROM `channels` WHERE `pkgId` = $id AND `chnlName` = '".$chnlName."'";
        $res5 = mysqli_query($conn,$query5);
        if($res5){
            $query6 = "UPDATE `package` SET `amount`= $finalAmount2 WHERE `pkgId` = $id";
            $res6 = mysqli_query($conn,$query6);
            if($res6){
                echo 1;
            }
        }
    }
}

/************* automatically add data pkg amt ***********/
if(isset($_POST['dummyVar5'])){
    require './config.php';
    $sum = 0;
    $query = "SELECT DISTINCT custompkgids.pkgId  FROM `custompkgids` INNER JOIN `package` ON custompkgids.pkgId=package.pkgId WHERE package.pkgType != 'default'";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        while($arr = mysqli_fetch_array($res)){
            $dbPkgIds = $arr['pkgId']." ";
            $query2 = "SELECT * FROM `custompkgids` WHERE `pkgId`=$dbPkgIds";
            $res2 = mysqli_query($conn,$query2);
            $count2 = mysqli_num_rows($res2);
            if($count2 >= 1){
                while($arr2 = mysqli_fetch_array($res2)){
                    $dbSubPkg = $arr2['pkgIds'];
                    $query3 = "SELECT * FROM `package` WHERE `pkgId`=$dbSubPkg";
                    $res3 = mysqli_query($conn,$query3);
                    $count3 = mysqli_num_rows($res3);
                    if($count >= 1){
                        while($arr3 = mysqli_fetch_array($res3)){
                            $dbAmount = $arr3['amount'];
                            $sum += $dbAmount;
                        }
                    }
                }
            }
            $query4 = "UPDATE `package` SET `amount`='$sum' WHERE `pkgId`= $dbPkgIds";
            $res4 = mysqli_query($conn,$query4);
            if($res4){
                $sum = 0;
            }
        }
    }
}



/************* Search Data *************/
if(isset($_POST['serchText'])){
    $searchText = $_POST['serchText'];
    $data = '';
    $slNo = 1;
    require "./config.php";
    $query = "SELECT * FROM `pkg_manage_co` JOIN `package` ON pkg_manage_co.pkgId = package.pkgId WHERE package.pkgName LIKE '%".$searchText."%' OR package.amount LIKE '%".$searchText."%' OR pkg_manage_co.date LIKE '%".$searchText."%' AND package.pkgType='default' ORDER BY package.pkgId DESC";
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
            $dbPkgName = $arr['pkgName'];
            $dbPkgAmt = $arr['amount'] == null? 0 : $arr['amount'];
            $dbDate = $arr['date'];
            $dbDateFormat = date_format(new DateTime($dbDate),"j F Y");
            $data .= '<tr id="tableData">
                            <td>'.$slNo++.'</td>
                            <td>'.$dbPkgName.'</td>
                            <td>&#8377; '.$dbPkgAmt.'</td>
                            <td> 
                                <a data-bs-toggle="modal" data-bs-target="#allChnlModal" style="cursor:pointer;color:blue;" onclick="getChnlsForModal('.$id.')">
                                    View Channels
                                </a> 
                            </td>
                            <td>'.$dbDateFormat.'</td>
                            <td class="d-flex align-items-center justify-content-center">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteData('.$id.')"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal">
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
if(isset($_POST['pkgNameCustom']) && isset($_POST['arr2']) && isset($_POST['adminId'])){
    $adminId = $_POST['adminId'];
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
    $query2 ="INSERT INTO `package`(`amount`, `pkgName`, `pkgType`) VALUES ('".$totalAmt."','".$pkgNameCpitalWord."-".$adminId."','defaultcust')";
    $res2 = mysqli_query($conn,$query2);
    if($res2){
        $sts = '1';
        $lastId = mysqli_insert_id($conn);
    }

    if($sts == '1'){
        $q = "INSERT INTO `pkg_manage_co`(`pkgId`, `empId`) VALUES ($lastId,$adminId)";
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
if(isset($_POST['dummyVar4'])){
    $data = '';
    $slNo = 1;
    require "./config.php";
    $query = "SELECT * FROM `pkg_manage_co` JOIN `package` ON pkg_manage_co.pkgId = package.pkgId WHERE package.pkgType='defaultcust'";
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
                        <th>Date Of Create</th>
                    </tr>
                </thead>
                <tbody>';
        while($arr = mysqli_fetch_array($res)){
            $dbPkgId = $arr['pkgIds'];
            $query2 = "SELECT * FROM `pkg_manage_co` JOIN `package` ON pkg_manage_co.pkgId = package.pkgId WHERE package.pkgType='default' AND package.pkgId = $dbPkgId";
            $res2 = mysqli_query($conn,$query2);
            $count2 = mysqli_num_rows($res2);
            if($count2 >= 1){
                while($arr2 = mysqli_fetch_array($res2)){
                    $dbPkgName = $arr2['pkgName'];
                    $dbPkgAmt = $arr2['amount'];
                    $dbDate = $arr2['date'];
                    $dbDateFormat = date_format(new DateTime($dbDate),"j F Y");
                    $data .= '<tr id="tableData">
                                    <td>'.$slNo++.'</td>
                                    <td>'.$dbPkgName.'</td>
                                    <td>&#8377; '.$dbPkgAmt.'</td>
                                    <td>'.$dbDateFormat.'</td>
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
if(isset($_POST['updateCustPkgName']) && isset($_POST['arr3']) && isset($_POST['hiddenCustPkgId']) && isset($_POST['adminId2'])){
    $adminId = $_POST['adminId2'];
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
        $query2 ="INSERT INTO `package`(`amount`, `pkgName`, `pkgType`) VALUES ('".$totalAmt."','".$pkgNameCpitalWord."-".$adminId."','defaultcust')";
        $res2 = mysqli_query($conn,$query2);
        if($res2){
            $sts = '1';
            $lastId = mysqli_insert_id($conn);
        }

        if($sts == '1'){
            $q = "INSERT INTO `pkg_manage_co`(`pkgId`, `empId`) VALUES ($lastId,$adminId)";
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
    $query = "SELECT * FROM `pkg_manage_co` JOIN `package` ON pkg_manage_co.pkgId = package.pkgId WHERE package.pkgName LIKE '%".$searchText."%' OR package.amount LIKE '%".$searchText."%' OR pkg_manage_co.date LIKE '%".$searchText."%'  AND package.pkgType='defaultcust'";
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