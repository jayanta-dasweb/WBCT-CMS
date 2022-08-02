<?php
/*******get total customer *****/
if(isset($_POST['totalCust'])){
    require 'config.php';
    $query = "SELECT * FROM `customer` INNER JOIN `new_connection` ON customer.custId = new_connection.custId WHERE new_connection.connStatus!='pending'";
    $res=mysqli_query($conn,$query);
    echo $count =mysqli_num_rows($res);
}


/*******get total active connection *****/
if(isset($_POST['totalActiveConnection'])){
    require 'config.php';
    $query = "SELECT * FROM `customer` INNER JOIN `new_connection` ON customer.custId = new_connection.custId WHERE new_connection.connStatus='active'";
    $res=mysqli_query($conn,$query);
    echo $count =mysqli_num_rows($res);
}

/*******get total pending complaints no *****/
if(isset($_POST['totalPendingComplaints'])){
    require 'config.php';
    $query = "SELECT * FROM `complaints` WHERE `status`='pending'";
    $res=mysqli_query($conn,$query);
    echo $count =mysqli_num_rows($res);
}

/*******get total pending connection no *****/
if(isset($_POST['totalPendingConnectionRequest'])){
    require 'config.php';
    $query = "SELECT * FROM `new_connection` WHERE `connStatus`='pending'";
    $res=mysqli_query($conn,$query);
    echo $count =mysqli_num_rows($res);
}

?>