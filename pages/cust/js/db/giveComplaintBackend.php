<?php
/********** Data insert  ***********/
if(isset($_POST['custId'])){
    $custId = $_POST['custId'];
    $sub = $_POST['sub'];
    $des = $_POST['des'];
    require './config.php';
    $query = "SELECT * FROM `new_connection` WHERE `custId` = $custId";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        while($arr = mysqli_fetch_array($res)){
            $dbEmpId = $arr['empId'];
            $query2 = "INSERT INTO `complaints`(`description`, `subject`, `custId`, `empId`,`resolveDt`) VALUES ('".$des."','".$sub."', $custId, $dbEmpId , NULL)";
            $res2 = mysqli_query($conn,$query2);
            if($res2){
                $last_id = mysqli_insert_id($conn);
                $randNo = rand(10,99);
                $comNo = 'COM'.$randNo.$last_id;
                $query3 = "UPDATE `complaints` SET `complaintNo`='$comNo' WHERE `complaintsId` = $last_id";
                $res3 = mysqli_query($conn,$query3);
                if($res3){
                    echo 1;
                }
            }
        }
    }
}

?>
