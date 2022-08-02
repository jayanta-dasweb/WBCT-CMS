/************ document ready *******/
$(document).ready(function () {
    resetSignUpForm();
    resetSignInForm();
    $('#labelText').text("Show Password");
    $('#labelText2').text("Show Password");
    $('#labelTextCO').text("Show Password");
    $('#labelTextForAdminOrEmpPswUpdate').text("Show Password");
    $('#labelTextForCustPswUpdate').text("Show Password");
    window.Swal = Swal;
});


/******************** Customer Section Work  ************/


/************* on sign In tab click  ********/
function resetSignInForm() {
    $('#signInForm')[0].reset();
    // $('#otpInputsFormForForgotPsw')[0].reset();
    $('#signUpFrmWork').show();
    $('#verifyUsingRegPhNoOTP').hide();
    $('#changePsw').hide();
    $('#successfullyPswUpdate').hide();
}

/******* Toggle Password ( Cust Sign IN ) *******/
function pswToggle() {
    var val = $('#checkbx').val();
    if (val == 0) {
        $('#checkbx').val(1);
        $('#custfloatingPassword').attr('type', 'text');
        $('#labelText').text("Hide Password");
    } else {
        $('#checkbx').val(0);
        $('#custfloatingPassword').attr('type', 'password');
        $('#labelText').text("Show Password");
    }
}

/************* Customer Sign in **********/
function custSignIn() {
    Swal.fire({
        icon: 'error',
        title: '<h1 style="color:#009970">Error</h1>',
        text: 'Something went wrong!',
        textColor: 'red',
        confirmButtonColor: '#009970'
    })
}


/************* on sign up tab click  ********/
function resetSignUpForm() {
    $('#CustSignUpForm')[0].reset();
    $('#otpInputsForm')[0].reset();
    $('#signUpFrmWork').show();
    $('#otpVarification').hide();
    $('#signupSuccessTab').hide();
}


/******* Toggle Password (Sign up ) *******/
function pswToggle2() {
    var val = $('#checkbx2').val();
    if (val == 0) {
        $('#checkbx2').val(1);
        $('.custConfirmPsw').attr('type', 'text');
        $('.custPsw').attr('type', 'text');
        $('#labelText2').text("Hide Password");
    } else {
        $('#checkbx2').val(0);
        $('.custConfirmPsw').attr('type', 'password');
        $('.custPsw').attr('type', 'password');
        $('#labelText2').text("Show Password");
    }
}

/****** resend otp ********/
function resendOTPTimer() {
    document.getElementById('resendOTPTimer').innerHTML = 01 + ":" + 00;
    startTimer();


    function startTimer() {
        var presentTime = document.getElementById('resendOTPTimer').innerHTML;
        var timeArray = presentTime.split(/[:]+/);
        var m = timeArray[0];
        var s = checkSecond((timeArray[1] - 1));
        if (s == 59) {
            m = m - 1
        }
        if (m < 0) {
            document.getElementById('resendOTPTimer').innerHTML = "Resend OTP";
            return
        }

        document.getElementById('resendOTPTimer').innerHTML = m + ":" + s;
        console.log(m)
        setTimeout(startTimer, 1000);

    }

    function checkSecond(sec) {
        if (sec < 10 && sec >= 0) {
            sec = "0" + sec
        }; // add zero in front of numbers < 10
        if (sec < 0) {
            sec = "59"
        };
        return sec;
    }
}

