<?php
/*******get total customer *****/
if(isset($_POST['totalCust'])){
    require 'config.php';
    $id = $_POST['totalCust'];
    $query = "SELECT * FROM `customer` JOIN `new_connection` ON customer.custId = new_connection.custId WHERE new_connection.connStatus='active' AND new_connection.empId = $id";
    $res=mysqli_query($conn,$query);
    echo $count =mysqli_num_rows($res);
}


/*******get total active connection *****/
if(isset($_POST['totalActiveConnection'])){
    require 'config.php';
    $id = $_POST['totalActiveConnection'];
    $query = "SELECT * FROM `customer` JOIN `new_connection` ON customer.custId = new_connection.custId WHERE new_connection.connStatus='active' AND new_connection.empId = $id";
    $res=mysqli_query($conn,$query);
    echo $count =mysqli_num_rows($res);
}

/*******get total pending complaints no *****/
if(isset($_POST['totalPendingComplaints'])){
    require 'config.php';
    $id = $_POST['totalPendingComplaints'];
    $query = "SELECT * FROM `complaints` WHERE `status`='pending' AND `empId` = $id";
    $res=mysqli_query($conn,$query);
    echo $count =mysqli_num_rows($res);
	mysqli_close($conn);
}

/*******get total pending connection no *****/
if(isset($_POST['totalPendingConnectionRequest'])){
    require 'config.php';
    $id = $_POST['totalPendingConnectionRequest'];
    $query = "SELECT * FROM `new_connection` WHERE `connStatus`='pending' AND `empId` = $id";
    $res=mysqli_query($conn,$query);
    echo $count =mysqli_num_rows($res);
	mysqli_close($conn);
}

?>