/*********on doc ready ******/
$(document).ready(function () {
    getCoDetails();
    getPkgDetails();
    getPendingComplaintsDetails();
});



/********get cable operator details *********/
function getCoDetails() {
    var session_ID = $('#sessionId').val();
    $.post('js/db/homeBackend.php', {
            custIdForGetCoDet: session_ID,
        },
        function (data, status) {
            // alert(data);
            let info = JSON.parse(data);
            $('#coName').text(info.empName);
            $('#coPhNo').text(info.phNumber);
        }
    );
}

/*********** get last pkg infor mation *******/
function getPkgDetails() {
    var session_ID = $('#sessionId').val();
    $.ajax({
        type: "POST",
        url: "js/db/homeBackend.php",
        data: {
            custIdForGetPkgDet : session_ID
        },
        success: function (response) {
            $('#pkgInfo').html(response);
            lastRecrgDt();
            getExDate();
        }
    });
}

/********get Pending Complaints details *********/
function getPendingComplaintsDetails() {
    var session_ID = $('#sessionId').val();
    $.ajax({
        type: "POST",
        url: "js/db/homeBackend.php",
        data: {
            custIdForGetPendingComplaintsDet: session_ID
        },
        success: function (response) {
            // alert(response);
            $('#noOfPendingComplaintsCard').text(response);
        }
    });
}

/********* Recharge Expired Alert popup show ********/
function getRecrgExAlert() {
    var session_ID = $('#sessionId').val();
    $.ajax({
        type: "POST",
        url: "js/db/homeBackend.php",
        data: {
            custIDForGetExDate: session_ID
        },
        success: function (response) {
            // alert(response);
            if(response == 1){
                $('#rechrgAlert').show();
            }
            if(response == 2){
                $('#rechrgAlert').hide();
            }
        }
    });
}

/*********** get last recharge dt **********/
function lastRecrgDt(){
    var lastPayId = $('#hiddenLastPayId').val();
    var session_ID = $('#sessionId').val();
    $.ajax({
        type: "POST",
        url: "js/db/homeBackend.php",
        data: {
            lastPayId : lastPayId,
            custIdForGetLastRechrgDt : session_ID
        },
        success: function (response) {
            $('#rechrgDtCard').text(response);
        }
    });
}

/**************** get expiry date *********/
function getExDate(){
    var lastPayId = $('#hiddenLastPayId').val();
    var session_ID = $('#sessionId').val();
    $.ajax({
        type: "POST",
        url: "js/db/homeBackend.php",
        data: {
            lastPayId2 : lastPayId,
            custIdForGetExDt : session_ID
        },
        success: function (response) {
            // alert(response);
            $('#expireDtCard').text(response);
        }
    });
}