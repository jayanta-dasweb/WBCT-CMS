/****************** Get Data ************/
function getData(){
    let dummyVar = "somthing";
    $.ajax({
        type: "POST",
        url: "js/db/addPkgBackend.php",
        data: {
            dummyVar : dummyVar 
        },
        success: function (response) {
            $('#cardBodyTable').html(response);
        }
    });
}

/*************Add data Into table ******/
function addData(){
    let createById = $('#sessionId').val(); 
    let createPkgName = $('#floatingPkgName').val();
    if(createPkgName == ''){
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter Package Name..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    }
    else{
        $.ajax({
            type: "POST",
            url: "js/db/addPkgBackend.php",
            data: {
                createById : createById,
                createPkgName : createPkgName
            },
            success: function (response) {
                // alert(response);
                if(response == 1){
                    Swal.fire({
                        icon: 'error',
                        title: '<h1 style="color:#009970">Error</h1>',
                        text: 'Package Name Already Exists..',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    })
                }
                if(response == 2){
                    Swal.fire({
                        icon: 'success',
                        title: '<h1 style="color:#009970">Success</h1>',
                        text: 'Data Inserted Successfully...',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    }).then(function (success) {
                        if (success) {
                            $('#addDataForm')[0].reset();
                            getData();
                        }
                    });
                }
            }
        });
    }
}

/***** edit data ********/
function editData(editId){
    getPkgName(editId);
    $('#hiddenId').val(editId);
}

/****** get pkg name ****/
function getPkgName(idForGetPkgName){
    $.ajax({
        type: "POST",
        url: "js/db/addPkgBackend.php",
        data: {
            idForGetPkgName : idForGetPkgName
        },
        success: function (response) {
            $('#floatingPkgNameUpdate').val(response);   
        }
    });
}

/********** final update ******/
function finalUpdateData(){
    let updateId = $('#hiddenId').val();
    let updatePkgName = $('#floatingPkgNameUpdate').val(); 
    if(updatePkgName == ''){
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter Package Name..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    }
    else{
        $.ajax({
            type: "POST",
            url: "js/db/addPkgBackend.php",
            data: {
                updateId : updateId,
                updatePkgName : updatePkgName
            },
            success: function (response) {
                if(response == 1){
                    Swal.fire({
                        icon: 'error',
                        title: '<h1 style="color:#009970">Error</h1>',
                        text: 'Package Name Already Exists..',
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
                            $('#updateModal').modal('hide');
                            getData();
                        }
                    });
                }
            }
        });
    }
}

/************ delete Data *********/
function deleteData(delid){
    let delId = delid;
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
                url: "js/db/addPkgBackend.php",
                data: {
                    delId: delId
                },
                success: function (response) {
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

    if (serchText == '') {
        getData();
    } else {
        $.ajax({
            type: "POST",
            url: "js/db/addPkgBackend.php",
            data: {
                serchText: serchText
            },
            success: function (response) {
                $('#cardBodyTable').html(response);
            }
        });
    }
}

