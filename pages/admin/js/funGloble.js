/*************** Get Admin, Employee Data Using Session Id **********/
function get_User_Info_Using_SessionID() {
    let session_ID = $('#sessionId').val();
    $.post('js/db/backendGloble.php', {
            id: session_ID
        },
        function (data, status) {
            let info = JSON.parse(data);
            let link = document.getElementById("userName");
            link.innerHTML = info.empName;
        }
    );
}


/********* Sign Out From Admin Pannel ********/
function sign_Out_Admin() {
    let dummyVariableAdminSignOut = "somthing";
    $.ajax({
        type: "POST",
        url: "js/db/backendGloble.php",
        data: {
            dummyVariableAdminSignOut: dummyVariableAdminSignOut
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


/********* Sign Out From Employee Pannel ********/
function sign_Out_Employee() {
    let dummyVariableEmployeeSignOut = "somthing";
    $.ajax({
        type: "POST",
        url: "js/db/backendGloble.php",
        data: {
            dummyVariableEmployeeSignOut: dummyVariableEmployeeSignOut
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



// // stop expand
// function stopExpand(){
//     document.getElementById('tableData').setAttribute('aria-expanded', "0");
//     setTimeout(function(){
//         document.getElementById('tableData').setAttribute('aria-expanded', "false");
//     }, 100);
// }
// // test 
// function dontExpandTest(){
//     stopExpand();
// }


/****** get total pending compplaints *******/
function getTotalPendingComplaintsRequests() {
    // alert("pending complaints");
    let totalPendingComplaints = "somthing";
    $.ajax({
        type: "POST",
        url: "js/db/backendGloble.php",
        data: {
            totalPendingComplaints: totalPendingComplaints
        },
        success: function (response) {
            // alert(response);
            $('#pendingComplaintsNo').text(response);
        }
    });
}

/****** get total pending connection request *******/
function getTotalPendingConnectionRequests() {
    // alert("pending conn");
    let totalPendingConnectionRequest = "somthing";
    $.ajax({
        type: "POST",
        url: "js/db/backendGloble.php",
        data: {
            totalPendingConnectionRequest: totalPendingConnectionRequest
        },
        success: function (response) {
            // alert(response);
            $('#connRequstNo').text(response);
        }
    });
}

/****** get total pending Recharge request *******/
function getTotalPendingRechargeRequests() {
    // alert("pending recharge");
    let totalPendingRechargeRequest = "somthing";
    $.ajax({
        type: "POST",
        url: "js/db/backendGloble.php",
        data: {
            totalPendingRechargeRequest: totalPendingRechargeRequest
        },
        success: function (response) {
            // alert(response);
            $('#rechargeRequestNo').text(response);
        }
    });
}

/*************** total active conn *******/
function getTotalNoOfactiveConn(){
    let totalActiveUser = "somthing";
    $.ajax({
        type: "POST",
        url: "js/db/backendGloble.php",
        data: {
            totalActiveUser: totalActiveUser
        },
        success: function (response) {
            // alert(response);
            $('#rechargeRequestNo').text(response);
        }
    });
}