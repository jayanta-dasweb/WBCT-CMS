var imported = document.createElement('script');
imported.src = './funGloble.js';
document.head.appendChild(imported);

/****************** get Data *********/
function getData() {
    var empId = $('#sessionId').val();
    $.ajax({
        type: "POST",
        url: "js/db/profileBackend.php",
        data: {
            empId: empId
        },
        success: function (response) {
            $('#cardTableDisplay').html(response);
        }
    });
}

/*********** edit Name  *************/
function editName(editEmpNameId) {
    $.ajax({
        type: "POST",
        url: "js/db/profileBackend.php",
        data: {
            editEmpNameId: editEmpNameId
        },
        success: function (response) {
            $('#floatingInputForName').val(response);
        }
    });
}

/*********** update Name  **********/
function nameUpdateFn() {
    var name = $('#floatingInputForName').val();
    var empIdForNameUpdate = $('#sessionId').val();
    if (name == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter Name...',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else {
        $.ajax({
            type: "POST",
            url: "js/db/profileBackend.php",
            data: {
                name: name,
                empIdForNameUpdate: empIdForNameUpdate
            },
            success: function (response) {
                if (response == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: '<h1 style="color:#009970">Success</h1>',
                        text: 'Name Update Successfully...',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    }).then(function () {
                        getData();
                        get_User_Info_Using_SessionID();
                        $('#nameUpdateModal').modal('hide');
                    });
                }
            }
        });
    }

}

/*************** Get Ph Number And send OTP ******/
function editPhNo(editPhNoId) {
    $.ajax({
        type: "POST",
        url: "js/db/profileBackend.php",
        data: {
            editPhNoId: editPhNoId
        },
        success: function (response) {
            if (response == 1) {
                Swal.fire({
                    icon: 'success',
                    title: '<h1 style="color:#009970">Error</h1>',
                    text: 'OPT Sent Successfully...',
                    textColor: 'red',
                    confirmButtonColor: '#009970'
                }).then(function () {
                    $('#phNoUpdateModal').modal('show');
                });
            }
        }
    });
}


/*************** Verify OTP Fun ************/
function verifyOTPFn() {
    var enterOTP = $('#floatingInputForOTP').val();
    var empIdForVarifyOTP = $('#sessionId').val();
    if (enterOTP == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter OTP...',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else {
        $.ajax({
            type: "POST",
            url: "js/db/profileBackend.php",
            data: {
                enterOTP: enterOTP,
                empIdForVarifyOTP: empIdForVarifyOTP
            },
            success: function (response) {
                if (response == 1) {
                    Swal.fire({
                        icon: 'error',
                        title: '<h1 style="color:#009970">Error</h1>',
                        text: 'Wrong OTP...',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    })
                }
                if (response == 2) {
                    $('#otpValidationForm').hide();
                    $('#otpVerifyBtn').hide();

                    $('#newPhnNo').show();
                    $('#sendOTPBtn').show();

                    $('#otpVerify2').hide();
                    $('#otpVerifyBtn2').hide();

                    $('#updatePhNoBtn').hide();
                }
            }
        });
    }
}


/********************** send OTP to New Ph Number **********/
function sendOTPFn() {
    var empIdForSendOTP = $('#sessionId').val();
    var newPhNumber = $('#floatingInputForNewNo').val();
    $.ajax({
        type: "POST",
        url: "js/db/profileBackend.php",
        data: {
            empIdForSendOTP: empIdForSendOTP,
            newPhNumber: newPhNumber
        },
        success: function (response) {
            if (response == 1) {
                Swal.fire({
                    icon: 'success',
                    title: '<h1 style="color:#009970">Error</h1>',
                    text: 'OPT Sent Successfully...',
                    textColor: 'red',
                    confirmButtonColor: '#009970'
                }).then(function () {
                    $('#otpValidationForm').hide();
                    $('#otpVerifyBtn').hide();

                    $('#newPhnNo').hide();
                    $('#sendOTPBtn').hide();

                    $('#otpVerify2').show();
                    $('#otpVerifyBtn2').show();

                    $('#updatePhNoBtn').hide();
                });
            }
        }
    });

}


/************ verify new no OTP *********/
function verifyOTPFn2() {
    var enterOTP2 = $('#floatingInputForOTP2').val();
    var empIdForVarifyOTP2 = $('#sessionId').val();
    if (enterOTP2 == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter OTP...',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else {
        $.ajax({
            type: "POST",
            url: "js/db/profileBackend.php",
            data: {
                enterOTP2: enterOTP2,
                empIdForVarifyOTP2: empIdForVarifyOTP2
            },
            success: function (response) {
                // alert(response);
                if (response == 1) {
                    Swal.fire({
                        icon: 'error',
                        title: '<h1 style="color:#009970">Error</h1>',
                        text: 'Wrong OTP...',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    })
                }
                if (response == 2) {
                    $('#otpValidationForm').hide();
                    $('#otpVerifyBtn').hide();

                    $('#newPhnNo').hide();
                    $('#sendOTPBtn').hide();

                    $('#otpVerify2').show();
                    $('#otpVerifyBtn2').hide();

                    $('#updatePhNoBtn').show();
                }
            }
        });
    }
}



