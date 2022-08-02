var imported = document.createElement('script');
imported.src = './funGloble.js';
document.head.appendChild(imported);

/********** get Data ************/
function getData(){
    var dummyVar = $('#sessionId').val();
    $.ajax({
        type: "POST",
        url: "js/db/rechrgPendingRequestBackend.php",
        data: {
            dummyVar: dummyVar
        },
        success: function (response) {
            // alert(response);
            $('#cardBodyTable').html(response);
        }
    });
}


/************ get pay details *******/
function getPayDetFn(getPayDetId){
    // alert("jj");
    $.ajax({
        type: "POST",
        url: "js/db/rechrgPendingRequestBackend.php",
        data: {
            getPayDetId : getPayDetId
        },
        success: function (response) {
            // alert(response);
            $('#payDetArea').html(response);
        }
    });
}


/************ all clear data ******/
function closeModl(){
    $('#payDetArea').html('');
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
            url: "js/db/rechrgPendingRequestBackend.php",
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

/*************** accept data ********/
function acceptData(acceptId){
    $.ajax({
        type: "POST",
        url: "js/db/rechrgPendingRequestBackend.php",
        data: {
            acceptId : acceptId
        },
        success: function (response) {
            // alert(response);
            if(response == 1){
                Swal.fire({
                    icon: 'success',
                    title: '<h1 style="color:#009970">Success</h1>',
                    text: 'Data Inserted Successfully...',
                    textColor: 'red',
                    confirmButtonColor: '#009970'
                }).then(function (success) {
                    if (success) {
                        getTotalPendingRechargeRequests();
                        getData();
                    }
                });
            }
        }
    });
}