/************* Customer Sign Up **********/
function custSignUp() {
    let name = $('.custName').val();
    let phNo = $('.custPhNo').val();
    let psw = $('.custPsw').val();
    let confirmPsw = $('.custConfirmPsw').val();
    if (name == '' && phNo == '' && psw == '' && confirmPsw == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'All fields are mandatory..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else if (name == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter Name..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else if (phNo == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter Mobile Number..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else if (psw == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter Password..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else if (confirmPsw == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter Confirm Password..',
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
            url: "/wbct-cms/assets/DB/backend.php",
            data: new FormData($("#CustSignUpForm")[0]),
            contentType: false,
            processData: false,
            success: function (response) {
                // alert(response);
               
                let data = JSON.parse(response);
                $('#hiddenTempCustId').val(data.custId);
                if (data.msg == 1) {
                    Swal.fire({
                        icon: 'error',
                        title: '<h1 style="color:#009970">Error</h1>',
                        text: 'Mobile number already exists...',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    })
                }
                if (response == 1) {
                    Swal.fire({
                        icon: 'error',
                        title: '<h1 style="color:#009970">Error</h1>',
                        text: 'Mobile number already exists...',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    })
                }
                if (data.msg == 2) {
                    Swal.fire({
                        icon: 'success',
                        title: '<h1 style="color:#009970">Success</h1>',
                        text: 'An OTP Sent To Your Mobile Number...',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    }).then(function (success) {
                        if (success) {
                            $('#signUpFrmWork').hide();
                            $('#otpVarification').show();
                            $('#signupSuccessTab').hide();

                        }
                    });
                }
            }
        });
    }
}


/**********************************
 * OTP verify function For Customer SignUp
 **********************************/

function verifyOTP() {
    let otp1 = $('.n1OTP').val();
    let otp2 = $('.n2OTP').val();
    let otp3 = $('.n3OTP').val();
    let otp4 = $('.n4OTP').val();
    let typeOTP = otp1.concat(otp2, otp3, otp4);
    let custId = $('#hiddenTempCustId').val();
    $.ajax({
        type: "POST",
        url: "/wbct-cms/assets/DB/backend.php",
        data: {
            typeOTPForCustSignUp: typeOTP,
            custIdForCustSignUp: custId
        },
        success: function (response) {
            // alert(response);
            if (response == 1) {
                $('#signUpFrmWork').hide();
                $('#otpVarification').hide();
                $('#signupSuccessTab').show();
            }
            if (response == 2) {
                Swal.fire({
                    icon: 'error',
                    title: '<h1 style="color:#009970">Error</h1>',
                    text: 'Wrong OTP...',
                    textColor: 'red',
                    confirmButtonColor: '#009970'
                })
            }
            if (response == 3) {
                Swal.fire({
                    icon: 'error',
                    title: '<h1 style="color:#009970">Error</h1>',
                    text: 'Data Not Found...',
                    textColor: 'red',
                    confirmButtonColor: '#009970'
                })
            }
        }
    });
}



/*********** resend OTP ********/
function resendOTP() {
    var getText = $('#resendOTPTimer').text();
    if (getText == "Resend OTP") {
        resendOTPTimer();
    }
}


/********* Automatically tab OTP ***********/
$(".inputs").keyup(function () {
    if (this.value.length == this.maxLength) {
        $(this).next('.inputs').select();
    }
});

/****** Trigger sign in tab *****/
function redirectSignIn() {
    $(".signInTab")[0].click();
    resetSignInForm();
}

/****** redirect sign up tab *****/
function redirectSignUp() {
    $(".signUpTab")[0].click();
    resetSignInForm();
}

/***********************************************
 *  Forgot Customer Psw Work
************************************************* */
// /*********************** on CO dashboard nav link click ************/
function popUpSignInModal2() {
    $('#signInFrmWork').show();
    $('#fortogPswCustSection').hide();
    $('#regMobileNoInputAndValidation2').hide();
    $('#custOTPVerification').hide();
    $('#createNewPswForCust').hide();
}

/************** back to sign in Customer *******/
function backToSignInCust() {
    $('#signInFrmWork').show();
    $('#fortogPswCustSection').hide();
    $('#regMobileNoInputAndValidation2').hide();
    $('#custOTPVerification').hide();
    $('#createNewPswForCust').hide();
}


// /******************** onclick Forgot password link  **********/
function forgotPswClik2() {
    $('#signInFrmWork').hide();
    $('#fortogPswCustSection').show();
    $('#regMobileNoInputAndValidation2').show();
    $('#custOTPVerification').hide();
    $('#createNewPswForCust').hide();
}