/*************** Final Update Ph nUmber ************/
function updatePhNoFn() {
    var empIdForFinalUpdate = $('#sessionId').val();
    var phNumberUpdate = $('#floatingInputForNewNo').val();
    $.ajax({
        type: "POST",
        url: "js/db/profileBackend.php",
        data: {
            empIdForFinalUpdate: empIdForFinalUpdate,
            phNumberUpdate: phNumberUpdate
        },
        success: function (response) {
            // alert(response);
            if (response == 1) {
                sign_Out_Admin();
                $('#otpValidationForm').show();
                $('#otpVerifyBtn').show();

                $('#newPhnNo').hide();
                $('#sendOTPBtn').hide();

                $('#otpVerify2').hide();
                $('#otpVerifyBtn2').hide();

                $('#updatePhNoBtn').hide();
                $('#otpValidationForm')[0].reset();
                $('#newPhNoForm')[0].reset();
                $('#otpValidationForm2')[0].reset();
                $('#phNoUpdateModal').modal('hide');
            }
        }
    });
}


/********* close ph number modal *****/
function closeUpdatePhNOModal() {
    $('#otpValidationForm').show();
    $('#otpVerifyBtn').show();

    $('#newPhnNo').hide();
    $('#sendOTPBtn').hide();

    $('#otpVerify2').hide();
    $('#otpVerifyBtn2').hide();

    $('#updatePhNoBtn').hide();
    $('#otpValidationForm')[0].reset();
    $('#newPhNoForm')[0].reset();
    $('#otpValidationForm2')[0].reset();
}



/******************* Password Toggle for Psw Update ************/
function PswToggleForPswUpdate() {
    var val = $('#flexCheckForPswToggle').val();
    if (val == 0) {
        $('#flexCheckForPswToggle').val(1);
        $('#floatingInputForNewPsw').attr('type', 'text');
        $('#floatingInputForConfirmPsw').attr('type', 'text');
        $('#labelText').text("Hide Password");
    } else {
        $('#flexCheckForPswToggle').val(0);
        $('#floatingInputForNewPsw').attr('type', 'password');
        $('#floatingInputForConfirmPsw').attr('type', 'password');
        $('#labelText').text("Show Password");
    }
}

/************ edit psw *****/
function editPsw(pswUpdateId) {
    $.ajax({
        type: "POST",
        url: "js/db/profileBackend.php",
        data: {
            pswUpdateId: pswUpdateId
        },
        success: function (response) {
            // alert(response);
            if (response == 1) {
                Swal.fire({
                    icon: 'success',
                    title: '<h1 style="color:#009970">Error</h1>',
                    text: 'OPT Sent Successfully...',
                    textColor: 'red',
                    confirmButtonColor: '#009970'
                }).then(function () {
                    $('#pswUpdateModal').modal('show');
                });
            }
        }
    });
}

/*************** verify OTP for psw update *********/
function verifyOTPFn3() {
    var enterOTPForPsw = $('#floatingInputForOTP3').val();
    var empIdForVarifyOTPForPsw = $('#sessionId').val();
    if (enterOTPForPsw == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter OTP...',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else {
        $.ajax({
            type: "POST",
            url: "js/db/profileBackend.php",
            data: {
                enterOTPForPsw: enterOTPForPsw,
                empIdForVarifyOTPForPsw: empIdForVarifyOTPForPsw
            },
            success: function (response) {
                // alert(response);
                if (response == 1) {
                    Swal.fire({
                        icon: 'error',
                        title: '<h1 style="color:#009970">Error</h1>',
                        text: 'Wrong OTP...',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    })
                }
                if (response == 2) {

                    $('#otpValidationForm3').hide();
                    $('#otpVerifyBtn3').hide();

                    $('#newPswForm').show();
                    $('#updatePswBtn').show();
                }
            }
        });
    }
}

/**************** final update psw ***********/
function updatePswFn() {
    var psw = $('#floatingInputForNewPsw').val();
    var confirmPsw = $('#floatingInputForConfirmPsw').val();
    var id = $('#sessionId').val();
    if (psw == '' && confirmPsw == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter Password and Confirm Password...',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else if (psw == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter Password...',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else if (confirmPsw == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter Confirm Password...',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else if (psw != confirmPsw) {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Password and confirm password are not Matching...',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else {
        $.ajax({
            type: "POST",
            url: "js/db/profileBackend.php",
            data: {
                psw: psw,
                id: id
            },
            success: function (response) {
                // alert(response);
                if (response == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: '<h1 style="color:#009970">Success</h1>',
                        text: 'Password Update Successfully...',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    }).then(function () {
                        sign_Out_Admin();
                        $('#otpValidationForm3').show();
                        $('#otpVerifyBtn3').show();

                        $('#newPswForm').hide();
                        $('#updatePswBtn').hide();
                        $('#newPswForm')[0].reset();
                        $('#otpValidationForm3')[0].reset();
                    });
                }
                if (response == 2) {
                    Swal.fire({
                        icon: 'error',
                        title: '<h1 style="color:#009970">Error</h1>',
                        text: 'Somthing Wrong !!!!...',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    })
                }
            }
        });
    }
}