$(document).ready(function () {
    getCustPkgData();
    getAllSubPkg();
});


/********** Get add Sub Pkg *******/
function getAllSubPkg(){
    var dummyVar3 = "somthing";
    $.ajax({
        type: "POST",
        url: "js/db/createCustPkgBackend.php",
        data: {
            dummyVar3:dummyVar3 
        },
        success: function (response) {
            $('#allSubPkgs').html(response);
        }
    });
}


// /************ ADD Custom Pkg data *************/
function addCustomPkg() {
    let pkgNameCustom = $('#floatingInputCustomName').val();
    var custId = $('#sessionId').val();
    var array = [];
    var checkboxes = document.querySelectorAll('input[name=subPkg]:checked');
    for (var i = 0; i < checkboxes.length; i++) {
        array.push(checkboxes[i].value);
    }

    var noOfSelectedCheckBx =  document.querySelectorAll('input[name=subPkg]:checked').length;
    // alert(noOfSelectedCheckBx);
    if(pkgNameCustom =='' && array == ''){
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'All Fields Are Mendetory..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    }
    else if(pkgNameCustom ==''){
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter Package Name..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    }
    else if(array == ''){
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Select Sub Packages..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    }
    else if(!(noOfSelectedCheckBx >= 2)){
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'At Least 2 Sub Package Should Select..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    }
    else{
        $.ajax({
            type: "POST",
            url: "js/db/createCustPkgBackend.php",
            data: {
                pkgNameCustom : pkgNameCustom,
                arr2 : array,
                custId : custId
            },
            success: function (response) {
                if (response == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: '<h1 style="color:#009970">Success</h1>',
                        text: 'Data Inserted Successfully...',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    }).then(function (success) {
                        if (success) {
                            getCustPkgData();
                            $('#addCustomPkgModal').modal('hide');
                            $('#addCustPkgForm')[0].reset();
                        }
                    });
                }
            }
        });
    }
}



/************ get all custom pkg details  **********/
function getCustPkgData(){
    var sessionId = $('#sessionId').val();
    $.ajax({
        type: "POST",
        url: "js/db/createCustPkgBackend.php",
        data: {
            custIdForGetPkgDet : sessionId
        },
        success: function (response) {
            // alert(response);
            $('#cardBodyTable').html(response);
        }
    });
}


/*********** show all sub pkgs modal view *********/
function getSubPkgsForModal(subPkgId){
    $.ajax({
        type: "POST",
        url: "js/db/createCustPkgBackend.php",
        data: {
            subPkgId:subPkgId 
        },
        success: function (response) {
            // alert(response);
            $('#showAllSubPkgsModalView').html(response);
        }
    });
}

/************* Edit Custom pkg data **********/
function editCustPkgData(editCustPkgId){
    getCustPkgNameData(editCustPkgId);
    getAllSubPkgForUpdateData(editCustPkgId);
    $('#hiddenCustPkgId').val(editCustPkgId);
}


/************** get Pkg name (custom pkg)******** */
function getCustPkgNameData(custPkgId){
    var pkgIdForGetCustPkgName = custPkgId;
    $.ajax({
        type: "POST",
        url: "js/db/createCustPkgBackend.php",
        data: {
            pkgIdForGetCustPkgName : pkgIdForGetCustPkgName
        },
        success: function (response) {
            $('#floatingInputUpdateDataCustPkg').val(response);
        }
    });
}

/********* get all sub packages with selected checkbox *****/
function getAllSubPkgForUpdateData(custPkgId2){
    var pkgIdForGetAllSubPkg = custPkgId2;
    $.ajax({
        type: "POST",
        url: "js/db/createCustPkgBackend.php",
        data: {
            pkgIdForGetAllSubPkg: pkgIdForGetAllSubPkg
        },
        success: function (response) {
            $('#allSubPkgsForUpdate').html(response);
        }
    });
}

/*********** final update custome pkg data ********/
function updateCustPkgData(){
    var custId2 = $('#sessionId').val();
    var hiddenCustPkgId = $('#hiddenCustPkgId').val();
    var updateCustPkgName = $('#floatingInputUpdateDataCustPkg').val();
    var array = [];
    var checkboxes = document.querySelectorAll('input[name=subPkg2]:checked');
    for (var i = 0; i < checkboxes.length; i++) {
        array.push(checkboxes[i].value);
    }
    
    var noOfSelectedCheckBx =  document.querySelectorAll('input[name=subPkg2]:checked').length;
    // alert(noOfSelectedCheckBx);
    if(updateCustPkgName =='' && array == ''){
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'All Fields Are Mendetory..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    }
    else if(updateCustPkgName ==''){
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Enter Package Name..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    }
    else if(array == ''){
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'Select Sub Packages..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    }
    else if(!(noOfSelectedCheckBx >= 2)){
        Swal.fire({
            icon: 'error',
            title: '<h1 style="color:#009970">Error</h1>',
            text: 'At Least 2 Sub Package Should Select..',
            textColor: 'red',
            confirmButtonColor: '#009970'
        })
    }
    else{
        $.ajax({
            type: "POST",
            url: "js/db/createCustPkgBackend.php",
            data: {
                updateCustPkgName : updateCustPkgName,
                arr3 : array,
                hiddenCustPkgId : hiddenCustPkgId,
                custId2 : custId2
            },
            success: function (response) {
                // alert(response);
                if (response == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: '<h1 style="color:#009970">Success</h1>',
                        text: 'Data Update Successfully...',
                        textColor: 'red',
                        confirmButtonColor: '#009970'
                    }).then(function (success) {
                        if (success) {
                            getCustPkgData();
                            $('#editModal').modal('hide');
                        }
                    });
                }
            }
        });
    }

}

function deleteCustPkgData(delCustPkgId){
    let delCustPkgId1 = delCustPkgId;
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
                url: "js/db/createCustPkgBackend.php",
                data: {
                    delCustPkgId1: delCustPkgId1
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
                                getCustPkgData();
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

/*************** Search Custom Pkg data ***********/
function searchData2() {
    let serchText2 = $('#searchText2').val();

    if (serchText2 == '') {
        getCustPkgData();
    } else {
        $.ajax({
            type: "POST",
            url: "js/db/createCustPkgBackend.php",
            data: {
                serchText2: serchText2
            },
            success: function (response) {
                // alert(response);
                $('#cardBodyTable').html(response);
            }
        });
    }
}