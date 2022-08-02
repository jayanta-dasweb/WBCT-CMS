<?php
/************ Get Data ********/
if(isset($_POST['dummyVar'])){
    $custId = $_POST['dummyVar'];
    require './config.php';
    $data = '';
    $query = "SELECT * FROM `payment` JOIN `customer` ON payment.custId=customer.custId JOIN `new_connection` ON new_connection.custId=customer.custId JOIN `cable_operator` ON cable_operator.empId=new_connection.empId WHERE payment.payStatus = 'done' AND payment.custId = $custId";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        $data .= '<table class="table table-bordered table-head-fixed  table-hover">
                    <thead class="bg-success text-white">
                        <tr>
                            <th>Payment No.</th>
                            <th>Name</th>
                            <th>STB No.</th>
                            <th>Cable Operator</th>
                            <th>Payment Details</th>
                        </tr>
                    </thead>
                    <tbody>';
        while($arr = mysqli_fetch_array($res)){
            $id = $arr['payId'];
            $payNo = $arr['payNo'];
            $custName = $arr['custName'];
            $stbNo = $arr['STBNumber'];
            $empName = $arr['empName'];
            $data .= '<tr id="tableData" data-widget="expandable-table" aria-expanded="false">
                        <td>'.$payNo.'</td>
                        <td>'.$custName.'</td>
                        <td>'.$stbNo.'</td>
                        <td>'.$empName.'</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary"
                                data-bs-toggle="modal" data-bs-target="#payDetailsModal" onclick= "getPayDetFn('.$id .')">
                                <i class="fas fa-info-circle"></i>
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

/********************** Get pay details *******/
if(isset($_POST['getPayDetId'])){
    $id = $_POST['getPayDetId'];
    require './config.php';
    $data ='';
    $data .= '<div style="border: 2px solid black; display:flex; align-items :center; justify-content:center; width:100%; padding:30px; flex-direction:column;">
                    <h1><b>INVOICE</b></h1>
                    <h6>WBCT-CMS</h6>';
    $query = "SELECT * FROM `payment` JOIN `customer` ON payment.custId=customer.custId JOIN `new_connection` ON new_connection.custId=customer.custId JOIN `cable_operator` ON cable_operator.empId=new_connection.empId WHERE payment.payStatus = 'done' AND payment.payId = $id";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        while($arr = mysqli_fetch_array($res)){
            $payNo = $arr['payNo'];
            $custName = $arr['custName'];
            $stbNo = $arr['STBNumber'];
            $empName = $arr['empName'];
            $dbRechargeDate = $arr['rechargeDt'];
            $dbDateFormat = date_format(new DateTime($dbRechargeDate),"j F Y");
            $dbExDate = $arr['expiredDt'];
            $dbDateFormatEx = date_format(new DateTime($dbExDate),"j F Y");
            $totalAmt = $arr['billAmt'];
            $totAmtWithInstChrg = $totalAmt + 200;
            $dbPayType = $arr['payType'];
            if($dbPayType == 'newConnection'){

            $data .= '<table style="width: 90%; margin-top:40px; font-size: 18px;">
                        <tr>
                            <th>Payment Number</th>
                            <td>'.$payNo.'</td>
                        </tr>
                        <tr>
                            <th>Customer Name</th>
                            <td>'.$custName.'</td>
                        </tr>
                        <tr>
                            <th>Cable Operator</th>
                            <td>'.$empName.'</td>
                        </tr>
                        <tr>
                            <th>STB Number</th>
                            <td>'.$stbNo.'</td>
                        </tr>
                        <tr>
                            <th>Recharge Date</th>
                            <td>'.$dbDateFormat.'</td>
                        </tr>
                        <tr>
                            <th>Package Expire</th>
                            <td>'.$dbDateFormatEx.'</td>
                        </tr>
                        <tr>
                            <th>Total Amount</th>
                            <td><i class="fas fa-rupee-sign"></i> '.$totAmtWithInstChrg.'</td>
                        </tr>
                    </table>';
            }
            if($dbPayType == 'monthlyRecharge'){
                $data .= '<table style="width: 90%; margin-top:40px; font-size: 18px;">
                        <tr>
                            <th>Payment Number</th>
                            <td>'.$payNo.'</td>
                        </tr>
                        <tr>
                            <th>Customer Name</th>
                            <td>'.$custName.'</td>
                        </tr>
                        <tr>
                            <th>Cable Operator</th>
                            <td>'.$empName.'</td>
                        </tr>
                        <tr>
                            <th>STB Number</th>
                            <td>'.$stbNo.'</td>
                        </tr>
                        <tr>
                            <th>Recharge Date</th>
                            <td>'.$dbDateFormat.'</td>
                        </tr>
                        <tr>
                            <th>Package Expire</th>
                            <td>'.$dbDateFormatEx.'</td>
                        </tr>
                        <tr>
                            <th>Total Amount</th>
                            <td><i class="fas fa-rupee-sign"></i> '.$totalAmt.'</td>
                        </tr>
                    </table>';
            }
        }
    }

    $query2 = "SELECT * FROM `payment` JOIN `includes` ON payment.payId=includes.payId JOIN `custompkgids` ON includes.pkgId=custompkgids.pkgId JOIN `package` ON package.pkgId=custompkgids.pkgIds WHERE includes.payId = $id AND package.pkgType = 'default' AND payment.payStatus = 'done'";
    $res2 = mysqli_query($conn,$query2);
    $count2 = mysqli_num_rows($res2);
    if($count2 >= 1){
        $data .= '<table style="margin-top: 30px;border: 2px solid black; width:90%; font-size: 18px;">
                    <tr style="border: 2px solid black; margin-top: 20px;">
                        <th style="border: 2px solid rgb(90, 90, 90); padding:5px;">
                            Package Name</th>
                        <td style="border: 2px solid rgb(90, 90, 90); padding:5px;">
                            <b>Amount</b>
                        </td>
                    </tr>';
        while($arr2 = mysqli_fetch_array($res2)){
            $dbpkgName = $arr2['pkgName'];
            $dbPkgAmt = $arr2['amount'];
            $dbPyTyp = $arr2['payType'];
            

            $data.='<tr style="border: 2px solid black;">
                        <th style="border: 2px solid rgb(90, 90, 90); padding:5px;">
                            '.$dbpkgName.'
                        </th>
                        <td style="border: 2px solid rgb(90, 90, 90); padding:5px;">
                            <i class="fas fa-rupee-sign"></i> '.$dbPkgAmt.'
                        </td>
                    </tr>';
            }
            if($dbPyTyp == 'newConnection'){
                $data .= '<tr style="border: 2px solid black;">
                        <th style="border: 2px solid rgb(90, 90, 90); padding:5px;">
                            GST (SGST + CGST)
                        </th>
                        <td style="border: 2px solid rgb(90, 90, 90); padding:5px;">
                            18%
                        </td>
                    </tr>
                    <tr style="border: 2px solid black;">
                        <th style="border: 2px solid rgb(90, 90, 90); padding:5px;">
                            Installation Charge
                        </th>
                        <td style="border: 2px solid rgb(90, 90, 90); padding:5px;">
                        <i class="fas fa-rupee-sign"></i> 200
                        </td>
                    </tr>
                        </table>';

            }
            if($dbPyTyp == 'monthlyRecharge'){
                $data .= '<tr style="border: 2px solid black;">
                        <th style="border: 2px solid rgb(90, 90, 90); padding:5px;">
                            GST (SGST + CGST)
                        </th>
                        <td style="border: 2px solid rgb(90, 90, 90); padding:5px;">
                            18%
                        </td>
                    </tr>
                        </table>';
            }
        
    }
    else{
        $query3 = "SELECT * FROM `payment` JOIN `includes` ON payment.payId=includes.payId JOIN `package` ON includes.pkgId=package.pkgId WHERE includes.payId = $id AND package.pkgType = 'default' AND payment.payStatus = 'done'";
        $res3 = mysqli_query($conn,$query3);
        $count3 = mysqli_num_rows($res3);
        if($count3 >= 1){
            $data .= '<table style="margin-top: 30px;border: 2px solid black; width:90%; font-size: 18px;">
                        <tr style="border: 2px solid black; margin-top: 20px;">
                            <th style="border: 2px solid rgb(90, 90, 90); padding:5px;">
                                Package Name</th>
                            <td style="border: 2px solid rgb(90, 90, 90); padding:5px;">
                                <b>Amount</b>
                            </td>
                        </tr>';
            while($arr3 = mysqli_fetch_array($res3)){
                $dbpkgName2 = $arr3['pkgName'];
                $dbPkgAmt2 = $arr3['amount'];
                $dbPyTyp2 = $arr3['payType'];
                
    
                $data.='<tr style="border: 2px solid black;">
                            <th style="border: 2px solid rgb(90, 90, 90); padding:5px;">
                                '.$dbpkgName2.'
                            </th>
                            <td style="border: 2px solid rgb(90, 90, 90); padding:5px;">
                                <i class="fas fa-rupee-sign"></i> '.$dbPkgAmt2.'
                            </td>
                        </tr>';
                }
                if($dbPyTyp2 == 'newConnection'){
                    $data .= '<tr style="border: 2px solid black;">
                            <th style="border: 2px solid rgb(90, 90, 90); padding:5px;">
                                GST (SGST + CGST)
                            </th>
                            <td style="border: 2px solid rgb(90, 90, 90); padding:5px;">
                                18%
                            </td>
                        </tr>
                        <tr style="border: 2px solid black;">
                            <th style="border: 2px solid rgb(90, 90, 90); padding:5px;">
                                Installation Charge
                            </th>
                            <td style="border: 2px solid rgb(90, 90, 90); padding:5px;">
                            <i class="fas fa-rupee-sign"></i> 200
                            </td>
                        </tr>
                            </table>';
    
                }
                if($dbPyTyp2 == 'monthlyRecharge'){
                    $data .= '<tr style="border: 2px solid black;">
                            <th style="border: 2px solid rgb(90, 90, 90); padding:5px;">
                                GST (SGST + CGST)
                            </th>
                            <td style="border: 2px solid rgb(90, 90, 90); padding:5px;">
                                18%
                            </td>
                        </tr>
                            </table>';
                }
            
        }
    }
    echo $data;
}


/************ Search Data ********/
if(isset($_POST['serchText'])){
    $searchText = $_POST['serchText'];
    $custId = $_POST['cId'];
    require './config.php';
    $data = '';
    $query = "SELECT * FROM `payment` JOIN `customer` ON payment.custId=customer.custId JOIN `new_connection` ON new_connection.custId=customer.custId JOIN `cable_operator` ON cable_operator.empId=new_connection.empId WHERE payment.payNo LIKE '%".$searchText."%' OR customer.custName LIKE '%".$searchText."%' OR customer.STBNumber LIKE '%".$searchText."%' OR cable_operator.empName LIKE '%".$searchText."%' AND payment.payStatus = 'done' AND payment.custId = $custId";
    $res = mysqli_query($conn,$query);
    $count = mysqli_num_rows($res);
    if($count >= 1){
        $data .= '<table class="table table-bordered table-head-fixed  table-hover">
                    <thead>
                        <tr>
                            <th>Payment No.</th>
                            <th>Name</th>
                            <th>STB No.</th>
                            <th>Employee Name</th>
                            <th>Payment Details</th>
                        </tr>
                    </thead>
                    <tbody>';
        while($arr = mysqli_fetch_array($res)){
            $id = $arr['payId'];
            $payNo = $arr['payNo'];
            $custName = $arr['custName'];
            $stbNo = $arr['STBNumber'];
            $empName = $arr['empName'];
            $paySts = $arr['payStatus'];
            if($paySts == 'done'){
                $data .= '<tr id="tableData" data-widget="expandable-table" aria-expanded="false">
                            <td>'.$payNo.'</td>
                            <td>'.$custName.'</td>
                            <td>'.$stbNo.'</td>
                            <td>'.$empName.'</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary"
                                    data-bs-toggle="modal" data-bs-target="#payDetailsModal" onclick= "getPayDetFn('.$id .')">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </td>
                        </tr>';
            }
            else{
                $data .= '<tr>
                <td colspan="7" class="table-active" style="text-align:center"> Records Not Found</td>
                </tr>';
                break;
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