// /************** Ph Number Validation and send OTP To customer  *********/
function phNoValidationAndSendOTPCust() {
    let custPhNumber = $('#CustfloatingInputForPhNo').val();
    let custName2 = $('#CustfloatingInputForName').val();
    if (custPhNumber == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter Reg. Ph. Number...',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else if (custName2 == '') {
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
            url: "/wbct-cms/assets/DB/backend.php",
            data: new FormData($("#custRegPhNoValidation")[0]),
            contentType: false,
            processData: false,
            success: function (response) {
                // alert(response);
                if (response == 1) {
                    Swal.fire({
                        icon: 'error',
                        title: '<h1 style="color:#009970">Error</h1>',
                        text: 'Wrong Ph Number And Name...',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    })
                }
                if (response == 2) {
                    Swal.fire({
                        icon: 'error',
                        title: '<h1 style="color:#009970">Error</h1>',
                        text: 'Wrong Name...',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    })
                }
                if (response == 3) {
                    Swal.fire({
                        icon: 'error',
                        title: '<h1 style="color:#009970">Error</h1>',
                        text: 'Wrong Ph Number...',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    })
                }
                if (response == 5) {
                    Swal.fire({
                        icon: 'error',
                        title: '<h1 style="color:#009970">Error</h1>',
                        text: 'Data Not Found...',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    })
                }
                if (response == 4) {
                    $.ajax({
                        type: "POST",
                        url: "/wbct-cms/assets/DB/backend.php",
                        data: {
                            phNoForOTP2 : custPhNumber,
                            custName2: custName2
                        },
                        success: function (response2) {
                            // alert(response2);
                            let data = JSON.parse(response2);
                            $('#custIdHidden').val(data.id);
                            $('#custPhHidden').val(data.ph);
                            
                            if (data.msg == 1) {
                                $('#custRegPhNoValidation')[0].reset();
                                $('#signInFrmWork').hide();
                                $('#fortogPswCustSection').show();
                                $('#regMobileNoInputAndValidation2').hide();
                                $('#custOTPVerification').show();
                                $('#createNewPswForCust').hide();
                            }
                        }
                    });
                }
            }
        });
    }

}

/**********************************
 * OTP verify function Customer psw reset
 **********************************/

function verifyOTPForCustPswReset() {
    let otp1 = $('.n1OTPCustPswReset').val();
    let otp2 = $('.n2OTPCustPswReset').val();
    let otp3 = $('.n3OTPCustPswReset').val();
    let otp4 = $('.n4OTPCustPswReset').val();
    let typeOTP = otp1.concat(otp2, otp3, otp4);
    let custIdHidden = $('#custIdHidden').val();
    let custPhHidden = $('#custPhHidden').val();
    $.ajax({
        type: "POST",
        url: "/wbct-cms/assets/DB/backend.php",
        data: {
            typeOTPByCust2 : typeOTP,
            custIdHidden: custIdHidden,
            custPhHidden : custPhHidden
        },
        success: function (response) {
            // alert(response);
            if (response == 1) {
                $('#otpInputsFormForCustPswReset')[0].reset();
                $('#signInFrmWork').hide();
                $('#fortogPswCustSection').show();
                $('#regMobileNoInputAndValidation2').hide();
                $('#custOTPVerification').hide();
                $('#createNewPswForCust').show();
            }
            if (response == 2) {
                Swal.fire({
                    icon: 'error',
                    title: '<h1 style="color:#009970">Error</h1>',
                    text: 'Wrong OTP...',
                    textColor: 'red',
                    confirmButtonColor: '#009970'
                })
            }
            if (response == 3) {
                Swal.fire({
                    icon: 'error',
                    title: '<h1 style="color:#009970">Error</h1>',
                    text: 'Data Not Found...',
                    textColor: 'red',
                    confirmButtonColor: '#009970'
                })
            }
        }
    });
}

