<?php
/******************** get all pkg **********/
if(isset($_POST['custId'])){
    $no = 1;
    $custId = $_POST['custId'];
    $data = '';
    require './config.php';
    $query = "SELECT * FROM `package` WHERE `pkgType` = 'default'";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        $data .= '<table class="table table-bordered table-striped table-sm" style="width: 811px !important;">
        <thead class="bg-success text-white" >
        <tr>
            <th scope="col">#</th>
            <th scope="col">Package Name</th>
            <th scope="col">Sub Package</th>
            <th scope="col">Amount</th>
        </tr>
        </thead>
        <tbody>';
        while($arr = mysqli_fetch_array($res)){
            $dbid = $arr['pkgId'];
            $dbAmt = $arr['amount'];
            $finalAmount = ceil($dbAmt + (18/100*$dbAmt)) ;
            $dbPkgName = $arr['pkgName'];
            $data .= '<tr>
                        <td class="d-flex justify-content-center">
                            <input class="form-check-input"
                                Style="margin-left: auto !important;" type="radio"
                                name="flexRadioDefault" id="flexRadioDefault1-'.$no.'" value = '.$dbid."%".$finalAmount.'>
                        </td>
                        <td>
                            <label class="form-check-label " for="flexRadioDefault1-'.$no.'">
                                '.$dbPkgName.'
                            </label>
                        </td>
                        <td>
                            <ul>
                                <li>N/A</li>
                            </ul>
                        </td>
                        <td>
                            <i class="fas fa-rupee-sign"></i> '.$dbAmt.' + 18% GST = '.$finalAmount.'
                        </td>
                    </tr>';
                    $no++;
        }
        $query2 = "SELECT pkg_manage_cust.pkgId AS mainId , package.*  FROM `package` JOIN `pkg_manage_cust` ON pkg_manage_cust.pkgId=package.pkgId WHERE pkg_manage_cust.custId = $custId";
        $res2 = mysqli_query($conn,$query2);
        $count2 = mysqli_num_rows($res2);
        if($count2 >= 1){
            while($arr2 = mysqli_fetch_array($res2)){
                $dataPkgId = $arr2['mainId'];
                $dbPkgN = $arr2['pkgName'];
                $dbPkgNameAfterExplode = explode('-',$dbPkgN);
                $dbPkgName = $dbPkgNameAfterExplode[0];
                $dbAmount = $arr2['amount'];
                $finalAmount2 = ceil($dbAmount + (18/100*$dbAmount));
                $data .= '<tr>
                            <td class="d-flex justify-content-center">
                                <input class="form-check-input"
                                    Style="margin-left: auto !important;" type="radio"
                                    name="flexRadioDefault" id="flexRadioDefault1-'.$no.'" value='.$dataPkgId."%".$finalAmount2.'>
                            </td>
                            <td>
                                <label class="form-check-label " for="flexRadioDefault1-'.$no.'">
                                    '.$dbPkgName.'
                                </label>
                            </td><td><ul>';
                
                $query3 = "SELECT * FROM `custompkgids` JOIN `package` ON package.pkgId=custompkgids.pkgIds WHERE custompkgids.pkgId = $dataPkgId AND package.pkgType = 'default'";
                $res3 = mysqli_query($conn,$query3);
                $count3 = mysqli_num_rows($res3);
                if($count3 >= 1){
                    while($arr3 = mysqli_fetch_array($res3)){
                        $dbPkgName2 = $arr3['pkgName'];
                        $data .= '<li>
                                    '.$dbPkgName2.' 
                                </li>';
                    }
                }
                $data .= '</ul></td><td>
                            <i class="fas fa-rupee-sign"></i> '.$dbAmount.' + 18% GST = '.$finalAmount2.'
                        </td>
                    </tr>';
                    $no++;
            }
        }
        $query4 = "SELECT * FROM `package` WHERE `pkgType` = 'defaultcust'";
        $res4 = mysqli_query($conn,$query4);
        $count4 = mysqli_num_rows($res4);
        if($count4 >= 1){
            while($arr4 = mysqli_fetch_array($res4)){
                $dataPkgId2 = $arr4['pkgId'];
                $dbPkgN2 = $arr4['pkgName'];
                $dbPkgNameAfterExplode2 = explode('-',$dbPkgN2);
                $dbPkgName2 = $dbPkgNameAfterExplode2[0];
                $dbAmount2 = $arr4['amount'];
                $finalAmount4 = ceil($dbAmount2 + (18/100*$dbAmount2));
                $data .= '<tr>
                            <td class="d-flex justify-content-center">
                                <input class="form-check-input"
                                    Style="margin-left: auto !important;" type="radio"
                                    name="flexRadioDefault" id="flexRadioDefault1-'.$no.'" value='.$dataPkgId2."%".$finalAmount4.' checked>
                            </td>
                            <td>
                                <label class="form-check-label " for="flexRadioDefault1-'.$no.'">
                                    '.$dbPkgName2.'
                                </label>
                            </td><td><ul>';
                
                $query5 = "SELECT * FROM `custompkgids` JOIN `package` ON package.pkgId=custompkgids.pkgIds WHERE custompkgids.pkgId = $dataPkgId2 AND package.pkgType = 'default'";
                $res5 = mysqli_query($conn,$query5);
                $count5 = mysqli_num_rows($res5);
                if($count5 >= 1){
                    while($arr5 = mysqli_fetch_array($res5)){
                        $dbPkgName3 = $arr5['pkgName'];
                        $data .= '<li>
                                    '.$dbPkgName3.' 
                                </li>';
                    }
                }
                $data .= '</ul></td><td>
                            <i class="fas fa-rupee-sign"></i> '.$dbAmount2.' + 18% GST = '.$finalAmount4.'
                        </td>
                    </tr>';
                    $no++;
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

/********************* final Submit data **********/
if(isset($_POST['custIdForFinalSubmit']) && isset($_POST['pkgId'])){
    $custId = $_POST['custIdForFinalSubmit'];
    $pkgId = $_POST['pkgId'];
    require './config.php';
    $query = "SELECT * FROM `package` WHERE `pkgId` = $pkgId";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        while($arr= mysqli_fetch_array($res)){
            $dbAmt = $arr['amount'];
            $finalAmount = ceil($dbAmt + (18/100*$dbAmt));
            $query2 = "INSERT INTO `payment`(`billAmt`, `custId`) VALUES ('$finalAmount','$custId')";
            $res2 = mysqli_query($conn,$query2);
            if($res2){
                $last_id = mysqli_insert_id($conn);
                $randNo = rand(10,99);
                $payNo = 'PAY'.$randNo.$last_id;
                $query3 = "UPDATE `payment` SET `payNo`='$payNo' WHERE `payId`=$last_id";
                $res3 = mysqli_query($conn,$query3);
                if($res3){
                    $query4 = "INSERT INTO `includes`(`pkgId`, `payId`) VALUES ($pkgId,$last_id)";
                    $res4 = mysqli_query($conn,$query4);
                    if($res4){
                        $query5 = "SELECT `connStatus` FROM `new_connection` WHERE `custId` = $custId";
                        $res5 = mysqli_query($conn,$query5);
                        $arr5 = mysqli_fetch_array($res5);
                        $dbConnSTS = $arr5['connStatus'];
                        if($dbConnSTS == 'offline'){
                            $query6 ="UPDATE `new_connection` SET `connStatus`='active' WHERE `custId` = $custId";
                            $res6 = mysqli_query($conn,$query6);
                            if($res6){
                                echo 1;
                            }
                        }
                        else{
                            echo 1;
                        }
                    }
                }
            }
        }
    }
}


/****************** payment gatway work *******/
if(isset($_POST['dummyVarForGateWay']) && isset($_POST['totalAmt'])){
    require './config.php';
    $custId = $_POST['dummyVarForGateWay'];
    $totalAmt = $_POST['totalAmt'];
    $query = "SELECT * FROM `customer` WHERE `custId` = $custId";
    $res2 = mysqli_query($conn,$query);
    while($arr2 = mysqli_fetch_array($res2)){
        $dbname = $arr2['custName'];
        $dbEmail = $arr2['email'];
        $phNumber = $arr2['phNumber'];
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://test.instamojo.com/api/1.1/payment-requests/');
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER,
                array("X-Api-Key:test_1b94eb73c3863e04f80831d407a",
                    "X-Auth-Token:test_d3abd515b3d8bb68d0824fd93e9"));
    $payload = Array(
        'purpose' => 'Cable TV New Connection',
        'amount' =>  $totalAmt,
        'phone' => $phNumber,
        'buyer_name' => $dbname,
        'redirect_url' => 'http://localhost/wbct-cms/pages/cust/home.php',
        'send_email' => true,
        'send_sms' => true,
        'email' => $dbEmail,
        'allow_repeated_payments' => false
    );
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
    $response = curl_exec($ch);
    curl_close($ch); 
    $res = json_decode($response);
    echo $res->payment_request->longurl;
}



?>