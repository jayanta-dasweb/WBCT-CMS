var imported = document.createElement('script');
imported.src = './funGloble.js';
document.head.appendChild(imported);


/************** Get data ********/
function getData(){
    var dummyVar = $('#sessionId').val();
    $.ajax({
        type: "POST",
        url: "js/db/pendingConnRequestBackend.php",
        data: {
            dummyVar:dummyVar
        },
        success: function (response) {
            $('#cardBodyTable').html(response);
        }
    });
}

/************** accept data *******/
function acceptData(editId){
    $('#hiddenConnId').val(editId);
}

/********** final Accept *****/
function finalAccept(){
    var connId = $('#hiddenConnId').val();
    var stbNo = $('#floatingInputForSTBNO').val();
    if(stbNo == ''){
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter STB Number..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    }
    else{
        $.ajax({
            type: "POST",
            url: "js/db/pendingConnRequestBackend.php",
            data: {
                connId : connId, 
                stbNo : stbNo
            },
            success: function (response) {
                if(response == 1){
                    Swal.fire({
                        icon: 'error',
                        title: '<h1 style="color:#009970">Error</h1>',
                        text: 'STB number Already Exists..',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    })
                }
                if(response == 2){
                    Swal.fire({
                        icon: 'success',
                        title: '<h1 style="color:#009970">Success</h1>',
                        text: 'Accepted...',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    }).then(function (success) {
                        if (success) {
                            $('#acceptModal').modal('hide');
                            $('#acceptConnectionForm')[0].reset();
                            getData();
                            getTotalPendingConnectionRequests();
                        }
                    });
                }
            }
        });
    }
}

/**************** onkeyup capitel all letters **********/
function capitalizeText(){
    var stbNoText = $('#floatingInputForSTBNO').val();
    $('#floatingInputForSTBNO').val(stbNoText.toUpperCase());
}

/*********** on close btn clik  *********/
function closeBtn(){
    $('#acceptConnectionForm')[0].reset();
}

/*********** Reject data  *******/
function rejectData(rejectId){
    let delId = rejectId;
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => 
    {
        if (result.isConfirmed) 
        {
            $.ajax({
                type: "POST",
                url: "js/db/pendingConnRequestBackend.php",
                data: {
                    delId: delId
                },
                success: function (response) {
                    // alert(response);
                    if (response == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: '<h1 style="color:#009970">Success</h1>',
                            text: 'Data Deleted Successfully...',
                            textColor: 'red',
                            confirmButtonColor: '#009970'
                        }).then(function (success) {
                            if (success) {
                                getData();
                                getTotalPendingConnectionRequests();
                            }
                        });
                    }
                }
            });
        }
        else{
            swal.fire("your data is safe..");
        }
    });
}

/*************** Search data ***********/
function searchData() {
    let serchText = $('#searchText').val();
    let sessionId = $('#sessionId').val();

    if (serchText == '') {
        getData();
    } else {
        $.ajax({
            type: "POST",
            url: "js/db/pendingConnRequestBackend.php",
            data: {
                serchText: serchText,
                sessionId: sessionId
            },
            success: function (response) {
                $('#cardBodyTable').html(response);
            }
        });
    }
}