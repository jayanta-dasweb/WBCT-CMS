<?php
/************** Get Data  **************/
if(isset($_POST['dummyVar2']))
{
    $data = '';
    $slNo = 1;
    require "./config.php";
    $query = "SELECT * FROM `cable_operator` WHERE `role`='employee'";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count != 0)
    {
        $data .= '<table class="table table-bordered table-head-fixed table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Ph Number</th>
                <th>Area</th>
                <th style="text-align: center;">Action</th>
            </tr>
        </thead>
        <tbody>';
        while($arr = mysqli_fetch_array($res))
        {
            $id = $arr['empId'];
            $name = $arr['empName'];
            $phNo = $arr['phNumber'];


            $data .= '<tr id="tableData">
                            <td>'.$slNo++.'</td>
                            <td>'.$name.'</td>
                            <td>'.$phNo.'</td>
                            <td>';



            $query2 = "SELECT * FROM `area` WHERE `empId`=$id";
            $res2 = mysqli_query($conn, $query2);
            $count2 = mysqli_num_rows($res2);
            $data .= '<ul>';
            if($count2 != 0){
                $countRow = 1;
                while($arr2 = mysqli_fetch_array($res2)){
                    $dbAreaName = $arr2['areaName'];
                    $data .= '<li>'.$dbAreaName.'</li>';
                    
                }
            }
            else{
                $data .= '<li style="color:red">Record Not Found</li>';
            }



            $data .= '</ul>
                    </td>
                        <td class="d-flex align-items-center justify-content-center">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-sm btn-success" onclick="editData('.$id.')" 
                                data-bs-toggle="modal" data-bs-target="#updateModal">
                                    <i class="fas fa-edit"></i>
                                </button>
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
    else
    {
        $data .= "<div class='w-100 d-flex align-items-center justify-content-center'>
                    <h6>Records Not Found</h6>
                </div>";
    }
    echo $data;
    mysqli_close($conn);
}




/*******************Get Emp Data **************/
if(isset($_POST['dummyVar'])){
    $data = '';
    require "./config.php";
    $query = "SELECT * FROM `cable_operator` WHERE `role`='employee'";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count != 0){
        $data .= '<select class="form-select selectedId" id="floatingSelect" aria-label="Floating label select example" >
                    <option selected value=0 >Open this select menu</option>';
        while($arr = mysqli_fetch_array($res)){
            $id = $arr['empId'];
            $name = $arr['empName'];
            $data .= '<option value='.$id.'>'.$name.'</option>';
        }
        $data .= '</select>
                <label for="floatingSelect">Select Employee</label>';
    }
    else{
        $data .= '<h6> Records Not Found </h6>';
    }
    echo $data;
    mysqli_close($conn);
}


