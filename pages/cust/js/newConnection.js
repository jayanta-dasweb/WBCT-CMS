/********** On doc Ready **********/
$(document).ready(function () {
    get_User_Info_Using_SessionID();
    firstStage();
    getAllArea();
    $('#paySTS').hide();
});


setInterval(function () {
    firstStage();
}, 900);

// setInterval(firstStage,1000);

/*************** Get Admin, Employee Data Using Session Id **********/
function get_User_Info_Using_SessionID() {
    let session_ID = $('#sessionId').val();
    $.post('js/db/newConnectionBackend.php', {
            phNoForGetUserDet: session_ID,
        },
        function (data, status) {
            // alert(data);
            let info = JSON.parse(data);
            $('#name').text(info.custName);
            $('#phNo').text(info.phNumber);
            $('#email').text(info.email);
        }
    );
}

/************** check first stage is complete or not **********/
function firstStage() {
    let session_ID = $('#sessionId').val();
    $.ajax({
        type: "POST",
        url: "js/db/newConnectionBackend.php",
        data: {
            phNoForFirstStage: session_ID
        },
        success: function (response) {
            // alert("first "+response);
            if (response == 1) {
                $('#floatingInputGridForHouseNO').prop('disabled', true);
                $('#floatingInputGridForArea2').prop('disabled', true);
                $('#floatingInputForPinCode').prop('disabled', true);
                $('.sbmtBtn').prop('disabled', true);
                $('.sendConnReqst').prop('disabled', false);
                $(".showConnSts").prop('disabled', true);
                $(".makePay").prop('disabled', true);
                $("#cableOperatorInfo").show();
                getUserAddress();
                getCoDetails();
                secondStage();
            }
            if (response == 2) {
                $('#floatingInputGridForHouseNO').prop('disabled', false);
                $('#floatingInputGridForArea2').prop('disabled', false);
                $('#floatingInputForPinCode').prop('disabled', false);
                $('.sbmtBtn').prop('disabled', false);
                $('.sendConnReqst').prop('disabled', true);
                $(".showConnSts").prop('disabled', true);
                $(".makePay").prop('disabled', true);
                $("#cableOperatorInfo").hide();
            }
            if(response == 222){
                window.location.replace("/wbct-cms/");
            }
        }
    });
}

/*************** Check Second stage Complete Or not ***********/
function secondStage() {
    let session_ID = $('#sessionId').val();
    $.ajax({
        type: "POST",
        url: "js/db/newConnectionBackend.php",
        data: {
            phNoForSecondStage: session_ID
        },
        success: function (response) {
            // alert("second "+response);
            if (response == 1) {
                $('#floatingInputGridForHouseNO').prop('disabled', true);
                $('#floatingInputGridForArea2').prop('disabled', true);
                $('#floatingInputForPinCode').prop('disabled', true);
                $('.sbmtBtn').prop('disabled', true);
                $('.sendConnReqst').prop('disabled', true);
                $(".showConnSts").prop('disabled', false);
                $(".makePay").prop('disabled', true);
                $("#cableOperatorInfo").show();
                thirdStage();
                getUserAddress();
            }
            if (response == 2) {
                $('#floatingInputGridForHouseNO').prop('disabled', true);
                $('#floatingInputGridForArea2').prop('disabled', true);
                $('#floatingInputForPinCode').prop('disabled', true);
                $('.sbmtBtn').prop('disabled', true);
                $('.sendConnReqst').prop('disabled', false);
                $(".showConnSts").prop('disabled', true);
                $(".makePay").prop('disabled', true);
                $("#cableOperatorInfo").show();
            }
        }
    });
}

/*************** Check Third stage Complete Or not ***********/
function thirdStage() {
    let session_ID = $('#sessionId').val();
    $.ajax({
        type: "POST",
        url: "js/db/newConnectionBackend.php",
        data: {
            phNoForThirdStage: session_ID
        },
        success: function (response) {
            // alert("third "+response);
            if (response == 1) {
                $('#floatingInputGridForHouseNO').prop('disabled', true);
                $('#floatingInputGridForArea2').prop('disabled', true);
                $('#floatingInputForPinCode').prop('disabled', true);
                $('.sbmtBtn').prop('disabled', true);
                $('.sendConnReqst').prop('disabled', true);
                $(".showConnSts").prop('disabled', false);
                $(".makePay").prop('disabled', false);
                $("#cableOperatorInfo").show();
                fourthStage();
            }
            if (response == 2) {
                $('#floatingInputGridForHouseNO').prop('disabled', true);
                $('#floatingInputGridForArea2').prop('disabled', true);
                $('#floatingInputForPinCode').prop('disabled', true);
                $('.sbmtBtn').prop('disabled', true);
                $('.sendConnReqst').prop('disabled', true);
                $(".showConnSts").prop('disabled', false);
                $(".makePay").prop('disabled', true);
                $("#cableOperatorInfo").show();
            }
        }
    });
}


