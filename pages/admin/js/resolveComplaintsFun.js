/********** get data ******/
function getData(){
    var dummyVar = "somthing";
    $.ajax({
        type: "POST",
        url: "js/db/resolveComplaintsBackend.php",
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
        url: "js/db/resolveComplaintsBackend.php",
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

    if (serchText == '') {
        getData();
    } else {
        $.ajax({
            type: "POST",
            url: "js/db/resolveComplaintsBackend.php",
            data: {
                serchText: serchText
            },
            success: function (response) {
                $('#cardBodyTable').html(response);
            }
        });
    }
}