/**************** Add data Into Table ************/
if(isset($_POST['empId']) && isset($_POST['areaName'])){
    $id = $_POST['empId'];
    $areaName = $_POST['areaName'];
    $areaNameCapitalEachWordFirstLetter = ucwords(strtolower($_POST['areaName']));
    $areaNameFilter = strtolower(str_replace(' ', '', $areaName));
    $sts = false;
    $sts2 = false;
    $sts4 = false;

    require "./config.php";
    $query = "SELECT * FROM `area` WHERE `empId` = $id";
    $res = mysqli_query($conn, $query);
    $count = mysqli_num_rows($res);
    if($count != 0){
        while($arr = mysqli_fetch_array($res)){
            $dbAreaName = $arr['areaName'];
            $dbAreaNameFilter = strtolower(str_replace(' ', '', $dbAreaName));
            if($dbAreaNameFilter == $areaNameFilter){
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
            $query2 = "SELECT * FROM `area`  WHERE `empId` != $id";
            $res2 = mysqli_query($conn, $query2);
            $count2 = mysqli_num_rows($res2);
            if($count2 != 0){
                while($arr2 = mysqli_fetch_array($res2))
                {
                    $dbAreaName2 = $arr2['areaName'];
                    $dbAreaNameFilter2 = strtolower(str_replace(' ', '', $dbAreaName2));
                    if($dbAreaNameFilter2 == $areaNameFilter){
                        $sts2 = true;
                        break;
                    }
                    else{
                        $sts2 = false;
                    }
                }
                if($sts2 == true){
                    echo 2;
                }
                else{
                    $query3 = "INSERT INTO `area`(`empId`, `areaName`) VALUES ($id ,'".$areaNameCapitalEachWordFirstLetter."')";
                    $res3 = mysqli_query($conn, $query3);
                    if($res3){
                        echo 3;
                    }
                }
            }
        }
    }
    else{
        $query4 = "SELECT * FROM `area`  WHERE `empId` != $id";
        $res4 = mysqli_query($conn, $query4);
        $count4 = mysqli_num_rows($res4);
        if($count4 != 0){
            while($arr4 = mysqli_fetch_array($res4))
            {
                $dbAreaName4 = $arr4['areaName'];
                $dbAreaNameFilter4 = strtolower(str_replace(' ', '', $dbAreaName4));
                if($dbAreaNameFilter4 == $areaNameFilter){
                    $sts4 = true;
                    break;
                }
                else{
                    $sts4 = false;
                }
            }
            if($sts4 == true){
                echo 2;
            }
            else{
                $query5 = "INSERT INTO `area`(`empId`, `areaName`) VALUES ($id ,'".$areaNameCapitalEachWordFirstLetter."')";
                $res5 = mysqli_query($conn, $query5);
                if($res5){
                    echo 4;
                }
            }
        }
    }
    mysqli_close($conn);
}

/******************** Get area data ****************/
if(isset($_POST['idForGetAreaDetails'])){
    $id =  $_POST['idForGetAreaDetails'];
    $data = '';
    require "./config.php";
    $query = "SELECT * FROM `area` WHERE `empId`=$id";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count != 0){
        $data .= '<select class="form-select selectedAreaName" id="floatingSelect" 
                        aria-label="Floating label select example" onchange="getAreaNameData()">
                    <option selected value="" >Open this select menu</option>';
        while($arr = mysqli_fetch_array($res)){
            $areaName = $arr['areaName'];
            $data .= '<option value="'.$areaName.'">'.$areaName.'</option>';
        }
        $data .= '</select>
                <label for="floatingSelect">Select Area</label>';
    }
    else{
        $data .= '<h6> Records Not Found </h6>';
    }
    echo $data;
    mysqli_close($conn);
}