/*************** Check Fourth stage Complete Or not ***********/
function fourthStage() {
    let session_ID = $('#sessionId').val();
    $.ajax({
        type: "POST",
        url: "js/db/newConnectionBackend.php",
        data: {
            phNoForFourthStage: session_ID
        },
        success: function (response) {
            // alert("fourth "+response);
            if (response == 1) {
                $('#floatingInputGridForHouseNO').prop('disabled', true);
                $('#floatingInputGridForArea2').prop('disabled', true);
                $('#floatingInputForPinCode').prop('disabled', true);
                $('.sbmtBtn').prop('disabled', true);
                $('.sendConnReqst').prop('disabled', true);
                $(".showConnSts").prop('disabled', false);
                $(".makePay").prop('disabled', true);
                $("#cableOperatorInfo").show();
                $('#paySTS').show();
            }
            if (response == 2) {
                $('#floatingInputGridForHouseNO').prop('disabled', true);
                $('#floatingInputGridForArea2').prop('disabled', true);
                $('#floatingInputForPinCode').prop('disabled', true);
                $('.sbmtBtn').prop('disabled', true);
                $('.sendConnReqst').prop('disabled', true);
                $(".showConnSts").prop('disabled', false);
                $(".makePay").prop('disabled', false);
                $("#cableOperatorInfo").show();
                fifthStage();
            }
        }
    });
}

/******************* fifth stege ***************/
function fifthStage() {
    // alert("under");
    let session_ID = $('#sessionId').val();
    $.ajax({
        type: "POST",
        url: "js/db/newConnectionBackend.php",
        data: {
            phNoForFifthStage: session_ID
        },
        success: function (response) {
            // alert("fifth "+response);
            if (response == 1) {
                $('#floatingInputGridForHouseNO').prop('disabled', true);
                $('#floatingInputGridForArea2').prop('disabled', true);
                $('#floatingInputForPinCode').prop('disabled', true);
                $('.sbmtBtn').prop('disabled', true);
                $('.sendConnReqst').prop('disabled', true);
                $(".showConnSts").prop('disabled', false);
                $(".makePay").prop('disabled', false);
                $("#cableOperatorInfo").show();
                $('#paySTS').hide();
                window.location.replace("/wbct-cms/");
            }
            if (response == 2) {
                $('#floatingInputGridForHouseNO').prop('disabled', true);
                $('#floatingInputGridForArea2').prop('disabled', true);
                $('#floatingInputForPinCode').prop('disabled', true);
                $('.sbmtBtn').prop('disabled', true);
                $('.sendConnReqst').prop('disabled', true);
                $(".showConnSts").prop('disabled', false);
                $(".makePay").prop('disabled', false);
                $("#cableOperatorInfo").show();
            }
        }
    });
}


/************* Get Cable operator details ********/
function getCoDetails() {
    let session_ID = $('#sessionId').val();
    $.post('js/db/newConnectionBackend.php', {
            phNoForGetEmpDet: session_ID,
        },
        function (data, status) {
            // alert(data);
            let info = JSON.parse(data);
            $('#cOName').text(info.empName);
            $('#cOPhNumber').text(info.empPh);
        }
    );
}


/********** get user Address **********/
function getUserAddress() {
    let session_ID = $('#sessionId').val();
    var d = '';
    $.post('js/db/newConnectionBackend.php', {
            phNoForGetUserAddress: session_ID
        },
        function (data, status) {
            // alert(data);
            let info = JSON.parse(data);
            d += '<input type="text" class="form-control" id="floatingInputGridForArea2" placeholder="e.g. 26" value="'+info.areaName+'" disabled>';
            d += '<label for="floatingInputGridForArea2">Area Name</label>';
            $('#floatingInputGridForHouseNO').val(info.houseNo);
            $('#floatingInputForPinCode').val(info.pincode);
            $('#areaSelect').html(d);
        }
    );
}

/******* get all area *****/
function getAllArea() {
    var dummyVar = "dummyVar";
    $.ajax({
        type: "POST",
        url: "js/db/newConnectionBackend.php",
        data: {
            dummyVar: dummyVar
        },
        success: function (response) {
            // alert(response);
            $('#areaSelect').html(response);
        }
    });
}


