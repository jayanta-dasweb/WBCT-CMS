/********************* On document REady ********/
$(document).ready(function () {
    hideRechrgNav();
    getUserDet();
    getSTBDet();
    getRecrgExAlert();
});

/*************** get User Information *******/
function getUserDet() {
    var session_ID = $('#sessionId').val();
    $.post('js/db/globleBackend.php', {
            custIdForGetDet: session_ID,
        },
        function (data, status) {
            // alert(data);

            let info = JSON.parse(data);
            var address = info.houseNo + ", " + info.areaName + ", " + info.pincode;
            $('#name').text(info.custName);
            $('#phNo').text(info.phNumber);
            $('#email').text(info.email);
            $('#address').text(address);
        }
    );
}



/*************** get STB Information *******/
function getSTBDet() {
    var session_ID = $('#sessionId').val();
    $.post('js/db/globleBackend.php', {
            custIdForGetSTBDet: session_ID,
        },
        function (data, status) {
            let info = JSON.parse(data);
            var sts = info.connStatus == 'active' ? 'Active' : 'Offline';
            $('#stbSts').text(sts);
            $('#stbNo').text(info.STBNumber);
            $('#setupDt').text(info.approveDt);

            var timestamp = info.approveDt;
            var date = new Date(timestamp);
            var day = date.getDate(); //Date of the month: 2 in our example
            var month = date.getMonth() + 1; //Month of the Year: 0-based index, so 1 in our example
            var year = date.getFullYear()
            var months = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            var selectedMonthName = months[month - 1];
            $('#setupDt').text(day + " " + selectedMonthName + " " + year);
        }
    );
}

/********* Sign Out From Customer Pannel ********/
function sign_Out_Cust() {
    let dummyVariableCustSignOut = "somthing";
    $.ajax({
        type: "POST",
        url: "js/db/globleBackend.php",
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

/********* after recharge done hide recharge nav ********/
function hideRechrgNav() {
    var session_ID = $('#sessionId').val();
    $.ajax({
        type: "POST",
        url: "js/db/globleBackend.php",
        data: {
            custIDForGetExDate: session_ID
        },
        success: function (response) {
            // alert(response);
            if(response == 1){
                $('#rechrgPg').show();
            }
            if(response == 2){
                $('#rechrgPg').hide();
            }
        }
    });
}