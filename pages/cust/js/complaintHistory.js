$(document).ready(function () {
    getData();
});

/********** get data ******/
function getData(){
    var dummyVar = $('#sessionId').val();
    $.ajax({
        type: "POST",
        url: "js/db/complaintHistoryBackend.php",
        data: {
            dummyVar : dummyVar 
        },
        success: function (response) {
            $('#cardBodyTable').html(response);
        }
    });
}

/*********** Get complaints data *******/
function showComplaintDetail(IdForGetComplaintDetail){
    
    $.ajax({
        type: "POST",
        url: "js/db/complaintHistoryBackend.php",
        data: {
            IdForGetComplaintDetail:IdForGetComplaintDetail
        },
        success: function (response) {
            $('#complaintDetail').html(response);
        }
    });
}

/*************** Search data ***********/
function searchData() {
    let serchText = $('#searchText').val();
    var cId = $('#sessionId').val();

    if (serchText == '') {
        getData();
    } else {
        $.ajax({
            type: "POST",
            url: "js/db/complaintHistoryBackend.php",
            data: {
                serchText: serchText,
                cId : cId
            },
            success: function (response) {
                $('#cardBodyTable').html(response);
            }
        });
    }
}