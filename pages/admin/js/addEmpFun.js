/********************* Get All data **********************/
function getData() {
    let getDataVar = "somthing";
    $.ajax({
        type: "POST",
        url: "js/db/addEmpBackend.php",
        data: {
            getDataVar: getDataVar
        },
        success: function (response) {
            $('#cardBodyTable').html(response);
        }
    });
}

/********************* get data for update ***************/
function editData(updateId) {
    let id = updateId;
    $('#hiddenId').val(id);
    $.post('js/db/addEmpBackend.php', {
            id: id
        },
        function (data, status) {
            let info = JSON.parse(data);
            $('#name').val(info.empName);
            $('#phno').val(info.phNumber);
        }
    );
}

/******************** Final Update Data *****************/
function finalUpdateData() {
    let hiddenId = $('#hiddenId').val();
    let name = $('#name').val();
    let phno = $('#phno').val();
    if (name == '' && phno == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter Name and Ph Number..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else if (name == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter Name..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else if (phno == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter Ph Number..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else {
        // alert("under");
        $.ajax({
            type: "POST",
            url: "js/db/addEmpBackend.php",
            data: {
                hiddenId: hiddenId,
                name: name,
                phno: phno
            },
            success: function (response) {
                if (response == 1) {
                    Swal.fire({
                        icon: 'error',
                        title: '<h1 style="color:#009970">Error</h1>',
                        text: 'Ph number already exist..',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    })
                }
                if (response == 2) {
                    Swal.fire({
                        icon: 'success',
                        title: '<h1 style="color:#009970">Success</h1>',
                        text: 'Data Update Successfully...',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    }).then(function () {
                        $('#updateModal').modal('hide');
                        getData();
                    });
                }
            }
        });
    }
}

/********************* add Data ****************/
function addData() {
    let empName = $('#inputName').val();
    let empPhno = $('#inputPh').val();
    if (empName == '' && empPhno == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter Name and Ph Number..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else if (empName == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter Name..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else if (empPhno == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter Ph Number..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else {
        // alert("under");
        $.ajax({
            type: "POST",
            url: "js/db/addEmpBackend.php",
            data: {
                empName: empName,
                empPhno: empPhno
            },
            success: function (response) {
                // alert(response);
                if (response == 1) {
                    Swal.fire({
                        icon: 'error',
                        title: '<h1 style="color:#009970">Error</h1>',
                        text: 'Ph number already exist..',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    })
                }
                if (response == 2) {
                    Swal.fire({
                        icon: 'success',
                        title: '<h1 style="color:#009970">Success</h1>',
                        text: 'Data Inserted Successfully...',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    }).then(function () {
                        $('#addDataForm')[0].reset();
                        getData();
                    });
                }
            }
        });
    }
}

/************ delete data **********/
function deleteData(id) {
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
                url: "js/db/addEmpBackend.php",
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
            url: "js/db/addEmpBackend.php",
            data: {
                serchText: serchText
            },
            success: function (response) {
                $('#cardBodyTable').html(response);
            }
        });
    }
}