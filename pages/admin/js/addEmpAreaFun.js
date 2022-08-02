/********************* Get all Data *************/
function getData() {
    let dummyVar2 = "somthing";
    $.ajax({
        type: "POST",
        url: "js/db/addEmpAreaBackend.php",
        data: {
            dummyVar2: dummyVar2
        },
        success: function (response) {
            // alert(response);
            $('#cardBodyTable').html(response);
        }
    });
}


/******************* Get all Emp Data ********/
function getEmpData() {
    let dummyVar = "somthing";
    $.ajax({
        type: "POST",
        url: "js/db/addEmpAreaBackend.php",
        data: {
            dummyVar: dummyVar
        },
        success: function (response) {
            $('.dataSelectForAssign').html(response);
        }
    });
}

/************ Insert Data Into Table  ************/
function addData() {
    let empId = $('.selectedId').val();
    let areaName = $('.addArea').val();
    if (empId == 0 && areaName == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'All Fields Are Mandatory..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else if (empId == 0) {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Select Employee..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else if (areaName == 0) {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter Area..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else {
        $.ajax({
            type: "POST",
            url: "js/db/addEmpAreaBackend.php",
            data: {
                empId: empId,
                areaName: areaName
            },
            success: function (response) {
                // alert(response);
                if (response == 1) {
                    Swal.fire({
                        icon: 'error',
                        title: '<h1 style="color:#009970">Error</h1>',
                        text: 'This Area has Already Assigned To This Employee..',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    })
                }
                if (response == 2) {
                    Swal.fire({
                        icon: 'error',
                        title: '<h1 style="color:#009970">Error</h1>',
                        text: 'This Area has Already Assigned To Another Employee..',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    })
                }
                if (response == 3 || response == 4) {
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


/*************** edit Data ***********/
function editData(editid) {
    $('#hiddenId').val(editid);
    getAreaData(editid);
}

/******** Get Area Data *******/
function getAreaData(idForGetAreaDetails) {
    $.ajax({
        type: "POST",
        url: "js/db/addEmpAreaBackend.php",
        data: {
            idForGetAreaDetails: idForGetAreaDetails
        },
        success: function (response) {
            // alert(response);
            $('.dataSelectForUpdate').html(response);
        }
    });
}

/******** Get Area Name  *********/
function getAreaNameData() {
    let areaName = $('.selectedAreaName').val();
    $('.editArea').val(areaName);
}

/********* close Update Modal *******/
function closeUpdateModal() {
    $('.editArea').val("");
}

/******** final update Data *********/
function finalUpdateData() {
    let empIdForUpdate = $('#hiddenId').val();
    let areaNameForUpdate = $('.selectedAreaName').val();
    let editAreaNameForUpdate = $('.editArea').val();
    if (areaNameForUpdate == '' && editAreaNameForUpdate == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'All Fields Are Mandatory..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else if (areaNameForUpdate == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Select Area..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else if (editAreaNameForUpdate == '') {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter New Area..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    } else {
        $.ajax({
            type: "POST",
            url: "js/db/addEmpAreaBackend.php",
            data: {
                empIdForUpdate: empIdForUpdate,
                areaNameForUpdate: areaNameForUpdate,
                editAreaNameForUpdate: editAreaNameForUpdate
            },
            success: function (response) {
                // alert(response);
                if (response == 1) {
                    Swal.fire({
                        icon: 'error',
                        title: '<h1 style="color:#009970">Error</h1>',
                        text: 'This Area has Already Assigned To This Employee..',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    })
                }
                if (response == 2) {
                    Swal.fire({
                        icon: 'error',
                        title: '<h1 style="color:#009970">Error</h1>',
                        text: 'This Area has Already Assigned To Another Employee..',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    })
                }
                if (response == 3) {
                    Swal.fire({
                        icon: 'success',
                        title: '<h1 style="color:#009970">Success</h1>',
                        text: 'Data Inserted Successfully...',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    }).then(function () {
                        $('#addDataForm')[0].reset();
                        getData();
                        $('#updateModal').modal('hide');
                        closeUpdateModal();
                    });
                }
            }
        });
    }
}

/******************* Delete Data  ***************/
function deleteData(dltId) {
    $('#hiddenId2').val(dltId);
    getAreaDataForDelete(dltId);
}

/************** get area data for delete **********/
function getAreaDataForDelete(idForDlt) {
    $.ajax({
        type: "POST",
        url: "js/db/addEmpAreaBackend.php",
        data: {
            idForDlt: idForDlt
        },
        success: function (response) {
            // alert(response);
            $('.dataSelectForDelete').html(response);
        }
    });
}

/*********** final delete ************/
function finalDeleteData() {
    let delId = $('#hiddenId2').val();
    let areaNameForDlt = $('.selectedAreaNameForDelet').val();
    if (areaNameForDlt != '') {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "js/db/addEmpAreaBackend.php",
                    data: {
                        delId: delId,
                        areaNameForDlt: areaNameForDlt
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
                                    $('#deleteModal').modal('hide');
                                    getData();
                                }
                            });
                        }
                    }
                });
            } else {
                swal.fire("your data is safe..");
                $('#deleteModal').modal('hide');
            }
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Select Area..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    }
}

/*************** Search data ***********/
function searchData() {
    let serchText = $('#searchText').val();

    if (serchText == '') {
        getData();
    } else {
        $.ajax({
            type: "POST",
            url: "js/db/addEmpAreaBackend.php",
            data: {
                serchText: serchText
            },
            success: function (response) {
                $('#cardBodyTable').html(response);
            }
        });
    }
}