/************ Final Update Data **********/
if(isset($_POST['empIdForUpdate']) && isset($_POST['areaNameForUpdate']) && isset($_POST['editAreaNameForUpdate']))
{
    $sts = false;
    $sts2 = false;
    $sts3 = false;
    $sts4 = false;
    $id = $_POST['empIdForUpdate'];
    $areaName = $_POST['areaNameForUpdate'];
    $filterAreaName = strtolower(str_replace(' ', '', $areaName));
    $editAreaName = $_POST['editAreaNameForUpdate'];
    $filterEditAreaName = strtolower(str_replace(' ', '', $editAreaName));
    $areaNameCapitalEachWordFirstLetter = ucwords(strtolower($_POST['editAreaNameForUpdate']));
    require "./config.php";
    $query = "SELECT * FROM `area` WHERE `empId` = $id";
    $res = mysqli_query($conn, $query);
    $count = mysqli_num_rows($res);
    if($count > 1)
    {
        while($arr = mysqli_fetch_array($res))
        {
            $dbEmpId = $arr['empId'];
            $dbAreaName = $arr['areaName'];
            $dbFilterAreaName = strtolower(str_replace(' ', '', $dbAreaName));
            if($dbFilterAreaName != $filterAreaName)
            {
                if($dbFilterAreaName == $filterEditAreaName)
                {
                    $sts = true;
                    break;
                }
                else
                {
                    $sts = false;
                }
            }
        }
        if($sts == true)
        {
            echo 1;
        }
        else
        {
            $query7 = "SELECT * FROM `area`  WHERE `empId` != $id";
            $res7 = mysqli_query($conn, $query7);
            $count7 = mysqli_num_rows($res7);
            if($count7 != 0)
            {
                while($arr7 = mysqli_fetch_array($res7))
                {
                    $dbAreaName7 = $arr7['areaName'];
                    $dbAreaNameFilter7 = strtolower(str_replace(' ', '', $dbAreaName7));
                    if($dbAreaNameFilter7 == $filterEditAreaName)
                    {
                        $sts4 = true;
                        break;
                    }
                    else
                    {
                        $sts4 = false;
                    }
                }
                if($sts4 == true)
                {
                    echo 2;
                }
                else
                {
                    $query8 = "UPDATE `area` SET `areaName`='".$areaNameCapitalEachWordFirstLetter."' WHERE `empId`= $id AND `areaName` = '".$areaName."' ";
                    $res8 = mysqli_query($conn, $query8);
                    if($res8)
                    {
                        echo 3;
                    }
                }
            }
        }

    }
    else if($count === 1)
    {
        $query2 = "SELECT * FROM `area`  WHERE `empId` != $id";
        $res2 = mysqli_query($conn, $query2);
        $count2 = mysqli_num_rows($res2);
        if($count2 != 0)
        {
            while($arr2 = mysqli_fetch_array($res2))
            {
                $dbAreaName2 = $arr2['areaName'];
                $dbAreaNameFilter2 = strtolower(str_replace(' ', '', $dbAreaName2));
                if($dbAreaNameFilter4 == $filterEditAreaName)
                {
                    $sts2 = true;
                    break;
                }
                else
                {
                    $sts2 = false;
                }
            }
            if($sts2 == true)
            {
                echo 2;
            }
            else
            {
                $query3 = "UPDATE `area` SET `areaName`='".$areaNameCapitalEachWordFirstLetter."' WHERE `empId`= $id AND `areaName` = '".$areaName."' ";
                $res3 = mysqli_query($conn, $query3);
                if($res3)
                {
                    echo 3;
                }
            }
        }
    }
    else
    {
        $query5 = "SELECT * FROM `area` WHERE `empId` != $id";
        $res5 = mysqli_query($conn, $query5);
        $count5 = mysqli_num_rows($res5);
        if($count5 != 0)
        {
            while($arr5 = mysqli_fetch_array($res5))
            {
                $dbAreaName5 = $arr5['areaName'];
                $dbAreaNameFilter5 = strtolower(str_replace(' ', '', $dbAreaName5));
                if($dbAreaNameFilter5 == $filterEditAreaName)
                {
                    $sts3 = true;
                    break;
                }
                else
                {
                    $sts3 = false;
                }
            }
            if($sts3 == true)
            {
                echo 2;
            }
            else
            {
                $query6 = "UPDATE `area` SET `areaName`='".$areaNameCapitalEachWordFirstLetter."' WHERE `empId`= $id AND `areaName` = '".$areaName."' ";
                $res6 = mysqli_query($conn, $query6);
                if($res6)
                {
                    echo 3;
                }
            }
        }
    }
}



/******************** Get area data for delete ****************/
if(isset($_POST['idForDlt'])){
    $id =  $_POST['idForDlt'];
    $data = '';
    require "./config.php";
    $query = "SELECT * FROM `area` WHERE `empId`=$id";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count != 0){
        $data .= '<select class="form-select selectedAreaNameForDelet" id="floatingSelect" 
                        aria-label="Floating label select example">
                    <option selected value="" >Open this select menu</option>';
        while($arr = mysqli_fetch_array($res)){
            $areaName = $arr['areaName'];
            $data .= '<option value="'.$areaName.'">'.$areaName.'</option>';
        }
        $data .= '</select>
                <label for="floatingSelect">Select Area</label>';
    }
    else{
        $data .= '<h6> Records Not Found </h6>';
    }
    echo $data;
    mysqli_close($conn);
}