/*********** submit data *******/
function submitData() {
    let session_ID = $('#sessionId').val();
    let hNo = $('#floatingInputGridForHouseNO').val();
    var getEmpIDAndAreaName = $('#floatingSelectGriForAreaSelect').val();
    let array = getEmpIDAndAreaName.split('%');
    let empId = array[0];
    let areaName = array[1];
    let pincode = $('#floatingInputForPinCode').val();
    if (hNo == '' && getEmpIDAndAreaName == "0" && pincode == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'All fields are mandatory...',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else if (hNo == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter House Number...',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else if (getEmpIDAndAreaName == 0) {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Select Area Name...',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else if (pincode == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter Pincode...',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else {
        $.ajax({
            type: "POST",
            url: "js/db/newConnectionBackend.php",
            data: {
                phNumberForAddSubmit: session_ID,
                hNo: hNo,
                empId: empId,
                areaName: areaName,
                pincode: pincode
            },
            success: function (response) {
                if (response == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: '<h1 style="color:#009970">Success</h1>',
                        text: 'Data Inserted Successfully...',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    }).then(function () {
                        firstStage();
                    });
                }
            }
        });
    }
}

/*************** Send Connection Request *********/
function sendConnRequestFn() {
    let session_ID = $('#sessionId').val();
    $.ajax({
        type: "POST",
        url: "js/db/newConnectionBackend.php",
        data: {
            phNoForSendConnReqst: session_ID
        },
        success: function (response) {
            if (response == 1) {
                Swal.fire({
                    icon: 'success',
                    title: '<h1 style="color:#009970">Success</h1>',
                    text: 'Connection Request Sent SuccessFully...',
                    textColor: 'red',
                    confirmButtonColor: '#009970'
                }).then(function () {
                    firstStage();
                });
            }
        }
    });
}


/********* Sign Out From Customer Pannel ********/
function sign_Out_Cust() {
    let dummyVariableCustSignOut = "somthing";
    $.ajax({
        type: "POST",
        url: "js/db/newConnectionBackend.php",
        data: {
            dummyVariableCustSignOut: dummyVariableCustSignOut
        },
        success: function (response) {
            if (response == 1) {
                Swal.fire({
                    icon: 'success',
                    title: '<h1 style="color:#009970">Success</h1>',
                    text: 'Sign Out Successfully...',
                    textColor: 'red',
                    confirmButtonColor: '#009970'
                }).then(function () {
                    window.location.replace("/wbct-cms/");
                });

            }
            if (response == 0) {
                alert("Somthing Worng !!!");
            }
        }
    });
}


/****************** Get Connection Request Status ***********/
function getConnReqstStatusFn() {
    let session_ID = $('#sessionId').val();
    $.ajax({
        type: "POST",
        url: "js/db/newConnectionBackend.php",
        data: {
            phNoForGetConnReqstSts: session_ID
        },
        success: function (response) {
            // alert(response);
            $('.connStsModalBody').html(response);
        }
    });
}

/**************get all pkgs ********/
function getCustPkgData() {
    var phNumberForGetPKg = $('#sessionId').val();
    $.ajax({
        type: "POST",
        url: "js/db/newConnectionBackend.php",
        data: {
            phNumberForGetPKg: phNumberForGetPKg
        },
        success: function (response) {
            // alert(response);
            $('.allPkgs').html(response);
        }
    });
}

/********** Proceed To Pay *****/
function proceedToPay() {
    var dummyVarForGateWay = $('#sessionId').val();
    var phNumberForProceedToPay = $('#sessionId').val();
    var getPkgIdAndAmt = $('input[name="flexRadioDefault"]:checked').val();
    let array = getPkgIdAndAmt.split('%');
    let pkgId = array[0];
    let amount = array[1];
    let totalAmt = array[2];
    // var emailId = '';
    var phNumberForGetUserDetForPay = $('#sessionId').val();
    $.post('js/db/newConnectionBackend.php', {
            phNumberForGetUserDetForPay: phNumberForGetUserDetForPay,
        },
        function (data, status) {
            let info = JSON.parse(data);
            // alert(info.email);
            var emailId = info.email;
            if (emailId != '') {
                $('#hiddenEmail').val(emailId);
            } else {
                $('#hiddenEmail').val("default@xyz.com");
            }
        }
    );
    var userEmail = $('#hiddenEmail').val();
    $.ajax({
        type: "POST",
        url: "js/db/newConnectionBackend.php",
        data: {
            phNumberForProceedToPay: phNumberForProceedToPay,
            pkgId: pkgId,
            amount: amount
        },
        success: function (response) {
            $('#showAllPkg').modal('hide');
            if (response == 1) {
                $.ajax({
                    type: "POST",
                    url: "js/db/newConnectionBackend.php",
                    data: {
                        dummyVarForGateWay: dummyVarForGateWay,
                        totalAmt: totalAmt
                    },
                    success: function (response) {
                        // alert(response);
                        window.location.href = response;
                    }
                });
            }
        }
    });

}