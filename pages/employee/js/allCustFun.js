
/*************** get data ********/
function getData() {
    var dummyVar = $('#sessionId').val();
    $.ajax({
        type: "POST",
        url: "js/db/allCustBackend.php",
        data: {
            dummyVar: dummyVar
        },
        success: function (response) {
            $('#cardBodyTable').html(response);
        }
    });
}

/********* get conn details ******/
function getConnDetFun(idForGetConnDetails) {
    $.ajax({
        type: "POST",
        url: "js/db/allCustBackend.php",
        data: {
            idForGetConnDetails: idForGetConnDetails
        },
        success: function (response) {
            // alert(response);
            $('#connDet').html(response);
        }
    });
}

/************* edit Data *********/
function editData(editId) {
    $('#hiddenCustId').val(editId);
    getDetailForUpdate(editId);
    getAllArea(editId);
}

/************ get All data for Update *****/
function getDetailForUpdate(editIdForUpdate) {
    $.post('js/db/allCustBackend.php', {
            editIdForUpdate: editIdForUpdate
        },
        function (data, status) {
            let info = JSON.parse(data);
            $('#floatingInputForName').val(info.custName);
            $('#floatingInputForEmail').val(info.email);
            $('#floatingInputForPhNo').val(info.phNo);
            $('#floatingInputForHNo').val(info.houseNo);
            $('#floatingInputForPinCode').val(info.pincode);
            $('#floatingInputForStbNo').val(info.STBNumber);
        }
    );

}

/************** get All Area *******/
function getAllArea(editIdForArea){
    $.ajax({
        type: "POST",
        url: "js/db/allCustBackend.php",
        data: {
            editIdForArea : editIdForArea
        },
        success: function (response) {
            // alert(response);
            $('#floatingSelectForArea').html(response);
        }
    });
}

/************ final Update Data *******/
function updateData(){
    var custNameUpdate = $('#floatingInputForName').val();
    var custPhNoUpdate = $('#floatingInputForPhNo').val();
    var custHNoUpdate = $('#floatingInputForHNo').val();
    var custPinCodeUpdate = $('#floatingInputForPinCode').val();
    var custSTBNoUpdate = $('#floatingInputForStbNo').val();
    if(custNameUpdate == '' && custPhNoUpdate == '' && custHNoUpdate == '' && custPinCodeUpdate == '' && custSTBNoUpdate == ''){
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'All Fields Are Mendetory..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    }
    else if(custNameUpdate == ''){
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter Name..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    }
    else if(custPhNoUpdate == ''){
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter Contact Number..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    }
    else if(custHNoUpdate == ''){
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter House Number..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    }
    else if(custPinCodeUpdate == ''){
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter Pin Code..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    }
    else if(custSTBNoUpdate == ''){
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
            url: "js/db/allCustBackend.php",
            data: new FormData($("#updateForm")[0]),
            contentType: false,
            processData: false,
            success: function (response) {
                // alert(response);
                if(response == 1){
                    Swal.fire({
                        icon: 'error',
                        title: '<h1 style="color:#009970">Error</h1>',
                        text: 'STB Number Already Exsist..',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    })
                }
                if(response == 2){
                    Swal.fire({
                        icon: 'success',
                        title: '<h1 style="color:#009970">Success</h1>',
                        text: 'Data Update Successfully...',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    }).then(function (success) {
                        if (success) {
                            getData();
                            $('#editDataModal').modal('hide');
                            $('#floatingInputForEmail').val('');
                        }
                    });
                }
            }
        });
    }
}

/**************** onkeyup capitel all letters **********/
function capitalizeText(){
    var stbNoText = $('#floatingInputForStbNo').val();
    $('#floatingInputForStbNo').val(stbNoText.toUpperCase());
}


/*************** delete Data ***********/
function deleteData(id){
    let delId = id;
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
                url: "js/db/allCustBackend.php",
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
            url: "js/db/allCustBackend.php",
            data: {
                serchText: serchText,
                sessionId : sessionId
            },
            success: function (response) {
                $('#cardBodyTable').html(response);
            }
        });
    }
}