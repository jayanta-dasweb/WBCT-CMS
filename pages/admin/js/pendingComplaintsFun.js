var imported = document.createElement('script');
imported.src = './funGloble.js';
document.head.appendChild(imported);


/********** get data ******/
function getData(){
    var dummyVar = "somthing";
    $.ajax({
        type: "POST",
        url: "js/db/pendingComplaintsBackend.php",
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
        url: "js/db/pendingComplaintsBackend.php",
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
            url: "js/db/pendingComplaintsBackend.php",
            data: {
                serchText: serchText
            },
            success: function (response) {
                $('#cardBodyTable').html(response);
            }
        });
    }
}

/************** Resolved Complaint *********/
function resolveComplaint(idForResolve){
    $.ajax({
        type: "POST",
        url: "js/db/pendingComplaintsBackend.php",
        data: {
            idForResolve : idForResolve
        },
        success: function (response) {
            if(response == 1){
                Swal.fire({
                    icon: 'success',
                    title: '<h1 style="color:#009970">Success</h1>',
                    text: 'Resolved...',
                    textColor: 'red',
                    confirmButtonColor: '#009970'
                }).then(function (success) {
                    getTotalPendingComplaintsRequests();
                    getData();
                });
            }
            
        }
    });
}