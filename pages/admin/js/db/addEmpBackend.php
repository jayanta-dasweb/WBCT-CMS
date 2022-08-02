<?php 
/***************** get all data ***********/
if(isset($_POST['getDataVar'])){
    $data = '';
    $slNo = 1;
    require "./config.php";
    $query = "SELECT * FROM `cable_operator` WHERE `role`='employee'";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count != 0){
        $data .= '<table class="table table-bordered table-head-fixed table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Ph Number</th>
                <th style="text-align: center;">Action</th>
            </tr>
        </thead>
        <tbody>';
        while($arr = mysqli_fetch_array($res)){
            $id = $arr['empId'];
            $name = $arr['empName'];
            $phNo = $arr['phNumber'];
            $data .= '<tr id="tableData">
                            <td>'.$slNo++.'</td>
                            <td>'.$name.'</td>
                            <td>'.$phNo.'</td>
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

/********* get edit Data *******/
if (isset($_POST['id'])) {
    require 'config.php';
	$id=$_POST['id'];
	$query="select * from cable_operator WHERE empId = $id";
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


/********************** Final update Data ***************/
if(isset($_POST['name']) && isset($_POST['phno']) && isset($_POST['hiddenId']))
{
    $id = $_POST['hiddenId'];
    $name = ucwords(strtolower($_POST['name']));
    $phno = $_POST['phno'];
    require "./config.php";
    $query = "SELECT * FROM `cable_operator` WHERE `phNumber`='".$phno."' AND `empId`!=$id";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count == 0){
        $query2 = "UPDATE `cable_operator` SET `empName`='".$name."',`phNumber`='".$phno."' WHERE `empId`=$id";
        $res2 = mysqli_query($conn, $query2);
        if($res2){
            echo 2;
        }
    }
    else{
        echo 1;
    }
    mysqli_close($conn);
}

/***************** Add Data Into Database **********/
if(isset($_POST['empName']) && isset($_POST['empPhno']))
{
    $name = ucwords(strtolower($_POST['empName']));
    $phno = $_POST['empPhno'];
    require "./config.php";
    $query = "SELECT * FROM `cable_operator` WHERE `phNumber`='".$phno."'";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count == 0){
        $query2 = "INSERT INTO `cable_operator`(`empName`, `phNumber`) VALUES ('".$name."','".$phno."')";
        $res2 = mysqli_query($conn, $query2);
        if($res2){
            echo 2;
        }
    }
    else{
        echo 1;
    }
    mysqli_close($conn);
}

/****************** Delete Data *************/
if(isset($_POST['delId'])){
    $id = $_POST['delId'];
    require "./config.php";
    $query = "DELETE FROM `cable_operator` WHERE `empId` = $id";
    $res = mysqli_query($conn,$query);
    if($res){
        echo 1;
    }
}

/************** Search Data ***********/
if(isset($_POST['serchText'])){
    $data = '';
    $slNo = 1;
    $searchText = $_POST['serchText'];
    require "./config.php";
    $query = "SELECT * FROM `cable_operator` WHERE `empName` Like '%".$searchText."%'  OR `phNumber` Like '%".$searchText."%' AND `role`='employee'";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count != 0){
        $data .= '<table class="table table-bordered table-head-fixed table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Ph Number</th>
                <th style="text-align: center;">Action</th>
            </tr>
        </thead>
        <tbody>';
        while($arr = mysqli_fetch_array($res)){
            $id = $arr['empId'];
            $name = $arr['empName'];
            $phNo = $arr['phNumber'];
            $data .= '<tr id="tableData">
                            <td>'.$slNo++.'</td>
                            <td>'.$name.'</td>
                            <td>'.$phNo.'</td>
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