/****************** Delete Data *************/
if(isset($_POST['delId']) && isset($_POST['areaNameForDlt'])){
    $id = $_POST['delId'];
    $areaName = $_POST['areaNameForDlt'];
    require "./config.php";
    $query = "DELETE FROM `area` WHERE `empId` = $id AND `areaName` = '".$areaName."'";
    $res = mysqli_query($conn,$query);
    if($res){
        echo 1;
    }
}

/************** Search Data ***********/
if(isset($_POST['serchText'])){
    $searchText = $_POST['serchText'];
    $data = '';
    $slNo = 1;
    require "./config.php";
    $query = "SELECT * FROM `cable_operator` WHERE `role`='employee' AND `empName` Like '%".$searchText."%'  OR `phNumber` Like '%".$searchText."%'";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1)
    {
        $data .= '<table class="table table-bordered table-head-fixed table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Ph Number</th>
                <th>Area</th>
                <th style="text-align: center;">Action</th>
            </tr>
        </thead>
        <tbody>';
        while($arr = mysqli_fetch_array($res))
        {
            $id = $arr['empId'];
            $name = $arr['empName'];
            $phNo = $arr['phNumber'];


            $data .= '<tr id="tableData">
                            <td>'.$slNo++.'</td>
                            <td>'.$name.'</td>
                            <td>'.$phNo.'</td>
                            <td>';



            $query2 = "SELECT * FROM `area` WHERE `empId`=$id";
            $res2 = mysqli_query($conn, $query2);
            $count2 = mysqli_num_rows($res2);
            $data .= '<ul>';
            if($count2 != 0){
                $countRow = 1;
                while($arr2 = mysqli_fetch_array($res2)){
                    $dbAreaName = $arr2['areaName'];
                    $data .= '<li>'.$dbAreaName.'</li>';
                    
                }
            }
            else{
                $data .= '<li style="color:red">Record Not Found</li>';
            }



            $data .= '</ul>
                    </td>
                        <td class="d-flex align-items-center justify-content-center">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-sm btn-success" onclick="editData('.$id.')" 
                                data-bs-toggle="modal" data-bs-target="#updateModal">
                                    <i class="fas fa-edit"></i>
                                </button>
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
    else
    {
        $slNo2 = 1;
        $query3 = "SELECT * FROM `cable_operator` WHERE `role`='employee'";
        $res3 = mysqli_query($conn,$query3);
        $count3 = mysqli_num_rows($res3);
        if($count3 >= 1)
        {
            $data .= '<table class="table table-bordered table-head-fixed table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Ph Number</th>
                    <th>Area</th>
                    <th style="text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>';
            while($arr3 = mysqli_fetch_array($res3))
            {
                $id2 = $arr3['empId'];
                $name2 = $arr3['empName'];
                $phNo2 = $arr3['phNumber'];


                $data .= '<tr id="tableData">
                                <td>'.$slNo2++.'</td>
                                <td>'.$name2.'</td>
                                <td>'.$phNo2.'</td>
                                <td>';



                $query4 = "SELECT * FROM `area` WHERE `areaName` LIKE '%".$searchText."%' AND `empId`=$id2";
                $res4 = mysqli_query($conn, $query4);
                $count4 = mysqli_num_rows($res4);
                $data .= '<ul>';
                if($count4 >= 1){
                    $countRow = 1;
                    while($arr4 = mysqli_fetch_array($res4)){
                        $dbAreaName2 = $arr4['areaName'];
                        $data .= '<li>'.$dbAreaName2.'</li>';
                        
                    }
                }
                else{
                    $data .= '<li style="color:red">Record Not Found</li>';
                }

                $data .= '</ul>
                        </td>
                            <td class="d-flex align-items-center justify-content-center">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-sm btn-success" onclick="editData('.$id2.')" 
                                    data-bs-toggle="modal" data-bs-target="#updateModal">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteData('.$id2.')"
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
    }
    echo $data;
    mysqli_close($conn);
}




?>