/********** Update Customer PSW *******/
function custUpdateNewPsw() {
    var psw = $('#CustfloatingInputForPsw').val();
    var confirmPsw = $('#CustfloatingInputForConfirm').val();
    var id = $('#custIdHidden').val();
    var ph = $('#custPhHidden').val();
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
    }
    /*******************
     * IF Cust id Not show
     ***********************/
    else if (id == 0) {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Somthing Wrong !!!!...',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    }  /*******************
    * IF Cust Ph Number Not show
    ***********************/
   else if (ph == 0) {
       Swal.fire({
           icon: 'error',
           title: '<h1 style="color:#009970">Error</h1>',
           text: 'Somthing Wrong !!!!...',
           textColor: 'red',
           confirmButtonColor: '#009970'
       })
   }else {
        $.ajax({
            type: "POST",
            url: "/wbct-cms/assets/DB/backend.php",
            data: new FormData($("#custPswResetForm")[0]),
            contentType: false,
            processData: false,
            success: function (response) {
                // alert(response);
                if (response == 1) {
                    $('#custPswResetForm')[0].reset();
                    Swal.fire({
                        icon: 'success',
                        title: '<h1 style="color:#009970">Success</h1>',
                        text: 'Password Update Successfully...',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    }).then(function () {
                        popUpSignInModal2();
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

/******************* Password Toggle for Cable Operator Psw Update ************/
function pswToggleCustUpdatePsw() {
    var val = $('#checkbxCustPswUpdate').val();
    if (val == 0) {
        $('#checkbxCustPswUpdate').val(1);
        $('#CustfloatingInputForPsw').attr('type', 'text');
        $('#CustfloatingInputForConfirm').attr('type', 'text');
        $('#labelTextForCustPswUpdate').text("Hide Password");
    } else {
        $('#checkbxCustPswUpdate').val(0);
        $('#CustfloatingInputForPsw').attr('type', 'password');
        $('#CustfloatingInputForConfirm').attr('type', 'password');
        $('#labelTextForCustPswUpdate').text("Show Password");
    }
}


/************* Customer Sign in **********/
function custSignIn() {
    var phNo = $('#custfloatingInput').val();
    var psw = $('#custfloatingPassword').val();

    if (phNo == '' && psw == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'All fields are mandatory..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else if (phNo == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter Phone Number..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else if (psw == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter Password..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else {
        $.ajax({
            type: "POST",
            url: "/wbct-cms/assets/DB/backend.php",
            data: new FormData($("#signInForm")[0]),
            contentType: false,
            processData: false,
            success: function (response) {
                // alert(response);
                if (response == 1) {
                    Swal.fire({
                        icon: 'error',
                        title: '<h1 style="color:#009970">Error</h1>',
                        text: 'Wrong Ph Number And Password..',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    })
                }
                if (response == 2) {
                    Swal.fire({
                        icon: 'error',
                        title: '<h1 style="color:#009970">Error</h1>',
                        text: 'Wrong Ph Number..',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    })
                }
                if (response == 3) {
                    Swal.fire({
                        icon: 'error',
                        title: '<h1 style="color:#009970">Error</h1>',
                        text: 'Wrong Password..',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    })
                }
                if (response == 4) {
                    window.location.replace("pages/cust/home.php");
                }
                if (response == 5) {
                    window.location.replace("pages/cust/newConnection.php");
                }
                if (response == 6) {
                    Swal.fire({
                        icon: 'error',
                        title: '<h1 style="color:#009970">Error</h1>',
                        text: 'Record Not Found..',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    })
                }
            }
        });
    }
}










/***************************** Admin and employee section ****************/

/******* Toggle Password ( Admin,employee Sign IN ) *******/
function pswToggleCO() {
    var val = $('#checkbxCO').val();
    if (val == 0) {
        $('#checkbxCO').val(1);
        $('#COfloatingPassword').attr('type', 'text');
        $('#labelTextCO').text("Hide Password");
    } else {
        $('#checkbxCO').val(0);
        $('#COfloatingPassword').attr('type', 'password');
        $('#labelTextCO').text("Show Password");
    }
}

/************* CO Sign in **********/
function COSignIn() {
    var role = $('#CORole').val();
    var phNo = $('#COfloatingInput').val();
    var psw = $('#COfloatingPassword').val();

    if (role == '' && phNo == '' && psw == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'All fields are mandatory..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else if (role == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Select SignIn Type..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else if (phNo == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter Phone Number..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else if (psw == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter Password..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else {
        $.ajax({
            type: "POST",
            url: "/wbct-cms/assets/DB/backend.php",
            data: new FormData($("#signInFormForCO")[0]),
            contentType: false,
            processData: false,
            success: function (response) {
                // alert(response);
                if (response == 1) {
                    Swal.fire({
                        icon: 'error',
                        title: '<h1 style="color:#009970">Error</h1>',
                        text: 'Wrong Ph Number And Password..',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    })
                }
                if (response == 2) {
                    Swal.fire({
                        icon: 'error',
                        title: '<h1 style="color:#009970">Error</h1>',
                        text: 'Wrong Ph Number..',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    })
                }
                if (response == 3) {
                    Swal.fire({
                        icon: 'error',
                        title: '<h1 style="color:#009970">Error</h1>',
                        text: 'Wrong Password..',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    })
                }
                if (response == 4) {
                    window.location.replace("pages/admin/home.php");
                }
                if (response == 5) {
                    window.location.replace("pages/employee/home.php");
                }
                if (response == 6) {
                    Swal.fire({
                        icon: 'error',
                        title: '<h1 style="color:#009970">Error</h1>',
                        text: 'Record Not Found..',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    })
                }
            }
        });
    }
}

// /*********************** on CO dashboard nav link click ************/
function popUpSignInModal() {
    $('.adminEmpDiv').show();
    $('#fortogPswAdminEmployeeSection').hide();
    $('#regMobileNoInputAndValidation').hide();
    $('#adminEmpOTPVerification').hide();
    $('#createNewPswForAdminEmp').hide();
}

/************** back to sign in Cable Operator *******/
function backToSignInCO() {
    $('.adminEmpDiv').show();
    $('#fortogPswAdminEmployeeSection').hide();
    $('#regMobileNoInputAndValidation').hide();
    $('#adminEmpOTPVerification').hide();
    $('#createNewPswForAdminEmp').hide();
}


// /******************** onclick Forgot password link  **********/
function forgotPswClik() {
    $('.adminEmpDiv').hide();
    $('#fortogPswAdminEmployeeSection').show();
    $('#regMobileNoInputAndValidation').show();
    $('#adminEmpOTPVerification').hide();
    $('#createNewPswForAdminEmp').hide();
}


// /************** Ph Number Validation and send OTP To cO OR Employee *********/
function phNoValidationAndSendOTPAdminEmp() {
    let adminOrEmployeePhNumber = $('#COfloatingInputForPhNo').val();
    let adminOrEmpName = $('#COfloatingInputForName').val();
    if (adminOrEmployeePhNumber == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter Reg. Ph. Number...',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else if (adminOrEmpName == '') {
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
            url: "/wbct-cms/assets/DB/backend.php",
            data: new FormData($("#empAdminRegPhNoValidation")[0]),
            contentType: false,
            processData: false,
            success: function (response) {
                // alert(response);
                if (response == 1) {
                    Swal.fire({
                        icon: 'error',
                        title: '<h1 style="color:#009970">Error</h1>',
                        text: 'Wrong Ph Number And Name...',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    })
                }
                if (response == 2) {
                    Swal.fire({
                        icon: 'error',
                        title: '<h1 style="color:#009970">Error</h1>',
                        text: 'Wrong Name...',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    })
                }
                if (response == 3) {
                    Swal.fire({
                        icon: 'error',
                        title: '<h1 style="color:#009970">Error</h1>',
                        text: 'Wrong Ph Number...',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    })
                }
                if (response == 5) {
                    Swal.fire({
                        icon: 'error',
                        title: '<h1 style="color:#009970">Error</h1>',
                        text: 'Data Not Found...',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    })
                }
                if (response == 4) {
                    $.ajax({
                        type: "POST",
                        url: "/wbct-cms/assets/DB/backend.php",
                        data: {
                            phNoForOTP: adminOrEmployeePhNumber,
                            empOrAdminName: adminOrEmpName
                        },
                        success: function (response2) {
                            // alert(response2);
                            let data = JSON.parse(response2);
                            $('#adminEmpId').val(data.id);
                            if (data.msg == 1) {
                                $('#empAdminRegPhNoValidation')[0].reset();
                                $('.adminEmpDiv').hide();
                                $('#fortogPswAdminEmployeeSection').show();
                                $('#regMobileNoInputAndValidation').hide();
                                $('#adminEmpOTPVerification').show();
                                $('#createNewPswForAdminEmp').hide();
                            }
                        }
                    });
                }
            }
        });
    }

}

/**********************************
 * OTP verify function Admin or emp psw reset
 **********************************/

function verifyOTPForAdminEmpPswReset() {
    let otp1 = $('.n1OTPAdminEmpPswReset').val();
    let otp2 = $('.n2OTPAdminEmpPswReset').val();
    let otp3 = $('.n3OTPAdminEmpPswReset').val();
    let otp4 = $('.n4OTPAdminEmpPswReset').val();
    let typeOTP = otp1.concat(otp2, otp3, otp4);
    let adminEmpId = $('#adminEmpId').val();
    $.ajax({
        type: "POST",
        url: "/wbct-cms/assets/DB/backend.php",
        data: {
            typeOTPByEmpOrAdmin: typeOTP,
            adminEmpId: adminEmpId
        },
        success: function (response) {
            // alert(response);
            if (response == 1) {
                $('#otpInputsFormForAdminEmpPswReset')[0].reset();
                $('.adminEmpDiv').hide();
                $('#fortogPswAdminEmployeeSection').show();
                $('#regMobileNoInputAndValidation').hide();
                $('#adminEmpOTPVerification').hide();
                $('#createNewPswForAdminEmp').show();
            }
            if (response == 2) {
                Swal.fire({
                    icon: 'error',
                    title: '<h1 style="color:#009970">Error</h1>',
                    text: 'Wrong OTP...',
                    textColor: 'red',
                    confirmButtonColor: '#009970'
                })
            }
            if (response == 3) {
                Swal.fire({
                    icon: 'error',
                    title: '<h1 style="color:#009970">Error</h1>',
                    text: 'Data Not Found...',
                    textColor: 'red',
                    confirmButtonColor: '#009970'
                })
            }
        }
    });
}

/********** Update Emp or Admin PSW *******/
function empOrAdminUpdateNewPsw() {
    var psw = $('#COfloatingInputForPsw').val();
    var confirmPsw = $('#COfloatingInputForConfirm').val();
    var id = $('#adminEmpId').val();
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
    }
    /*******************
     * IF Admin or Emp id Not show
     ***********************/
    else if (id == 0) {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Somthing Wrong !!!!...',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else {
        $.ajax({
            type: "POST",
            url: "/wbct-cms/assets/DB/backend.php",
            data: new FormData($("#empOrAdminPswResetForm")[0]),
            contentType: false,
            processData: false,
            success: function (response) {
                if (response == 1) {
                    $('#empOrAdminPswResetForm')[0].reset();
                    Swal.fire({
                        icon: 'success',
                        title: '<h1 style="color:#009970">Success</h1>',
                        text: 'Password Update Successfully...',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    }).then(function () {
                        popUpSignInModal();
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

/******************* Password Toggle for Cable Operator Psw Update ************/
function pswToggleCOUpdatePsw() {
    var val = $('#checkbxAdminOrEmpPswUpdate').val();
    if (val == 0) {
        $('#checkbxAdminOrEmpPswUpdate').val(1);
        $('#COfloatingInputForPsw').attr('type', 'text');
        $('#COfloatingInputForConfirm').attr('type', 'text');
        $('#labelTextForAdminOrEmpPswUpdate').text("Hide Password");
    } else {
        $('#checkbxAdminOrEmpPswUpdate').val(0);
        $('#COfloatingInputForPsw').attr('type', 'password');
        $('#COfloatingInputForConfirm').attr('type', 'password');
        $('#labelTextForAdminOrEmpPswUpdate').text("Show Password");
    }
}